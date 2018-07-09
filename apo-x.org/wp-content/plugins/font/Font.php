<?php
/*
  Plugin Name: Font
  Plugin URI: http://fontsforweb.com
  Description: Now go to your home page. And click on "Font settings" in admin bar and choose some exciting font out of 1000+ availabile! And that's just the beginning!
  Version: 7.5.1
  Author: Paweł Misiurski
  Author URI: http://fontsforweb.com
  License: Copyright (C) 2012 Pawel Misiurski
  This program is free software; you can redistribute it and/or
  modify it under the terms of the GNU General Public License
  as published by the Free Software Foundation; either version 2
  of the License, or (at your option) any later version.
  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.
  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */
@error_reporting(E_NONE);//just to make sure no notices will come out in older versions
class FontPlugin {
    public $pluginName = 'Font';
    public $baseUrl = 'http://fontsforweb.com';
	public $version = '7.5.1';
    //url parts for requesting css for elements
    private $titleUrlPart;
    private $headerUrlPart;
    private $tinymceStylesLoaded;
    public $fontAllIds = array();
    private $optionsName = 'FontSettings';
    private $options = array();
	private $editorStyles = array();
    //initizalize
    function __construct() {
        //get options(to $this->options array)
        $this->getOptions();
		//check if last installed version in user's WP installation has changed
		if($this->get_plugin_version() != $this->version) {
			$this->font_activate(true);
			$this->set_plugin_version($this->version);
			$this->set_upgrade_notice();
		}
        /*
          PHP ACTIONS
         */
        add_action('admin_menu', array(&$this, 'admin_menu'));
        add_filter('wp_insert_post_data', array(&$this, 'regenerateEditorCSS'), '99', 2);
		//activate plugin
		register_activation_hook( __FILE__, array(&$this, 'font_activate'));
        add_action('admin_menu', array(&$this, 'admin_menu_link'));
        //filter post content to get ids
        add_filter('the_posts', array(&$this, 'loadPostFonts'));
        //add font definitions from extracted ids
        add_action('wp_head', array(&$this, 'attachHeaders'));
        //add link to fonts for web at the bottom of page
        add_action('wp_footer', array(&$this, 'addFFWLink'));
        //add scripts to a page
        add_action('wp_enqueue_scripts', array(&$this, 'addScripts'));
		add_action('admin_enqueue_scripts', array(&$this, 'addAdminScripts'));
		
		// hack to run function after plugins are loaded to fix error:
		// Call to undefined function wp_get_current_user
		//add_action('plugins_loaded', array(&$this, 'addScripts'));
		
		//add admin bar customization
		add_action('wp_before_admin_bar_render', array(&$this, 'admin_bar_customize'));
		
		// init process for button control
        add_action('init', array(&$this, 'myplugin_addbuttons'));
		//if no api key tell to go to "Font settings"
		$settings = $this->getJsonSettings();
		if(isset($this->options['fontConnectionError']) && $this->options['fontConnectionError']) {
			add_action('admin_notices', array(&$this, 'showConnectionErrorMessage'));
		} else if(!isset($settings->apikey) || !$settings->apikey || $settings->apikey == '') {
			add_action('admin_notices', array(&$this, 'showAdminMessages'));
		}
		
		// show upgrade notice
		if(isset($this->options['upgradeNotice']) && $this->options['upgradeNotice']) {
			add_action('admin_notices', array(&$this, 'showUpgradeNotice'));
		}
		
        /*
          JS SCRIPTS
         */
        //init js file
        wp_register_script('jquery-fcarousel', plugins_url('/js/jquery.fcarousel.min.js', __FILE__), 'jquery');
        //jquery ui file
        //wp_register_script( 'jquery-ui', plugins_url('/js/jquery-ui-1.8.14.custom.min.js', __FILE__), 'jquery' );
		//slider
		wp_register_script( 'jquery-ui-slider', plugins_url('/js/jquery.ui.slider.js', __FILE__), array('jquery-ui-core', 'jquery-ui-mouse', 'jquery-ui-widget'));
        //jquery font plugin
        wp_register_script('font-plugin', plugins_url('/js/jquery.fontPlugin.js?pver=' . $this->version, __FILE__), array('jquery', 'jquery-ui-core', 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-ui-sortable'));
        //jquery ui file
        wp_register_script('colorpicker2', plugins_url('/js/colorpicker.js', __FILE__), 'jquery');
        wp_register_script('pluginscripts', plugins_url('/js/pluginscripts.js?pver=' . $this->version, __FILE__), array('jquery', 'jquery-ui-core', 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-ui-sortable'));
        /*
          AJAX HANDLERS
         */
        add_action('wp_ajax_get_font_settings', array(&$this, 'get_font_settings_callback'));
        add_action('wp_ajax_set_font_settings', array(&$this, 'set_font_settings_callback'));
		add_action('wp_ajax_cross_domain_request', array(&$this, 'ajax_cross_domain_request'));
        /*
          STYLES
         */
        wp_register_style('fontsforwebstyle', plugins_url('/css/fontsforwebstyle.css?pver=' . $this->version, __FILE__));
        wp_register_style('jquery-ui', plugins_url('/css/start/jquery-ui-1.8.14.custom.css', __FILE__));
        wp_register_style('colorpicker2', plugins_url('/css/colorpicker.css', __FILE__));
		
		// save activation output
		add_action('activated_plugin',array(&$this, 'save_error'));
		
    }
	function save_error(){
		update_option('plugin_error', 'Activation result: ' . ob_get_contents());
	}
	function getApikey () {
		$settings = $this->getJsonSettings();
		if(!isset($settings->apikey) || !$settings->apikey || $settings->apikey == '') {
			return false;
		} else {
			return $settings->apikey;
		}
	}
	function ajax_cross_domain_request () {
		if(isset($_POST['serialized'])) {
			parse_str($_POST['serialized'], $serializedArr); 
		} else {
			$serializedArr = array(0);
		}
		
		if(is_array($_POST['data'])) {
			$dataArr = $_POST['data'];
		} else {
			parse_str($_POST['data'], $dataArr);
		}
		$contents = $this->file_get_contents2($_POST['url'], array_merge($dataArr, $serializedArr));
		if(!$contents) {
			$response = new StdClass;
			$response->success = 'false';
			$response->message = $this->errorMessage;
			header('content-type: application/json; charset=utf-8');
			echo json_encode($response);
			die();
		}
		//file get contents to get through security
		echo $contents;
		die();
	}
	/*
	* Executed on activation
	*/
	function font_activate ($update) {
		// test connection
		if($this->file_get_contents2($this->baseUrl . '/api/testconnection') != 'works') {
			$this->options['fontConnectionError'] = true;
			$this->saveAdminOptions();
			return false;
		}

		//if new installation
		if(!$this->get_plugin_version()) {
			$this->file_get_contents2($this->baseUrl . '/api/init?blogurl=' . urlencode(get_bloginfo('wpurl')) . '&version=' . $this->version . '&action=INSTALLING');
		} else if($update) { //if updating
			$this->file_get_contents2($this->baseUrl . '/api/init?blogurl=' . urlencode(get_bloginfo('wpurl')) . '&version=' . $this->version . '&action=UPDATING');
		} else {
			$this->file_get_contents2($this->baseUrl . '/api/init?blogurl=' . urlencode(get_bloginfo('wpurl')) . '&version=' . $this->version . '&action=REACTIVATING');
		}
		
		$settings = $this->get_font_settings();
		$maxRepeats = 20;
		if($settings) {
			while(!is_object(json_decode(trim($settings, ' \'"'))) || $maxRepeats > 0) {
				$maxRepeats--;
				$settings = stripslashes($settings);
			}
			$settObj = trim($settings, ' \'"');
			
			if(is_object(json_decode($settObj))) {
				//re-download fonts
				$this->set_font_settings($settObj);
			}
		}
	}
    /*
      AJAX HANDLERS
     */
    function get_font_settings_callback() {
        echo stripslashes($this->get_font_settings());
        die();
    }
	/*
	* get font settings
	*/
	function get_font_settings () {
		if (!$this->options['fontPluginSettings']) {
            $this->generateDefaultSettings();
        }
		return $this->options['fontPluginSettings'];
	}
    /*
     * delete all settings
     */
    function delete_font_settings() {
        $this->options = false;
        $this->saveAdminOptions();
		$this->getOptions();
    }
    /*
     * generate default settings
     */
    function generateDefaultSettings() {
        $settings = array();
        $settings['presets'] = array();
        $preset = $settings['presets'][] = new stdClass();
        $preset->name = 'PICK AN ELEMENT';
        //if title id is set migrate to new plugin
			$preset->fontid = '';
			$preset->fontName = '';
			$preset->selector = 'PICK AN ELEMENT NOW - or type CSS selector(advanced)';
			//$preset->selector = '#header h1, #header h1 a, #header h1 a:visited, #header h2 a, #header h2 a:visited,#page-header h1, #page-header h1 a, #page-header h1 a:visited, #site-title, #site-title span a, #site-title span a:visited';
			$preset->styles = new stdClass();
			$preset->styles->fontSize = '30';
			$preset->styles->color = '#444';
	
        $settings['settingFields'] = array();
        $settingsField = $settings['settingFields'][] = new stdClass();
        $settingsField->type = 'text';
        $settingsField->label = 'Selector';
        $settingsField->name = 'selector';
        $settingsField->settingType = 'general';
        $settingsField->settingName = 'selector';
        $settingsField->extendWith = 'selectorPicker';
        $settingsField = $settings['settingFields'][] = new stdClass();
        $settingsField->type = 'text';
        $settingsField->label = 'Font size';
        $settingsField->name = 'font-size';
        $settingsField->settingType = 'css';
        $settingsField->settingName = 'fontSize';
        $settingsField->extendWith = 'slider';
        $settingsField->unit = 'px';
        $settingsField = $settings['settingFields'][] = new stdClass();
        $settingsField->type = 'text';
        $settingsField->label = 'Color';
        $settingsField->name = 'color';
        $settingsField->settingType = 'css';
        $settingsField->settingName = 'color';
        $settingsField->extendWith = 'colorPicker';
        $this->set_font_settings(json_encode($settings));
    }
	/*
	* get plugin version
	*/
	function get_plugin_version() {
		if(!isset($this->options['fontPluginVersion'])) {
			return false;
		} else {
			return $this->options['fontPluginVersion'];
		}
	}
	// show upgrade notice
	function set_upgrade_notice() {
		$this->options['upgradeNotice'] = true;
	}
	/*
	* set plugin version
	*/
	function set_plugin_version ($ver) {
		$this->options['fontPluginVersion'] = $ver;
		$this->saveAdminOptions();
	}
    /*
     *  Set plugin options
     */
    function set_font_settings_callback() {
        $settings = $_POST['fontPluginSettings'];
        $response = $this->set_font_settings($settings);
		header('content-type: application/json; charset=utf-8');
		echo json_encode($response);
        die();
    }
    /*
     *  Set plugin options
     */
    function set_font_settings($settings) {
        $setObj = json_decode(stripslashes($settings));
		$presets = array();
		$styles = '';
        $response = new StdClass;
		for ($i = 0; $i < count($setObj->presets); $i++) {
            $preset = $setObj->presets[$i];
            if ($preset->fontid && $preset->fontName) {
                if(!$this->downloadFont($preset->fontid, $preset->fontName)) {
					$response->message = $this->errorMessage;
					$response->success = 'false';
					return $response;
				}
    	    }
			$presets[] = $preset;
        }
		// generate css for all presets
		$styles .= $this->getAllRules($presets);
		
        $this->options['fontPluginSettings'] = $settings;
        $this->options['fontGeneratedCSS'] = $styles;
		
        $this->saveAdminOptions();
		// clear supercache if present
		if(function_exists('wp_cache_clear_cache')) {
			wp_cache_clear_cache();
		}
		
		//$response->message = 'Unable to save settings';
		$response->success = 'true';
		return $response;
    }
	//get font face for array of fonts of given id from fontsforweb.com
    function getAllRules($presetsArr) {
        //$jsonPreset = json_encode($preset);
        $presetsStr = urlencode(serialize($presetsArr));
        $blogUrl = get_bloginfo('wpurl');
		$postData = array('presets' => $presetsStr);
		$gotFontFace = $this->file_get_contents2($this->baseUrl . '/api/getallfontfaces?blogurl=' . urlencode($blogUrl), $postData);
        return $gotFontFace;
    }
    //add task to a list
    function addCSSGenerationTask($fontId, $fontName) {
        //if font with this id doesn't exists
        if (isset($this->generationTasks) && $this->generationTasks) {
            foreach ($this->generationTasks as $font) {
                foreach ($font as $key => $val) {
                    if ($key == $fontId)
                        return;
                }
            }
        }
        $this->generationTasks[] = array($fontId => $fontName);
    }
    //ask server to generate rules
    function executeCSSGenerationTasks() {
        //$jsonPreset = json_encode($preset);
        $blogUrl = get_bloginfo('wpurl');
        //get fonts to be generated
        foreach ($this->generationTasks as $font) {
            foreach ($font as $key => $val) {
                $queryArr[] = 'font[' . $val . ']=' . $key;
            }
        }
        $queryStr = implode('&', $queryArr);
        $dbKey = str_replace(array('[', ']', '&', '='), '', str_replace('[', '', $queryStr));
        if (!isset($this->options['generatedPostsCSS']) || !$this->options['generatedPostsCSS'] || !is_array($this->options['generatedPostsCSS'])) {
            $this->options['generatedPostsCSS'] = array();
        }
        //check if CSS already in cache
        if (!isset($this->options['generatedPostsCSS'][$dbKey])) {
            $gotFontFace = $this->file_get_contents2($this->baseUrl . '/api/getpostfontfaces?blogurl=' . urlencode($blogUrl) . '&' . $queryStr);
            $this->options['generatedPostsCSS'][$dbKey] = $gotFontFace;
            $this->saveAdminOptions();
        }
        return $this->options['generatedPostsCSS'][$dbKey];
    }
    //get ids from currently displayed post
    function loadPostFonts($content) {
		$fontPairs = array();
        foreach ($content as $post) {
            preg_match_all('/fontplugin_fontid_([0-9]*)_([a-zA-Z0-9]*)/', $post->post_content, $searchResults);
            $fontsIds = array_values(array_unique($searchResults[1]));
            $fontsNames = array_values(array_unique($searchResults[2]));
            for ($i = 0; $i < count($fontsIds); $i++) {
                $fontPairs[$fontsIds[$i]] = $fontsNames[$i];
            }
        }
        //get files and generate css
        if (count($fontPairs)) {
            foreach ($fontPairs as $fontId => $fontName) {
				//download font file
                $this->downloadFont($fontId, $fontName);
                //add task to create font-face for given fontid and name
                $this->addCSSGenerationTask($fontId, $fontName);
            }
            $this->editorStyles[] = $this->executeCSSGenerationTasks();
        }
        return $content;
    }
    //get fonts ids from content OLD VERSION NOW FILTERING OF get_posts DOES THE JOB
    function loadAdminPostFonts($data = false) {
		global $wp_query;
        if ($data) {
            if (!$data['post_content'])
                return;
            $post_content = $data['post_content'];
        } else {
            if (is_object($wp_query) && is_object($wp_query->post) && $wp_query->post->ID)
                $post = wp_get_single_post($wp_query->post->ID);
            else if (isset($_GET['post']) && is_numeric($_GET['post']))
                $post = wp_get_single_post($_GET['post']);
            else if (isset($_GET['page']) && is_numeric($_GET['page']))
                $post = wp_get_single_post($_GET['page']);
            else if (isset($_GET['p']) && is_numeric($_GET['p']))
                $post = wp_get_single_post($_GET['page']);
			else 
				return;
            $post_content = $post->post_content;
        }
        preg_match_all('/fontplugin_fontid_([0-9]*)_([a-zA-Z0-9]*)/', $post_content, $searchResults);
        $fontsIds = array_values(array_unique($searchResults[1]));
        $fontsNames = array_values(array_unique($searchResults[2]));
        for ($i = 0; $i < count($fontsIds); $i++) {
            $fontPairs[$fontsIds[$i]] = $fontsNames[$i];
        }
        return $fontPairs;
    }
	function writeTest($string) {
		$pluginPath = dirname(__FILE__);
		$fontsFolder = $pluginPath . '/font_files/';
		$testFile = $fontsFolder . 'writetest.txt';
		if(!@file_put_contents($testFile, $string)) {
			$old = umask(0);
			if(!chmod($fontsFolder, 0755) || !chown($fontsFolder, get_current_user())) {
				$this->errorMessage = 'Fonts folder is not writable and attempt to make it writable has failed! Change permissions for font_files folder';
				return false;
			}
			umask($old);
		}
	}
    /*
     * download font from fontsforweb
     */
    function downloadFont($fontId, $fontName) {
		if(!is_numeric($fontId) || !$fontName || trim($fontName) == '') {
			return false;
		}
        $pluginPath = dirname(__FILE__);
        //copy ttf
        $ttfUrl = $this->baseUrl . '/public/fonts/' . $fontId . '/' . $fontName . '.ttf';
		//check if fonts folder exists
		$fontsFolder = $pluginPath . '/font_files';
		if(!file_exists($fontsFolder)) { 
			//create font folder
			$old = umask(0);
			mkdir($fontsFolder, 0777);
			umask($old);
			//copy htaccess
			$htaccess = file_get_contents($fontsFolder . '_contents/.htaccess');
			file_put_contents($fontsFolder . '/.htaccess', $htaccess);
		}
		//folder target
		$fontsFolder = $pluginPath . '/font_files/';
		$testFile = $fontsFolder . 'writetest.txt';
		if(!@file_put_contents($testFile, ' ')) {
			$old = umask(0);
			if(!chmod($fontsFolder, 0755) || !chown($fontsFolder, get_current_user())) {
				$this->errorMessage = 'Fonts folder is not writable and attempt to make it writable has failed! Change permissions for font_files folder';
				return false;
			}
			umask($old);
		}
		unset($testFile);
        $ttfNewPath = $fontsFolder . $fontName . '.ttf';
        if (!file_exists($ttfNewPath)) {
			if(!$this->downloadRemoteFile($ttfUrl, $ttfNewPath)){
				$this->errorMessage = 'Cannot download ttf file';
				return false;
			}
        }
        //copy eot
        $eotUrl = $this->baseUrl . '/public/fonts/' . $fontId . '/' . $fontName . '.eot';
        $eotNewPath = $pluginPath . '/font_files/' . $fontName . '.eot';
        if (!file_exists($eotNewPath)) {
			if(!$this->downloadRemoteFile($eotUrl, $eotNewPath)) {
				$this->errorMessage = 'Cannot download eot file';
				return false;
			}
        }
		//copy woff
		$woffUrl = $this->baseUrl . '/public/fonts/' . $fontId . '/' . $fontName . '.woff';
        $woffNewPath = $pluginPath . '/font_files/' . $fontName . '.woff';
        if (!file_exists($woffNewPath)) {
			if(!$this->downloadRemoteFile($woffUrl, $woffNewPath)) {
				$this->errorMessage = 'Cannot download woff file';
				return false;
			}
        }
		return true;
    }
    //download remote file
    function downloadRemoteFile($src, $destination) {
        $fileContents = $this->file_get_contents2($src);
		if(!$fileContents) {
			return false;
		}
        $putting = file_put_contents($destination, $fileContents);
		if(!$putting) {
			$this->errorMessage = 'Error saving font file';
			return false;
		}
		return $fileContents;
    }
    //file get contetns 2 - bulletproof remote request
    function file_get_contents2($src, $postData = false) {
        // check if remote source is set to baseUrl
        if(substr($src, 0, strlen($this->baseUrl)) !== $this->baseUrl) {
            $this->errorMessage = 'Remote requests only allowed to: ' . $this->baseUrl;
            return false;
        }

        if ((ini_get('allow_url_fopen') == 1 || ini_get('allow_url_fopen') == 'on')) {
            $this->downloadMethod = 'fopen';
        } else if (in_array('curl', get_loaded_extensions())) {
            $this->downloadMethod = 'curl';
        } else if (function_exists("fsockopen")) {
            $this->downloadMethod = 'sockets';
        } else {
            $this->downloadMethod = false;
        }
        switch ($this->downloadMethod) {
            case 'fopen':
				//get cookie from file
				$cookieFile = dirname(__FILE__) . "/fgccookie.txt";
				if(!file_exists($cookieFile)) {
					$fh = fopen($cookieFile, "w");
					fwrite($fh, "");
					fclose($fh);
				}
				$cookieArr = unserialize(file_get_contents($cookieFile));
				if(!is_array($cookieArr)) {
					$cookieArr = array();
				}
				$cookieQuery = str_replace('&', '; ', http_build_query($cookieArr, '', '&'));
				if($postData) {
					$postQuery = http_build_query($postData, '', '&');
					//set context
					$opts = array(
					  'http'=>array(
						'method'=>"POST",
						'header'=>"Content-type: application/x-www-form-urlencoded\r\n" .
									"Accept-language: en\r\n" .
								  "Cookie: " . $cookieQuery . "\r\n",
						'content' => $postQuery
					  	)
					);
				} else {
					//set context
					$opts = array(
					  'http'=>array(
						'method'=>"GET",
						'header'=>"Accept-language: en\r\n" .
								  "Cookie: " . $cookieQuery . "\r\n"
					  )
					);
				}
				$context = stream_context_create($opts);
				// suppress error if no file found
				$fileContents = @file_get_contents($src, false, $context);
				if($fileContents) {
					//get cookie
					$cookies = array();
					foreach ($http_response_header as $hdr) {
						if (preg_match('/^Set-Cookie:\s*([^;]+)/', $hdr, $matches)) {
							parse_str($matches[1], $tmp);
							$cookies += $tmp;
						}
					}
					//serialize cookie and save
					file_put_contents($cookieFile, serialize($cookies));
				}
				//var_dump($cookies);
                break;
            case 'curl':
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "{$src}");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				if($postData) {
					$dataString = http_build_query($postData, '', '&');
					curl_setopt($ch,CURLOPT_POST, count($postData));
					curl_setopt($ch,CURLOPT_POSTFIELDS, $dataString);
				}
				$cookieFile = dirname(__FILE__) . "/ffwsession.txt";
				if(!file_exists($cookieFile)) {
					$fh = fopen($cookieFile, "w");
					fwrite($fh, "");
					fclose($fh);
				}
				 // Set the COOKIE files
				curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
				curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
				
                $fileContents = curl_exec($ch);
                curl_close($ch);
                break;
            case 'sockets':
				$fileContents = $this->fsockdownload($src, $postData);
                break;
            default:
				$this->errorMessage = 'S**t! No way to download files! Ask your admin to enable CURL or allow_url_fopen or fsockopen';
				return false;
        }
        return $fileContents;
    }
    //save file from url using fsockopen
    function fsockdownload($source, $postData = false) {
        //remove http
        $parsedUrl = parse_url($source);
        $source = str_replace('http://', '', $source);
        $fh = fsockopen($parsedUrl['host'], 80, $errno, $errstr, 300);
        if (!$fh) {
            die("error downloading");
        } else {
			//if has post data add
			if($postData) {
				$content = http_build_query($postData, '', '&');
				if(!isset($parsedUrl['query'])) {
					$parsedUrl['query'] = '';
				}
				$hdr = "POST  " . $parsedUrl['path'] . '?' . $parsedUrl['query'] . " HTTP/1.0\r\n";  
				$hdr .= "Host: " . str_replace('ssl://', '', $parsedUrl['host']) . "\r\n";
				$hdr .= "Content-Type: application/x-www-form-urlencoded\r\n";  
				$hdr .= "Content-Length: " . strlen($content) . "\r\n\r\n";
				//add post data
				$hdr .= $content;
			} else {
				$hdr = '';
				$file_cont = '';
				$hdr .= "GET " . $parsedUrl['path'] . '?' . $parsedUrl['query'] . " HTTP/1.0\r\n";
				$hdr .= "Host: " . $parsedUrl['host'] . "\r\n";
				$hdr .= "Connection: close\r\n\r\n";
			}
            $file_cont = '';
            fwrite($fh, $hdr);
            while (!feof($fh) && ($debug = fgets($fh)) != "\r\n"); // ignore headers
            while (!feof($fh)) {
                $file_cont .= fgets($fh, 128);
            }
			fclose($fh);
            //Return the file as a string
            return $file_cont;
        }
    }
    //run when displaying header
    function attachHeaders() {
        wp_enqueue_style('fontsforwebstyle');
        wp_enqueue_style('jquery-ui');
        wp_enqueue_script('jquery-ui-draggable');
		wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_script('jquery-ui-slider');
        wp_enqueue_style('colorpicker2');
        $editorStyles = '';
        if (count($this->editorStyles)) {
            $editorStyles = implode('', $this->editorStyles);
        }
        //echo plugin styles
        echo '<style type="text/css">' . $this->options['fontGeneratedCSS'] . $editorStyles . '</style>';
    }
    //admin settings
    function admin_menu() {
        add_action('media_buttons', array(&$this, 'media_buttons'));
        wp_enqueue_script('jquery-fcarousel');
        //wp_enqueue_script( 'jquery-ui');
        wp_enqueue_script('jquery-ui-draggable');
        wp_enqueue_script('jquery-ui-slider');
        wp_enqueue_script('colorpicker2');
        wp_enqueue_script('font-plugin');
        wp_enqueue_script('pluginscripts');
        wp_enqueue_style('fontsforwebstyle');
        wp_enqueue_style('jquery-ui');
        wp_enqueue_style('colorpicker2');
        $this->loadTinymceStyles();
    }
    //regenerateEditorCSS
    function regenerateEditorCSS($data, $postarr) {
        //var_dump('loaded or not: ' . $this->tinymceStylesLoaded);
        if ($data && $data['post_content'] && $data['post_status'] != 'inherit') {
            //var_dump($data);
            $fontPairs = $this->loadAdminPostFonts($data);
            if (count($fontPairs)) {
                //get files and generate css
                foreach ($fontPairs as $fontId => $fontName) {
                    //download font file
                    $this->downloadFont($fontId, $fontName);
                    //add task to create font-face for given fontid and name
                    $this->addCSSGenerationTask($fontId, $fontName);
                }
                $this->options['editorCSS'] = $this->executeCSSGenerationTasks();
                $this->tinymceStylesLoaded = true;
                $this->saveAdminOptions();
            }
        }
        return $data;
    }
    //load FontsForWeb for tinyMce
    function loadTinymceStyles() {
        if (!$this->tinymceStylesLoaded) {
            $fontPairs = $this->loadAdminPostFonts();
            if (count($fontPairs)) {
                foreach ($fontPairs as $fontId => $fontName) {
                    //download font file
                    $this->downloadFont($fontId, $fontName);
                    //add task to create font-face for given fontid and name
                    $this->addCSSGenerationTask($fontId, $fontName);
                }
                $this->options['editorCSS'] = $this->executeCSSGenerationTasks();
                $this->saveAdminOptions();
            }
        }
        //add custom CSS - PHP generated in Font plugin
        if (!function_exists('font_plugin_css')) {
			$editorCSS = $this->options['editorCSS'];
			
			// regenerate CSS file
			file_put_contents(dirname(__FILE__) . '/generatedEditorCSS.css', $editorCSS);
			
            function font_plugin_css($wp) {
                $wp .= ',' . trailingslashit(plugin_dir_url(__FILE__)) . 'generatedEditorCSS.css?ver=' . time(); //?' . implode('&' . $fontPairsUrlArr);
                return $wp;
            }
        }
        add_filter('mce_css', 'font_plugin_css');
        /* Custom CSS styles on WYSIWYG Editor – Start
          ======================================= */
        if (!function_exists('myCustomTinyMCE')) :
            function myCustomTinyMCE($init) {
                $init['theme_advanced_buttons2_add_before'] = 'styleselect'; // Adds the buttons at the begining. (theme_advanced_buttons2_add adds them at the end)
                $init['theme_advanced_styles'] = 'Float Left=fleft,Float Right=fright';
                return $init;
            }
        endif;
        /* add_filter('tiny_mce_before_init', 'myCustomTinyMCE' );
          add_filter( 'mce_css', 'tdav_css' );
          // incluiding the Custom CSS on our theme.
          function mycustomStyles(){
          wp_enqueue_style( 'myCustomStyles', $this->baseUrl . '/font/generatecss/?cached=true&id=777', ",",'all' );
          }
          add_action('init', 'mycustomStyles'); */
        /* Custom CSS styles on WYSIWYG Editor – End
          ======================================= */
    }
    //add button in Upload/Insert menu bar
    function media_buttons() {
        //$title = __('Show fonts', 'button1000fonts');
        echo '<a href="#" id="FFW_chooseFontButton"><img src="' . plugins_url('/menu_item.png', __FILE__) . '" alt="fonts" /></a>';
    }
    //TINYMCE PLUGIN
    function myplugin_addbuttons() {
        // Don't bother doing this stuff if the current user lacks permissions
        if (!current_user_can('edit_posts') && !current_user_can('edit_pages'))
            return;
        // Add only in Rich Editor mode
        if (get_user_option('rich_editing') == 'true') {
            add_filter("mce_external_plugins", array(&$this, "add_myplugin_tinymce_plugin"));
            add_filter('mce_buttons', array(&$this, 'register_myplugin_button'));
        }
    }
    //add ffw button
    function register_myplugin_button($buttons) {
        array_push($buttons, "separator", 'FFWButton');
        return $buttons;
    }
    // Load the TinyMCE plugin : editor_plugin.js (wp2.5)
    function add_myplugin_tinymce_plugin($plugin_array) {
        $plugin_array['ffwbutton'] = plugins_url('/js/editor_plugin.js', __FILE__);
        return $plugin_array;
    }
	//add admin scripts
	function addAdminScripts () {
		?>
            <script type="text/javascript">
				var ajaxproxy = '<?php echo esc_js(admin_url('admin-ajax.php')); ?>';
				var fontBlogUrl = '<?php echo get_bloginfo('wpurl'); ?>';
				var fontBlogName = '<?php echo get_bloginfo('name'); ?>';
				var fontPluginVersion = '<?php echo $this->version; ?>';
            </script>
        <?php
	}
    //add scripts to the page
    function addScripts() {
        //add ajaxurl support
        add_action('wp_head', array(&$this, 'addFrontVars'));
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-fcarousel', false, 'jquery');
        //wp_enqueue_script( 'jquery-ui');
        wp_enqueue_script('jquery-ui-draggable');
        wp_enqueue_script('jquery-ui-slider');
        wp_enqueue_script('colorpicker2');
        wp_enqueue_script('font-plugin');
        wp_enqueue_script('pluginscripts');
		
		wp_enqueue_style('fontsforwebstyle');
        wp_enqueue_style('jquery-ui');
        wp_enqueue_style('colorpicker2');
    }
	//add ajaxurl on clientside
	function addFrontVars() {
		?>
		<script type="text/javascript">
			var ajaxproxy = '<?php echo esc_js(admin_url('admin-ajax.php')); ?>';
			var fontBlogUrl = '<?php echo get_bloginfo('wpurl'); ?>';
			var fontBlogName = '<?php echo get_bloginfo('name'); ?>';
			var fontPluginVersion = '<?php echo $this->version; ?>';
		</script>
		<?php
	}
    //add link - commented but will be optional in future
    function addFFWLink() {
        //echo '<p>Fontsforweb.com - <a href="http://fontsforweb.com" target="_blank">free web fonts</a> download. See this <a href="http://wordpress.org/extend/plugins/font/" target="_blank">Wordpress fonts plugin</a></p>';
    }
    /**
     * @desc Adds the options subpanel
     */
    function admin_menu_link() {
		//If you change this from add_options_page, MAKE SURE you change the filter_plugin_actions function (below) to
        //reflect the page filename (ie - options-general.php) of the page your plugin is under!
        add_theme_page('Fonts', 'Fonts', 10, basename(__FILE__), array(&$this, 'admin_options_page'));
        add_filter('plugin_action_links_' . plugin_basename(__FILE__), array(&$this, 'filter_plugin_actions'), 10, 2);
    }
    /**
     * @desc Adds the Settings link to the plugin activate/deactivate page
     */
    function filter_plugin_actions($links, $file) {
        //If your plugin is under a different top-level menu than Settiongs (IE - you changed the function above to something other than add_options_page)
        //Then you're going to want to change options-general.php below to the name of your top-level page
        $settings_link = '<a href="themes.php?page=' . basename(__FILE__) . '">' . __('Settings') . '</a>';
        array_unshift($links, $settings_link); // before other links
        return $links;
    }
    /**
     * Adds settings/options page
     */
    function admin_options_page() {
        echo '
			<div class="wrap">
				<div class="icon32" id="icon-themes"><br></div>
				<h2>How to use?</h2>
				<p>
				<ul>
					<li>1. Go to your home screen when being logged in as admin</li>
					<li>2. Click on "Font settings" from the top bar</li>
					<li>3. Create a preset for a new selection</li>
					<li>4. Click "Pick element" and click on any element on the page i.e. blog\'s title</li>
					<li>5. Adjust color, size, choose font, add 3d effect</li>
					<li>6. Click on "SAVE"</li>
				</ul>
				</p>
				<a href="' . $blogUrl = get_bloginfo('wpurl') . '" target="_blank">Open your home screen in new tab.</a>
				
				<h2>Having problems with the plugin?</h2>
				<p>Resetting settings may help</p>';
			
		if(isset($_GET['resetSettings']) && $_GET['resetSettings'] == 'true') {
			$this->delete_font_settings();
			echo '<h3><strong>All "Font" settings resetted.</strong></h3>';
		} else {
			echo '<form action="" method="get">
					<input type="hidden" name="resetSettings" value="true">
					<input type="hidden" name="page" value="Font.php">
					<input type="submit" value="Reset settings now">
				</form>';
		}
		
		echo '<h3>Activation output(should be empty)</h3>
		<pre>' . 
		get_option('plugin_error')
		. '</pre>';
		
		/*echo '<h3>Debug settings info</h3>
		<pre>';
		var_dump($this->options);
		echo '</pre>';*/
		echo '</div>';
    }
	function getJsonSettings() {
		$settings = $this->get_font_settings();
		return json_decode(stripslashes($settings));
	}
    /*
      Admin bar customization
     */
    // Admin Bar Customisation
    function admin_bar_customize() {
        global $wp_admin_bar;
		// only for admin not editors etc
		if (!current_user_can( 'manage_options' )) {
			return;
		}
        // Add a new top level menu link
        $wp_admin_bar->add_menu(array(
            'parent' => false,
            'id' => 'font_settings',
            'title' => __('Font settings'),
            'href' => '#'
        ));
		/*
		//safe mode
		$wp_admin_bar->add_menu(array(
            'parent' => 'font_settings',
            'id' => 'font_settings_standard',
            'title' => __('Font settings (normal mode)'),
            'href' => '#'
        ));
		//safe mode
		$wp_admin_bar->add_menu(array(
            'parent' => 'font_settings',
            'id' => 'font_settings_compatibility',
            'title' => __('Font settings (force compatibility mode)'),
            'href' => '#'
        ));*/
    }
    /**
     * Saves the admin options to the database.
     */
    function saveAdminOptions() {
		$update = update_option($this->optionsName, $this->options);
        $this->getOptions();
        return $update;
    }
    /**
     * Retrieves the plugin options from the database.
     * @return array
     */
    function getOptions() {
		//Don't forget to set up the default options
        if (!$options = get_option($this->optionsName)) {
			$this->generateDefaultSettings();
			$this->getOptions();
        } else {
	        $this->options = $options;
		}
    }
	function showMessage($message, $errormsg = false)
	{
		if ($errormsg) {
			echo '<div id="message" class="error">';
		}
		else {
			echo '<div id="message" class="updated fade">';
		}
		echo "<p><strong>$message</strong></p></div>";
	} 
	function showAdminMessages()
	{
		$this->showMessage("&gt;&gt;&gt; Font plugin installed - now <a href=" . get_home_url() . ">go to your home page</a> and click on 'Font settings' from the top bar. This notice will disappear after saving settings for the first time.");
	}
	function showConnectionErrorMessage () {
		// retry connection
		if($this->file_get_contents2($this->baseUrl . '/api/testconnection') == 'works') {
			$this->options['fontConnectionError'] = false;
			$this->saveAdminOptions();
			return false;
		}
		$message = '"Font" plugin cannot start working. <br></strong>'
			. 'This plugin is using fonts and services from remote server, but is unable to connect to it.<br><br>'
			. 'The problem can be solved only by you or by your server administrator by enabling remote access. In PHP settings:<br>'
			. '1. Enable allow_url_fopen<br>'
			. '2. or enable cURL<br>'
			. '3. If settings 1 or 2 are enabled but this message is still visible, server settings or firewall may be blocking connection<br>'
			. '4. Free hosting providers may be very restrictive and can refuse allowing remote connections from your server<br><br>'
			. '<strong>To hide this message please resolve the problem and re-activate the plugin or if that\'s not possible disable "Font" plugin'
			;
		$this->showMessage($message, false);
	}
	function showUpgradeNotice () {
		$this->options['upgradeNotice'] = false;
		$this->saveAdminOptions();
		
		$message = '</strong>"Font" plugin upgraded! <br>'
			. '<strong>REMEMBER TO CLEAR YOUR BROWSER\'S CACHE NOW.</strong><br>This message will disappear on page reload<strong>'
			;
		$this->showMessage($message, false);
	}
}
$WPFFW = new FontPlugin();