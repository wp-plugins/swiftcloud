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
      <?php _e('We are constantly working on the betterment and improvement of this plugin so stay tuned.', 'swift-cloud');?>
    </p>
  </div>
</div>
<?php } 