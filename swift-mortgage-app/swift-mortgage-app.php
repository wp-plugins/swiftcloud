<?php
/*
	Plugin Name: Swift Mortgage App
	Plugin URI: http://wordpress.org/extend/plugins/wordpress-importer/
	Description: This simple plugin will capture the incomplete form. 
	Author: sjaved
	Author URI: https://jwebsol.com/
	Version: 1.0
	Text Domain: swift-mortgage-app
	License: GPL version 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/

//Call funtion to create necessary table(s)
register_activation_hook( __FILE__, 'sma_install' );

global $sma_db_version;
$sma_db_version = '1.0';

function sma_install() { 
	global $wpdb;
	global $jal_db_version;

	$table_name = $wpdb->prefix . 'sma_log';
	 
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		filename varchar(255) DEFAULT '' NOT NULL,
		daet_time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		name varchar(255) DEFAULT '' NOT NULL,
		email varchar(255) DEFAULT '' NOT NULL,
		phone varchar(255) DEFAULT '' NOT NULL,
		status TINYINT DEFAULT '0' NOT NULL,
		UNIQUE KEY id (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	add_option( 'sm_db_version', $sma_db_version );
}

add_action('admin_menu', 'sma_add_menu');
function sma_add_menu(){
	$page_hook_suffix = add_submenu_page('swift_control_panel','Swift Form Log', 'Swift Form Log', 'manage_options', 'sma_admin_dispplay_log', 'sma_admin_dispplay_log', $icon_url, 29);
	add_submenu_page('swift_control_panel', 'Swift Form Log Settings', 'Swift Form Log Settings', 'manage_options', 'sma_admin_dispplay_log_settings', 'sma_admin_dispplay_log_settings', $icon_url, 29);
	
	/*
          * Use the retrieved $page_hook_suffix to hook the function that links our script.
          * This hook invokes the function only on our plugin administration screen,
          * see: http://codex.wordpress.org/Administration_Menus#Page_Hook_Suffix
          */
    add_action('admin_print_scripts-' . $page_hook_suffix, 'sma_load_admin_scripts');
}

function sma_admin_dispplay_log(){
	global $wpdb;
	$i = 1;
	$table_name = $wpdb->prefix . "sma_log";
	
	//alter table to add new column	
	//$wpdb->query("ALTER TABLE $table_name ADD status TINYINT DEFAULT '0' NOT NULL");
	//$wpdb->query("ALTER TABLE $table_name ADD phone varchar(255) DEFAULT '' NOT NULL");
 
 	if( isset($_GET['mode']) && $_GET['mode'] == 'remove_record' && isset($_GET['id']) && !empty($_GET['id']) ){
 		
		$wpdb->delete( $table_name, $where = array('id' => $_GET['id']), $where_format = array( '%d' ) );
		
	}
	$fLog = $wpdb->get_results("SELECT * FROM $table_name ORDER BY daet_time DESC");
	
	/*echo '<pre>';
	print_r($fLog);
	exit;*/
	
	?>
    <div class="wrap">
    	<h2>Form Log </h2>
    
    	<div class="inner_content">
        
 			<table cellspacing="0" class="wp-list-table widefat fixed users">
                <thead>
                  <tr>
                    <th scope='col' id='cb' class='manage-column column-cb check-column'  style="">&nbsp;</th>
                    <th scope='col' id='file_name' class='manage-column'  style=""><a href="#"><span>File Name</span><span class="sorting-indicator"></span></a></th>
                    <th scope='col' id='name' class='manage-column  '  style=""><a href="#"><span>Name</span><span class="sorting-indicator"></span></a></th>
                    <th scope='col' id='email' class='manage-column'  style=""><a href="#"><span>E-mail</span><span class="sorting-indicator"></span></a></th>
                    <th scope='col' id='email' class='manage-column'  style=""><a href="#"><span>Phone</span><span class="sorting-indicator"></span></a></th>
                    <th scope='col' id='email' class='manage-column'  style=""><a href="#"><span>Status</span><span class="sorting-indicator"></span></a></th>
                    <th scope='col' id='date' class='manage-column column-role'  style="">Date/Time</th>
                    <th scope='col' id='actions' class='manage-column column-posts num'  style="">Actions</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th scope='col' id='cb' class='manage-column column-cb check-column'  style="">&nbsp;</th>
                    <th scope='col' id='file_name' class='manage-column'  style=""><a href="#"><span>File Name</span><span class="sorting-indicator"></span></a></th>
                    <th scope='col' id='name' class='manage-column  '  style=""><a href="#"><span>Name</span><span class="sorting-indicator"></span></a></th>
                    <th scope='col' id='email' class='manage-column'  style=""><a href="#"><span>E-mail</span><span class="sorting-indicator"></span></a></th>
                    <th scope='col' id='email' class='manage-column'  style=""><a href="#"><span>Phone</span><span class="sorting-indicator"></span></a></th>
                    <th scope='col' id='email' class='manage-column'  style=""><a href="#"><span>Status</span><span class="sorting-indicator"></span></a></th>
                    <th scope='col' id='date' class='manage-column column-role'  style="">Date/Time</th>
                    <th scope='col' id='actions' class='manage-column column-posts num'  style="">Actions</th>
                  </tr>
                </tfoot>
                <tbody id="the-list" class='list:user'> 
                  <?php if($fLog) :
                            foreach ( $fLog as $log) :
                                ?>
                  <tr id='user-<?php echo $log->id;  ?>' class="alternate">
                    <th scope='row' class='check-column'><span style="margin-left:10px;"><?php echo $i;?></span></th>
                    <td class="filename column-filename"><?php if($log->filename) echo $log->filename; else echo '-';?></td>
                    <td class="name column-name"><?php if($log->name) echo $log->name; else echo '-';?></td>
                    <td class="email column-email">
                    <?php if($log->email) {?><a href='mailto:<?php echo $log->email; ?>' title='E-mail: <?php echo $log->email; ?>'><?php echo $log->email; ?></a><?php }else{ echo '-';}?>
                    </td>
                    <td class="email column-email">
                    <?php if($log->phone) {?><a href='tel:<?php echo $log->phone; ?>' title='Phone: <?php echo $log->phone; ?>'><?php echo $log->phone; ?></a><?php }else{ echo '-';}?>
                    </td>
                    <td class="role column-role"><?php if($log->status == '1') echo '<i class="fa fa-flag-checkered complete"></i> Complete'; else echo '<i class="fa fa-exclamation-triangle incomplete" ></i> Incomplete'?></td>
                    <td class="role column-role"><abbr class="timeago" title="<?php echo $log->daet_time;?>"><?php echo ($log->daet_time);?></abbr></td>
                    <td class="posts column-posts num"> <a onclick="return confirm('Are you sure you want to delete this record ?');" href="admin.php?page=sma_admin_dispplay_log&mode=remove_record&id=<?php echo $log->id; ?>"><i class="fa fa-times-circle delete"></i></a></td>
                  </tr>
                  <?php $i++;
                          endforeach; //foreach end;
                    else: ?>
                    <tr id='user-1' class="alternate">
                         
                        <td scope='row' class='check-column' colspan="6" align="center" valign="middle"><?php _e('No Record found.', 'swift-mortgage-app')?></th>
             
                  </tr>
                    <?php 
                      endif; //first if end
                  ?>
                </tbody>
            </table>
            
        <link rel="stylesheet" type="text/css" href="http://netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.css">
		<style type="text/css">
			.complete{ color:#66CD00; }
			.incomplete{ color:#F5F500; }
			.delete{ color:#FF0000; }			
        </style>    
		<script type="text/javascript">
			jQuery(document).ready(function() {
  				jQuery("abbr.timeago").timeago();
			});
        </script>
        </div>
          
    </div>
<?php }

function sma_admin_dispplay_log_settings(){?>
	 <div class="wrap">
    	<h2>Settings</h2>
        <?php
			if ( 
			isset( $_POST['save_sma_form'] ) 
				&& wp_verify_nonce( $_POST['save_sma'], 'save_sma' ) 
			) {
				 $update = update_option('sma_settings', $_POST['sma_settings']);
			}
  			
			$sma_settings = get_option('sma_settings');
		?>
        
            <div class="inner_content">
            <?php if($update){
                echo '<div id="message" class="updated below-h2"><p>Settings successfully updated!</p></div>';
            }?>
            <br /><br />
            <form action="" method="post" >
	            
                <label for="popup-delay">Form ID</label>
                <input type="text" value="<?php echo $sma_settings['form_id'] ?>" class="widefat" name="sma_settings[form_id]" placeholder="e.g. sma_form" /><br /><br />
                
                <label for="popup-delay">File field ID</label>
                <input type="text" value="<?php echo $sma_settings['file_field_id'] ?>" class="widefat" name="sma_settings[file_field_id]" placeholder="e.g. clientID"/><br /><br />
                
                <label for="popup-delay">Name field ID</label>
                <input type="text" value="<?php echo $sma_settings['name_field_id'] ?>" class="widefat" name="sma_settings[name_field_id]" placeholder="e.g. name"/><br /><br />
                
                <label for="popup-delay">Email field ID</label>
                <input type="text" value="<?php echo $sma_settings['email_field_id'] ?>" class="widefat" name="sma_settings[email_field_id]" placeholder="e.g. email"/><br /><br />
                
                <label for="popup-delay">Phone field ID</label>
                <input type="text" value="<?php echo $sma_settings['phone_field_id'] ?>" class="widefat" name="sma_settings[phone_field_id]" placeholder="e.g. phone"/><br /><br />
                
                <label for="popup-delay">Submit field ID</label>
                <input type="text" value="<?php echo $sma_settings['submit_field_id'] ?>" class="widefat" name="sma_settings[submit_field_id]" placeholder="e.g. sma_submit"/>
                
                <?php wp_nonce_field('save_sma', 'save_sma')?><br /><br /><br />
        		<input type="submit" name="save_sma_form" class="button button-primary" value="Save Changes" />
                
        	</form>
            
            <p><strong>Note:*</strong> form ID must be unique</p>
        
            </div>
        
    </div>
<?php }

//Looad google tag manager.
function sma_virtual_page_views(){?>
	
	<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-XXXX"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-XXXX');</script>
<!-- End Google Tag Manager -->

<?php }
add_action('wp_head', 'sma_virtual_page_views');   

//Lod necessary javascript files and handlers
function sma_load_scripts(){
	
	wp_enqueue_script( 'sma-main', plugins_url('/js/sma.js' , __FILE__), array('jquery'), '', true );
	
	$sma_settings = get_option('sma_settings');
		
	// Localize the script with new data
	$data = array( 
		'ajax_url' => admin_url( 'admin-ajax.php' ),
		'form_id' => $sma_settings['form_id'],
		'file_field_id' => $sma_settings['file_field_id'],
		'name_field_id' => $sma_settings['name_field_id'],
		'email_field_id' => $sma_settings['email_field_id'],
		'phone_field_id' => $sma_settings['phone_field_id'],
		'submit_field_id' => $sma_settings['submit_field_id']
 	);
	wp_localize_script( 'sma-main', 'sma_data', $data );

}
add_action('wp_enqueue_scripts', 'sma_load_scripts', 10);

function sma_load_admin_scripts(){
 
	wp_enqueue_script( 'sma-main-admin', plugins_url('/js/jquery.timeago.js' , __FILE__), array('jquery'), '', true );
}

function sma_save_log_cb(){
	global $wpdb;
	$cookie_name = 'sma_log_id';
 	
	$client_id =  $_POST['client_id'] ;

	$table_name = $wpdb->prefix . "sma_log";
	
	if(isset($_COOKIE['sma_log_id'])) {
		
		$wpdb->update( 
			$table_name, 
			array( 
				'filename' => $client_id, 
				'daet_time' => date('Y-m-d h:i:s'), 
			), 
			array( 'id' => $_COOKIE['sma_log_id'] ), 
			array( 
				'%s',	// value1
				'%s'	// value2
			), 
			array( '%d' ) 
		);
		
	}else{
		$wpdb->insert( 
			$table_name, 
			array( 
				'filename' => $client_id, 
				'daet_time' => date('Y-m-d h:i:s'), 
			), 
			array( 
				'%s', 
				'%s', 
			) 
		);
		
		$cookie_value = $wpdb->insert_id;
	
		setcookie('sma_log_id', $cookie_value, 0, "/"); // end when session end
	}
 	
	echo $_COOKIE['sma_log_id'];
	wp_die(); // this is required to terminate immediately and return a proper response
	 
}
add_action( 'wp_ajax_sma_save_log', 'sma_save_log_cb' );
add_action( 'wp_ajax_nopriv_sma_save_log', 'sma_save_log_cb' );

function sma_save_log_name_cb(){
	global $wpdb;
	$cookie_name = 'sma_log_id';
 	
	$client_name =  $_POST['client_name'] ;

	$table_name = $wpdb->prefix . "sma_log";
	
	if(isset($_COOKIE['sma_log_id'])) {
		
		$wpdb->update( 
			$table_name, 
			array( 
				'name' => $client_name, 
			), 
			array( 'id' => $_COOKIE['sma_log_id'] ), 
			array( 
				'%s',	// value1
			), 
			array( '%d' ) 
		);
		
	}else{
		$wpdb->insert( 
			$table_name, 
			array( 
				'email' => $client_id, 
			), 
			array( 
				'%s', 
 			) 
		);
		
		$cookie_value = $wpdb->insert_id;
	
		setcookie('sma_log_id', $cookie_value, 0, "/"); // end when session end
	}
 	
	echo $_COOKIE['sma_log_id'];
	wp_die(); // this is required to terminate immediately and return a proper response
	 
}
add_action( 'wp_ajax_sma_save_log_name', 'sma_save_log_name_cb' );
add_action( 'wp_ajax_nopriv_sma_save_log_name', 'sma_save_log_name_cb' );

function sma_save_log_email_cb(){
	global $wpdb;
	$cookie_name = 'sma_log_id';
 	
	$client_email =  $_POST['client_email'] ;

	$table_name = $wpdb->prefix . "sma_log";
	
	if(isset($_COOKIE['sma_log_id'])) {
		
		$wpdb->update( 
			$table_name, 
			array( 
				'email' => $client_email, 
			), 
			array( 'id' => $_COOKIE['sma_log_id'] ), 
			array( 
				'%s',	// value1
			), 
			array( '%d' ) 
		);
		
	}else{
		$wpdb->insert( 
			$table_name, 
			array( 
				'email' => $client_id, 
			), 
			array( 
				'%s', 
 			) 
		);
		
		$cookie_value = $wpdb->insert_id;
	
		setcookie('sma_log_id', $cookie_value, 0, "/"); // end when session end
	}
 	
	echo $_COOKIE['sma_log_id'];
	wp_die(); // this is required to terminate immediately and return a proper response
	 
}
add_action( 'wp_ajax_sma_save_log_email', 'sma_save_log_email_cb' );
add_action( 'wp_ajax_nopriv_sma_save_log_email', 'sma_save_log_email_cb' );

function sma_save_log_phone_cb(){
	global $wpdb;
	$cookie_name = 'sma_log_id';
 	
	$client_phone =  $_POST['client_phone'] ;

	$table_name = $wpdb->prefix . "sma_log";
	
	if(isset($_COOKIE['sma_log_id'])) {
		
		$wpdb->update( 
			$table_name, 
			array( 
				'phone' => $client_phone, 
			), 
			array( 'id' => $_COOKIE['sma_log_id'] ), 
			array( 
				'%s',	// value1
			), 
			array( '%d' ) 
		);
		
	}else{
		$wpdb->insert( 
			$table_name, 
			array( 
				'phone' => $client_phone, 
			), 
			array( 
				'%s', 
 			)
		);
		
		$cookie_value = $wpdb->insert_id;
	
		setcookie('sma_log_id', $cookie_value, 0, "/"); // end when session end
	}
 	
	echo $_COOKIE['sma_log_id'];
	wp_die(); // this is required to terminate immediately and return a proper response
	 
}
add_action( 'wp_ajax_sma_save_log_phone', 'sma_save_log_phone_cb' );
add_action( 'wp_ajax_nopriv_sma_save_log_phone', 'sma_save_log_phone_cb' );

function sma_save_log_complete_cb(){
	global $wpdb;
	$cookie_name = 'sma_log_id';
  
	$table_name = $wpdb->prefix . "sma_log";
	
	if(isset($_COOKIE['sma_log_id'])) {
		
		$wpdb->update( 
			$table_name, 
			array( 
				'status' => 1, 
			), 
			array( 'id' => $_COOKIE['sma_log_id'] ), 
			array( 
				'%d',	// value1
			), 
			array( '%d' ) 
		);
		
	} 
 	
	if(isset($_COOKIE['sma_log_id'])) {
	  unset($_COOKIE['sma_log_id']);
	  setcookie('sma_log_id', '', time() - 3600); // empty value and old timestamp
	}
	wp_die(); // this is required to terminate immediately and return a proper response
	 
}
add_action( 'wp_ajax_sma_save_log_complete', 'sma_save_log_complete_cb' );
add_action( 'wp_ajax_nopriv_sma_save_log_complete', 'sma_save_log_complete_cb' );