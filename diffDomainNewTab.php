<?php
   /**
    * @package diffDomainNewTab
    * @version 1.0
    */
   /*
   Plugin Name: Diff Domain New Tab
   Plugin URI: http://nasssar.me/Plugins/lol-fb-post
   Description: Open links in new tab and save your vistors.
   Author: Alaa nassar
   Version: 1.1
   Author URI: http://nasssar.me/
   Domain : diffDomainNewTab
   */



   function diffDomainNewTab() {
   	add_options_page( 'Diff Domain New Tab', 'Diff Domain New Tab', 'manage_options', 'diffDomainNewTab', 'diffDomainNewTabFun' );
   }

   add_action( 'admin_menu', 'diffDomainNewTab' );
   /** Step 3. */
   function diffDomainNewTabFun() {
   	if ( !current_user_can( 'manage_options' ) )  {
   		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
   	}

   ?>
<div class="wrap">
   <h2> <?php esc_html_e('Diff Domain New Tab','diffDomainNewTab') ?></h2>
   <p> <?php esc_html_e('Diff Domain New Tab checks your external links and open in new tab.','diffDomainNewTab') ?></p>
   <form method="post" action="options.php">
      <?php wp_nonce_field('update-options') ?>
      <table class="form-table">
         <tbody>
            <tr>
               <th><label for="diffDomainNewTab-active">
                  <?php esc_html_e('Active WP New Tab','diffDomainNewTab') ?>
                  </label>
               </th>
               <td>
                  <select name="diffDomainNewTab-active" id="diffDomainNewTab-active" value="<?php echo get_option('diffDomainNewTab-active'); ?>">
                     <option value="no" <?php if (get_option('diffDomainNewTab-active') == 'no') { ?>
                        selected
                        <?php  } ?> >no</option>
                     <option value="yes"  <?php if (get_option('diffDomainNewTab-active') == 'yes') { ?>
                        selected
                        <?php  } ?> >yes</option>
                  </select>
               </td>
            </tr>
            <?php if (get_option('diffDomainNewTab-active') == 'yes'): ?>
            <tr>
               <th><label for="diffDomainNewTab-exception">
                  <?php esc_html_e('Exception list ','diffDomainNewTab') ?>
                  </label>
               </th>
               <td>
                  <style media="screen">
                     span.dashicons.dashicons-trash.remove_field {
                     cursor: pointer;
                     margin-top: 5px;
                     }
                  </style>
                  <div class="diffDomainNewTab-inputs">
                     <div class="input_fields_wrap">
                        <button class="add_field_button">Add link</button>
                        <?php
                           $dataloop = get_option('diffDomainNewTab-exception');
                           $i;
                           foreach ( $dataloop as $value): ?>
                        <div><input type="text" name="diffDomainNewTab-exception[]" value="<?php echo $value ; ?>"><span class="dashicons dashicons-trash remove_field"></span></div>
                        <?php
                           $i++;
                           endforeach; ?>
                     </div>
                     <script type="text/javascript">
                        jQuery(document).ready(function($) {

                            var max_fields      = 10; //maximum input boxes allowed
                            var wrapper         = $(".input_fields_wrap"); //Fields wrapper
                            var add_button      = $(".add_field_button"); //Add button ID

                            var x = 1; //initlal text box count
                            $(add_button).click(function(e){ //on add input button click
                                e.preventDefault();
                                if(x < max_fields){ //max input box allowed
                                    x++; //text box increment
                                    $(wrapper).append('<div><input type="text" name="diffDomainNewTab-exception[]"/><span class="dashicons dashicons-trash remove_field"></span></div>'); //add input box
                                }
                            });

                            $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
                                e.preventDefault(); $(this).parent('div').remove(); x--;
                            })
                        });
                     </script>
                  </div>
               </td>
            </tr>
            <?php endif; ?>
         </tbody>
      </table>
      <p><input type="submit" name="Submit" value="save" /></p>
      <input type="hidden" name="action" value="update" />
      <?php if (get_option('diffDomainNewTab-active') == 'yes'): ?>
      <input type="hidden" name="page_options"
         value="diffDomainNewTab-exception ,
         diffDomainNewTab-active"/>
      <?php else: ?>
      <input type="hidden" name="page_options" value="diffDomainNewTab-active"/>
      <?php endif; ?>
   </form>

   <h2> <?php esc_html_e('Features ','diffDomainNewTab') ?></h2>
   <ul>

     <?php esc_html_e('<li> Automatically checks all external links','diffDomainNewTab') ?></li>
    <?php esc_html_e('<li> open youtube , google, facebook, twitter or any social media in a new tab','diffDomainNewTab') ?></li>
    <?php esc_html_e('<li> keep your visitor on your site and never loose a single visitor again to external sites','diffDomainNewTab') ?></li>
    <?php esc_html_e('<li> choose what links to open in new tab or widnow','diffDomainNewTab') ?></li>
    <?php esc_html_e('<li> your website links are filtered automatically','diffDomainNewTab') ?></li>
   </ul>

   <?php
      ?>
</div>
<?php
   }



    // echo get_option('diffDomainNewTab-exception');


   	function diffDomainNewTab_scripts(){
			 if (get_option('diffDomainNewTab-active') == 'yes') {
				 wp_enqueue_script( 'diffDomainNewTab_js',plugin_dir_url( __FILE__ ).'diffDomainNewTab.js' ,  array('jquery') , false ,  false);

			 }
   		}

   		function print_diffDomainNewTab_scripts() {
				if (get_option('diffDomainNewTab-active') == 'yes') {
   					if ( wp_script_is( 'diffDomainNewTab_js', 'enqueued' ) ) {
   			?>
<script type="text/javascript">
   jQuery('a').diffDomainNewTab({
   		exceptionList: [
   			<?php
      $lists = get_option('diffDomainNewTab-exception');

      foreach ( $lists as $list): ?>
   			<?php echo "'$list'," ; ?>
   			<?php endforeach; ?>
   		]
   });
</script>
<?php
}
}
}

add_action('wp_enqueue_scripts','diffDomainNewTab_scripts');
add_action('wp_footer','print_diffDomainNewTab_scripts',99);
