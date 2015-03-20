<?php 

/**
 * Plugin file. This file should ideally be used to work with the
 * administrative side of the WordPress site.
 */

// Add the options page and menu item.
add_action( 'admin_menu', 'swift_control_panel' ) ;

function swift_control_panel(){
	
	$icon_url = plugins_url('/images/swiftcloud.png' , __FILE__); 
	
	$page_hook = add_menu_page( $page_title = 'SwiftCloud', $menu_title = 'SwiftCloud', $capability = 'manage_options', $menu_slug = 'swift_control_panel', $function = 'swift_control_panel_cb', $icon_url, $position );

	add_action('admin_print_scripts-'.$page_hook, 'swift_enqueue_admin_scripts_styles');
}

function swift_enqueue_admin_scripts_styles(){
 	
 	wp_enqueue_style( 'swift-toggle-style', plugins_url('/toggles/css/toggles.css' , __FILE__), '', '', '' );
	wp_enqueue_style( 'swift-toggle-style-theme', plugins_url('/toggles/css/toggles-full.css' , __FILE__), '', '', '' );
	
	wp_enqueue_script( 'swift-toggle-js', plugins_url('/toggles/toggles.js' , __FILE__), array('jquery'), '', true );
	wp_enqueue_script( 'swift-toggle-custom-js', plugins_url('/js/admin.js' , __FILE__), array('jquery', 'swift-toggle-js'), '', true );

 		
}
 


function swift_control_panel_cb(){?>

<div class="wrap">
  <h2>SwiftCloud Control Panel</h2>
  <h2 class="nav-tab-wrapper">
    <?php $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'general';?>
    <a href="<?php echo admin_url('admin.php')?>?page=swift_control_panel&tab=general" class="nav-tab <?php echo $active_tab == 'general' ? 'nav-tab-active' : ''; ?>">
    <?php _e('SwiftCloud User Guide'); ?>
    </a> <a href="<?php echo admin_url('admin.php')?>?page=swift_control_panel&tab=autopopup" class="nav-tab <?php echo $active_tab == 'autopopup' ? 'nav-tab-active' : ''; ?>">
    <?php _e('Timed PopUp'); ?>
    </a> 
    <a href="<?php echo admin_url('admin.php')?>?page=swift_control_panel&tab=scrollpopup" class="nav-tab <?php echo $active_tab == 'scrollpopup' ? 'nav-tab-active' : ''; ?>">
    <?php _e('Scroll PopUp'); ?>
    </a>
   	<a href="<?php echo admin_url('admin.php')?>?page=swift_control_panel&tab=exitpopup" class="nav-tab <?php echo $active_tab == 'exitpopup' ? 'nav-tab-active' : ''; ?>">
    <?php _e('Exit PopUp'); ?>
    </a>
    
    <a href="<?php echo admin_url('admin.php')?>?page=swift_control_panel&tab=leadscoring" class="nav-tab <?php echo $active_tab == 'leadscoring' ? 'nav-tab-active' : ''; ?>">
    	<?php _e('Lead Scoring'); ?>
    </a>
    
    </h2>
  <?php if( $active_tab == 'general' ) {?>
  <div class="inner_content">
    <p>
      <?php _e('This form is designed to work with <a href="http://SwiftForm.com" target="_new">SwiftForm.com</a>, a free drag-and-drop forms generator 100% integrated with SwiftCloud, a social business platform. 
	  No purchase is required to get value and use this plugin. Learn more at <a href="http://SwiftCloud.me" target="_new">SwiftCloud.me</a>.', 'swift-cloud');?>
    </p>
    <h3>
      <?php _e('Widget usage instructions:', 'swift-cloud');?>
    </h3>
    <p>
      <?php _e('Here is how to use this plugin with widget locations, typically in a sidebar or footer.', 'swift-cloud');?>
    <ol>
      <li>
        <?php _e('Visit <a href="http://SwiftForm.com" target="_new">SwiftForm.com</a>, signup if needed (free), and generate your webform(s). Make note of the number of each form.', 'swift-cloud');?>
      </li>
      <li>
        <?php _e('Next, Navigate to Appearance > <a href="'.get_admin_url('', 'widgets.php').'">Widgets</a>.', 'swift-cloud');?>
      </li>
      <li>
        <?php _e('Add the "Swiftform" widget in sidebar to show the like box in your website sidebar.', 'swift-cloud');?>
      </li>
      <li>
        <?php _e('Add a Widget title.', 'swift-cloud');?>
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
	    <p>
      <?php _e('Here is how to use this plugin to drop forms into any main page-body area', 'swift-cloud');?>
		</p>
    <ol>
      <li>
        <?php _e('Add [swiftform id="123"] shortcode into post/page/ editor to display the form.' , 'swift-cloud');?>
      </li>
      <li>
        <?php _e('Replace the "123" with ID of the swift form.', 'swift-cloud');?>
      </li>
    </ol>
    
    <h2>Best Practices</h2>  
    	<ol><li>Lead Nurturing: See <a href="http://swiftmarketing.com/sales-lead-incubator" target="_blank">http://swiftmarketing.com/sales-lead-incubator</a></li></ol> 
    
    <p>
      <?php _e('We are constantly working on improving this plugin so stay tuned.', 'swift-cloud');?>
    </p>
  </div>
  <?php }?>
  <?php
   		if( $active_tab == 'autopopup' ) {
			
			/*Save settings */
			if ( 
				isset( $_POST['save_popups'] ) 
				&& wp_verify_nonce( $_POST['save_popups'], 'save_popups' ) 
			) {
				$swift_settings = get_option('swift_settings');
				
				//Save feilds of time pop over
 				$swift_settings['delay'] = $_POST['swift_settings']['delay'];
				$swift_settings['width'] = $_POST['swift_settings']['width'];
				$swift_settings['height'] = $_POST['swift_settings']['height'];
				$swift_settings['enable_time'] = $_POST['swift_settings']['enable_time'];
				$swift_settings['time_lead'] = $_POST['swift_settings']['time_lead'];
 				
				/*echo '<pre>';print_r($_POST['save_popups']);exit;*/
				 $update = update_option('swift_settings', $swift_settings);
			}
			$swift_settings = get_option('swift_settings');
			
			
 	    $settings = array( 'media_buttons' => true, 'textarea_rows' => 10, 'quicktags' => true, 'textarea_name' => 'swift_settings[delay]',  );
		
		$swift_settings = get_option('swift_settings');
		
	   /*echo '<pre>';print_r($swift_settings);exit;*/
	   
	   ?>
      <div class="inner_content">
        <?php 
		
 		if($update){
                echo '<div id="message" class="updated below-h2"><p>Settings updated successfully!</p></div>';
            }?>
        <?php
        
        //$delay = $_POST['time_delay'];
            //echo '<pre>';print_r($del);exit; ?>
             <form method="post" action="" >
             
             
        <table class="form-table">
         
            <tr>
              <th colspan="2"><h3>Timed Lead Capture Pop-Over</h3></thj>
            </tr>
            <tr>
              <th>
            <label for="popup-delay">Fire this popup after </label>
            </th><td>
            <input type="text" value="<?php echo $swift_settings['delay'] ?>" class="" name="swift_settings[delay]"/> seconds
            </td>
            </tr>
            <tr>
              <th>
            <label for="popup-delay">with a width of</label></th>
            <td>
            <input type="text" value="<?php echo $swift_settings['width'] ?>" class="" name="swift_settings[width]"/> in pixels
            </td>
            </tr>
            <tr>
              <th>
            <label for="popup-delay">and height</label>
            </th>
            <td>
            <input type="text" value="<?php echo $swift_settings['height'] ?>" class="" name="swift_settings[height]"/> in pixels.
            </td>
            </tr>
            
            <tr>
              <th> <label for="popup-delay">Currently, the popup is </label></th>
              <td> 
              <div class="toggle_container" style="width:100px; text-align:center">
                <div class="enable_time toggle-light">
                </div>
                <input class="checkme" id="enable_time" type="checkbox" value="1" <?php echo checked('1',$swift_settings['enable_time']) ?> name="swift_settings[enable_time]" style="display:none;"/>
                <script type="text/javascript">
                    jQuery(document).ready(function($){
                        
                            $('.enable_time').toggles({checkbox:$('.checkme')});							
                            <?php if($swift_settings['enable_time']){?>
                                $('.enable_time').click();
                            <?php }?>
                    });
                </script>
                </div>
                </td>
            </tr>
            
            <tr>
              <th>PopUp Content</th>
              <td>
            <?php $settings['textarea_name'] = 'swift_settings[time_lead]' ; 
            wp_editor( stripslashes($swift_settings['time_lead']) , 'time_lead_capture', $settings )?>
            </td>
            </tr>
           
             <tr>
              <td class="2">
            <?php wp_nonce_field('save_popups', 'save_popups')?>
            <input type="submit" class="button button-primary" value="Save Changes" />
            </td></tr>
         
        </table>
        
         </form>
      </div>
      <?php } 
	  
	  //Scroll PopUp Starts
      if( $active_tab == 'scrollpopup' ) {
		  
 	   /*echo '<pre>';print_r($swift_settings);exit;*/
 	   ?>
      <div class="inner_content">
        <?php 
			
			/*Save settings */
			if ( 
				isset( $_POST['save_popups'] ) 
				&& wp_verify_nonce( $_POST['save_popups'], 'save_popups' ) 
			) {
				$swift_settings = get_option('swift_settings');
 				
				//Save feilds of scroll aware popup
 				$swift_settings['width1'] = $_POST['swift_settings']['width1'];
				$swift_settings['height1'] = $_POST['swift_settings']['height1'];
				$swift_settings['enable_scroll'] = $_POST['swift_settings']['enable_scroll'];
				$swift_settings['slide_in'] = $_POST['swift_settings']['slide_in'];
	 
				
				
				/*echo '<pre>';print_r($_POST['save_popups']);exit;*/
				 $update = update_option('swift_settings', $swift_settings);
			}
			$swift_settings = get_option('swift_settings');
			
			if($update){
                echo '<div id="message" class="updated below-h2"><p>Settings updated successfully!</p></div>';
            }?>
        <?php
        
        //$delay = $_POST['time_delay'];
            //echo '<pre>';print_r($del);exit; ?>
             <form method="post" action="" >
             
             
        <table class="form-table">
             
            <tr>
              <th colspan="2"><h3>Scroll-Aware Slide-In</h3>
              </th>
              </tr>
            
             <tr>
              <th colspan="2">Fire this popup if someone scrolls down 70% of the page-height</th>
              </tr>
               
            
            <tr>
              <th>
            <label for="popup-scroll">with a width of</label>
            </th>
            <td>
            <input type="text" value="<?php echo $swift_settings['width1'] ?>" class="" name="swift_settings[width1]"/> in pixels
            </td>
            </tr>
             
             <tr>
              <th>
              
            <label for="popup-scroll">and height of</label>
            </th>
            <td>
            <input type="text" value="<?php echo $swift_settings['height1'] ?>" class="" name="swift_settings[height1]"/> in pixels.
            </td></tr>
            
            <tr>
              <th>
            <label for="popup-delay">Currently, the popup is </label></th>
            <td>
            <div class="toggle_container" style="width:100px; text-align:center">
                <div class="enable_scroll toggle-light">
                </div> 
                 
                <input type="checkbox" value="1" <?php echo checked('1',$swift_settings['enable_scroll']) ?> class="checkme_1"  id="enable_scroll" name="swift_settings[enable_scroll]" style="display:none;"/>
                <script type="text/javascript">
                    jQuery(document).ready(function($){
                        
                            $('.enable_scroll').toggles({checkbox:$('.checkme_1')});							
                            <?php if($swift_settings['enable_scroll']){?>
                                $('.enable_scroll').click();
                            <?php }?>
                    });
                </script>
                </div>
                
            
            </td>
            </tr>
            
            <tr>
              <th>Popup content</th>
              <td>
            <?php 
            $settings['textarea_name'] = 'swift_settings[slide_in]' ;
            wp_editor( stripslashes($swift_settings['slide_in']) , 'scroll_aware_slidein', $settings )?>
            </td>
             </tr>
          
                    <tr>
              <td class="2">
            <?php wp_nonce_field('save_popups', 'save_popups')?>
            <input type="submit" class="button button-primary" value="Save Changes" />
            </td></tr>
         
        </table>
        
         </form>
      </div>
      <?php }
	  
      if( $active_tab == 'exitpopup' ) {
 	    $settings = array( 'media_buttons' => true, 'textarea_rows' => 10, 'quicktags' => true, 'textarea_name' => 'swift_settings[delay]',  );
 	   /*echo '<pre>';print_r($swift_settings);exit;*/
	   
	   ?>
      <div class="inner_content">
        <?php 
			/*Save settings */
			if ( 
				isset( $_POST['save_popups'] ) 
				&& wp_verify_nonce( $_POST['save_popups'], 'save_popups' ) 
			) {
				$swift_settings = get_option('swift_settings');
				
				//Save feilds of scroll aware popup
 				$swift_settings['width2'] = $_POST['swift_settings']['width2'];
				$swift_settings['height2'] = $_POST['swift_settings']['height2'];
				$swift_settings['enable_exit'] = $_POST['swift_settings']['enable_exit'];
				$swift_settings['exit_intnet'] = $_POST['swift_settings']['exit_intnet'];
				
				
				/*echo '<pre>';print_r($_POST['save_popups']);exit;*/
				 $update = update_option('swift_settings', $swift_settings);
			}
			$swift_settings = get_option('swift_settings');
			
			
			if($update){
                echo '<div id="message" class="updated below-h2"><p>Settings updated successfully!</p></div>';
            }?>
        <?php
        
        //$delay = $_POST['time_delay'];
            //echo '<pre>';print_r($del);exit; ?>
             <form method="post" action="" >
             
             
        <table class="form-table">
 
         
            <tr>
              <th colspan="2">
            <h3>Exit-Intent Overlay</h3>
            </th>
            </tr>
            
            <tr>
             
             <th colspan="2">
            		Fire this popup if someone mouses to leave the page,
             </th>
            
            </tr>
            
            
                    <tr>
              <th>
            <label for="popup-exit">with a width of</label>
            </th>
            <td>
            <input type="text" value="<?php echo $swift_settings['width2'] ?>" class="" name="swift_settings[width2]"/> in pixels 
            </td>
            </tr>
                  
            <tr>
              <th>
            <label for="popup-exit">and height of</label>
            </th><td>
            <input type="text" value="<?php echo $swift_settings['height2'] ?>" class="" name="swift_settings[height2]"/> in pixels.
            </td>
            </tr>
            
            <tr>
            <th>
            <label for="popup-delay">Currently, the popup is</label>
            </th>
            <td>
            <div class="toggle_container" style="width:100px; text-align:center">
                <div class="enable_exit toggle-light">
                </div>
                <input type="checkbox" value="1" <?php echo checked('1',$swift_settings['enable_exit']) ?> class="checkme_2"  id="enable_exit" name="swift_settings[enable_exit]" style="display:none;"/>
                  
                <script type="text/javascript">
                    jQuery(document).ready(function($){
                        
                            $('.enable_exit').toggles({checkbox:$('.checkme_2')});							
                            <?php if($swift_settings['enable_exit']){?>
                                $('.enable_exit').click();
                            <?php }?>
                    });
                </script>
                </div>
                
            </td>
            </tr>
            
            
            <tr>
              <th>PopUp content</th>
              <td>
            <?php 
            $settings['textarea_name'] = 'swift_settings[exit_intnet]' ;
            wp_editor( stripslashes($swift_settings['exit_intnet']) , 'exit_intnet_overlay', $settings )?>
            </td>
            </tr>
                    <tr>
              <td class="2">
            <?php wp_nonce_field('save_popups', 'save_popups')?>
            <input type="submit" class="button button-primary" value="Save Changes" />
            </td></tr>
         
        </table>
        
         </form>
      </div>
      
      <?php } if( $active_tab == 'leadscoring' ) {
 	    $settings = array( 'media_buttons' => true, 'textarea_rows' => 10, 'quicktags' => true, 'textarea_name' => 'swift_settings[delay]',  );
 	   /*echo '<pre>';print_r($swift_settings);exit;*/
	   
	   ?>
      <div class="inner_content">
        <?php 
			/*Save settings */
			if ( 
				isset( $_POST['save_popups'] ) 
				&& wp_verify_nonce( $_POST['save_popups'], 'save_popups' ) 
			) {
				$swift_settings = get_option('swift_settings');
				
				//Save feilds of scroll aware popup
 				$swift_settings['width2'] = $_POST['swift_settings']['width2'];
				$swift_settings['height2'] = $_POST['swift_settings']['height2'];
				$swift_settings['enable_exit'] = $_POST['swift_settings']['enable_exit'];
				$swift_settings['exit_intnet'] = $_POST['swift_settings']['exit_intnet'];
				
				
				/*echo '<pre>';print_r($_POST['save_popups']);exit;*/
				 $update = update_option('swift_settings', $swift_settings);
			}
			$swift_settings = get_option('swift_settings');
			
			
			if($update){
                echo '<div id="message" class="updated below-h2"><p>Settings updated successfully!</p></div>';
            }?>
		
         <table class="form-table">
 
         
            <tr>
              <th colspan="2" align="center">
            <h3>Coming soon</h3>
            </th>
            </tr>
            </table>
            
      </div>
      <?php } ?>
      
	  
</div>
<?php 
}  