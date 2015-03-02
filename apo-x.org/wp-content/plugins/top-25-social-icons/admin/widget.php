<?php class baba extends WP_Widget{

function baba () {

	  parent::WP_Widget(false, $name = __('Top 25 Social Icons', 'sbr') );
	  add_action( 'admin_print_styles', array( &$this, 'register_admin_styles' ) );
		}



function form($instance){
if($instance){

	
     $title = esc_attr($instance['title']);
     $text1 = esc_attr($instance['text1']);
	 $text2= esc_attr($instance['text2']);
	 $text3 = esc_attr($instance['text3']);
	 $text4= esc_attr($instance['text4']);
	 $text5= esc_attr($instance['text5']);
	 $text6= esc_attr($instance['text6']);
	 $text7= esc_attr($instance['text7']);
	 $text8= esc_attr($instance['text8']);
	 $text9= esc_attr($instance['text9']);
	 $text10= esc_attr($instance['text10']);
	 $text11= esc_attr($instance['text11']);
	 $text12= esc_attr($instance['text12']);
	 $text13= esc_attr($instance['text13']);
	 $text14= esc_attr($instance['text14']);
	 $text15= esc_attr($instance['text15']);
	 $text16= esc_attr($instance['text16']);
	 $text17= esc_attr($instance['text17']);
	 $text18= esc_attr($instance['text18']);
	 $text19= esc_attr($instance['text19']);
	 $text20= esc_attr($instance['text20']);
     $text21= esc_attr($instance['text21']);
	 $text22= esc_attr($instance['text22']);
	 $text23= esc_attr($instance['text23']);
	 $text24= esc_attr($instance['text24']);
	 $text25= esc_attr($instance['text25']);
	
 }
else{

	$title = '';
	$text1 = '';
	$text2 = '';
	$text3 = '';
	$text4 = '';
	$text5 = '';
	$text6 = '';
	$text7 = '';
	$text8 = '';
	$text9 = '';
	$text10 = '';
	$text11 = '';
	$text12 = '';
	$text13 = '';
	$text14 = '';
	$text15 = '';
	$text16 = '';
	$text17 = '';
	$text18 = '';
	$text19 = '';
	$text20 = '';
	$text21 = '';
	$text22 = '';
	$text23 = '';
	$text24 = '';
	$text25 = '';
}
?>
<div class="social-lite">
<p>
<label for="<?php echo  $this->get_field_id('title'); ?>"><?php _e('Title :', 'sbr')?></label>
<input class="icon-fields"id="<?php echo $this->get_field_id('title'); ?>" placeholder="<?php echo ucfirst( 'Title' ); ?>" name="<?php echo $this->get_field_name('title');?>" type="text" value="<?php if(!$title){echo 'Follow us';}else{echo $title;}?>" />
</p>

<p>
<label for="<?php echo  $this->get_field_id('text1'); ?>"><?php _e('FaceBook :', 'sbr')?></label>
<br/><img class="lt-images" src="<?php echo plugins_url( '/top-25-social-icons/images/icons-16/fb.png')?>" alt="facebook"><input class="icon-fields" id="<?php echo $this->get_field_id('text1'); ?>" placeholder="<?php echo ucfirst( 'FaceBook' ); ?>" name="<?php echo $this->get_field_name('text1')?>" type="text" value="<?php echo $text1;?>" />
</p>


<p>
<label for="<?php echo  $this->get_field_id('text2'); ?>"><?php _e('Twitter :', 'sbr')?></label>
<br/><img class="lt-images" src="<?php echo plugins_url( '/top-25-social-icons/images/icons-16/twitter.png')?>" alt="Twitter"><input class="icon-fields"id="<?php echo $this->get_field_id('text2'); ?>" placeholder="<?php echo ucfirst( 'Twitter' ); ?>" name="<?php echo $this->get_field_name('text2')?>" type="text" value="<?php echo $text2;?>" />
</p>

<p>
<label for="<?php echo  $this->get_field_id('text3'); ?>"><?php _e('Pinterest :', 'sbr')?></label>
<br/><img class="lt-images" src="<?php echo plugins_url( '/top-25-social-icons/images/icons-16/pinterest.png')?>" alt="Pinterest"><input class="icon-fields"id="<?php echo $this->get_field_id('text3'); ?>" placeholder="<?php echo ucfirst( 'Pinterest' ); ?>"  name="<?php echo  $this->get_field_name('text3');?>"  type="text"value="<?php echo $text3;?>" />
</p>


<p>
<label for="<?php echo  $this->get_field_id('text4'); ?>"><?php _e('YouTube :', 'sbr')?></label>
<br/><img class="lt-images" src="<?php echo plugins_url( '/top-25-social-icons/images/icons-16/youtube.png')?>" alt="YouTube"><input class="icon-fields" id="<?php echo $this->get_field_id('text4'); ?>" placeholder="<?php echo ucfirst( 'YouTube' ); ?>" name="<?php echo  $this->get_field_name('text4');?>" type="text" value="<?php echo $text4;?>" />
</p>
 
 <p>
<label for="<?php echo  $this->get_field_id('text5'); ?>"><?php _e('GooglePlus :', 'sbr')?></label>
<br/><img class="lt-images" src="<?php echo plugins_url( '/top-25-social-icons/images/icons-16/g-plus.png')?>" alt="GooglePlus"><input class="icon-fields" id="<?php echo $this->get_field_id('text5'); ?>" placeholder="<?php echo ucfirst( 'GooglePlus' ); ?>" name="<?php echo  $this->get_field_name('text5');?>" type="text" value="<?php echo $text5;?>" />
</p>
 
 <p>
<label for="<?php echo  $this->get_field_id('text6'); ?>"><?php _e('Digg :', 'sbr')?></label>
<br/><img class="lt-images" src="<?php echo plugins_url( '/top-25-social-icons/images/icons-16/digg.png')?>" alt="digg"><input class="icon-fields" id="<?php echo $this->get_field_id('text6'); ?>"  placeholder="<?php echo ucfirst( 'Digg' ); ?>" name="<?php echo  $this->get_field_name('text6');?>" type="text" value="<?php echo $text6;?>" />
</p>
 
 <p>
<label for="<?php echo  $this->get_field_id('text7'); ?>"><?php _e('Reddit :', 'sbr')?></label>
<br/><img class="lt-images" src="<?php echo plugins_url( '/top-25-social-icons/images/icons-16/reddit.png')?>" alt="Reddit"><input class="icon-fields" id="<?php echo $this->get_field_id('text7'); ?>"  placeholder="<?php echo ucfirst( 'Reddit' ); ?>" name="<?php echo  $this->get_field_name('text7');?>" type="text" value="<?php echo $text7;?>" />
</p>
 
 <p>
<label for="<?php echo  $this->get_field_id('text8'); ?>"><?php _e('LinkedIn :', 'sbr')?></label>
<br/><img class="lt-images" src="<?php echo plugins_url( '/top-25-social-icons/images/icons-16/linked-in.png')?>" alt="LinkedIn"><input class="icon-fields" id="<?php echo $this->get_field_id('text8'); ?>"  placeholder="<?php echo ucfirst( 'LinkedIn' ); ?>" name="<?php echo  $this->get_field_name('text8');?>" type="text" value="<?php echo $text8;?>" />
</p>
 
  <p>
<label for="<?php echo  $this->get_field_id('text9'); ?>"><?php _e('Flickr :', 'sbr')?></label>
<br/><img class="lt-images" src="<?php echo plugins_url( '/top-25-social-icons/images/icons-16/flickr.png')?>" alt="Flicker"><input class="icon-fields" id="<?php echo $this->get_field_id('text9'); ?>"  placeholder="<?php echo ucfirst( 'Flicker' ); ?>" name="<?php echo  $this->get_field_name('text9');?>" type="text" value="<?php echo $text9;?>" />
</p>
  
   <p>
<label for="<?php echo  $this->get_field_id('text10'); ?>"><?php _e('Dribble :', 'sbr')?></label>
<br/><img class="lt-images" src="<?php echo plugins_url( '/top-25-social-icons/images/icons-16/dribble.png')?>" alt="Dribble"><input class="icon-fields" id="<?php echo $this->get_field_id('text10'); ?>"  placeholder="<?php echo ucfirst( 'Dribble' ); ?>" name="<?php echo  $this->get_field_name('text10');?>" type="text" value="<?php echo $text10;?>" />
</p>
  
   <p>
<label for="<?php echo  $this->get_field_id('text11'); ?>"><?php _e('Email :', 'sbr')?></label>
<br/><img class="lt-images" src="<?php echo plugins_url( '/top-25-social-icons/images/icons-16/email.png')?>" alt="Email"><input class="icon-fields" id="<?php echo $this->get_field_id('text11'); ?>"  placeholder="<?php echo ucfirst( 'http://www.specificfeeds.com/follow' ); ?>" name="<?php echo  $this->get_field_name('text11');?>" type="text" value="<?php if(!$text11){echo 'http://www.specificfeeds.com/follow';}else{echo $text11;}?>" /><br/>
Leave http://www.specificfeeds.com/follow so that users can subscribe to your blog by RSS or Email &dash; powered by <a href="http://www.specificfeeds.com/rss" title="specificfeeds" target="_blank">SpecificFeeds</a> 

</p>
  
   <p>
<label for="<?php echo  $this->get_field_id('text12'); ?>"><?php _e('InstaGram :', 'sbr')?></label>
<br/><img class="lt-images" src="<?php echo plugins_url( '/top-25-social-icons/images/icons-16/instagram.png')?>" alt="InstaGram"><input class="icon-fields" id="<?php echo $this->get_field_id('text12'); ?>" placeholder="<?php echo ucfirst( 'InstaGram' ); ?>" name="<?php echo  $this->get_field_name('text12');?>" type="text" value="<?php echo $text12;?>" />
</p>
  
   <p>
<label for="<?php echo  $this->get_field_id('text13'); ?>"><?php _e('vimeo :', 'sbr')?></label>
<br/><img class="lt-images" src="<?php echo plugins_url( '/top-25-social-icons/images/icons-16/vimeo.png')?>" alt="vimeo"><input class="icon-fields" id="<?php echo $this->get_field_id('text13'); ?>" placeholder="<?php echo ucfirst( 'vimeo' ); ?>" name="<?php echo  $this->get_field_name('text13');?>" type="text" value="<?php echo $text13;?>" />
</p>
  
   <p>
<label for="<?php echo  $this->get_field_id('text14'); ?>"><?php _e('YELP :', 'sbr')?></label>
<br/><img class="lt-images" src="<?php echo plugins_url( '/top-25-social-icons/images/icons-16/yelp.png')?>" alt="YELP"><input class="icon-fields" id="<?php echo $this->get_field_id('text14'); ?>"  placeholder="<?php echo ucfirst( 'YELP' ); ?>" name="<?php echo  $this->get_field_name('text14');?>" type="text" value="<?php echo $text14;?>" />
</p>
  
   <p>
<label for="<?php echo  $this->get_field_id('text15'); ?>"><?php _e('Tumblar :', 'sbr')?></label>
<br/><img class="lt-images" src="<?php echo plugins_url( '/top-25-social-icons/images/icons-16/tumblar.png')?>" alt="Tumblar"><input class="icon-fields" id="<?php echo $this->get_field_id('text15'); ?>" placeholder="<?php echo ucfirst( 'Tumblar' ); ?>" name="<?php echo  $this->get_field_name('text15');?>" type="text" value="<?php echo $text15;?>" />
</p>
   
     <p>
<label for="<?php echo  $this->get_field_id('text16'); ?>"><?php _e('StumbleUpon :', 'sbr')?></label>
<br/><img class="lt-images" src="<?php echo plugins_url( '/top-25-social-icons/images/icons-16/stumble.png')?>" alt="StumbleUpon"><input class="icon-fields" id="<?php echo $this->get_field_id('text16'); ?>" placeholder="<?php echo ucfirst( 'StumbleUpon' ); ?>" name="<?php echo  $this->get_field_name('text16');?>" type="text" value="<?php echo $text16;?>" />
</p>

     <p>
<label for="<?php echo  $this->get_field_id('text17'); ?>"><?php _e('Skype :', 'sbr')?></label>
<br/><img class="lt-images" src="<?php echo plugins_url( '/top-25-social-icons/images/icons-16/skype.png')?>" alt="Skype"><input class="icon-fields" id="<?php echo $this->get_field_id('text17'); ?>" placeholder="<?php echo ucfirst( 'Skype' ); ?>" name="<?php echo  $this->get_field_name('text17');?>" type="text" value="<?php echo $text17;?>" />
</p>
     <p>
<label for="<?php echo  $this->get_field_id('text18'); ?>"><?php _e('Evernote :', 'sbr')?></label>
<br/><img class="lt-images" src="<?php echo plugins_url( '/top-25-social-icons/images/icons-16/evernote.png')?>" alt="Evernote"><input class="icon-fields" id="<?php echo $this->get_field_id('text18'); ?>" placeholder="<?php echo ucfirst( 'Evernote' ); ?>" name="<?php echo  $this->get_field_name('text18');?>" type="text" value="<?php echo $text18;?>" />
</p>
     <p>
<label for="<?php echo  $this->get_field_id('text19'); ?>"><?php _e('Github :', 'sbr')?></label>
<br/><img class="lt-images" src="<?php echo plugins_url( '/top-25-social-icons/images/icons-16/git.png')?>" alt="Github"><input class="icon-fields" id="<?php echo $this->get_field_id('text19'); ?>" placeholder="<?php echo ucfirst( 'Github' ); ?>" name="<?php echo  $this->get_field_name('text19');?>" type="text" value="<?php echo $text19;?>" />
</p>
     <p>
<label for="<?php echo  $this->get_field_id('text20'); ?>"><?php _e('RSS :', 'sbr')?></label>
<br/><img class="lt-images" src="<?php echo plugins_url( '/top-25-social-icons/images/icons-16/rss.png')?>" alt="RSS"><input class="icon-fields" id="<?php echo $this->get_field_id('text20'); ?>" placeholder="<?php echo ucfirst( 'RSS' ); ?>" name="<?php echo  $this->get_field_name('text20');?>" type="text" value="<?php echo $text20;?>" />
</p>
     <p>
<label for="<?php echo  $this->get_field_id('text21'); ?>"><?php _e('MySpace :', 'sbr')?></label>
<br/><img class="lt-images" src="<?php echo plugins_url( '/top-25-social-icons/images/icons-16/myspace.png')?>" alt="RSS"><input class="icon-fields" id="<?php echo $this->get_field_id('text21'); ?>" placeholder="<?php echo ucfirst( 'MySpace' ); ?>" name="<?php echo  $this->get_field_name('text21');?>" type="text" value="<?php echo $text21;?>" />
</p>
     <p>
<label for="<?php echo  $this->get_field_id('text22'); ?>"><?php _e('Forrst :', 'sbr')?></label>
<br/><img class="lt-images" src="<?php echo plugins_url( '/top-25-social-icons/images/icons-16/forrst.png')?>" alt="forrst"><input class="icon-fields" id="<?php echo $this->get_field_id('text22'); ?>" placeholder="<?php echo ucfirst( 'Forrst' ); ?>" name="<?php echo  $this->get_field_name('text22');?>" type="text" value="<?php echo $text22;?>" />
</p>
     <p>
<label for="<?php echo  $this->get_field_id('text23'); ?>"><?php _e('Deviantart :', 'sbr')?></label>
<br/><img class="lt-images" src="<?php echo plugins_url( '/top-25-social-icons/images/icons-16/devinart.png')?>" alt="Deviantart"><input class="icon-fields" id="<?php echo $this->get_field_id('text23'); ?>" placeholder="<?php echo ucfirst( 'Deviantart' ); ?>" name="<?php echo  $this->get_field_name('text23');?>" type="text" value="<?php echo $text23;?>" />
</p>
     <p>
<label for="<?php echo  $this->get_field_id('text24'); ?>"><?php _e('Last.fm :', 'sbr')?></label>
<br/><img class="lt-images" src="<?php echo plugins_url( '/top-25-social-icons/images/icons-16/lastfm.png')?>" alt="Last.fm"><input class="icon-fields" id="<?php echo $this->get_field_id('text24'); ?>" placeholder="<?php echo ucfirst( 'Last.fm' ); ?>" name="<?php echo  $this->get_field_name('text24');?>" type="text" value="<?php echo $text24;?>" />
</p>
     <p>
<label for="<?php echo  $this->get_field_id('text25'); ?>"><?php _e('XING :', 'sbr')?></label>
<br/><img class="lt-images" src="<?php echo plugins_url( '/top-25-social-icons/images/icons-16/xing.png')?>" alt="XING"><input class="icon-fields" id="<?php echo $this->get_field_id('text25'); ?>" placeholder="<?php echo ucfirst( 'XING' ); ?>" name="<?php echo  $this->get_field_name('text25');?>" type="text" value="<?php echo $text25;?>" />
</p> 

<p>
<a href="<?php echo get_admin_url();?>options-general.php?page=top25-social-icons">Settings</a>
</p>

</div>
<?php   
  
}

function update($new_instance, $old_instance){
	  
    $instance = $old_instance;
      // Fields
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['text1'] = strip_tags($new_instance['text1']);
    $instance['text2'] = strip_tags($new_instance['text2']);
    $instance['text3'] = strip_tags($new_instance['text3']);
    $instance['text4'] = strip_tags($new_instance['text4']);
    $instance['text5'] = strip_tags($new_instance['text5']);
    $instance['text6'] = strip_tags($new_instance['text6']);
    $instance['text7'] = strip_tags($new_instance['text7']);
    $instance['text8'] = strip_tags($new_instance['text8']);
	$instance['text9'] = strip_tags($new_instance['text9']);
	$instance['text10'] = strip_tags($new_instance['text10']);
	$instance['text11'] = strip_tags($new_instance['text11']);
    $instance['text12'] = strip_tags($new_instance['text12']);
  $instance['text13'] = strip_tags($new_instance['text13']);
  $instance['text14'] = strip_tags($new_instance['text14']);
  $instance['text15'] = strip_tags($new_instance['text15']);
  $instance['text16'] = strip_tags($new_instance['text16']);
  $instance['text17'] = strip_tags($new_instance['text17']);
  $instance['text18'] = strip_tags($new_instance['text18']);
  $instance['text19'] = strip_tags($new_instance['text19']);
  $instance['text20'] = strip_tags($new_instance['text20']);
  $instance['text21'] =  strip_tags($new_instance['text21']);
  $instance['text22'] =  strip_tags($new_instance['text22']);
  $instance['text23'] =  strip_tags($new_instance['text23']);
  $instance['text24'] =  strip_tags($new_instance['text24']);
  $instance['text25'] =  strip_tags($new_instance['text25']);
	  return $instance;
}
 

function widget($args, $instance){
extract( $args );

 $title = apply_filters('widget_title', $instance['title']);
 $text1 = $instance['text1'];
 $text2 = $instance['text2'];
 $text3 = $instance['text3'];
 $text4 = $instance['text4'];
 $text5 = $instance['text5'];
 $text6 = $instance['text6'];
 $text7 = $instance['text7'];
 $text8 = $instance['text8'];
 $text9 = $instance['text9'];
 $text10 = $instance['text10'];
 $text11 = $instance['text11'];
 $text12 = $instance['text12'];
 $text13 = $instance['text13'];
 $text14 = $instance['text14'];
 $text15 = $instance['text15'];
 $text16 = $instance['text16'];
 $text17 = $instance['text17'];
 $text18 = $instance['text18'];
 $text19 = $instance['text19'];
 $text20 = $instance['text20'];
 $text21 = $instance['text21'];
 $text22 = $instance['text22'];
 $text23 = $instance['text23'];
 $text24 = $instance['text24'];
 $text25 = $instance['text25'];
 $imgW = get_option('imgw'); 
 $imgh = get_option('imgh'); 
 $imgtype = get_option('images-type') .'/';
 
 
 $targetlinks = get_option('targetlinks'); 
 if($targetlinks =='1'){ $target = 'target="_blank"';}else{$target='';}
   echo $before_widget;
   // Display the widget
   echo '<div class="widget-text sbr_box">';
   echo '<ul>';
   // Check if title is set
   if ($title) {	
      echo $before_title . $title . $after_title;
   }
  if(!get_option('images-type')){$imgtype = "circle/";}
   // Check if text is set
    if( $text1 ) {
      echo '<li class="sbr_text social-icons FB"><a href='.$text1.' '.$target.' data-tip="Facebook"><img width='.$imgW.'  height='.$imgh.' src='.plugins_url( '/top-25-social-icons/images/'. $imgtype .'facebook.png').'></a></li>';
   }
   if( $text2 ) {
      echo '<li class="sbr_text social-icons TW"><a href='.$text2.' '.$target.' data-tip="Twitter"><img width='.$imgW.'  height='.$imgh.' src='.plugins_url( '/top-25-social-icons/images/'. $imgtype .'twitter.png').'></a></li>';
   }
   
   // Check if text is set
   if( $text3 ) {
      echo '<li class="sbr_text social-icons Pinterest"><a href='.$text3.' '.$target.' data-tip="Pinterest"><img width='.$imgW.'  height='.$imgh.' src='.plugins_url( '/top-25-social-icons/images/'. $imgtype .'pinterest.png').'></a></li>';
   }
   
   if( $text4 ) {
      echo '<li class="sbr_text social-icons Youtube"><a href='.$text4.' '.$target.' data-tip="Youtube"><img width='.$imgW.'  height='.$imgh.' src='.plugins_url( '/top-25-social-icons/images/'. $imgtype .'youtube.png').'></a></li>';
   }
     if( $text5 ) {
      echo '<li class="sbr_text social-icons Gplus"><a href='.$text5.'  '.$target.' data-tip="GooglePlus"><img width='.$imgW.'  height='.$imgh.' src='.plugins_url( '/top-25-social-icons/images/'. $imgtype .'googleplus.png').'></a></li>';
   }
     if( $text6 ) {
      echo '<li class="sbr_text social-icons Digg"><a href='.$text6.'   '.$target.' data-tip="Digg"><img width='.$imgW.'  height='.$imgh.' src='.plugins_url( '/top-25-social-icons/images/'. $imgtype .'digg.png').'></a></li>';
   }
     if( $text7 ) {
      echo '<li class="sbr_text social-icons Reddit"><a href='.$text7.' '.$target.' data-tip="Reddit"><img width='.$imgW.'  height='.$imgh.' src='.plugins_url( '/top-25-social-icons/images/'. $imgtype .'reddit.png').'></a></li>';
   }
     if( $text8 ) {
      echo '<li class="sbr_text social-icons Linked"><a href='.$text8.'  '.$target.' data-tip="Linkedin"><img width='.$imgW.'  height='.$imgh.' src='.plugins_url( '/top-25-social-icons/images/'. $imgtype .'linkedin.png').'></a></li>';
   }
     if( $text9 ) {
      echo '<li class="sbr_text social-icons fliker"><a href='.$text9.'  '.$target.' data-tip="Flickr"><img width='.$imgW.'  height='.$imgh.' src='.plugins_url( '/top-25-social-icons/images/'. $imgtype .'flickr.png').'></a></li>';
   }
     if( $text10 ) {
      echo '<li class="sbr_text social-icons Dribbble"><a href='.$text10.'  '.$target.' data-tip="Dribbble"><img width='.$imgW.'  height='.$imgh.' src='.plugins_url( '/top-25-social-icons/images/'. $imgtype .'dribble.png').'></a></li>';
   }
     if( $text11 ) {
	 if($text11 != 'http://www.specificfeeds.com/follow'){$mot = "mailto:";}else{$mot= '';}
      echo '<li class="sbr_text social-icons Email"><a href='.$mot.$text11.' data-tip="Email"><img width='.$imgW.'  height='.$imgh.' src='.plugins_url( '/top-25-social-icons/images/'. $imgtype .'email.png').'></a></li>';
   }
     if( $text12 ) {
      echo '<li class="sbr_text social-icons Instagram"><a href='.$text12.'  '.$target.' data-tip="Instagram"><img width='.$imgW.'  height='.$imgh.' src='.plugins_url( '/top-25-social-icons/images/'. $imgtype .'instagram.png').'></a></li>';
   }
     if( $text13 ) {
      echo '<li class="sbr_text social-icons Vimeo"><a href='.$text13.'  '.$target.' data-tip="Vimeo"><img width='.$imgW.'  height='.$imgh.' src='.plugins_url( '/top-25-social-icons/images/'. $imgtype .'vimeo.png').'></a></li>';
   }
     if( $text14 ) {
      echo '<li class="sbr_text social-icons Yelp"><a href='.$text14.'  '.$target.' data-tip="Yelp"><img width='.$imgW.'  height='.$imgh.' src='.plugins_url( '/top-25-social-icons/images/'. $imgtype .'yelp.png').'></a></li>';
   }
     if( $text15 ) {
      echo '<li class="sbr_text social-icons Tumblr"><a href='.$text15.'  '.$target.' data-tip="tumblr"><img width='.$imgW.'  height='.$imgh.' src='.plugins_url( '/top-25-social-icons/images/'. $imgtype .'tumblr.png').'></a></li>';
   }
     if( $text16 ) {
      echo '<li class="sbr_text social-icons StumbleUpon"><a href='.$text16.'  '.$target.' data-tip="StumbleUpon"><img width='.$imgW.'  height='.$imgh.' src='.plugins_url( '/top-25-social-icons/images/'. $imgtype .'stumbleupon.png').'></a></li>';
   }
     if( $text17 ) {
      echo '<li class="sbr_text social-icons Skype"><a href='.$text17.'  '.$target.' data-tip="Skype"><img width='.$imgW.'  height='.$imgh.' src='.plugins_url( '/top-25-social-icons/images/'. $imgtype .'skype.png').'></a></li>';
   }
     if( $text18 ) {
      echo '<li class="sbr_text social-icons Evernote"><a href='.$text18.'  '.$target.' data-tip="Evernote"><img width='.$imgW.'  height='.$imgh.' src='.plugins_url( '/top-25-social-icons/images/'. $imgtype .'evernote.png').'></a></li>';
   }
     if( $text19 ) {
      echo '<li class="sbr_text social-icons Github"><a href='.$text19.'   '.$target.' data-tip="Github"><img width='.$imgW.'  height='.$imgh.' src='.plugins_url( '/top-25-social-icons/images/'. $imgtype .'github.png').'></a></li>';
   }
     if( $text20 ) {
      echo '<li class="sbr_text social-icons Rss"><a href='.$text20.'  '.$target.' data-tip="RSS"><img width='.$imgW.'  height='.$imgh.' src='.plugins_url( '/top-25-social-icons/images/'. $imgtype .'rss.png').'></a></li>';
   }
    if( $text21 ) {
      echo '<li class="sbr_text social-icons MySpace"><a href='.$text21.'  '.$target.' data-tip="MySpace"><img width='.$imgW.'  height='.$imgh.' src='.plugins_url( '/top-25-social-icons/images/'. $imgtype .'myspace.png').'></a></li>';
   }
   
    if( $text22 ) {
      echo '<li class="sbr_text social-icons Forrst"><a href='.$text22.'  '.$target.' data-tip="Forrst"><img width='.$imgW.'  height='.$imgh.' src='.plugins_url( '/top-25-social-icons/images/'. $imgtype .'forrst.png').'></a></li>';
   }
   
    if( $text23 ) {
      echo '<li class="sbr_text social-icons Deviantart"><a href='.$text23.'  '.$target.' data-tip="Deviantart"><img width='.$imgW.'  height='.$imgh.' src='.plugins_url( '/top-25-social-icons/images/'. $imgtype .'deviantart.png').'></a></li>';
   }
   
    if( $text24 ) {
      echo '<li class="sbr_text social-icons Last.fm "><a href='.$text24.'  '.$target.' data-tip="Last.fm "><img width='.$imgW.'  height='.$imgh.' src='.plugins_url( '/top-25-social-icons/images/'. $imgtype .'lastfm.png').'></a></li>';
   }
   
    if( $text25 ) {
      echo '<li class="sbr_text social-icons Xing"><a href='.$text25.'  '.$target.' data-tip="Xing"><img width='.$imgW.'  height='.$imgh.' src='.plugins_url( '/top-25-social-icons/images/'. $imgtype .'xing.png').'></a></li>';
   }
   echo '</ul>';
   // Check if textarea is set
   echo '</div>';
   echo $after_widget;

 
 }
 
public function register_admin_styles() {

wp_enqueue_style( 'top25-social-icons', plugins_url( 'top-25-social-icons/css/admin.css' ) );

} // end register_admin_styles

}
add_action('widgets_init', create_function('', 'return register_widget("baba");'));