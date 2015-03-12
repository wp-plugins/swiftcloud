<?php 

/**
 * Plugin file. This file should ideally be used to work with the
 * administrative side of the WordPress site.
 */

// Add the options page and menu item.
add_action( 'admin_menu', 'swift_control_panel' ) ;

function swift_control_panel(){
	
	add_menu_page( $page_title = 'Swift Form Settings', $menu_title = 'Swift Form Settings', $capability = 'manage_options', $menu_slug = 'swift_control_panel', $function = 'swift_control_panel_cb', $icon_url, $position );

	
}

function swift_control_panel_cb(){?>

<div class="wrap">
  <h2>Swift Control Panel</h2>

  <h2 class="nav-tab-wrapper">
<?php $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'general';?>

                <a href="<?php echo admin_url('admin.php')?>?page=swift_control_panel&tab=general" class="nav-tab <?php echo $active_tab == 'general' ? 'nav-tab-active' : ''; ?>"><?php _e('General'); ?></a>
                 <a href="<?php echo admin_url('admin.php')?>?page=swift_control_panel&tab=autopopup" class="nav-tab <?php echo $active_tab == 'autopopup' ? 'nav-tab-active' : ''; ?>"><?php _e('Auto PopUp'); ?></a>
               
                  
                 
            </h2>
  <?php if( $active_tab == 'general' ) {?>            
	  <div class="inner_content">
    <p>
      <?php _e('Thanks for installing the plugin.', 'swift-cloud');?>
    </p>
    <h3>
      <?php _e('Widget usage instructions:', 'swift-cloud');?>
    </h3>
    <p>
      <?php _e('Here are easy steps to use this plugin.', 'swift-cloud');?>
    <ol>
    <li>
        <?php _e('Navigate to Appearance > <a href="'.get_admin_url('', 'widgets.php').'">Widgets</a>.', 'swift-cloud');?>
      </li>
      <li>
        <?php _e('Add the "Swiftform" widget in sidebar to show the like box in your website sidebar.', 'swift-cloud');?>
      </li>
      <li>
        <?php _e('Input title.', 'swift-cloud');?>
      </li>
      <li>
        <?php _e('Input cloud form ID that you have generated from <a href="http://swiftform.com/" target="_blank">swiftform.com</a> using drag and drop form builder.', 'swift-cloud');?>
      </li>
      <li>
        <?php _e('Save changes and enjoy.', 'swift-cloud');?>
      </li>
    </ol>
    </p>
    
    <h3>
      <?php _e('Shortcode usage instructions:', 'swift-cloud'); ?>
    </h3>
    
     <ol>
    <li>
        <?php _e('Add [swiftform id="123"] shortcode into post/page/ editor to display the form.' , 'swift-cloud');?>
      </li>
      <li>
        <?php _e('Replace the "123" with ID of the swift form.', 'swift-cloud');?>
      </li>
      </ol>
    
    
    <p>
      <?php _e('We are constantly working on the betterment and improvement of this plugin so stay tuned.',  			 	  'swift-cloud');?>
    </p>
  </div>
  <?php }?>
  
  <?php if( $active_tab == 'autopopup' ) {
	  
	  	if ( 
			isset( $_POST['save_popups'] ) 
			&& wp_verify_nonce( $_POST['save_popups'], 'save_popups' ) 
		) {
			/*echo '<pre>';print_r($_POST['save_popups']);exit;*/
			 $update = update_option('swift_settings', $_POST['swift_settings']);
  		}
			
	    $settings = array( 'media_buttons' => true, 'textarea_rows' => 10, 'quicktags' => true, 'textarea_name' => 'swift_settings[delay]',  );
		
		$swift_settings = get_option('swift_settings');
	   /*echo '<pre>';print_r($swift_settings);exit;*/
	   
	   ?>            
	  <div class="inner_content">
      	<?php if($update){
			echo '<div id="message" class="updated below-h2"><p>Settings updated successfully!</p></div>';
		}?>
        <?php //$delay = $_POST['time_delay'];
		//echo '<pre>';print_r($del);exit; ?>
		<form method="post" action="" >
     	<h3>Timed Lead Capture Pop-Over</h3>
        <?php
		$settings['textarea_name'] = 'swift_settings[delay]' ;?>
		<label for="popup-delay">Popup Delay</label>
        <input type="text" value="<?php echo $swift_settings['delay'] ?>" class="widefat" name=  		 		 		 		"swift_settings[delay]"/>
        <label for="popup-delay">Width</label>
        <input type="text" value="<?php echo $swift_settings['width'] ?>" class="widefat" name=  		 		 		 		"swift_settings[width]"/>
        <label for="popup-delay">Height</label>
        <input type="text" value="<?php echo $swift_settings['height'] ?>" class="widefat" name=  		 		 		 		"swift_settings[height]"/>
        <br /><br /><br />
        <?php $settings['textarea_name'] = 'swift_settings[time_lead]' ; 
		wp_editor( stripslashes($swift_settings['time_lead']) , 'time_lead_capture', $settings )?>
   		<br />
        <label for="scroll-aware">Scroll-Aware Slide-In</label><br /><br />
        <label for="popup-scroll">Width</label>
         <input type="text" value="<?php echo $swift_settings['width1'] ?>" class="widefat" name=  		 		 		 		"swift_settings[width1]"/>
         <label for="popup-scroll">Height</label>
        <input type="text" value="<?php echo $swift_settings['height1'] ?>" class="widefat" name=  		 		 		 		"swift_settings[height1]"/>
        <?php 
		$settings['textarea_name'] = 'swift_settings[slide_in]' ;
		wp_editor( stripslashes($swift_settings['slide_in']) , 'scroll_aware_slidein', $settings )?>
        <br />
        <label for="exit-intent">Exit-Intent Overlay</label><br /><br />
        <label for="popup-exit">Width</label>
        <input type="text" value="<?php echo $swift_settings['width2'] ?>" class="widefat" name=  		 		 		 		"swift_settings[width2]"/>
        <label for="popup-exit">Height</label>
        <input type="text" value="<?php echo $swift_settings['height2'] ?>" class="widefat" name=  		 		 		 		"swift_settings[height2]"/>
        <?php 
		$settings['textarea_name'] = 'swift_settings[exit_intnet]' ;
		wp_editor( stripslashes($swift_settings['exit_intnet']) , 'exit_intnet_overlay', $settings )?>
        <br />
        <?php wp_nonce_field('save_popups', 'save_popups')?>
        <input type="submit" class="button button-primary" value="Save Changes" />
        
        </form>
  		</div>
  <?php }?>
  
  
</div>
<?php 
} 