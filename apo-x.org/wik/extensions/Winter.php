<?php

/***********************************************************
 * Name:     Winter (Wiki INTERpreter)
 * Desc:     Scripting engine for MediaWiki
 *
 * Version:  2.2.0
 *
 * Author:   Swiftly Tilting (contact@swiftlytilting.com)
 * Homepage: http://www.mediawiki.org/wiki/Extension:Winter
 *           http://www.swiftlytilting.com/category/winter/
 * License:  GNU GPL (http://www.gnu.org/licenses/gpl.html)
 *
 ***********************************************************
 */

$wgExtensionCredits['parserhook'][] = 
   array(
      'name'        => 'Winter (Wiki INTERpreter)',
      'author'      => 'SwiftlyTilting.com',
      'url'         => 'http://www.mediawiki.org/wiki/Extension:Winter',
      'description' => 'Adds an interpreted language to Mediawiki pages',
      'version'     => '2.2.0'
   ); 


class WinterScript
{

   private $winterVersion = '2.2.0',   
           $text,
           $maxNestLevel,
	        $maxOperations,
	        $maxIterations,	
	        $notallowed,	        
	        $escapeChars,
	        $replaceChars,
	        $pregWord,
	        $operationCount,	       
	        $functions,
	        $scriptVars,
	        $pageTemplates,
	        $pageText;
	        

	
	public  $nowinter;        // public to allow for a preg_replce_callback() function


	/**
	 *  Constructor; initializes the Winter scripting engine
	 *
	 */
	public function __construct()
	{  
	   $text = '';
	   
	   // Check for user defined settings in LocalSettings.php
	   global $wgWinterMaxNesting,
	          $wgWinterMaxOperations,
	          $wgWinterMaxIterations,
	          $wgWinterNotAllowed;	         
      
      // Maximum number of nesting levels allowed
		$this->maxNestLevel  = isset($wgWinterMaxNesting)?$wgWinterMaxNesting:50; 
      
      // Maximum number of operations per script allowed
      $this->maxOperations = isset($wgWinterMaxOperations)?$wgWinterMaxOperations:10000; 

      // Maximum number of per-loop iterations allowed
      $this->maxIterations = isset($wgWinterMaxIterations)?$wgWinterMaxIterations:1000; 
      
      // Blocked functions
      $this->notallowed    = isset($wgWinterNotAllowed)?explode(' ',$wgWinterNotAllowed):array();

									
		// Define escape characters
		$this->escapeChars =  array( '^!',  '^(',  '^)',   '^[',  '^]', '^_', '^.'  );
		$this->replaceChars = array( '|',   '{',   '}',    '{{',  '}}', '^'  ,'' );		
		
		// Define acceptable characters for functions and variables
		$this->pregWord = '[A-Za-z0-9_\-\$\w]';		
		
		$this->operationCount = 0;
		
		$this->functions = array();
		$this->scriptVars = array(); 		
		$this->nowinter = array();
		$this->nowinter['key'] = rand();		      
      $this->pageTemplates = array();
	}

   /**
	 *  Processed before Mediawiki gets a chance to modify code
	 *
	 */

   public function preWikiProcess($text)
   {  
      global $wgParser, $wgVersion, $wgSitename, $wgServer, $wgServerName;            
      
      $this->pageText = $text;     
      
      $this->scriptVars['_templates'] = array();
      $this->scriptVars['_system'] = array();            
      
      $this->scriptVars['_user']['name'] = $wgParser->mOptions->mUser->mName;
      $this->scriptVars['_user']['id'] = $wgParser->mOptions->mUser->mId;
      
      $this->scriptVars['_page']['title'] = $wgParser->mTitle->mTextform;
      $this->scriptVars['_page']['titleurlform'] = $wgParser->mTitle->mUrlform;
      $this->scriptVars['_page']['namespace'] = $wgParser->mTitle->mNamespace;
      $this->scriptVars['_page']['articleid'] = $wgParser->mTitle->mArticleID;
      $this->scriptVars['_page']['prefixedtitle'] = $wgParser->mTitle->mPrefixedText;
            
      $this->scriptVars['_system']['mediawikiversion'] = $wgVersion;
      $this->scriptVars['_system']['sitename'] = $wgSitename;            
      $this->scriptVars['_system']['server'] = $wgServer;
      $this->scriptVars['_system']['servername'] = $wgServerName; 
                 
      if (array_key_exists('SCRIPT_URI', $_SERVER))
      {
      	$this->scriptVars['_system']['uri'] = $_SERVER['SCRIPT_URI'];
      }
      if (array_key_exists('SCRIPT_URL', $_SERVER))
      {
      	$this->scriptVars['_system']['url'] = $_SERVER['SCRIPT_URL'];
   	}
   	if (array_key_exists('REQUEST_METHOD', $_SERVER))
      {
      	$this->scriptVars['_system']['requestmethod'] = $_SERVER['REQUEST_METHOD'];
   	}
   	if (array_key_exists('QUERY_STRING', $_SERVER))
      {
      	$this->scriptVars['_system']['querystring'] = $_SERVER['QUERY_STRING'];
      }

      //  remove line breaks from within winter code      
      if (stripos($text,'{{#keep_nl') === false)
      {
         for($loc = 0;($loc = strpos($text,"\n ",$loc)) !== false;$loc++)
         {  
            $head = substr($text,0,$loc); 
            
            if (substr_count($head,'{{') > substr_count($head,'}}'))
            {  
               $lastloc = $loc;      
              
               do 
               {  $newhead = substr($head,0,$lastloc);
                  $lastloc = strrpos($newhead,'{{');                
                  $headtail = substr($head,$lastloc);               
               }
               while(substr_count($headtail,'{{') <= substr_count($headtail,'}}'));
               	   
         		if (preg_match('/\{\{#' . $this->pregWord . '+?\s*\|.*/s',   $headtail, $match))
         		{
                  $text = $head . ' ' . substr($text,$loc+1);
                  $loc++;
               }
            }   
         }
      }
      
      
      // Check for <winterprewiki> blocks and execute code             
      $text = preg_replace_callback('%\<winterprewiki\>(.*)\</winterprewiki\>%isU',
         create_function(
            '$matches',
            'global $wgWinter; return $wgWinter->processText($matches[1]);'           
         ),$text);	
       

      // Check for templates and add them to template variable 
      $text = $this->recurseTemplates($text);              

      return $text;   
   }
      
	/**
	 * Allow functions to be added
	 *
	 */
	public function addFunction($funcname,$call)
	{		
		$this->functions[strtolower($funcname)]['call'] = $call;
		return true;
	}

	/**
	 * Allow variables to be added
	 *
	 */
	
   public function addVar($varname, $value = '')
   {
      if (is_array($varname) && count($varname) == 2)
      {  return $this->scriptVars[$varname[0]][$varname[1]] = $value;
	   }
		
		return $this->scriptVars[$varname] = $value;		
   }

	/**
	 * Returns standard Winter error message
	 *
	 */

	public function showError($str, $num = false)
   {  $str = str_replace('|','&#124;',$str);
		return  "<b># ERROR" . ($num?" ($num)":'') . ": $str </b></span>";
   }   

	/**
	 *  Processes unprepared Winterscript
	 *
	 */
	 
	public function processText($text)
	{  
	   if (strpos($text,'{{#') === false)
	   {  return $text;
	   }
	   
	   $text = $this->preProcess($text);
	   $text = $this->parseScript($text);		
		return  $this->postProcess($text);
	}

	/*************************************************************************
	 *************************************************************************
	 *        The methods following this comment block are considered
	 *              private and shouldn't be called directly
	 */

	/**
	 *  Format text so the parser can read it without causing errors.
	 *  This mostly involves adding reverse quotes (`) to the end of each }
	 *  for every level it is nested.  
	 *
	 */
	private function preProcess($text, $doreturn = true)
	{  
	   
	   // Handle <nowinter> blocks
		   
	   $text = preg_replace_callback('%(\&lt;|\<)nowinter(\&gt;|\>)(.*)(\&lt;|\<)\/nowinter(\&gt;|\>)%isU',
       create_function(
           '$matches',
           'global $wgWinter;
           $cnt = count($wgWinter->nowinter) + $wgWinter->nowinter["key"];
           $wgWinter->nowinter[$cnt] = $matches[3];
           return "<!-- nowinter: ". ($cnt) . " -->";'           
       ),$text);
       
      
      // Format shortcuts and variables
      $text = str_replace('`','&lsquo;',$text);
		
		// Protect template parameter variables
		$text = preg_replace('%\{\{\{('. $this->pregWord . '+)\}\}\}%U', '!{!`!{$1}!`!}!',$text);
		
		// {{#xyz}} => {{#xyz|}}
		$text = preg_replace('%\{\{#('. $this->pregWord . '+?)\s*\}\}%U', '{{#$1|}}',$text);            
      
      //
      $text = str_replace('&nbsp;!= ',' &nbsp;!= ',$text);
      
      // {{#abc x y z}} => {{#abc|x|y|z}
      $text = preg_replace_callback('%\{\{#('. $this->pregWord . '+\s+[^\|]+)\s*\}\}%U',
       create_function(                   
           '$matches',
           'if (!strpos($matches[1],\'|\'))
           { $matches[1] = preg_replace(\'%\s+%\',\'|\',$matches[1]);
           } 
           return \'{{#\' . $matches[1] . \'}}\';'  
           
       ),$text);
       
      
      // Make program code easier to traverse recursively
		$offset = 0;
		$converted = 0;
		while ($offset < strlen($text) && $offset = strpos($text,'}}',$offset))
		{  $front = substr($text,0,$offset++);
			$back = substr($text,++$offset);

         $blockfront = strrpos($front, '{{#');
         
			$count = substr_count($front,'{{#') - substr_count($front,'}}') - $converted;
			$tag = '';
			if ($count > 0)
			{ $tag = str_repeat('`',$count);
			  $converted++;

			}
			else
			{
				$count = 0;
				$converted--;
			}
			
			
			$block = substr($front,$blockfront);
			$block = str_replace( '||',"|$tag|$tag",$block);
			$block = preg_replace( '%\^([\(|\!|\)|_|\[|\]])%',"^$tag\\1",$block);
			$front = substr($front,0,$blockfront) . $block;
			
			$text = $front . '}' . $tag . '}' . $tag . $back;

			$offset += $count;
		}
		

		if ($doreturn)
	   {  return $text;
	   }
	  	else
		{  $this->text = $text;
	   }	
	}

	/**
	 * do some final clean up work to restore text to the way it was before
	 * it was formatted by preprocess
	 *
	 */
	private function postProcess($text)
	{
		$text = preg_replace('%!\{!`!\{(.*)\}!`!\}!%U', '{{{$1}}}', $text);
		$text = preg_replace('%}`+%', '}', $text);
		$text = preg_replace('%\|`+%', '|', $text);
		$text = preg_replace('%\^`+%', '^', $text);
		
		$text = str_replace('&lsquo;', '`', $text);
		
	   $text = preg_replace_callback('%\<!-- nowinter: ([0-9]*) --\>%',
       create_function(
           '$matches',
           'global $wgWinter;
           //$matches[1] = $matches[1] - $wgWinter->nowinter["key"];
           
           return $wgWinter->nowinter[($matches[1])];'           
       ),$text);
		
		return $text;

	}   
   

		/**
	 *  Used to test if $functionString has $num paramameters.  If true, return array of
	 *  the parmeters, else returns false
	 *
	 */
	private function hasParamNum($num, $functionString)
	{  if (substr_count($functionString[0],'|') == $num &&
			preg_match('/\{\{#'. $this->pregWord . '+?\s*' . str_repeat('\|\s*"?(.*?)"?\s*',$num) .'\}\}/s', $functionString[0], $casematch))
		{
			$savedmatch0 = $casematch[0];

			$casematch = str_replace($this->escapeChars,$this->replaceChars,$casematch);
			$casematch[0] = $savedmatch0;

			return $casematch;
		}
		else
		{
			return false;
		}
	}

	/**
	 *  Returns an array of the parmeters
	 *
	 */
	private function getParams($functionString, $noquote = false)
	{  $num = substr_count($functionString[0],'|');
	   $quote = $noquote?'':'"?';
	   
		if (preg_match('/\{\{#'. $this->pregWord . '+?\s*' . str_repeat('\|\s*'.$quote.'(.*?)'.$quote.'\s*',$num) .'\}\}/s',   $functionString[0], $casematch))
		{
			$savedmatch0 = $casematch[0];
			$casematch = str_replace($this->escapeChars,$this->replaceChars,$casematch);
			$casematch[0] = $savedmatch0;

			return $casematch;
		}
		else
		{
			return false;
		}
	}


   /**
    *  implodes an array if it exceeds $level levels
    *
    */
   private function arrayFlatten($array,$level)
   {
      if ($level === 0)
      {  if  (is_array($array))
         {  return $this->implodeRecursive('|',$array);
         }
         else
         {   return $array;
         }
      } else 
      {  if (is_array($array))
         {  foreach ($array as $n=>$v)
            {  $array[$n] = $this->arrayFlatten($v,$level-1);
            }
         }

      }
      return $array;
   }     
     
   /**
    * Implode an multidimensional array into one string
    *
    */           
   private function implodeRecursive($del, $array)
   {  $ret = '';
      
      foreach ($array as $n => $v)
      {  if (is_array($v))
         {  $array[$n] = $this->implodeRecursive($del, $v);
         }
      }
      return implode($del, $array);
   }   
   
   /**
    *  Helper function for preWikiProcess. 
    *
    */   
   private function recurseTemplates($text, $returnPipes = true)
   {  
      
      $text = preg_replace_callback('%{{[^#]((?>[^{}])|(?R))*}}%is',
                                    array('self','recurseTemplatesCallback'), 
                                    $text); 
      
      return $returnPipes ? $text = str_replace('['.$this->nowinter['key'].']','|',$text)
                          : $text;
   }
   
   /**
    *  Helper function for recurseTemplates 
    *
    */ 
       
   private function recurseTemplatesCallback($matches)
   {  // reads template vars
       
       $key = $this->nowinter['key'];
       $templateCode = substr($matches[0], 2,-2);  
       
       if (strpos($templateCode,'{{') !== false)
       {  
          $templateCode = $this->recurseTemplates($templateCode, false);
       }   
       
       $this->pageTemplates[] = $templateCode;		
       $num =  count($this->pageTemplates) - 1;       
              
       $arr = explode('|',$templateCode);            
       foreach ($arr as $n => $v)
       {  $v2 = str_replace('['.$key.']','|',$v);
          $arr[$n] = $v;
          if (preg_match('%^\s*([^{]*?)\s*=\s*(.*)\s*$%',$v,$matches2))
          {  $arr[strtolower($matches2[1])] = $matches2[2];               
          }
       }            
       
       $this->addVar(array('_templates',$num), $arr);
       
       return str_replace('|','['.$this->nowinter['key'].']','{{' . $templateCode . 
       (preg_grep('/^wintertemplate$/i', $arr)?'|WinterTemplateID=' . $num:'') . '}}');
   }
      
   
               /******************************************************/
					/*** Parse Script
				   /******************************************************/
  	/**
	 *  parseScript() does most of the work for us.  It expects properly
	 *  formatted text from preprocess()
	 *	
	 *	
	 */
	private function parseScript($text = false, &$lvars = false, $level = 0)
	{  
		if ($level > $this->maxNestLevel)
		{  return  $this->showError("Maximum nesting level ($this->maxNestLevel) exceeded.",1);		   
		}                        
      
      // Operation count warning already displayed so don't display again
      if ($this->operationCount >  $this->maxOperations)
      {  return;         
      }       
   
		if ($text === false)
		{  $text = $this->text;
		}
		
		if ($text == '')
		{  return $text;
	   }	   
		
		$text = str_replace('}`','}',$text);  // Removes one level of recusion
		$text = str_replace('|`','|',$text);  // Removes one level of recusion
		$text = str_replace('^`','^',$text);  // Removes one level of recusion

		if ($lvars === false)
		{  $localVars = &$this->scriptVars;
		}
		else if ($lvars == $this->scriptVars)
		{  $localVars = &$this->scriptVars;
		}
		else
		{  $localVars  =& $lvars;
		}
		
		$varString = false;
		while (  preg_match('%\{\{#('. $this->pregWord . '*?)\s*\|\s*"?(.*?)"?\s*\}\}%s', $text, $functionString) && $this->operationCount <=  $this->maxOperations)
		{  
         $this->operationCount++;
         
         // Check for op count limit & display error once limit is reached
         if ($this->operationCount ==  $this->maxOperations)
         {  return  $this->showError("Maximum number of operations ($this->maxOperations) reached.",2);         
         }		  
         
         // Set up default syntax error
			$functionString[1] = strtolower($functionString[1]);
			$wReturn = $this->showError('Syntax error in <i>('.$functionString[1].'|'.$functionString[2].')</i>.',3);
         
         
         //  Check to see if the function is on the blacklist
         if (in_array($functionString[1],$this->notallowed,true))
         {  $wReturn  =  $this->showError( $functionString[1].' has been disabled by the administrator.',4);
         }

	            /******************************************************/
			      /* if construct
			      /******************************************************/
				   
				   /**
					 *   {{#if | bool || ..true code .. }}                      					 
					 *   {{#if | bool || ..true code .. || .. false code }}                      					 
					 *
					 *   Echo text without evaluating it by converting
					 *  { | } to their html character codes.  
					 *   It's better to use <nowinter> if possible
					 *
			       */			
         else if ($functionString[1] == 'if')
         {  if (preg_match('%\s*"?(.*?)"?\s*\|\|\s*"?(.*?)"?\s*\|\|\s*"?(.*?)"?\s*$%s',$functionString[2], $param))
				{  
				   $param = str_replace($this->escapeChars,$this->replaceChars,$param);
				   $wReturn  = '';
				   if ($this->parseScript($param[1],$localVars,$level+1))
				   {  $wReturn = $this->parseScript($param[2],$localVars,$level+1);
				   } else
				   {  $wReturn = $this->parseScript($param[3],$localVars,$level+1);
				   }
				}
				else if (preg_match('%\s*"?(.*?)"?\s*\|\|\s*"?(.*?)"?\s*$%s',$functionString[2], $param))
				{  
				   $param = str_replace($this->escapeChars,$this->replaceChars,$param);
				   $wReturn  = '';
				   if ($this->parseScript($param[1],$localVars,$level+1))
				   {  $wReturn = $this->parseScript($param[2],$localVars,$level+1);
				   }
				}
				else if (strpos($functionString[2],'||') === false)
			{  $wReturn = '{{#iff|' . $functionString[2] . '}}';
				}
         
         }
         
					/******************************************************/
					/*** While construct
					/******************************************************/
					
					/**
					 *   {{#while | bool || 
					 *   ..loop code..           
					 *   }}                      
					 *
					 */
			else if ($functionString[1] == 'while')
			{
				if (preg_match('%\s*"?(.*?)"?\s*\|\|\s*"?(.*?)"?\s*$%s',$functionString[2], $param))
				{  
				   $param = str_replace($this->escapeChars,$this->replaceChars,$param);
				   $wReturn  = '';
					$loop = 0;
					$maxLoop = $this->maxIterations;
					

					while ($this->parseScript($param[1],$localVars,$level+1) && ($loop < $maxLoop))
					{
						$wReturn .= $this->parseScript($param[2],$localVars,$level+1);
						$loop++;
					}
					if ($loop >= $maxLoop)
					{
						$wReturn  .= $this->showError("Maximum number of iterations ($maxLoop) reached in <i>while</i>.",5);
					}		
				}
			   else
			   {  $wReturn = $this->showError('Syntax error in <i>while</i> statement.',6);
			   }
            
			}
			
			      /******************************************************/
					/*** Repeat construct
					/******************************************************/

					/**
					 *   {{#repeat | number ||
					 *   ..loop code..           
					 *   }}                      
					 *
					 */					
			else if ($functionString[1] == 'repeat')
			{
				if (preg_match('%\s*"?(.*?)"?\s*\|\|\s*"?(.*?)"?\s*$%s',$functionString[2], $param))
				{  
				   $param = str_replace($this->escapeChars,$this->replaceChars,$param);
				   $wReturn  = '';
					$loop = 0;
					$maxLoop = $this->maxIterations;
					
               $param[1] = $this->parseScript($param[1],$localVars,$level+1);
               if (is_numeric($param[1])) 
					{   while (($param[1]--) && ($loop < $maxLoop))
					   {
   						$wReturn .= $this->parseScript($param[2],$localVars,$level+1);
	   					$loop++;
		   			}
			   		if ($loop >= $maxLoop)
				   	{
					   	$wReturn  .= $this->showError("Maximum number of iterations ($maxLoop) reached in <i>repeat</i>.", 7);
					   }		
					}
					else
					{
					   $wReturn .= $this->showError('First parameter must be numeric.',8);
					}
				}
			   else
			   {  $wReturn = $this->showError('Syntax error in <i>repeat</i> statement.',9);
			   }
         
            
			}

					/******************************************************/
					/*** for construct
					/******************************************************/
					
					/**
					 *   {{#for | x || y || z ||
					 *   ..loop code..           
					 *   }}                      
					 *
					 */
			else if  ($functionString[1] == 'for')
			{
				if (preg_match('%\s*"?(.*?)"?\s*\|\|\s*"?(.*?)"?\s*\|\|\s*"?(.*?)"?\s*\|\|\s*"?(.*?)"?\s*$%s',$functionString[2],  $param))
				{  $param = str_replace($this->escapeChars,$this->replaceChars,$param);
					$wReturn  = '';
					$loop = 0;
					$maxLoop = $this->maxIterations;
					

					$this->parseScript($param[1],$localVars,$level+1);
					while ($out  = $this->parseScript($param[2],$localVars,$level+1) && $loop < $maxLoop)
					{
						$wReturn .= $this->parseScript($param[4],$localVars,$level+1);
						$this->parseScript($param[3],$localVars,$level+1);
						$loop++;
					}
					if ($loop >= $maxLoop)
					{
						$wReturn  .= $this->showError("Maximum number of iterations ($maxLoop) reached in for.",10);
					}
				}
				else
			   {  $wReturn = $this->showError('Syntax error in <i>for</i> statement.',11);
			   }
				
			}
			
				   /******************************************************/
					/*** foreach construct
					/******************************************************/

					/**
					 *   {{#foreach | var || key || value ||
					 *   ..loop code..           
					 *   }}                      
					 *
					 
					 *   {{#foreach | var || value ||
					 *   ..loop code..           
					 *   }}                      
					 *					 
					 
					 *   {{#foreach | var ||
					 *   ..loop code..           
					 *   }}                      
					 *
					 *
					 *   _key   _value   -  special variables, always present in foreach loop
				    *   _k     _v       -  special variables, present when not user defined
					 * 
					 * 
					 */		
			else if ($functionString[1] == 'foreach')
			{
				if (     preg_match('%\s*"?(.*?)"?\s*\|\|\s*"?(.*?)"?\s*\|\|\s*"?(.*?)"?\s*\|\|\s*"?(.*?)"?\s*$%s',$functionString[2], $param)				
				      OR preg_match('%\s*"?(.*?)"?\s*\|\|\s*"?(.*?)"?\s*\|\|\s*"?(.*?)"?\s*$%s',$functionString[2], $param)				      				      
				      OR preg_match('%\s*"?(.*?)"?\s*\|\|\s*"?(.*?)"?\s*$%s',$functionString[2], $param)
				   )
				{  
				   $param = str_replace($this->escapeChars,$this->replaceChars,$param);
				   
				   $wReturn  = '';
				   
				   $param[1] = $this->parseScript($param[1],$localVars,$level+1);
				   if (array_key_exists($param[1],$localVars) && is_array($localVars[$param[1]]))
				   {  				   				   
				      
                  
                  if (count($localVars[$param[1]]) < $this->maxIterations)
                  {
                     $valuename = '_k';
                     $valuevar  = '_v';
                     
                     if (count($param) == 4)
                     {  
                        $valuevar = $this->parseScript($param[2],$localVars,$level+1); 
                     }
                     else if (count($param) == 5)              
                     {  
                        $valuename = $this->parseScript($param[2],$localVars,$level+1);
                        $valuevar  = $this->parseScript($param[3],$localVars,$level+1); 
                     }
                                                         
                     foreach ($localVars[$param[1]] as $n=>$v)
         		      {  
   				         $localVars['_key'] = $n;
   				         $localVars[$valuename] = $n;
   				         $localVars['_value'] = $v;
   				         $localVars[$valuevar] = $v;
   				         $wReturn .= $this->parseScript($param[count($param)-1],$localVars,$level+1);   			   
		   		      }
		   		   }
		   		   else
		   		   {  $wReturn = $this->showError("Array <i>$param[1]</i> larger than maximum number of allowed iterations ($this->maxIterations) in <i>foreach</i>.",23);
		   		   }
		   		}
		   		else
		   	   {
		   	      $wReturn = '';
		   	   }			   	
				}
			   else
			   {  
			      $wReturn = $this->showError('Syntax error in <i>foreach</i> statement.',12);
			   }            
			}
			
					/******************************************************/
					/*** Function construct
					/******************************************************/

               /**
					 *   {{#function | functionName || 
					 *   ..function code..           
					 *   }}                      
					 *
					 *   parameters are passed using variable names 1, 2, .., n
					 *
                */
			else if  ($functionString[1] == 'function')
			{  
			   if (preg_match('%\s*"?(.*?)"?\s*\|\|\s*"?(.*)"?\s*%s',$functionString[2],  $param))
				{  $param = str_replace($this->escapeChars,$this->replaceChars,$param);
				   $funcname = strtolower($this->parseScript($param[1],$localVars,$level+1));
					$this->functions[$funcname]['eval'] = $param[2];
					$wReturn = NULL;
				}
				else if (preg_match('%\s*"?(.*?)"?\s*%s',$functionString[2],  $param))
				{  $param = str_replace($this->escapeChars,$this->replaceChars,$param);
				   $funcname = strtolower($this->parseScript($param[1],$localVars,$level+1));
					$wReturn = $this->functions[$funcname]['eval'];
				}
				else
				{  $wReturn = $this->showError("Error defining function <i>$param[1]</i>.",13);				
				}
				
			}
			      /******************************************************/
			      /* Define - Do C-like "macros"
			      /******************************************************/
			      
			      /**
					 *   {{#define | search | replace  }}                      
					 *   {{#str_replace_all | search | replace  }}                      
					 *
					 *   Affects all program code at the same nesting level or higher
					 *
			       */			
			else if ($functionString[1] == 'define' || $functionString[1] == 'str_replace_all'  )
			{  if (preg_match('%\s*"?(.*?)"?\s*\|\s*"?(.*)"?\s*%s',$functionString[2],  $param))
				{  
				      $param = str_replace($this->escapeChars,$this->replaceChars,$param);
				      $text = substr_replace($text,'',strpos($text,$functionString[0]),strlen($functionString[0])); 			       				    
				    
				      $text = str_replace($param[1],$param[2],$text);
				      $wReturn = false;			     
					 
				}
				else
				{  $wReturn = $this->showError('Syntax error in <i>' . $functionString[1] . '</i> statement.',14);				
				}
         }
                  
         	   /******************************************************/
					/*** Eval construct
					/******************************************************/
				   
				   /**
					 *   {{#eval | ..code..  }}                      
					 *
					 *   formats and evaluates code generated at runtime
					 *
			       */			       			       
			else if ($functionString[1] == 'eval')
			{
				if (preg_match('%\s*"?(.*?)"?\s*$%s',$functionString[2], $param))
				{  
				   // first evaluate top level escape chars				   				   				   
				   $param[1] = str_replace($this->escapeChars,$this->replaceChars,$param[1]);				   				   
               
               // first get rid of any existing nesting formatting
      		   $param[1] = preg_replace('%}`+%', '}', $param[1]);
		         $param[1] = preg_replace('%\|`+%', '|', $param[1]);
		         $param[1] = preg_replace('%\^`+%', '^', $param[1]);  
               
               
               // then format again
				   $param[1] = $this->preprocess($param[1],true);
				  
				   // then parse
					$param[1] = $this->parseScript($param[1],$localVars,$level+1);
					
					$wReturn = $param[1];
				   
				}
			   else
			   {  $wReturn = $this->showError('Syntax error in <i>eval</i> statement.',15);
			   }                     
			}
         
               /******************************************************/
			      /* noeval construct
			      /******************************************************/
				   
				   /**
					 *   {{#noeval | ..code..  }}                      
					 *
					 *   Echo text without evaluating it by converting
					 *  { | } to their html character codes.  
					 *   It's better to use <nowinter> if possible
					 *
			       */
			else if ($functionString[1] == 'noeval')
			{     $wReturn = $this->postprocess($functionString[2]);
				   $wReturn = str_replace($this->escapeChars,$this->replaceChars,$wReturn);
				   
				   $replace = array ('{' => '&#123;',
				                     '|' => '&#124;',
				                     '}' => '&#125;');
				   				   
				   $wReturn = str_replace(array_keys($replace),array_values($replace), $wReturn);
				     			   
			}

               /******************************************************/
			      /* comment construct
			      /******************************************************/
				   
				   /**
					 *   {{#comment | ..anything..  }}                      
					 *
					 *   Return nothing without evaluating parameters
					 *
			       */
			else if ($functionString[1] == 'comment' || $functionString[1] === '')
			{     $wReturn = '';				     			   
			}
			         
			      /******************************************************/
			      /* Check for expressions inside the parameters.
			      /* if found, parse them.
			      /******************************************************/

			else if (strpos($functionString[2], '{{#') !== false)
			{ 
				$parsedParams = $this->parseScript($functionString[2],$localVars,$level+1);
				
				$wReturn = '{{#' . $functionString[1] . '|' . $parsedParams . '}}';
			}

					/******************************************************/
					/*** Now we begin looking for general functions
					/******************************************************/

			else
			{
				switch ($functionString[1])
				{

					/******************************************************/
					/*** Logic functions
					/******************************************************/
					
					/**
					 * {{#iff | bool | .. true code .. }}
					 *
					 * {{#iff | bool | .. true code .. | .. false code ..}}
					 * 
					 */					
					case 'iff':
						if ($param = $this->hasParamNum(2,$functionString))
						{  $wReturn  = (($param[1])?$param[2]:'');
						}

						if ($param = $this->hasParamNum(3,$functionString))
						{  $wReturn  = (($param[1])?$param[2]:$param[3]);
						}
					break;
                  
               /**
					 * {{#not | bool }}
					 *
					 */
					case 'not':
						if ($param = $this->hasParamNum(1,$functionString))
						{  $wReturn  = (($param[1])?'0':'1');
						}
					break;


					/**
					 * {{#ifeq | a | b | .. eq code .. }}
					 *
					 * {{#ifeq | a | b | .. eq code .. | .. neq code ..}}
					 * 
					 */
					case 'ifeq':
						if ($param = $this->hasParamNum(3,$functionString))
						{  $wReturn  = (($param[1] == $param[2])?$param[3]:NULL);
						}
						else if($param = $this->hasParamNum(4,$functionString))
						{  $wReturn  = (($param[1] == $param[2])?$param[3]:$param[4]);
						}

					break;
					
					
					/**
					 * {{#ifneq | a | b | .. not eq code .. }}
					 *
					 * {{#ifneq | a | b | .. not eq code .. | .. eq code ..}}
					 * 
					 */
					case 'ifneq':
						if ($param = $this->hasParamNum(3,$functionString))
						{  $wReturn  = (($param[1] != $param[2])?$param[3]:NULL);
						}
						if ($param = $this->hasParamNum(4,$functionString))
						{  $wReturn  = (($param[1] != $param[2])?$param[3]:$param[4]);
						}
					break;

					
					/******************************************************/
					/*** Variable functions
					/******************************************************/

					/**
					 * {{#unsetvar| var }}
					 * 
					 */
					case 'unsetvar':
						if ($param = $this->hasParamNum(1,$functionString))
						{  unset($localVars[$param[1]]);
							$wReturn  = NULL;
						}
					break;

					/**
					 * {{#isset| var }}
					 * 
					 * returns bool
					 *
					 */
					case 'isset':
						if ($param = $this->hasParamNum(1,$functionString))
						{
							$wReturn  = array_key_exists($param[1],$localVars)?'1':'0';
						}
					break;

					/******************************************************/
					/*** setvar & var (Variable operations)
					/******************************************************/									
					
					/**
					 * {{#setvar | varname | value }}
					 * {{#setvar | varname | x-index | value }}
					 * {{#setvar | varname | x-index | y-index |value }}
					 *
					 * {{#var | varname }}
					 * {{#var | varname | x-index }}
					 * {{#var | varname | x-index | y-index }}
					 * {{#var | varname | operator }}
					 * {{#var | varname | operator | value }}
					 *
					 */
					case 'setvar':
					case 'var':
					   
						$fallthru = false;
						
					   // {{#var | varname  }}
						if ($param = $this->hasParamNum(1,$functionString))
						{  
						   $param[1] = strtolower($param[1]);
						   if (array_key_exists($param[1],$localVars))
						   {  $var = $localVars[$param[1]];
						      if (!is_array($var))
						      {   						      
	   						   $wReturn  = $var;
		   					}
			   				else
				   			{  $wReturn = $this->implodeRecursive('|',$var);
					   	   }
					   	}
					   	else
					   	{  $localVars[$param[1]] = '';
					   	   $wReturn = '';
					   	}
						}
						
						/**
						 * {{#setvar | varname | value }}
						 * {{#var | varname | operator }}
						 * {{#var | varname | x index }}
						 *
						 */
						 
						else if  ($param = $this->hasParamNum(2,$functionString))
						{  
						   $param[1] = strtolower($param[1]);
						   
						   if (!array_key_exists($param[1],$localVars))
						   { $localVars[$param[1]] = '';
						   }
						   
						   if ($param[2] == '++')
							{  $wReturn  = $localVars[$param[1]]++;
							} else if ($param[2] == '--')
							{  $wReturn  = $localVars[$param[1]]--;
							} else if ($functionString[1] == 'setvar')
							{  
							   $localVars[$param[1]] = $param[2];
								$wReturn = NULL;
							}
							 else if ( $functionString[1] == 'var' && 
							            is_array($localVars[$param[1]])
							            
							          )
							{  if (array_key_exists($param[2], $localVars[$param[1]]))
							   {  
							      if (is_array($wReturn))
                           {  $wReturn = implode('|',$wReturn);
                           }  else
                           {  $wReturn = $localVars[$param[1]][$param[2]]; 
                           }
                        }
                        else
                        {  
                           $wReturn = $localVars[$param[1]][$param[2]] = '';
                        }
                     }
						}
						
						/**
						 * {{#setvar | varname | x-index | value }}
						 * {{#var | varname | operator | value }}
						 * {{#var | varname | X index | y index }}
						 *
						 */
						
						else if($param = $this->hasParamNum(3,$functionString))
						{  
						   $param[1] = strtolower($param[1]);
						   
						   if (!array_key_exists($param[1],$localVars))
						   { $localVars[$param[1]] = '';
						   }
							
							// {{#setvar | varname | x-index | value }}
							if ($functionString[1] == 'setvar')
							{  
							   $localVars[$param[1]][$param[2]] = $param[3];
								$wReturn = NULL;
							}
							else							
							{  $isSilent = false;
							   $param3 = $param[3];
							   
							   // check for @ modifier (silent assignment)
							   							   
							   if (strpos($param[2],'@') === 0)
							   {  $isSilent = true;
							      $param[2] = substr($param[2],1);
							   }							      
							   
   							switch($param[2])
   							{
   								case '=':
   									$localVars[$param[1]] = $param3;
   									$wReturn = $param3;
   								break ;
   
   								case '+=':
   									$localVars[$param[1]] += $param3;
   									$wReturn = $localVars[$param[1]];
   								break  ;
   
   								case '-=':
   									$localVars[$param[1]] -= $param3;
   									$wReturn = $localVars[$param[1]];
   								break  ;
   
   								case '*=':
   									$localVars[$param[1]] *= $param3;
   									$wReturn = $localVars[$param[1]];
   								break  ;
   
   								case '/=':
   									if ($param3 != 0)
   									{  $localVars[$param[1]] /= $param3;
   									}
   									else
   									{  $localVars[$param[1]] /= $this->showError('Divide by Zero using assignment.',16);
   									}
   									$wReturn = $localVars[$param[1]];
   								break  ;
   
   								case '.=':
   									$localVars[$param[1]] .= $param3;
   									$wReturn = $localVars[$param[1]];
   								break  ;
                           
                           case '&lt;-':
                           case '<-':
   									if (array_key_exists($param[3],$localVars))
   									{  $localVars[$param[1]] = $localVars[$param[3]];
   									   $wReturn = $localVars[$param[1]];
   								   }
   								break  ;
   								
   								case '&lt;=&gt;':
                           case '<=>':                           
   									if (array_key_exists($param[3],$localVars))
   									{  $localVars[$param[1]] =& $localVars[$param[3]];
   									   $wReturn = $localVars[$param[1]];
   								   }
   								break  ;
   								
   								default:
   								   //  Didn't match assignment operators above
   								   //   check some special cases
   								      								
   								   // Check for 2D array assignment ( [][]= )
   								   // Need to adapt for N-dimensional arrays
   								   if (preg_match('%\[\s*"?(.*?)"?\s*\]\[\s*"?(.*?)"?\s*\]\s*\=%s',$param[2],$new_params))
   								   {  
   								      if ( array_key_exists($new_params[1],$localVars[$param[1]]) && 
							                   !is_array($localVars[$param[1]][$new_params[1]]))
							            {  $localVars[$param[1]][$new_params[1]] = array();
							            }
							                								       
   								      $wReturn = $dest = $this->arrayFlatten($param3,0);   							   								           								      
   								      if ($new_params[1] === '' && $new_params[2] === '')
   								      {   $localVars[$param[1]][][] = $dest;   								         
   								      }
   								      else if ($new_params[1] === '' && $new_params[2] !== '')
   								      {  $localVars[$param[1]][][$new_params[2]] = $dest;   								         
   								      } 
   								      else if ($new_params[1] !== '' && $new_params[2] === '')
   								      {  $localVars[$param[1]][$new_params[1]][] = $dest;   								         
   								      } 
   								      else if ($new_params[1] !== '' && $new_params[2] !== '')
   								      {   $localVars[$param[1]][$new_params[1]][$new_params[2]] = $dest;   								         
   								      }    								      
   								   }
   								   
   								   // check for 1D array assignment ([]=)
   								   else if (preg_match('%\[\s*"?(.*?)"?\s*\]\s*\=%s',$param[2],$new_params))
   								   {  
   								      $wReturn = $dest = $this->arrayFlatten($param3,1); 
   								         								      
   								      if ($new_params[1] === '')
   								      {   $localVars[$param[1]][] = $dest;
   								       
   								      }
   								      else
   								      {   $localVars[$param[1]][$new_params[1]] = $dest;
   								       
   								      }   								      
   								   }
   								   
   								   // check for 2D array referencing
   									else if ( $functionString[1] == 'var' && 
							            array_key_exists($param[1], $localVars) &&
							            is_array($localVars[$param[1]]) && 
							            array_key_exists($param[2], $localVars[$param[1]])
							            && is_array($localVars[$param[1]][$param[2]]) && 
							            array_key_exists($param[3], $localVars[$param[1]][$param[2]])
							                  )
							         {
							            $wReturn = $localVars[$param[1]][$param[2]][$param[3]]; 
							            if (is_array($wReturn))
                                 {  $wReturn = implode('|',$wReturn);
                                 }  
                              }                                                            
                              else
   									{  /*************************************
   									     var didn't match any case
   									     prepare to fall through to #op
   									   **************************************/
   									   $fallthru = $localVars[$param[1]];
   								   }   							 
   							}
   							if ($isSilent)
   							{  $wReturn = '';
   						   }  
   					   }
						}						

						/**
						 * {{#setvar | varname | x-index | y-index | value }}
						 * {{#var | varname | a | b | .. | n }}
						 *
						 */

						else 
						{  						   
						   $param = $this->getParams($functionString);
						   $numparams = count($param)- 1;  //substract index 0 which is the whole string
						 	
						 	$param[1] = strtolower($param[1]);						   
						   if (!array_key_exists($param[1],$localVars))
						   { $localVars[$param[1]] = '';
						   }
						 	// {{#setvar | varname | x-index | y-index | value }}
						 	
						 	if ($functionString[1] == 'setvar' && $numparams == 4)
							{ 
							   if ( array_key_exists($param[2],$localVars[$param[1]]) && 
							        !is_array($localVars[$param[1]][$param[2]]))
							   {  $localVars[$param[1]][$param[2]] = array();
							   }
							   
							   $localVars[$param[1]][$param[2]][$param[3]] = $param[4];
							   
								$wReturn = NULL;
							}
						   
						   // see if we can rewrite longer operations and if so, do it
						   else if (($numparams > 3) && 
						            ($numparams/2 != round($numparams/2 )) 
						           )
						   {  
						      
						      $levels = $numparams / 2 - 1;
						      $out = str_repeat('{{#var|',$levels+1);
						      $paramsleft = $numparams;
						      
						      $out .= $param[1].'|'.$param[2].'|'.$param[3].'}'.str_repeat('`',$levels).'}'.str_repeat('`',$levels);
						      $levels--;
						      $paramsleft -= 3;
						      for ($paramsleft ; $paramsleft > 0; $paramsleft -= 2, $levels--)
						      {  $curparam = $numparams - $paramsleft + 1;
						         $out .= '|'.$param[$curparam].'|'.$param[$curparam + 1].'}'.str_repeat('`',$levels).'}'.str_repeat('`',$levels);
						      }
						      
						      $wReturn = $out;
						   	
					      }
						   
						   else
						   {  
						      $wReturn = $this->showError('Syntax error in <i>variable: ' . $param[1] . '</i> statement.',17);
						      break;						   
						   }
						 
                  }
				  /**
					*  if the operator isn't supported by #var, we will check to
					*  see if is supported by the more general function #op
					*
					*  This is accomplished by not breaking and formatting
					*  the parameters to how #op expects them (ie substituting the
					*  variable's value for the variable's name)
					*/
					if ($fallthru === false)
					{  if ($functionString[1] == 'setvar')
						{  $wReturn = NULL;
						}
						break;
					}

					case 'op':
					   
					   $param = $this->getParams($functionString);
						$numparams = count($param)- 1;  //substract index 0 which is the whole string
						
                  if ($numparams == 1 && (strpos($param[1],' ') !== false))
					   {  
					      
					      if ( substr_count($param[1],'(') != substr_count($param[1],')' ) )
					      {  $wReturn = $this->showError('Syntax error in <i>operation</i> statement - parentheses must match.',18);
					      }
					      else
					      { 
							   $param[1] = preg_replace('%(#'. $this->pregWord . '+)%', '{{$1|}}',$param[1]);
							   $param[1] = preg_replace('%\(\s*%', '{{#op|',$param[1]);
							   $param[1] = preg_replace('%\s*\)%', '}}',$param[1]);
							   $param[1] = preg_replace('%\s+%', '|',$param[1]);
							   
							   $param[1] = $this->preprocess("{{#op|$param[1]}}",true);
							   
							   $param[1] = $this->parseScript($param[1]);
							   
							   $wReturn = $param[1];							 
							}					
						}
						else if ($numparams > 3 && ($numparams/2 != round($numparams/2 )))
						{  $levels = $numparams / 2 -1;
						   $out = str_repeat('{{#op|',$levels+1);
						   $paramsleft = $numparams;
						   
						   $out .= $param[1].'|'.$param[2].'|'.$param[3].'}'.str_repeat('`',$levels).'}'.str_repeat('`',$levels);
						   $levels--;
						   $paramsleft -= 3;
						   for ($paramsleft ; $paramsleft > 0; $paramsleft -= 2, $levels--)
						   {  $curparam = $numparams - $paramsleft + 1;
						      $out .= '|'.$param[$curparam].'|'.$param[$curparam + 1].'}'.str_repeat('`',$levels).'}'.str_repeat('`',$levels);
						   }
						   
						   $wReturn = $out;
							
					   }
						else if ($numparams == 3)
						{  if (isset($fallthru) && $fallthru !== false)
							{  // if we're falling thru from #var, correct
								// param[1] as mentioned above

								$param[1] = $fallthru;
							}
                     
							switch($param[2])
							{
					/******************************************************/
					/*** Arithmetic operators
					/******************************************************/
								case '+':
									$wReturn = $param[1] + $param[3];
								break;

								case '-':
								  $wReturn = $param[1] - $param[3];
								break;

								case '*':
									$wReturn = $param[1] * $param[3];
								break;

								case '/':
									if ($param[3] != 0)
									{  $wReturn = $param[1] / $param[3];
									}
									else
									{  $wReturn = $this->showError('Divide by Zero using division operator.',19);
									}
								break;

								case 'mod':
									$wReturn = fmod($param[1],$param[3]);
								break;
								
								case '^':
									$wReturn = pow($param[1],$param[3]);
								break;
								
                        case '&amp;':
                        case '&':
									$wReturn = $param[1] & $param[3];
								break;
								
								case '&#160;?':
                        case '?':
									$wReturn = $param[1] | $param[3];
								break;
								
                        case 'xor':
									$wReturn = $param[1] ^ $param[3];
								break;

                        case '&gt;&gt;':
                        case '>>':
									$wReturn = $param[1] >> $param[3];
								break;
								
								case '&lt;&lt;':
                        case '<<':
									$wReturn = $param[1] << $param[3];
								break;

					/******************************************************/
					/*** Logic operators
					/******************************************************/

								case '==':
									$wReturn = ($param[1] == $param[3])?'1':'0';
								break;
								
								case '===':
									$wReturn = ($param[1] === $param[3])?'1':'0';
								break;
								
								case '!=':
								case '&nbsp;!=':
									$wReturn = ($param[1] != $param[3])?'1':'0';
								break;

								case '!==':
								case '&nbsp;!==':
									$wReturn = ($param[1] !== $param[3])?'1':'0';
								break;

								case '<':
								case '&lt;':
									$wReturn = ((int)$param[1] < (int)$param[3])?'1':'0';
								break;
                        
                        case '>':
								case '&gt;':
									$wReturn = ((int)$param[1] > (int)$param[3])?'1':'0';
								break;

								case '<=':
								case '&lt;=':
									$wReturn = ((int)$param[1] <= (int)$param[3])?'1':'0';
								break;

								case '>=':
								case '&gt;=':
									$wReturn = (int)($param[1] >= (int)$param[3])?'1':'0';
								break;

								case 'and':
									$wReturn = ($param[1] && $param[3])?'1':'0';
								break;

								case 'or':
									$wReturn = ($param[1] || $param[3])?'1':'0';
								break;

								default:
									$wReturn = $this->showError("operator <i>$param[2]</i> not defined in ($param[1]|$param[2]|$param[3]).",20);									

							} // end switch
						}
					
						else if ($param = $this->hasParamNum(1,$functionString))
						{ 
						    $wReturn = $param[1];
						 
					   }

					break;
					
					/******************************************************/
					/*** Numeric functions
					/******************************************************/						
	
					/**
					 *  
                *  {{#add | 1 | 2 | .. | n }}                
                *
                */
				   case 'add':
				   case 'subtract':
				   case 'multiply':
				   case 'divide':				   
				      
				      if ($param = $this->getParams($functionString))
				      {  $size = count($param);
				         $tmp = $param[1];
				         for ($i = 2; $i < $size; $i++)
				         {  switch($functionString[1])
				            {  
				               case 'add':
				                  $tmp += $param[$i];
				               break;
				               
				               case 'subtract':
				                  $tmp -= $param[$i];
				               break;
				               
				               case 'multiply':
				                  $tmp *= $param[$i];
				               break;
				               
				               case 'divide':
				                  if ($param[$i] != 0)
									   {  $tmp /= $param[$i];
									   }
									   else
									   {  $tmp = $this->showError('Divide by Zero using <i>divide</i>.',21);
									      $i = $size;
									   }				                  
				               break;				               
				            }
				         }      
				         $wReturn = $tmp;
				      }
               break;


					/******************************************************/
					/*** String functions
					/******************************************************/

				   /**
                *  {{#substr | string | offset }}
                *  {{#substr | string | offset | length }}
                *
                */ 

					case 'substr':
						if ($param = $this->hasParamNum(2,$functionString))
						{  
						   $wReturn  = substr($param[1],$param[2]);						   
						} else if ($param = $this->hasParamNum(3,$functionString))
						{  
						   $wReturn  = substr($param[1],$param[2], $param[3]);
						}
						$wReturn  = ($wReturn)?$wReturn:'';
					break;

				   /**
                *  {{#strpos | string | needle | replace }}
                *  {{#strpos | string | needle | replace | offset }}
                *
                */ 

					case 'strpos':
						if ($param = $this->hasParamNum(3,$functionString))
						{  $wReturn = strpos($param[1],$param[2], $param[3]);
						   $wReturn  = ($wReturn)?$wReturn:'';
						}
						else if ($param = $this->hasParamNum(2,$functionString))
						{  $wReturn = strpos($param[1],$param[2]);
						   $wReturn  = ($wReturn)?$wReturn:'';
						}
					break;

				   /**
                *  {{#str_replace| haystack | needle | replace }}
                *
                */ 

					case 'str_replace':
						if ($param = $this->hasParamNum(3,$functionString))
						{  
						   $wReturn  = str_replace($param[1],$param[2],$param[3]);
						}
					break;

					
				   /**
                *  {{#preg_replace| regular expression | replace | haystack }}
                *  {{#preg_replace| regular expression | replace | haystack | limit }}
                *
                */ 

					case 'preg_replace':
						if ($param = $this->hasParamNum(3,$functionString))
						{
							$wReturn  = preg_replace($param[1],$param[2],$param[3]);
						} else if ($param = $this->hasParamNum(4,$functionString))
						{
							$wReturn  = preg_replace($param[1],$param[2],$param[3], $param[4]);
						}
					break;
					

               /**
                * Various php string functions which take one parameter
                *
                *  {{#strtoupper| string }}
                *
                *
                */ 
                
					case 'strtoupper':
					case 'strtolower':
					case 'ucfirst':
					case 'trim':
					case 'ltrim':
					case 'rtrim':
					case 'strlen':
					case 'strip_tags':
					case 'time':
					case 'microtime':
					case 'urlencode':
					   if ($param = $this->hasParamNum(1,$functionString))
					   {  
					      $wReturn = call_user_func($functionString[1],$param[1]);					      					      
					      $wReturn = ($wReturn !== false)?$wReturn:'';
					      
					   }
					
					break;
					
                              
               /******************************************************/
					/*** Array functions
					/******************************************************/
					
					
					 /**
                * Array creation and return
                *
                * {{#array | array_name }}
                *    if array name exists, returns the array as a 1 dimensional list
                *    separated by |.  If doesn't exist, creates array.
                *
                * {{#array | array_name  | 1 | 2 | ... | n }}
                *    Creates an array with n members
                *  
                */    

               case 'array':
                  $didreturn = false;
                  if ($param = $this->hasParamNum(1,$functionString))                     
                  {  $param[1] = format_array_name($param[1]);
                     if (array_key_exists($param[1], $localVars) &&
                         is_array($localVars[$param[1]]))
                     {  $wReturn = implode('|',$localVars[$param[1]]);
                        $didreturn = true;
                        
                     }
                  }
                  
                  if (!$didreturn)
                  {
                     $param = $this->getParams($functionString);
                     $param[1] = strtolower($param[1]);
                     $localVars[$param[1]] = array();
                     $size = count($param);
                  
                     for ($i = 2;$i < $size;$i++)
                     {                                              
                        if (preg_match('%^(.*?)"?\s*\=\>\s*"?(.*?)$%s',$param[$i],$arr_param))
                        {
                            $localVars[$param[1]][$arr_param[1]] = $arr_param[2];                           
                        }                     
                        else 
                        {
                           $localVars[$param[1]][] = $param[$i];
                        }                   
                     }
                     $wReturn = NULL;
                  }
               break;
                              
               case 'count':
                  if (  ($param = $this->hasParamNum(1,$functionString)) && 
                        array_key_exists($param[1] = strtolower($param[1]),$localVars) && 
                        is_array($localVars[$param[1]])
                    )
                  {  
                     $wReturn = count($localVars[$param[1]]);
                  } else
                  {  
                     $wReturn = count( $this->getParams($functionString)) - 1;
                  }
                  
               break;
               
               
               /**
                * Array sorting functions.  Arrays passed by reference.  True returned on sucess
                *
                * {{#array_rand | array_name }}
                *    Returns a random key from the arrar
                *
                * {{#array_rand | array_name | size }}
                *    Returns an array or a specific size with random keys 
                *
                * {{#array_rand | array_name | size | 'values' }}
                *    Returns a randomized array vales
                *
                */                              

               case 'array_rand':
               case 'array_rand_value':
                  if ($param = $this->hasParamNum(1,$functionString))
                  {   $param[1] = strtolower($param[1]);
                      $rand = array_rand($localVars[$param[1]]);
                      $wReturn = ($functionString[1] == 'array_rand') ?
                                  $rand : $localVars[$param[1]][$rand];
                                 
                  }
                  else if ($param = $this->hasParamNum(2,$functionString))
                  {  $param[1] = strtolower($param[1]);
                     $arr_size = count($localVars[$param[1]]);                    
                     $param[2] = ($param[2] >= $arr_size || $param[2] < 1)? $arr_size:$param[2];
                     $rand_order = array_rand($localVars[$param[1]],$param[2]);
                     
                     if ($functionString[1] == 'array_rand')                     
                     {  $tmp_arr = $rand_order;
                     }
                     else
                     {
                        $tmp_arr = array();
                        for($i = 0;$i < $param[2];$i++)
                        {  $tmp_arr[] = $localVars[$param[1]][$rand_order[$i]];
                        }
                     }
                     
                     $wReturn = implode($tmp_arr,'|');  
                  }
                  
               break;
               
               /**
                * Explode - breaks a string up into an array by a delimiter
                *
                * {{#explode | delimiter | string }}
                * returns list
                *
                * {{#explode | delimiter | string | array }}
                * returns nothing
                */
               case 'explode':
                  if ($param = $this->hasParamNum(3,$functionString))
                  {  
                     $localVars[$param[3]] = explode($param[1],$param[2]);
                     $wReturn = '';
                  }                  
                  else if ($param = $this->hasParamNum(2,$functionString))
                  {  
                     $wReturn = ($wReturn = explode($param[1],$param[2]))?$wReturn:''; 
                  }
              break;
               
               /**
                * Implode - Combines elements of an array using delimiter
                *
                * {{#implode | delimiter | array }}
                *
                * {{#implode | delimiter | list }}
                */

              case 'implode':
                 if ($param = $this->hasParamNum(2,$functionString) && 
                     array_key_exists($param[2],$localVars) && 
                     is_array($localVars[$param[2]])
                    )
                  {  
                     $wReturn = ($wReturn = implode($param[1],$localVars[$param[2]]))?$wReturn:'';
                  }
                  else if ($param = $this->getParams($functionString))
                  {  $arr = array();
                     $cnt = count($param);
                     for ($i = 2; $i > $cnt;$i++)
                     {  $arr[] = $param[$i];
                     }
                     $wReturn = ($wReturn = implode($param[1],$arr))?$wReturn:'';
                  }
              break;        

               
               /**
                * Array sorting functions
                *
                * {{#sort | array_name | ['#number' / '#string'] }}
                *
                */

               case 'sort':
               case 'rsort':
					case 'asort':
					case 'arsort':
					case 'natsort':
					case 'ksort':
					case 'krsort':
				
				      if ($param = $this->getParams($functionString))
				      {  $numparams = count($param)- 1;
				         
				         
				         
				         $arr = array();
				         
					      if (  (  (  ($numparams == 2)  && 					              
					                  (  (($param[2] = strtolower($param[2])) == '#string') ||
					                     ($param[2] == '#number') 
					                  ) 
					               ) || ($numparams == 1)
					            )  &&					            
					            array_key_exists($param[1] = strtolower($param[1]), $localVars) &&
                           is_array($localVars[$param[1]])
                        )
					      { $param[1] = $param[1];
					        $arr =  $localVars[$param[1]];
					        $showarr = false;
					        
					      } 
					      else
					      {  
					         for ($i = 1;$i <= $numparams; $i++)
					         {  $arr[] = $param[$i];
					         }
					         $showarr = true;
					         $numparams = 1;
					         $param[2] = '';
					         
					      }   
					          
					      if ($numparams == 1)
					      {  
					         $ret = $functionString[1]($arr);
					        
					      }   
					      else if ($numparams == 2 && $functionString[1] != 'natsort')
					      { 
					         if (strtolower($param[2]) == '#number')
					         {  $flag = SORT_NUMERIC;
					         }
					         else if (strtolower($param[2]) == '#string')
					         {  $flag = SORT_STRING;
					         }
					         else
					         {  $flag = SORT_REGULAR;
					         }
					         
					         $ret = $functionString[1]($arr, $flag);
					      }
					      
					      if ($ret)
					      {  $wReturn = '';
					         if ($showarr)
					         { $wReturn = implode('|',$arr);
					         } else
					         { $localVars[$param[1]] = $arr;
					         }
					      }
					      else
					      {  $wReturn = $this->showError("There was a problem sorting the array with <i> $functionString[1] </i>.",22);
					      }
					         					      
					       unset($arr);
					   }
					break;
					
					
					/******************************************************/
					/*** Misc functions
					/******************************************************/

               /**
                * {{#nocache}}
                *
                * For use with dynamic scripts
                *
                */ 
                
               case 'nocache':
						global $wgParser;
						$wgParser->disableCache();
						$wReturn = NULL;

					break;
               

               /**
                * {{#default | wikiTemplateParam | defaultValue}}
                * {{#set_param_default | wikiTemplateParam | defaultValue}}
                *
                * 
                *
                */
               
					case 'default':
					case 'set_param_default':
						if ($param = $this->hasParamNum(2,$functionString))
						{
							$wReturn  = NULL;
							$text = str_replace('!{!`!{'.$param[1].'}!`!}!',$param[2],$text);
						}
					break;					

               /**
                * {{#null | .. anything .. }}
                * {{#comment | .. anything .. }}
                *
                */
                
					case 'null':					
						$wReturn = NULL;
					break;

               /**
                * {{#debug}}
                *
                *
                * Displays all user defined functions and variables
                * 
                */

               case 'debug':
                  $wReturn = "<pre>Operation count: $this->operationCount -- Nesting level: $level\nFunctions:\n" .
                              ( (count($this->functions)) ?  
                                    print_r($this->functions,true): 'No user defined functions'
                              ) . "\n\nVariables:\n" .
                              print_r($localVars,true) . 
                              
                            '</pre>';
               break;
               
               /**
                *  {{#rand}}
                *  {{#rand | upper limit}}
                *  {{#rand | lower | upper }}
                *
                */
                            
               case 'rand':
                  if ($param = $this->hasParamNum(1,$functionString))
                  {  if (!$param[1])
                     {  $wReturn = mt_rand();
                     } else
                     {  $wReturn = mt_rand(0,$param[1]);
                     }                     
                  }
                  else if ($param = $this->hasParamNum(2,$functionString))
                  {  $wReturn = mt_rand($param[1],$param[2]);
                  }               
               break;
               
               /**
                * {{#html_to_xml | html }}
                *    Prepends all tags with xml_ so html can be read with xml_xpath
                *
                */               
                
               case 'html_to_xml':
                  if ($param = $this->hasParamNum(1,$functionString))
                  {
                     $wReturn = str_replace('</','>/xml_',$param[1]);
                     $wReturn = str_replace('<','<xml_',$wReturn);
                     $wReturn = str_replace('>/xml_','</xml_',$wReturn);
                     
                  }  
               break;
               
               /**
                * {{#xml_xpath | xml | xpath statement }}
                *    Returns the xpath statement run on the xml
                *
                */

               case 'xml_xpath':
                  if ($param = $this->hasParamNum(2,$functionString))
                  { 
                    try 
                    { 
                     @ $xml = new SimpleXMLElement(html_entity_decode(strip_tags($param[1])));
                    
                     
                      if (@ ($wReturn = $xml->xpath($param[2])) !== false)
                      { 
                        if (is_array($wReturn))
                        {  $wReturn = implode('|',$wReturn);
                        }                                              
                      }
                      else 
                      {
                         $wReturn = '';
                      }
                    } catch (Exception $e) 
                    {
                      $wReturn = 'ERROR: String could not be parsed as XML';
                    }
                    
                  }
               break;
               
               case 'error':
                  if ($param = $this->hasParamNum(1,$functionString))
                  { $wReturn = $this->showError($param[1]);
                  }
               break;
               
               /**
                * {{#request_var | varname }}
                *
                * Returns the request variable
                *
                */                
               case 'request_var':
                  if ($param = $this->hasParamNum(1,$functionString))
                  {  global $wgRequest;
                     $wReturn = $wgRequest->getVal($param[1], '');                     
                  }
               break;
               
               /**
                * {{#request_var | varname }}
                *
                * Returns the request variable
                *
                */                
               case 'template_var':
                  if ($param = $this->hasParamNum(2,$functionString))
                  {  
                     if (  array_key_exists($param[2],$this->scriptVars['_templates']) &&
                           is_array($this->scriptVars['_templates'][$param[2]]) &&
                           array_key_exists($param[1],$this->scriptVars['_templates'][$param[2]])                           
                        )
                        
                     {  $wReturn = $this->scriptVars['_templates'][$param[2]][$param[1]];
                     }
                     else if ($param[2] == '{{{WinterTemplateID}}}')
                     {  $wReturn = "[Template Var $param[2]]";
                     }
                     
                     else                     
                     {   $wReturn = $this->showError("Template variable ($param[1])($param[2]) not defined");
                     }
                  }
               break;
               
               /**
                * {{#to_string | varname }}
                *
                * Changes the type cast
                *
                */                
               case 'to_str':
               case 'to_string':
                  if ($param = $this->hasParamNum(1,$functionString))
                  {  
                     $wReturn = (string)$param[1];
                  }
               break;

               /**
                * {{#to_integer | varname }}
                *
                * Changes the type cast
                *
                */                               
               case 'to_int':
               case 'to_integer':
                  if ($param = $this->hasParamNum(1,$functionString))
                  {  
                     $wReturn = (int)$param[1];
                  }
               break;


               /**
                * {{#show_page_text}}
                *
                * Shows original page code
                *
                */   
               
               case 'show_page_text':
                 				   
                  $replace = array ('{' => '&#123;',
				                     '|' => '&#124;',
				                     '}' => '&#125;');
				   				   
				      $wReturn = '<pre>'.str_replace(array_keys($replace),array_values($replace), $this->pageText).'</pre>';
				   break;

               /**
                * {{#version}}
                *
                * Shows Winter version
                *
                */   				   
				   case 'version':
				   
				      $wReturn = $this->winterVersion;
				   
				   break;

               /**
                * {{#date | datestring }}
                * {{#date | datestring | time }}
                *
                * Displays a string of the date
                *
                */   				   
				   case 'date':
				      if ($param = $this->hasParamNum(2,$functionString) && is_numeric($param[2]))
                  {   
                     $wReturn = date($param[1],$param[2]);
                  }                 
                  else if ($param = $this->hasParamNum(1,$functionString))
                  {  
                     $wReturn = date($param[1]);
                  }
               break;
               
               /**
                * {{#wordwrap | sting || length}}
                * {{#wordwrap | sting || length | break long words}}
                * Adds line breaks after length characters. wraps at spaces but                
                *
                */         
              
               case 'wordwrap':
                  if ($param = $this->hasParamNum(3,$functionString))
                  {  
                     $wReturn = wordwrap($param[1],$param[2],'<br />',$param[3]);
                  }
                  if ($param = $this->hasParamNum(2,$functionString))
                  {  
                     $wReturn = wordwrap($param[1],$param[2],'<br />',true);
                  }
               break;
              
               case 'keepnl':
                  $wReturn ='';
               break;
 					/**
 					 *
 					 *   {{#include | page name  }}                      
					 *
					 *   includes text from another page and parses with Winter engine
					 *
					 *   {{#include_raw | page name  }}                      
					 *
					 *   includes text from another page without parsing 
					 *
			       */	
               
               case 'include':
               case 'include_raw':
               	if ($param = $this->hasParamNum(1,$functionString))
               	{	$titleFromText = Title::newFromText($param[1]);
							$article = new Article($titleFromText);
 							
							$wReturn = $article->fetchContent() . '';
								
							if ($functionString[1] == 'include')
							{	$wReturn = $this->preprocess($wReturn,true);
				  
				   		// then parse
							$wReturn = $this->parseScript($wReturn,$localVars,$level+1);
							
               		}
               	} 
               	
               break;
               
               /******************************************************/
					/*** No function matched - check user defined functions 
					/*** and variable names
					/******************************************************/

					default:
						// Is user defined function?
						if (  is_array($this->functions) &&
								array_key_exists($functionString[1],$this->functions) &&
								$param = $this->getParams($functionString)
							)
						{  $param[0] = $functionString[1];
							
							// If function has been defined in script, evaluate it
							if (array_key_exists('eval',$this->functions[$functionString[1]]))
							{

										$func = $this->functions[$functionString[1]]['eval'];
										$wReturn = $this->parseScript($func, $param, $level + 1);
							}
							
							// else function was defined externally, call defined function
							else
							{  if (($ret = call_user_func($this->functions[$functionString[1]]['call'],$param)) !== false)
							   {  $wReturn  =  $ret;
							   }
							}
						}
						
						// not a user defined function, so treat as variable
						else
						{  
						   // If variable isn't defined, create
						   if (!array_key_exists($functionString[1],$localVars))
						   {  $localVars[$functionString[1]] = '';
						   }     
						   
						   //replace shortcut variable call with var syntax
						   if ($functionString[2] != '')
						   {
						         $functionString[2] = '|' . $functionString[2];
   				      }
	                  $wReturn = '{{#var|' . $functionString[1] . $functionString[2] . '}}';
							
						}
					break;

				} // end switch            				
			}
			 
			if ($wReturn !== false)
			{  $text = substr_replace($text,$wReturn,strpos($text,$functionString[0]),strlen($functionString[0]));
		   }
		}
		return $text;				
		
	} // End parseText()
	
} // End class Winter 



$wgWinter = new WinterScript();

$wgHooks['ParserBeforeStrip'][] = 'wfWinterBeforeStrip';
$wgHooks['ParserBeforeTidy'][]  = 'wfWinterBeforeTidy';

function wfWinterBeforeStrip( &$parser, &$text)
{  global $wgWinter, $wgWinterNamespaces;   
   
   $namespace = $parser->mTitle->mNamespace;
   
   if (isset($wgWinterNamespaces) && array_key_exists($namespace,$wgWinterNamespaces) 
         && !$wgWinterNamespaces[$namespace])
   {  return true;
   } 
   else
   {  wfRunHooks('WinterBeforeProcess',array(&$wgWinter,&$parser));
      if (strpos($text,'{{#') !== false)
	   {	
	   	$text = $wgWinter->preWikiProcess($text);
	   }
      
      return true;
   }   	      
}

function wfWinterBeforeTidy( &$parser, &$text)
{  global $wgWinter, $wgWinterNamespaces;
   
   $namespace = $parser->mTitle->mNamespace;
   
   if (isset($wgWinterNamespaces) && array_key_exists($namespace,$wgWinterNamespaces) 
         && !$wgWinterNamespaces[$namespace])
   {  return true;
   } else
   {  
	   $text = $wgWinter->processText($text); 
	   wfRunHooks('WinterAfterProcess',array(&$wgWinter,&$parser));
      return true;
   }
}

                                           
?>