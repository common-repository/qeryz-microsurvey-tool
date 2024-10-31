<?php
// Settings page in the admin panel 
function qeryz_survey_admin_page() {
    global $current_user;
    get_currentuserinfo(); 
 
?>              

  <div class="wrap">

<?php 
    $error = '';
        //Deactivate function goes here......
    if (isset($_GET["action"]) && $_GET["action"]=="deactivate") {
        update_option('qeryz_username', "");
        update_option('qeryz_code', "0");
    }    
    if (isset($_POST["action"]) && $_POST["action"]=="login") {
        //Login function goes here......
        if ($_POST["qeryz_username"] != "" && $_POST["qeryz_password"] != "")  {
            $qeryz_logindata = array("qeryz_username" => $_POST["qeryz_username"], "qeryz_password" => $_POST["qeryz_password"]);            
            $qeryz_loginresult = qeryz_post_request(QERYZ_LOGIN_URL, $qeryz_logindata);
            update_option('qeryz_username', $_POST["qeryz_username"]);
            update_option('qeryz_password', $_POST["qeryz_password"]);
            $qeryz_array = explode("##", $qeryz_loginresult);
            $substr = $qeryz_array[0];
            $substr_group = $qeryz_array[4];
            $qeryz_user_id = trim(substr($substr, 8));
            $qeryz_group = trim(substr($substr_group, 11));
        
        //Using user_id as qeryz_code
        update_option('qeryz_code',$qeryz_user_id);
        update_option('qeryz_group',$qeryz_group);
            $qeryz_len = strlen(trim($qeryz_loginresult));
            if ($qeryz_len == 0){
                    $error["login"] = "<p class='error_message'>Username or Password is Incorrect. Please check your login details.</p>";            
            }
            
        }
        else {
                $error["login"] = "<p class='error_message'>Could not log in to Qeryz. Please check your login details.</p>"; 
        } 
        
    }
    if(get_option('qeryz_code') > "0"){

    if (isset($_POST['qeryz_identity']) || isset($_POST['qeryz-form-identity']) || isset($_POST['qeryz_checkbox'])) {    
        $qeryz_identity = stripcslashes($_POST['qeryz_identity']);         
        $qeryz_checkbox = $_POST['qeryz_checkbox'];       
        $qeryz_form_checkbox = $_POST['qeryz_form_checkbox'];
        $qeryz_form_identity = $_POST['qeryz-form-identity'];          
        $qeryz_form_identity = stripslashes($qeryz_form_identity);           
        //save/update a value                                 
        update_option('QeryzIdentity', $qeryz_identity);                    
        update_option('qeryz-form-identity', $qeryz_form_identity);            
        update_option('qeryz_checkbox', $qeryz_checkbox);   
        update_option('qeryz_form_checkbox', $qeryz_form_checkbox);
        echo '<div class="updated">Settings Updated</div>';  
        
                  
    }       
        
?>
<div id="qeryz_dashboard_plugin" class="postbox-container postbox">

    <div id="qeryz_title" style="background: rgb(221, 221, 221);"><img src="<?php echo plugin_dir_url( __FILE__ ).'/images/qeryzlogo.png' ?>" alt="" width="10%"></div>
    <div id="qeryz_body">
    <span style="float:right;"><a href="admin.php?page=qeryz_survey_admin_page&action=deactivate">Deactivate</a></span>
    Current Account &rarr; <b><?php echo get_option('qeryz_username'); ?></b><div style="display:inline-block;margin-left:5px;background:#F09A28;color:#fff;font-size:10px;text-transform:uppercase;padding:3px 8px;-moz-border-radius:5px;-webkit-border-radius:5px;"><?php echo get_option('qeryz_group'); ?></div> 
    <br><br>To start using Qeryz Survey, launch our dashboard for access to all features, including survey customization!
    <br><br>
     <form action="<?php echo QERYZ_DASHBOARD_LINK ?>" method="post" target="_blank">
     <input type="hidden" name="qryz_username" value="<?php echo get_option('qeryz_username'); ?>">
     <input type="hidden" name="qryz_password" value="<?php echo get_option('qeryz_password'); ?>">
    <input type="submit" class="qeryz_btn" value="Launch Qeryz" name="submit" />(This will open up a new browser tab.)
     </form> 
     
     <!--     Start Identity feature  -->
     <form method="post" action="admin.php?page=qeryz_survey_admin_page">
        <h3>Advance Code for Qeryz Identity Feature:</h3>
        <h4>For more information on how to use the identity feature, please visit <a href="<?php echo QERYZ_BASE_URL; ?>/blog/identify-customers-qeryz/" target="_blank">Identifying Customers Qeryz</a></h4>     

        <h3>
            <input type="hidden" id="enable_tracking" name="qeryz_checkbox" value="0" <?php checked( '0', get_option( 'qeryz_checkbox' ) ); ?> />
            <input type="checkbox" id="enable_tracking" name="qeryz_checkbox" value="1" <?php checked( '1', get_option( 'qeryz_checkbox' ) ); ?> /><?php _e("Enable Identity Tracking"); ?>
        </h3>
         <p class="description"><?php _e("Enable this check box if you want Qeryz to enable the Identity feature."); ?></p> 
        
        <!--Login Identity-->
        <h4>Capture Identity Through Login</h4> 
        <p>If you want to capture your users identity, just enter your Identifier.</p>   
        <span> Your code must be wrapped in <code>&lt;?php ?&gt;</code> tags  </span>
         
        <p>Example: If you want to get the first name of the currently signed user, use this code: <br><code>&lt;?php echo $current_user->user_firstname; ?&gt;</code></p>   
        <pre>                                                                                                              
            <span style='color:#5f5035;'>&lt;script type ='text/javascript'></span>
            <span style='color:#5f5035;'>// Get Logged in Users</span>
             <span style='color:#5f5035;'>qRz.push([</span><span style='color:#0000e6; '>"QrzTrackLoggedIn"</span>, { 
                <textarea name="qeryz_identity" class="qeryz_mtop10" cols="55" rows="5"><?php echo esc_textarea(qeryz_tracking()); ?></textarea>                
                 }];
             &lt;/script>
                                                                                   
        </pre>
        <h3>
            <input type="hidden" id="enable_tracking" name="qeryz_form_checkbox" value="0" <?php checked( '0', get_option( 'qeryz_form_checkbox' ) ); ?> />
            <input type="checkbox" id="enable_tracking" name="qeryz_form_checkbox" value="1" <?php checked( '1', get_option( 'qeryz_form_checkbox' ) ); ?> /><?php _e("Enable Identity Form Tracking"); ?>
        </h3> 
        <p class="description"><?php _e("Enable this check box if you want Qeryz to enable the Identity feature form."); ?></p>       
        <!--Form Identity-->                                                     
        <h4>Capture Identity Through Contact or Lead Forms</h4>
        <p>For getting a user's identity through forms (usually email lead gathering forms or contact forms), Enter the ID of the form you want to Capture.</p>
        
        <pre>          
            <span style='color:#5f5035;'>&lt;script type ='text/javascript'></span>
            <span style='color:#5f5035;'>// Get Form Data</span>         
            <span style='color:#5f5035;'>qRz.push([</span><span style='color:#0000e6; '>"QrzTrackSubmit",'<input type="text" name="qeryz-form-identity" style="width: 200px;" value="<?php echo qeryz_form_tracking(); ?>"/>'</span>]);
             &lt;/script>                                               
        </pre>    
                                                                                                                                       
        <br/>
        <input class="button-primary" type="submit" value="Save Changes" />
     </form>
                    
    </div>
    
</div>    
<?php  }else { ?>
<!--QERYZ LOGIN FORM HERE-->      
    <h2>Qeryz - Configuration</h2>
    <div id="qryz-metabox">
<?php if (isset($error) && isset($error["login"])) { echo $error["login"]; } ?>
    <form method="post" action="admin.php?page=qeryz_survey_admin_page">
        <input type="hidden" name="action" value="login">
        <h3>Survey Configuration</h3>
        <p>Log in with your Qeryz account:</p>
        <table class="form-table">
            <tr valign="top">
              <th scope="row">Qeryz Email</th>
              <td><input type="text" name="qeryz_username" value="<?php echo get_option('qeryz_username'); ?>" /></td>
            </tr>
            <tr valign="top">
              <th scope="row">Qeryz Password</th>
              <td><input type="password" name="qeryz_password" value="<?php if (get_option('qeryz_password') != "") { echo ""; }; ?>" /></td>
            </tr>
            </table>
        <p class="submit"><input type="submit" class="button-primary" value="Submit" name="submit" /></p>
        <div class="form-wrap">
                  &nbsp;Don't have a Qeryz account? <a href="<?php echo QERYZ_SIGNUP_URL; ?>" target="_blank" data-popup="true">Sign up now</a>.
        </div>
      </form>
    </div>
  </div>
  <?php
} }
  ?>