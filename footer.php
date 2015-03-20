<?php
global $wp_page_template;


        if(cms_opt('footer_social_area_active')=='1'){
          $social_area = '
            <script language="javascript1.5" type="application/javascript">
            	jQuery(document).ready(function($) {
                	$(\'.FollowUs a\').hover(function() { $(this).stop().animate({opacity: 1}, 300) }, function(){ $(this).stop().animate({opacity: 0.3}, 600) });
            	}); 
            
            </script>


            <div class="FollowUs pos'.cms_opt('footer_social_area_icons_pos').'">
             	<h1>'.cms_opt('footer_social_area_h1','','','Get Connected').'</h1>
                <div>
                   '.(cms_opt('footer_social_icons_delicious_url')!=''?'<a href="'.str_replace('&','&amp;',cms_opt('footer_social_icons_delicious_url')).'" target="_new" id="delicious"></a>':'')
                    .(cms_opt('footer_social_icons_facebook_url')!=''?'<a href="'.str_replace('&','&amp;',cms_opt('footer_social_icons_facebook_url')).'" target="_new"  id="facebook"></a>':'')
                    .(cms_opt('footer_social_icons_flickr_url')!=''?'<a href="'.str_replace('&','&amp;',cms_opt('footer_social_icons_flickr_url')).'" target="_new"  id="flickr"></a>':'')
                    .(cms_opt('footer_social_icons_google_url')!=''?'<a href="'.str_replace('&','&amp;',cms_opt('footer_social_icons_google_url')).'" target="_new"  id="google"></a>':'')
                    .(cms_opt('footer_social_icons_linkedin_url')!=''?'<a href="'.str_replace('&','&amp;',cms_opt('footer_social_icons_linkedin_url')).'" target="_new"  id="linkedin"></a>':'')
                    .(cms_opt('footer_social_icons_twitter_url')!=''?'<a href="'.str_replace('&','&amp;',cms_opt('footer_social_icons_twitter_url')).'" target="_new"  id="twitter"></a>':'')
                    .(cms_opt('footer_social_icons_youtube_url')!=''?'<a href="'.str_replace('&','&amp;',cms_opt('footer_social_icons_youtube_url')).'" target="_new"  id="youtube"></a>':'')
                    
                    .(cms_opt('footer_social_icons_yelp_url')!=''?'<a href="'.str_replace('&','&amp;',cms_opt('footer_social_icons_yelp_url')).'" target="_new"  id="yelp"></a>':'')
                    .(cms_opt('footer_social_icons_foursquare_url')!=''?'<a href="'.str_replace('&','&amp;',cms_opt('footer_social_icons_foursquare_url')).'" target="_new"  id="foursquare"></a>':'')
                    .(cms_opt('footer_social_icons_digg_url')!=''?'<a href="'.str_replace('&','&amp;',cms_opt('footer_social_icons_digg_url')).'" target="_new"  id="digg"></a>':'').'
                    <a href="/rss" id="rss"></a>'
                    .(cms_opt('footer_social_icons_email_url')!=''?'<a href="mailto:'.str_replace('&','&amp;',cms_opt('footer_social_icons_email_url')).'" target="_new"  id="email"></a>':'').'
                </div>
             </div>
          ';
        }
?>     


<?php
	if(get_option('WPCMS_footer_position')!='1'){
	
	 if(cms_opt('prefooter_widget_area_position')=='2'){
          if ( is_active_sidebar( 'prefooter-widget-area' ) ) : ?>
    			<div id="prefooter" class="widget-area">
    					<?php dynamic_sidebar( 'prefooter-widget-area' ); ?>
    			</div><!-- #prefooter .widget-area -->
    		<?php
    	    endif;
        }
	
		echo'
			</div><!-- #main -->';
			

        if(cms_opt('prefooter_widget_area_position')=='1'){
          if ( is_active_sidebar( 'prefooter-widget-area' ) ) : ?>
    			<div id="prefooter" class="widget-area">
    			    <?php
                if(cms_opt('footer_social_area_position')=='4')
        			echo $social_area;
              ?>
    					<?php dynamic_sidebar( 'prefooter-widget-area' ); ?>
    			</div><!-- #prefooter .widget-area -->
    		<?php
    	    endif;
        }

       
	echo'
		</div><!-- #wrapper -->		
		';
	}
?>

  <div class="Footer-container">
  	<div id="footer" role="contentinfo">
      <?php
        if(cms_opt('footer_social_area_position')=='3')
			echo $social_area;
      ?>
      
      <?php 
        if(cms_opt('prefooter_widget_area_position')!='1' and cms_opt('prefooter_widget_area_position')!='2'):
        if ( is_active_sidebar( 'prefooter-widget-area' ) ) : ?>
  			<div id="prefooter" class="widget-area">
  					<?php dynamic_sidebar( 'prefooter-widget-area' ); ?>
  			</div><!-- #prefooter .widget-area -->
  	  <?php endif;
        endif;
       ?>
	  
      <?php
        if(cms_opt('footer_social_area_position')=='2')
			echo $social_area;
      ?>
		
      <?php get_sidebar( 'footer' ); ?>
      
      <?php
        if(cms_opt('footer_social_area_position')=='1')
			echo $social_area;
      ?>

      <?php if(is_active_sidebar('postfooter-widget-area')): ?>
  				<div id="postfooter" class="widget-area">
  						<?php dynamic_sidebar('postfooter-widget-area'); ?>
  				</div><!-- #postfooter .widget-area -->
      <?php endif; ?>

      <?php
        if(cms_opt('footer_social_area_position')=='0' or cms_opt('footer_social_area_position')==null)
			echo $social_area;
      ?>

	  <?php
			if(get_option('WPCMS_credits_position')=='1'){
			 
			  if ( is_active_sidebar( 'presitecredits-widget-area' ) ){
				echo'
				<div id="presitecredits" class="widget-area">
				  '.get_dynamic_sidebar( 'presitecredits-widget-area' ).'
				</div>';
			  }

			  echo '
			  <div id="site-info">
        <a href="'.($wp_page_template[0]=='page-noreload.php'?'#':'/').'contact">Contact</a> | <a href="'.($wp_page_template[0]=='page-noreload.php'?'#':'/').'privacy">Privacy</a> | <a href="'.($wp_page_template[0]=='page-noreload.php'?'#':'/').'terms">Terms of Use</a> | &copy;'.date("Y ").cms_opt('company_legal_name').'
 				 <br />
         <a href="http://swiftwebdesigner.com/website-developer" title="Website developer">Website Developer</a>: <a href="http://SwiftMarketing.com/" title="Swift Marketing" rel="home">Swift Marketing</a> | <a target="_blank" href="/wp-admin">Admin panel</a> | <a target="_blank" href="http://my.SwiftCRM.com">Swift CRM</a> | <a href="http://mail.'.$_SERVER['SERVER_NAME'].'" target="_blank">Email</a>'.(cms_opt('email_url')!=''?' | <a href="'.cms_opt('email_url').'">Email Login</a>':'').'
        </div>
			  <div class="br0"></div>
			  ';
			}
		?>
  	</div>
  </div>

  <?php
  	if(get_option('WPCMS_footer_position')=='1'){
  	 
  	   if(cms_opt('prefooter_widget_area_position')=='2'){
          if ( is_active_sidebar( 'prefooter-widget-area' ) ) : ?>
    			<div id="prefooter" class="widget-area">
    					<?php dynamic_sidebar( 'prefooter-widget-area' ); ?>
    			</div><!-- #prefooter .widget-area -->
    		<?php
    	    endif;
        }
  	
  		echo'
        </div><!-- #main -->';
        
        if(cms_opt('prefooter_widget_area_position')=='1'){
          if ( is_active_sidebar( 'prefooter-widget-area' ) ) : ?>
    			<div id="prefooter" class="widget-area">
    					<?php dynamic_sidebar( 'prefooter-widget-area' ); ?>
    			</div><!-- #prefooter .widget-area -->
    		<?php
    	    endif;
        }
        
      echo '
  		</div><!-- #wrapper -->		
  		';
  	}


   if(get_option('WPCMS_credits_position')=='0'){
     if ( is_active_sidebar( 'presitecredits-widget-area' ) ) : ?>
        <div id="presitecredits" class="widget-area">
          <?php dynamic_sidebar( 'presitecredits-widget-area' ); ?>
        </div>
      <?php endif; ?>

      <div id="site-info">
        <a href="/contact">Contact</a> | <a href="/privacy">Privacy</a> | <a href="/terms">Terms of Use</a> | &copy;<?php echo date("Y ").get_option('WPCMS_company_legal_name'); ?>
        <br />
        <a href="http://swiftwebdesigner.com/website-developer" title="Website developer">Website Developer</a>: <a href="http://SwiftMarketing.com" title="Swift Marketing" rel="home">Swift Marketing</a> | <a target="_blank" href="/wp-admin">Admin panel</a> | <a target="_blank" href="http://my.SwiftCRM.com">Swift CRM</a> | <?php echo '<a href="http://mail.'.$_SERVER['SERVER_NAME'].'" target="_blank">Email</a>'; ?> | <?php echo '<a href="http://docs.'.$_SERVER['SERVER_NAME'].'" target="_blank">Internal Docs</a>'; ?> | <?php echo '<a href="http://calendar.'.$_SERVER['SERVER_NAME'].'" target="_blank">Calendar</a>'; ?>
       
			  
      </div>
<?php
   }
	wp_footer();
global $agent_code;
?>
<?php //popup html
function removeslashes($string)
{
    $string=implode("",explode("\\",$string));
    return stripslashes(trim($string));
}
$delay = get_option('swift_settings');
/*echo '<pre>';print_r($delay);exit;*/
?>
</body>
</html>