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
		   
		   curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		
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
