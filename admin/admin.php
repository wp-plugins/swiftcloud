<?php
/**
 * Plugin file. This file should ideally be used to work with the
 * administrative side of the WordPress site.
 */
// Add the options page and menu item.
add_action('admin_menu', 'swift_control_panel');

function swift_control_panel() {
    $icon_url = plugins_url('/images/swiftcloud.png', __FILE__);
    $page_hook = add_menu_page($page_title = 'SwiftCloud', $menu_title = 'SwiftCloud', $capability = 'manage_options', $menu_slug = 'swift_control_panel', $function = 'swift_control_panel_cb', $icon_url, $position);
    add_action('admin_print_scripts-' . $page_hook, 'swift_enqueue_admin_scripts_styles');
}

function swift_enqueue_admin_scripts_styles() {
    wp_enqueue_style('swift-toggle-style', plugins_url('/toggles/css/toggles.css', __FILE__), '', '', '');
    wp_enqueue_style('swift-toggle-style-theme', plugins_url('/toggles/css/toggles-full.css', __FILE__), '', '', '');

    wp_enqueue_style('swift-admin-style', plugins_url('/css/admin.css', __FILE__), '', '', '');

    wp_enqueue_script('swift-toggle-js', plugins_url('/toggles/toggles.js', __FILE__), array('jquery'), '', true);
    wp_enqueue_script('swift-toggle-custom-js', plugins_url('/js/admin.js', __FILE__), array('jquery', 'swift-toggle-js'), '', true);
}

function swift_control_panel_cb() {
    ?>
    <div class="wrap">
        <h2>SwiftCloud Control Panel</h2>
        <h2 class="nav-tab-wrapper">
            <?php $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'general'; ?>
            <a href="<?php echo admin_url('admin.php') ?>?page=swift_control_panel&tab=general" class="nav-tab <?php echo $active_tab == 'general' ? 'nav-tab-active' : ''; ?>"><?php _e('SwiftCloud User Guide'); ?></a>
            <a href="<?php echo admin_url('admin.php') ?>?page=swift_control_panel&tab=autopopup" class="nav-tab <?php echo $active_tab == 'autopopup' ? 'nav-tab-active' : ''; ?>"><?php _e('Timed PopUp'); ?></a>
            <a href="<?php echo admin_url('admin.php') ?>?page=swift_control_panel&tab=scrollpopup" class="nav-tab <?php echo $active_tab == 'scrollpopup' ? 'nav-tab-active' : ''; ?>"><?php _e('Scroll PopUp'); ?></a>
            <a href="<?php echo admin_url('admin.php') ?>?page=swift_control_panel&tab=exitpopup" class="nav-tab <?php echo $active_tab == 'exitpopup' ? 'nav-tab-active' : ''; ?>"><?php _e('Exit PopUp'); ?></a>
            <a href="<?php echo admin_url('admin.php') ?>?page=swift_control_panel&tab=leadscoring" class="nav-tab <?php echo $active_tab == 'leadscoring' ? 'nav-tab-active' : ''; ?>"><?php _e('Lead Scoring'); ?></a>
            <a href="<?php echo admin_url('admin.php') ?>?page=swift_control_panel&tab=livechat" class="nav-tab <?php echo $active_tab == 'livechat' ? 'nav-tab-active' : ''; ?>"><?php _e('Live Chat'); ?></a>
            <a href="<?php echo admin_url('admin.php') ?>?page=swift_control_panel&tab=helpsupport" class="nav-tab <?php echo $active_tab == 'helpsupport' ? 'nav-tab-active' : ''; ?>"><?php _e('Help / Support'); ?></a>
        </h2>

        <!-- SwiftCloud User Guide -->
        <?php if ($active_tab == 'general') { ?>
            <div class="inner_content">
                <p><?php _e('Thanks for installing the plugin.', 'swift-cloud'); ?></p>
                <h3><?php _e('Widget usage instructions:', 'swift-cloud'); ?></h3>
                <p><?php _e('Here are easy steps to use this plugin.', 'swift-cloud'); ?></p>
                <ol>
                    <li><?php _e('Navigate to Appearance > <a href="' . get_admin_url('', 'widgets.php') . '">Widgets</a>.', 'swift-cloud'); ?></li>
                    <li><?php _e('Add the "Swiftform" widget in sidebar to show the like box in your website sidebar.', 'swift-cloud'); ?></li>
                    <li><?php _e('Input title.', 'swift-cloud'); ?></li>
                    <li><?php _e('Input cloud form ID that you have generated from <a href="http://swiftform.com/" target="_blank">swiftform.com</a> using drag and drop form builder.', 'swift-cloud'); ?></li>
                    <li><?php _e('Save changes and enjoy.', 'swift-cloud'); ?></li>
                </ol>
                <h3><?php _e('Shortcode usage instructions:', 'swift-cloud'); ?></h3>
                <ol>
                    <li><?php _e('Add [swiftform id="123"] shortcode into post/page/ editor to display the form.', 'swift-cloud'); ?></li>
                    <li><?php _e('Replace the "123" with ID of the swift form.', 'swift-cloud'); ?></li>
                </ol>
                <h2>Best Practices</h2>
                <ol><li>Lead Nurturing: See <a href="http://swiftmarketing.com/sales-lead-incubator" target="_blank">http://swiftmarketing.com/sales-lead-incubator</a></li></ol>
                <p><?php _e('We are constantly working on the betterment and improvement of this plugin so stay tuned.', 'swift-cloud'); ?></p>
            </div>
        <?php } ?>

        <?php
        // Timed PopUp
        if ($active_tab == 'autopopup') {
            /* Save settings */
            $swift_settings = get_option('swift_settings');
            if (isset($_POST['save_popups']) && wp_verify_nonce($_POST['save_popups'], 'save_popups')) {
                $swift_settings['delay'] = $_POST['swift_settings']['delay'];
                $swift_settings['width'] = $_POST['swift_settings']['width'];
                $swift_settings['height'] = $_POST['swift_settings']['height'];
                $swift_settings['enable_time'] = $_POST['swift_settings']['enable_time'];
                $swift_settings['time_lead'] = $_POST['swift_settings']['time_lead'];
                $swift_settings['form_id'] = $_POST['swift_settings']['form_id'];
                $swift_settings['timed_popup_content'] = $_POST['swift_settings']['timed_popup_content'];

                $update = update_option('swift_settings', $swift_settings);
            }
            $settings = array('media_buttons' => true, 'textarea_rows' => 10, 'quicktags' => true, 'textarea_name' => 'swift_settings[delay]',);
            ?>
            <div class="inner_content">
                <?php
                if ($update) {
                    echo '<div id="message" class="updated below-h2"><p>Settings updated successfully!</p></div>';
                }
                ?>
                <form method="post" action="" >
                    <table class="form-table">
                        <tr>
                            <th colspan="2"><h3>Timed Lead Capture Pop-Over</h3></thj>
                        </tr>
                        <tr>
                            <th><label for="popup-delay">Fire this popup after </label></th>
                            <td><input type="text" value="<?php echo $swift_settings['delay'] ?>" class="" name="swift_settings[delay]"/> seconds</td>
                        </tr>
                        <tr>
                            <th><label for="popup-delay">with a width of</label></th>
                            <td><input type="text" value="<?php echo $swift_settings['width'] ?>" class="" name="swift_settings[width]"/> in pixels</td>
                        </tr>
                        <tr>
                            <th><label for="popup-delay">and height</label></th>
                            <td><input type="text" value="<?php echo $swift_settings['height'] ?>" class="" name="swift_settings[height]"/> in pixels.</td>
                        </tr>
                        <tr>
                            <th><label for="popup-delay">Currently, the popup is </label></th>
                            <td>
                                <div class="toggle_container" style="width:100px; text-align:center">
                                    <div class="enable_time toggle-light"></div>
                                    <input class="checkme" id="enable_time" type="checkbox" value="1" <?php echo checked('1', $swift_settings['enable_time']) ?> name="swift_settings[enable_time]" style="display:none;"/>
                                    <script type="text/javascript">
                                        jQuery(document).ready(function($) {
                                            $('.enable_time').toggles({checkbox: $('.checkme')});
        <?php if ($swift_settings['enable_time']) { ?>
                                                $('.enable_time').click();
        <?php } ?>
                                        });
                                    </script>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>PopUp Content</th>
                            <td>
                                <h2 class="nav-tab-wrapper" id="wpseo-tabs">
                                    <a class="nav-tab custom-tab <?php if ($swift_settings['timed_popup_content'] == 's_id' || empty($swift_settings['timed_popup_content'])) echo 'nav-tab-active'; ?>" data-formid="sform_a_1" id="general-tab" href="#sform">SwiftForm</a>
                                    <a class="nav-tab custom-tab <?php if ($swift_settings['timed_popup_content'] == 'html_content') echo 'nav-tab-active'; ?>" id="home-tab" data-formid="sform_a_1" href="#html">Direct HTML</a>
                                </h2>
                                <br />
                                <br />
                                <div class="tabwrapper">
                                    <div id="sform" class="panel <?php if ($swift_settings['timed_popup_content'] == 's_id' || empty($swift_settings['timed_popup_content'])) echo 'active'; ?> ">
                                        My timed popup form ID # is
                                        <input type="text" value="<?php echo $swift_settings['form_id'] ?>" class="" name="swift_settings[form_id]"/>
                                        <input style="display:none;" type="radio" class="sform_a_1" name="swift_settings[timed_popup_content]" value="s_id" />
                                    </div>
                                    <div id="html" class="panel <?php if ($swift_settings['timed_popup_content'] == 'html_content') echo 'active'; ?>">
                                        <input style="display:none;" type="radio" class="sform_a_1" name="swift_settings[timed_popup_content]" value="html_content" />
                                        <?php
                                        $settings['textarea_name'] = 'swift_settings[time_lead]';
                                        wp_editor(stripslashes($swift_settings['time_lead']), 'time_lead_capture', $settings)
                                        ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="2">
                                <?php wp_nonce_field('save_popups', 'save_popups') ?>
                                <input type="submit" class="button button-primary" value="Save Changes" />
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            <?php
        }

        // Scroll PopUp Starts
        if ($active_tab == 'scrollpopup') {
            ?>
            <div class="inner_content">
                <?php
                /* Save settings */
                $swift_settings = get_option('swift_settings');
                if (isset($_POST['save_popups']) && wp_verify_nonce($_POST['save_popups'], 'save_popups')) {
                    //Save feilds of scroll aware popup
                    $swift_settings['width1'] = $_POST['swift_settings']['width1'];
                    $swift_settings['height1'] = $_POST['swift_settings']['height1'];
                    $swift_settings['enable_scroll'] = $_POST['swift_settings']['enable_scroll'];
                    $swift_settings['slide_in'] = $_POST['swift_settings']['slide_in'];
                    $swift_settings['form_id_slide'] = $_POST['swift_settings']['form_id_slide'];
                    $swift_settings['scroll_popup_content'] = $_POST['swift_settings']['scroll_popup_content'];

                    $update = update_option('swift_settings', $swift_settings);
                }

                if ($update) {
                    echo '<div id="message" class="updated below-h2"><p>Settings updated successfully!</p></div>';
                }
                ?>
                <form method="post" action="" >
                    <table class="form-table">
                        <tr>
                            <th colspan="2"><h3>Scroll-Aware Slide-In</h3></th>
                        </tr>
                        <tr>
                            <th colspan="2">Fire this popup if someone scrolls down 70% of the page-height</th>
                        </tr>
                        <tr>
                            <th><label for="popup-scroll">with a width of</label></th>
                            <td><input type="text" value="<?php echo $swift_settings['width1'] ?>" class="" name="swift_settings[width1]"/> in pixels</td>
                        </tr>
                        <tr>
                            <th><label for="popup-scroll">and height of</label></th>
                            <td><input type="text" value="<?php echo $swift_settings['height1'] ?>" class="" name="swift_settings[height1]"/> in pixels.</td>
                        </tr>
                        <tr>
                            <th><label for="popup-delay">Currently, the popup is </label></th>
                            <td>
                                <div class="toggle_container" style="width:100px; text-align:center">
                                    <div class="enable_scroll toggle-light"></div>
                                    <input type="checkbox" value="1" <?php echo checked('1', $swift_settings['enable_scroll']) ?> class="checkme_1"  id="enable_scroll" name="swift_settings[enable_scroll]" style="display:none;"/>
                                    <script type="text/javascript">
                                        jQuery(document).ready(function($) {

                                            $('.enable_scroll').toggles({checkbox: $('.checkme_1')});
        <?php if ($swift_settings['enable_scroll']) { ?>
                                                $('.enable_scroll').click();
        <?php } ?>
                                        });
                                    </script>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Popup content</th>
                            <td>
                                <h2 class="nav-tab-wrapper" id="wpseo-tabs">
                                    <a class="nav-tab custom-tab <?php if ($swift_settings['scroll_popup_content'] == 's_id' || empty($swift_settings['scroll_popup_content'])) echo 'nav-tab-active'; ?>" data-formid="swift_two" id="general-tab" href="#sform">SwiftForm</a>
                                    <a class="nav-tab custom-tab <?php if ($swift_settings['scroll_popup_content'] == 'html_content') echo 'nav-tab-active'; ?>" id="home-tab" data-formid="swift_two" href="#html">Direct HTML</a>
                                </h2>
                                <br />
                                <br />
                                <div class="tabwrapper">
                                    <div id="sform" class="panel <?php if ($swift_settings['scroll_popup_content'] == 's_id' || empty($swift_settings['scroll_popup_content'])) echo 'active'; ?> ">
                                        My scroll popup form ID # is
                                        <input type="text" value="<?php echo $swift_settings['form_id_slide'] ?>" class="" name="swift_settings[form_id_slide]"/>
                                        <input style="display:none;" type="radio" class="swift_two" name="swift_settings[scroll_popup_content]" value="s_id" checked="checked"/>
                                    </div>
                                    <div id="html" class="panel <?php if ($swift_settings['scroll_popup_content'] == 'html_content') echo 'active'; ?>">
                                        <input style="display:none;" type="radio" class="swift_two" name="swift_settings[scroll_popup_content]" value="html_content" />
                                        <?php
                                        $settings['textarea_name'] = 'swift_settings[slide_in]';
                                        wp_editor(stripslashes($swift_settings['slide_in']), 'scroll_aware_slidein', $settings)
                                        ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="2">
                                <?php wp_nonce_field('save_popups', 'save_popups') ?>
                                <input type="submit" class="button button-primary" value="Save Changes" />
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            <?php
        }

        if ($active_tab == 'exitpopup') {
            $settings = array('media_buttons' => true, 'textarea_rows' => 10, 'quicktags' => true, 'textarea_name' => 'swift_settings[delay]',);
            ?>
            <div class="inner_content">
                <?php
                /* Save settings */
                $swift_settings = get_option('swift_settings');
                if (isset($_POST['save_popups']) && wp_verify_nonce($_POST['save_popups'], 'save_popups')) {
                    $swift_settings['width2'] = $_POST['swift_settings']['width2'];
                    $swift_settings['height2'] = $_POST['swift_settings']['height2'];
                    $swift_settings['enable_exit'] = $_POST['swift_settings']['enable_exit'];
                    $swift_settings['exit_intnet'] = $_POST['swift_settings']['exit_intnet'];
                    $swift_settings['form_id_exit'] = $_POST['swift_settings']['form_id_exit'];
                    $swift_settings['exit_popup_content'] = $_POST['swift_settings']['exit_popup_content'];

                    $update = update_option('swift_settings', $swift_settings);
                }

                if ($update) {
                    echo '<div id="message" class="updated below-h2"><p>Settings updated successfully!</p></div>';
                }
                ?>
                <form method="post" action="" >
                    <table class="form-table">
                        <tr>
                            <th colspan="2"><h3>Exit-Intent Overlay</h3></th>
                        </tr>
                        <tr>
                            <th colspan="2">Fire this popup if someone mouses to leave the page,</th>
                        </tr>
                        <tr>
                            <th><label for="popup-exit">with a width of</label></th>
                            <td><input type="text" value="<?php echo $swift_settings['width2'] ?>" class="" name="swift_settings[width2]"/> in pixels</td>
                        </tr>
                        <tr>
                            <th><label for="popup-exit">and height of</label></th>
                            <td><input type="text" value="<?php echo $swift_settings['height2'] ?>" class="" name="swift_settings[height2]"/> in pixels.</td>
                        </tr>
                        <tr>
                            <th><label for="popup-delay">Currently, the popup is</label></th>
                            <td>
                                <div class="toggle_container" style="width:100px; text-align:center">
                                    <div class="enable_exit toggle-light">
                                    </div>
                                    <input type="checkbox" value="1" <?php echo checked('1', $swift_settings['enable_exit']) ?> class="checkme_2"  id="enable_exit" name="swift_settings[enable_exit]" style="display:none;"/>
                                    <script type="text/javascript">
                                        jQuery(document).ready(function($) {
                                            $('.enable_exit').toggles({checkbox: $('.checkme_2')});
        <?php if ($swift_settings['enable_exit']) { ?>
                                                $('.enable_exit').click();
        <?php } ?>
                                        });
                                    </script>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>PopUp content</th>
                            <td>
                                <h2 class="nav-tab-wrapper" id="wpseo-tabs">
                                    <a class="nav-tab custom-tab <?php if ($swift_settings['exit_popup_content'] == 's_id' || empty($swift_settings['exit_popup_content'])) echo 'nav-tab-active'; ?>" data-formid="swift_three" id="general-tab" href="#sform">SwiftForm</a>
                                    <a class="nav-tab custom-tab <?php if ($swift_settings['exit_popup_content'] == 'html_content') echo 'nav-tab-active'; ?>" id="home-tab" data-formid="swift_three" href="#html">Direct HTML</a>
                                </h2>
                                <br />
                                <br />
                                <div class="tabwrapper">
                                    <div id="sform" class="panel <?php if ($swift_settings['exit_popup_content'] == 's_id' || empty($swift_settings['exit_popup_content'])) echo 'active'; ?> ">
                                        My exit popup form ID # is
                                        <input type="text" value="<?php echo $swift_settings['form_id_exit'] ?>" class="" name="swift_settings[form_id_exit]"/>
                                        <input style="display:none;" type="radio" class="swift_three" name="swift_settings[scroll_popup_content]" value="s_id" checked="checked"/>
                                    </div>
                                    <div id="html" class="panel <?php if ($swift_settings['exit_popup_content'] == 'html_content') echo 'active'; ?>">
                                        <input style="display:none;" type="radio" class="swift_three" name="swift_settings[exit_popup_content]" value="html_content" />
                                        <?php
                                        $settings['textarea_name'] = 'swift_settings[exit_intnet]';
                                        wp_editor(stripslashes($swift_settings['exit_intnet']), 'exit_intnet_overlay', $settings)
                                        ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="2">
                                <?php wp_nonce_field('save_popups', 'save_popups') ?>
                                <input type="submit" class="button button-primary" value="Save Changes" />
                            </td>
                        </tr>
                    </table>
                </form>
            </div>

            <?php
        }


        if ($active_tab == 'leadscoring') {
            $settings = array('media_buttons' => true, 'textarea_rows' => 10, 'quicktags' => true, 'textarea_name' => 'swift_settings[delay]',);
            ?>
            <div class="inner_content">
                <?php
                /* Save settings */
                if (isset($_POST['save_popups']) && wp_verify_nonce($_POST['save_popups'], 'save_popups')) {
                    $swift_settings = get_option('swift_settings');
                }
                $swift_settings = get_option('swift_settings');

                if ($update) {
                    echo '<div id="message" class="updated below-h2"><p>Settings updated successfully!</p></div>';
                }
                ?>
                <table class="form-table">
                    <tr>
                        <th colspan="2" align="center"><h3>Coming soon</h3></th>
                    </tr>
                </table>
            </div>
            <?php
        }

        if ($active_tab == 'livechat') {
            $settings = array('media_buttons' => true, 'textarea_rows' => 10, 'quicktags' => true, 'textarea_name' => 'swift_settings[delay]',);
            ?>
            <div class="inner_content">
                <?php
                /* Save settings */
                if (isset($_POST['save_popups']) && wp_verify_nonce($_POST['save_popups'], 'save_popups')) {
                    $swift_settings = get_option('swift_settings');
                }
                $swift_settings = get_option('swift_settings');

                if ($update) {
                    echo '<div id="message" class="updated below-h2"><p>Settings updated successfully!</p></div>';
                }
                ?>
                <table class="form-table">
                    <tr>
                        <th colspan="2" align="center"><h3>Coming soon</h3></th>
                    </tr>
                    <tr>
                        <td>Live Chat is</td>
                        <td>
                            <div class="toggle_container" style="width:100px; text-align:center">
                                <div class="enable_chat toggle-light"></div>
                                <input type="checkbox" value="1" <?php echo checked('1', $swift_settings['enable_scroll']) ?> class="checkme_c"  id="enable_chat" name="swift_settings[enable_chat]" style="display:none;"/>
                                <script type="text/javascript">
                                    jQuery(document).ready(function($) {
                                        $('.enable_chat').toggles({checkbox: $('.checkme_c')});
        <?php if ($swift_settings['enable_scroll']) { ?>
                                            $('.enable_chat').click();
        <?php } ?>
                                    });
                                </script>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <?php
        }

        if ($active_tab == 'helpsupport') {
            ?>
            <div class="inner_content">
                <?php
                /* Save settings */
                $swift_settings = get_option('swift_settings');
                if (isset($_POST['save_help_support']) && wp_verify_nonce($_POST['save_help_support'], 'save_help_support')) {
                    $swift_settings['help_form_id'] = $_POST['swift_settings']['help_form_id'];
                    $swift_settings['help_form_cat'] = $_POST['swift_settings']['help_form_cat'];
                    $update = update_option('swift_settings', $swift_settings);
                }

                if ($update) {
                    echo '<div id="message" class="updated below-h2"><p>Settings updated successfully!</p></div>';
                }
                ?>
                <form method="post" action="" >
                    <table class="form-table">
                        <tr><th colspan="2" align="center"><h3>SwiftHelpDesk.com</h3></th></tr>
                        <tr>
                            <th><label for="popup-scroll">My SwiftForm.com help support form is number</label></th>
                            <td><input type="text" value="<?php echo $swift_settings['help_form_id'] ?>" class="" name="swift_settings[help_form_id]"/></td>
                        </tr>
                        <tr>
                            <th><label for="popup-scroll">My help / support category is</label></th>
                            <td>
                                <?php
                                $cat_args = array(
                                    'name' => 'swift_settings[help_form_cat]',
                                    'show_option_all' => '--Select--',
                                    'show_option_none' => '0',
                                    'option_none_value' => '0',
                                    'selected' => $swift_settings['help_form_cat'],
                                );
                                wp_dropdown_categories($cat_args);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <?php wp_nonce_field('save_help_support', 'save_help_support') ?>
                                <input type="submit" name="submit" value="Save" class="button-orange" />
                            </th>
                        </tr>
                    </table>
                </form>

                <p><?php _e('How to use:', 'swift-cloud'); ?></p>
                <ol>
                    <li><?php _e('Login to SwiftForm.com (account required, free or premium)', 'swift-cloud'); ?></li>
                    <li><?php _e('Create a Support / Helpdesk form', 'swift-cloud'); ?></li>
                    <li><?php _e('Note the number of the form and enter it above.', 'swift-cloud'); ?></li>
                    <li><?php _e('Drop shortcode [swifthelpdeskform] on to any page-body.', 'swift-cloud'); ?></li>
                </ol>
                <p><?php _e('This will create a custom support form and search system for you.', 'swift-cloud'); ?></p>
            </div>
        <?php } ?>
    </div>
    <?php
}

//swift help desk form
function function_SwiftHelpDeskForm($attr) {
    $swift_settings = get_option('swift_settings');
    $HelpFormId = $swift_settings['help_form_id'];
    $HelpFormCat = $swift_settings['help_form_cat'];
    ?>
    <div style="float: left; width: 49%; margin-right: 1%;">
        <h2 class="recent-artical-title">Recent Articles</h2>
        <div class="tag_list" id="tag_list"><!--Tag list goes here...--></div>
        <div id="recent-post">
            <?php query_posts('&post_type=post&posts_per_page=10&orderby=date&order=DESC'); ?>
            <?php while (have_posts()) : the_post(); ?>
                <div class="sm-recent-post">
                    <a href="<?php echo get_permalink(get_the_ID()); ?>">
                        <h4><?php the_title(); ?></h4>
                        <div class="sm-recent-post-img">
                            <?php if (has_post_thumbnail()) { // check if the post has a Post Thumbnail assigned to it.  ?>
                                <?php the_post_thumbnail(array(80, 80)); ?>
                            <?php } else { ?>
                            <img src="<?php echo plugins_url() ?>/swiftcloud/images/flag.png" alt="" />
                            <?php } ?>
                        </div>
                        <div class="sm-recent-post-content">
                            <?php sm_custom_excerpt(20, get_the_ID(), TRUE); ?>
                        </div>
                        <div class="clear"></div>
                    </a>
                </div>
                <hr class="recent-post-line">
            <?php endwhile; ?>
            <?php wp_reset_query(); ?>
        </div>
    </div>
    <div style="float: left; width: 49%; margin-left: 1%;">
        <?php echo do_shortcode('[swiftform id="' . $HelpFormId . '"]'); ?>
        <script type="text/javascript">
            jQuery(document).ready(function() {
                $("#form-submit").prepend('<input type="hidden" value="' +<?php echo $HelpFormId; ?> + '" name="formid"><input type="hidden" name="iSubscriber" value="717">');
            });
        </script>
    </div>

    <script type="text/javascript">
        jQuery(document).ready(function() {
            jQuery('#field1').keyup(function() {
                search_key = jQuery.trim(jQuery('#field1').val());
                if (search_key.length > 0) {
                    // search for related articles
                    jQuery.ajax({
                        type: "POST",
                        url: '<?php echo plugins_url(); ?>/swiftcloud/admin/loopHandler.php',
                        data: "search_key=" + jQuery("#field1").val(),
                        success: function(data) {
                            jQuery('#recent-post').html("");
                            jQuery('#recent-post').html(data);
                        }
                    });

                    // search for tags
                    jQuery.ajax({
                        type: "POST",
                        url: '<?php echo plugins_url(); ?>/swiftcloud/admin/loopHandlerTags.php',
                        data: "search_key=" + jQuery("#field1").val(),
                        success: function(data) {
                            jQuery('#tag_list').html("");
                            jQuery('#tag_list').html(data);
                        }
                    });
                }
            });
        });
    </script>

    <?php
}

add_shortcode('swifthelpdeskform', 'function_SwiftHelpDeskForm');

//End swift help desk form
// custom excerpt
function sm_excerpt($excerpt_length = 55, $id = false, $echo = true) {

    $text = '';

    if ($id) {
        $the_post = & get_post($my_id = $id);
        $text = ($the_post->post_excerpt) ? $the_post->post_excerpt : $the_post->post_content;
    } else {
        global $post;
        $text = ($post->post_excerpt) ? $post->post_excerpt : get_the_content('');
    }

    $text = strip_shortcodes($text);
    $text = apply_filters('the_content', $text);
    $text = str_replace(']]>', ']]&gt;', $text);
    $text = strip_tags($text);

    $excerpt_more = ' ' . '...';
    $words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
    if (count($words) > $excerpt_length) {
        array_pop($words);
        $text = implode(' ', $words);
        $text = $text . $excerpt_more;
    } else {
        $text = implode(' ', $words);
    }
    if ($echo)
        echo apply_filters('the_content', $text);
    else
        return $text;
}

function sm_custom_excerpt($excerpt_length = 55, $id = false, $echo = false) {
    return sm_excerpt($excerpt_length, $id, $echo);
}