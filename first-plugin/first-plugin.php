<?php
/**
 * Plugin Name: First Plugin
 * Plugin URI: http://wordpress.dataprogram.info
 * Description: This is the first plugin I ever created.
 * Version: 1.0
 * Author: Victor P. Unda
 * Author URI: http://www.intillajta.org
 **/

function ideapro_ex_function() {

  $content = "This is a basic plugin.";

  $content .= "<div>this is a div</div>";
  $content .= "<p>this is a blocvk of paragraph test.</p>";

   return $content;
}

add_shortcode('example', 'ideapro_ex_function');


function ideapro_admin_menu_option() {

  add_menu_page('Header & Footer Scripts', 'Site Scripts','manage_options','ideapro-admin-menu','ideapro_scripts_page','',200);
}

add_action('admin_menu', 'ideapro_admin_menu_option');

/**
 *
 */
function ideapro_scripts_page() {

  if(array_key_exists('submit_scripts_update',$_POST)) {
    update_option('ideapro_header_scripts',$_POST['header_scripts']);
    update_option('ideapro_footer_scripts',$_POST['footer_scripts']);

    ?>
    <div id="setting-error-settings-updated" class="updated-settings-error notice is-dismissible"><strong>Settings have been saved</strong></div>
    <?php
  }


  $header_scripts = get_option('ideapro_header_scripts', 'none');
  $footer_scripts = get_option('ideapro_footer_scripts', 'none');

  ?>
    <div class="wrap">
      <h2>Hello testing</h2>
      <form method="post" action="">
      <label for="header_scripts">Update Scripts</label>
      <textarea name="header_scripts" class="large-text"><?php print $header_scripts ?></textarea>
      <label for="footer_scripts"></label>
      <textarea name="footer_scripts" class="large-text"><?php print $footer_scripts ?></textarea>

      <input type="submit" name="submit_scripts_update" class="button button" value="UPDATE SCRIPTS">
      </form>
    </div>
<?php
}

/**
 * header_scripts get_option to print header
 */
function ideapro_display_header_scripts() {

  $header_scripts = get_option('ideapro_header_scripts', 'none');

  print $header_scripts;


}
add_action('wp_head','ideapro_display_header_scripts');

/**
 * footer scripts get_option to print footer
 */
function ideapro_display_footer_scripts(){

  $footer_scripts = get_option('ideapro_footer_scripts', 'none');

  print $footer_scripts;
}

add_action('wp_footer','ideapro_display_footer_scripts');

/**
 * @return string
 */
  function ideaproform() {

    $content = '';

    $content .= '<form method="post" action="http://wordpress.dataprogram.info/thank-you">';
    $content .= '<br />';
    $content .= '<input type="text" name="full_name" placeholder="Your Full Name" />';
    $content .= '<br />';
    $content .= '<input type="text" name="email_address" placeholder="Email Address" />';
    $content .= '<br />';
    $content .= '<input type="text" name="phone_number" placeholder="Phone Number" />';
    $content .= '<br />';
    $content .= '<textarea name="comments" placeholder="Give us your comments"></textarea>';
    $content .= '<br />';

    $content .= '<input type="submit" name="ideapro_submit_form" value="SUBMIT YOUR INFORMATION">';
    $content .= '</form>';
    return $content;
  }

  add_shortcode('ideapro_contact_form','ideaproform');


function set_content_type() {
  return 'text/html';
}

/**
 * email action
 */
  function ideapro_form_capture() {

      global $post;
      global $wpdb;

    if(array_key_exists('ideapro_submit_form',$_POST)){

      $to = "llajta9@gmail.com";
      $subject = "Idea Pro Example for submition";
      $headers = array('Content-Type: text/html; charset=UTF-8');
      $body = '';

      $body .= 'Name:  ' .$_POST['full_name'];
      $body .= 'Email: ' .$_POST['email_address'];
      $body .= 'Phone Number:  ' .$_POST['phone_number'];
      $body .= 'Comments:  ' .$_POST['comments'];


      add_filter('wp_mail_content_type', 'set_content_type');
      wp_mail($to, $subject, $body, $headers);

      remove_filter('wp_mail_content_type', 'set_content_type');

      /* Insert the information into a comment */

//      $time = current_time('mysql');
//
//      $data = array(
//        'comment_post_ID' => $post->ID,
//        'comment_content' => $body, /* informtion from the top */
//        'comment_author_IP' => $_SERVER['REMOTE_ADDR'], /* where the user is coming from */
//        'comment_date' => $time,
//        'comment_approved' => 1,
//      );
//
//      wp_insert_comment($data);

      $wpdb->get_results(" INSERT INTO wp_form_submission (data) VALUES ('".$body."') ");

    }


  }

  add_action('wp_head','ideapro_form_capture' );