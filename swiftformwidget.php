<?php
/*
		Plugin Name: SwiftCloud
		Plugin URL: http://kb.SwiftCloud.me/wordpress-plugin
		Description: Allows you to include Swift Forms as widget in Sidebars
		Version: 1.0
		Author: Roger Vaughn, Sajid Javed
		Author URI: http://SwiftCloud.me/
	*/

//Load admin modules
require_once('admin/admin.php');

//Enqueue scripts and styles.
function swift_enqueue_scripts_styles(){

	wp_enqueue_script( 'swift-popup-js', plugins_url('/js/jquery.magnific-popup.min.js' , __FILE__), array('jquery'), '', true );
		
	wp_enqueue_style( 'swift-popup-css', plugins_url('/css/magnific-popup.css' , __FILE__), '', '', '' );
	
	wp_enqueue_style( 'swift-popup-custom', plugins_url('/css/public.css' , __FILE__), '', '', '' );
		
}
add_action('wp_enqueue_scripts', 'swift_enqueue_scripts_styles');

//Time aware poup will go here.
function swift_timed_popup(){
	$swift_settings = get_option('swift_settings');
		
	$returner = '';
	
	?>
		<div style="display:none;">
            <a class="popup-with-form swift_popup_trigger" href="#swift_timed_popup" >Inline</a>
        </div>
        <!-- This file is used to markup the public facing aspect of the plugin. -->
        
        <div style="width:400px;display: none;">
        <div id="swift_timed_popup" class="white-popup" style="width:<?php echo $swift_settings['width']?>px; height:<?php echo $swift_settings['height']?>px">
                <?php 
               echo apply_filters('the_content', stripslashes($swift_settings['time_lead']));
                ?>
         </div>       
            </div>
        
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                                            
                 $('.popup-with-form').magnificPopup({
                      type: 'inline',
                      preloader: false,
					  
					  // Delay in milliseconds before popup is removed
					  removalDelay: 300,
					
					  // Class that is added to popup wrapper and background
					  // make it unique to apply your CSS animations just to this exact popup
					  mainClass: 'mfp-fade'
					  
                     });
                
                openFancybox(<?php echo $swift_settings['delay']?>);
                
            });
            
            function openFancybox(interval) {
                setTimeout( function() {jQuery('.swift_popup_trigger').trigger('click'); },interval);
            }
        </script>
	<?php 
	
}
add_action('wp_footer', 'swift_timed_popup', 10);

//Scroll aware poup will go here.
function swift_scroll_popup(){
	$swift_settings = get_option('swift_settings');
	
	/*echo "<pre>";
	print_r($swift_settings);
	echo "</pre>";*/
	$returner = '';
	
	?>
		<div style="display:none;">
            <a class="swift_scroll_popup_trigger" href="#swift_scroll_popup" >Inline</a>
        </div>
        <span id="scroll_aware_init" style="opacity:0;">&nbsp;</span>
        <!-- This file is used to markup the public facing aspect of the plugin. -->
        
        <div style="display: none;">
        <div id="swift_scroll_popup" class="white-popup" style="width:<?php echo $swift_settings['width2']?>px; height:<?php echo $swift_settings['height2']?>px">
                <?php echo apply_filters('the_content', stripslashes($swift_settings['slide_in'])); ?>
         </div>       
            </div>
        
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                                            
                 $('.swift_scroll_popup_trigger').magnificPopup({
																
                      type: 'inline',
                      preloader: false,
					  
					  // Delay in milliseconds before popup is removed
					  removalDelay: 300,
					
					  // Class that is added to popup wrapper and background
					  // make it unique to apply your CSS animations just to this exact popup
					  mainClass: 'mfp-fade'
					  
                     });
				 
				 $(window).scroll(function(e){
									
					var $scroll_position = $( "#scroll_aware_init" );
					var window_offset = $scroll_position.offset().top - $(window).scrollTop();
					
					//console.log(window_offset);
					
					if(window_offset <= 900){
					 jQuery('.swift_scroll_popup_trigger').trigger('click');
					}
					 
					
				});
				 
             });
            						
        </script>
	<?php 
	
}
add_action('wp_footer', 'swift_scroll_popup', 10);
//Scroll aware poup end here.

//Exit intent poup will go here.
function swift_exit_popup(){
	$swift_settings = get_option('swift_settings');

	
	$returner = '';
	
	?>
		<div style="display:none;">
            <a class="swift_exit_popup_trigger" href="#swift_exit_popup" >Inline</a>
        </div>
        <!-- This file is used to markup the public facing aspect of the plugin. -->
        
        <div style="width:400px;display: none;">
        <div id="swift_exit_popup" class="white-popup" style="width:<?php echo $swift_settings['width2']?>px; height:<?php echo $swift_settings['height2']?>px">
                <?php 
               echo apply_filters('the_content', stripslashes($swift_settings['exit_intnet']));
                ?>
         </div>       
            </div>
        
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                                            
                 $('.swift_exit_popup_trigger').magnificPopup({
                      type: 'inline',
                      preloader: false,
					  
					  // Delay in milliseconds before popup is removed
					  removalDelay: 300,
					
					  // Class that is added to popup wrapper and background
					  // make it unique to apply your CSS animations just to this exact popup
					  mainClass: 'mfp-fade'
					  
                     });
				 
				 $(document).mouseleave(function(e) {
					
					//console.log(e.pageY);
					if(e.pageY <= 5)
					{	
						jQuery('.swift_exit_popup_trigger').trigger('click')
					}
					
				});
				 
             });
            						
        </script>
	<?php 
	
}
add_action('wp_footer', 'swift_exit_popup', 10);

class Swiftform_Widget extends WP_Widget
{
	var $ErrorMessage = 'Form ID is required to display form!';
	 /**
	  * Declares the Swiftform_Widget class.
	  */
    function Swiftform_Widget(){
    $widget_ops = array('classname' => 'widget_swiftform', 'description' => __( "SwiftForm Widget Setup") );
    $control_ops = array('width' => 300, 'height' => 300);
    $this->WP_Widget('swiftform', __('Swiftform'), $widget_ops, $control_ops);
	add_shortcode('swiftform', array($this, 'dispaly_swiftform') );
	
    }
	
	function dispaly_swiftform($atts, $content = ''){
		
		$atts = shortcode_atts(
			array(
				'id' => '',
 			), $atts );
		
		extract($atts);		
		
		if( empty($id) ) return $this->ErrorMessage;
		
  		$formID = $atts['id'];
		
		$readFormUrl = 'http://swiftform.com/f/'.$formID;
		//$readFormUrl = 'http://swiftform.com/f/44646546';
		//exit($readFormUrl);
		
		// make sure curl is installed
		if (function_exists('curl_init')) {
		   // initialize a new curl resource
		   $ch = curl_init();
 
 		   // set the url to fetch
		   curl_setopt($ch, CURLOPT_URL, $readFormUrl);
		
		   // don't give me the headers just the content
		   curl_setopt($ch, CURLOPT_HEADER, 0);
		
		   // return the value instead of printing the response to browser
		   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		   
		   curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
		
		   // use a user agent to mimic a browser
		   curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.5) Gecko/20041107 Firefox/1.0');
		
		   $text = curl_exec($ch);
		    
		   // remember to always close the session and free all resources
		   curl_close($ch);
		} else {
		   // curl library is not installed so we better use something else
		}
		return $text;
	}
	
  	/**
    * Displays the Widget
    *
    */
    function widget($args, $instance){
			 
      extract($args);
      $title = apply_filters('widget_title', empty($instance['title']) ? '&nbsp;' : $instance['title']);
      $formID = empty($instance['formID']) ? '' : $instance['formID'];
     
      # Before the widget
      echo $before_widget;

      # The title
      if ( $title )
      echo $before_title . $title . $after_title;
	
      # Make the widget show the form
	  if($formID!="") {
		  
		  $formData = array('id' => $formID);
		  
		  $text = $this->dispaly_swiftform($formData);
 		
		 global $iSubscriberId;
		 if($iSubscriberId>0)
		 $text = preg_replace('/name="iSubscriberId"  value="(\d*)"/','name="iSubscriberId"  value="'.$iSubscriberId.'"',$text);
	
		 echo $text;
		 
	  }else{
		  echo $this->ErrorMessage;
	  }
	  

      # After the widget
      echo $after_widget;
  }

  /**
    * Saves the widgets settings.
    */
    function update($new_instance, $old_instance){
      $instance = $old_instance;
      $instance['title'] = strip_tags(stripslashes($new_instance['title']));
      $instance['formID'] = strip_tags(stripslashes($new_instance['formID']));

    return $instance;
  }

  /**
    * Creates the edit form for the widget.
    */
    function form($instance){
      //Defaults
      $instance = wp_parse_args( (array) $instance, array('title'=>'', 'formID'=>'') );

      $title = htmlspecialchars($instance['title']);
      $formID = htmlspecialchars($instance['formID']);
      
      # Output the options
      echo '<p style="text-align:right;"><label for="' . $this->get_field_name('title') . '">' . __('Title:') . ' <input style="width: 250px;" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . $title . '" /></label></p>';
      # Text line 1
      echo '<p style="text-align:right;"><label for="' . $this->get_field_name('formID') . '">' . __('Form ID:') . ' <input style="width: 200px;" id="' . $this->get_field_id('formID') . '" name="' . $this->get_field_name('formID') . '" type="text" value="' . $formID . '" /></label></p>';
  }

}// END class

/**
* Register Swift Form Widget
*
* Calls 'widgets_init' action after the Hello World widget has been registered.
*/
function Swiftform_Widget_Init() {
	register_widget('Swiftform_Widget');
}
add_action('widgets_init', 'Swiftform_Widget_Init');
