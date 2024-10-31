<?php
   /*
   Plugin Name: Qeryz Wordpress Survey
   Plugin URI: https://qeryz.com
   Description: A plugin for Qeryz, a pop-up, as-you-go microsurvey that you can put in any and every webpage you have in your website.
   Version: 1.6.3
   Author: Qeryz
   Author URI: https://qeryz.com
   License: GPL2
   */


define('QERYZ_SCRIPT_DOMAIN',         "qeryz.com");
define('QERYZ_BASE_URL',              "https://qeryz.com/");             
define('QERYZ_LOGIN_URL',             QERYZ_BASE_URL."wp_login.php");
define('QERYZ_SIGNUP_URL',            QERYZ_BASE_URL."wp-reg.php");
define('QERYZ_DASHBOARD_LINK',        "https://qeryz.com/wp_login.php");
 
require_once dirname( __FILE__ ) . '/qeryz_survey_admin.php';
   
 // Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
  echo "Hi there!  I'm just a plugin, not much I can do when called directly.";
  exit;
}

function load_qeryz_style() {    
    wp_register_style('qeryz_style', plugins_url('qeryz_css.css', __FILE__));
    wp_enqueue_style('qeryz_style');
}
add_action('admin_enqueue_scripts', 'load_qeryz_style');

function load_qeryz_js() { 
    wp_register_script('qeryz_wordpress_js', 'https://qeryz.com/survey/js/qryz_v3.2.js');
    wp_enqueue_script('qeryz_wordpress_js');
}
add_action('wp_enqueue_scripts', 'load_qeryz_js');

function add_qeryz_caps() {
    $role = get_role( 'administrator' );
    $role->add_cap( 'qeryz_survey_admin' );    
}  
add_action( 'admin_init', 'add_qeryz_caps');

/**
 * Start inserting Qeryz script
 * 
 */
function qeryz_survey() {
    
    $code = get_option('qeryz_code');
    $identity_check = get_option('qeryz_checkbox');
    $identity_form_check = get_option('qeryz_form_checkbox');
    $form_id_identity = get_option('qeryz-form-identity');
       
    if ($code > 0){
//<!--Start of Qeryz Survey Script-->
    echo ' 
<!-- Start of code for Qeryz Survey Wordpress Plugin  -->
    <script type="text/javascript">  
    var qRz = qRz || [];                         
    (function() {                
        setTimeout(function(){                                         
            var qryz_plks = document.createElement("div");
            qryz_plks.id = "qryz_plks";
            qryz_plks.className = "qryz_plks";
            document.body.appendChild(qryz_plks);
            qryzInit2('.$code.');
        },0);
    })();
    </script>';
        if ($identity_check > 0 ){
            echo '            
            <script type="text/javascript"> 
                qRz.push(["QrzTrackLoggedIn", {'."\n";                 
            echo qeryz_custom_code();                                                
            echo '}]);
            </script>';   
        }
        if ($identity_form_check > 0 ) {  
            echo '<script type="text/javascript">                  
                // Get Form Data 
                qRz.push(["QrzTrackSubmit", "'.$form_id_identity.'"]);                           
            </script>
            ';    
        } 
    echo '<!--End of Qeryz Survey Script-->';     
    }

}
add_action('wp_footer', 'qeryz_survey',100);

/**
 * Add menu in the admin page
 * 
 */
function qeryz_survey_menu() {                                                                               
    add_menu_page("Qeryz Admin", "Qeryz Survey", "qeryz_survey_admin", "qeryz_survey_admin_page", "qeryz_survey_admin_page", plugin_dir_url( __FILE__ ).'/images/qeryz_menu_icon.png');    
    add_action( 'admin_init', 'register_qeryz_plugin_settings' );
} 
add_action('admin_menu', 'qeryz_survey_menu');

/**
 * Register some qeryz fields
 * 
 */
function register_qeryz_plugin_settings() {

    // Authentication and codes
    register_setting( 'qeryz-settings-group', 'qeryz_id' );
    register_setting( 'qeryz-settings-group', 'qeryz_username' );
    register_setting( 'qeryz-settings-group', 'qeryz_password' );

}

/**
 * Making request for Qeryz website when trying to login
 * 
 */
function qeryz_post_request($url, $_data, $optional_headers = null)
{
//        $url = str_replace("https", "http", $url);
    
    $args = array('body' => $_data);
    $response = wp_remote_post( $url, $args ); 
    if(is_wp_error($response)){
        echo 'Error Found ( '.$response->get_error_message().' )';
    }       
    return $response['body'];

}

/**
 * Request for url
 * 
 */
function qeryz_url_get($filename) {
    $response = wp_remote_get($filename);
    return $response['body'];
}

/**
 * Outputting the Identiy embedded codes in textarea
 * Added since @1.6
 * Adden global $current user since 1.6.1
 */    
function qeryz_tracking(){ 
    global $current_user;
    get_currentuserinfo();  
               
     $qeryz_identity = get_option('QeryzIdentity');
     
     if ($qeryz_identity) return stripslashes($qeryz_identity); 
        //qeryz identity code                                       
        
        $qeryz_embed_opts .= '"name": "<?php echo $current_user->user_firstname; ?>",'."\n";
        $qeryz_embed_opts .= '"email": "<?php echo $current_user->user_email; ?>" ';               
        //qeryz lead form

        $qeryz_identity = $qeryz_embed_opts;   
        update_option('QeryzIdentity', $qeryz_identity);
         
        if ($qeryz_identity) return $qeryz_identity;      
        else return '';                               
                      
}

/**
 * Inserting the identity code in the script
 * Added since @1.6
 * Adden global $current user since 1.6.1
 */
function qeryz_custom_code(){ 
        global $current_user;
        get_currentuserinfo();     
             
        $qeryz_custom_code = stripslashes(get_option('QeryzIdentity'));    

        if(!$qeryz_custom_code){   
            $qeryz_embed_identity .= "'name': '<?php echo $current_user->user_login; ?>',"."\n";
            $qeryz_embed_identity .= "'email': '<?php echo $current_user->user_email; ?>'";    
            $qeryz_custom_code = $qeryz_embed_identity;
               
       }
       update_option('QeryzIdentity', $qeryz_custom_code);
 
         ob_start();
        eval('?>' . $qeryz_custom_code);
        ob_end_flush();                                      
}                                                     

/**
 * Returning default value for identity form
 * Added since @1.6
 */                      
function qeryz_form_tracking(){
    $qeryz_form_identity = get_option('qeryz-form-identity');
    
   if ($qeryz_form_identity) return $qeryz_form_identity;
   else return 'Enter Form ID Here'; 
}

/**
 * Notifying users to log in
 * 
 */
if ( $pagenow == 'plugins.php') :

    function custom_admin_notice() {
        $code = get_option('qeryz_code');
        if($code == 0){
        echo '<div class="error" style="padding: 0; margin: 0; border: none; background: none;">
                <div class="qryz_pop_up">
                    <div class="qryz_message"><p><strong>You\'re In! Make sure to take a minute to <a class="button qryz_btn" href='.QERYZ_SIGNUP_URL.' target="_blank">  Signup  </a> for your Qeryz Account. Or click <a href='.admin_url( 'admin.php?page=qeryz_survey_admin_page' ).'> login </a> if you already have one.</strong></p>
                    </div>
                </div>
            </div>';
        }
    }
    add_action( 'admin_notices', 'custom_admin_notice' );

endif;
?>