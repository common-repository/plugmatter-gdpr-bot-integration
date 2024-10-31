<?php 
$msg = '';
$msg_reg='';
$reg_done = false;

	wp_register_style('pm_gdpr_license_css', plugins_url('../css/settings_page.css', __FILE__));
	wp_enqueue_style('pm_gdpr_license_css');	

if(isset($_POST["pm_gdpr_licence_key"] ) && ($_POST["pm_gdpr_licence_key"]!="")) {

	$pm_gdpr_licence_key = sanitize_text_field($_POST["pm_gdpr_licence_key"]);

	$res = wp_remote_post("https://plugmatter.com/gdprbot-activate",
			array('body'=>array(
					"license_key"=>$pm_gdpr_licence_key,
					"domain_url"=>get_option('siteurl'),
					"package"=>Plugmatter_GDPR_PACKAGE,	
					)
				)
			);
	$res_arr = explode(":",$res["body"]);
	if($res_arr[0] == "VERIFIED") {
		update_option('pm_gdpr_package', sanitize_text_field($res_arr[1]));
		update_option('pm_gdpr_licence_key', $pm_gdpr_licence_key);
		$msg="<div class='pm_gdpr_msg_success'><strong>Plugmatter GDPR Bot activated successfully</strong></div>";
	} else {
		$msg="<div class='pm_gdpr_msg_error'><strong>Invalid License Key</strong></div>";
	}
} 
//------------------------------------------------------------------------------------------------------
?>

<div class='pm_gdpr_wrap'>
	<div class='pm_gdpr_headbar'>
		<div class='pm_gdpr_pagetitle'><h2>Activation</h2></div>
	    <div class='pm_gdpr_logodiv'>
	    	<img src='<?php echo plugins_url("../images/logo.png", __FILE__);?>' height='35'>
	    </div>	    
	</div>
	<?php 	
	if($msg!='') { 
		echo "$msg";
	}
	if(get_option('pm_gdpr_licence_key') != "") {	
		
	?>
		<div class='pmadmin_body'  style="position:relative">
	        <br>
	        <h3>Done! Plugmatter GDPR Bot integration is active.</h3>
			
			<br><br>
		</div>
	<?php 
	} else {
	?>
	
		<div class='pmadmin_body'  style="position:relative">
		    <div style='padding-bottom:16px;padding-top:16px;'>
		        
		    	<p>Enter your License Key to activate the Plugmatter GDPR Bot Integration. 
		    		<a href="https://plugmatter.com/login" target="_blank">Login</a> the 
		    		Plugmatter GDPR Bot Dashboard to get your License Key.</p>
		    </div>        
			<form action="<?php $siteurl = get_option('siteurl');echo $siteurl."/wp-admin/admin.php?page=pm_gdpr_settings"; ?>" id='pm_settings' method="post">	
				<div>
					<div class='pm_gdpr_enable_lable' style='width:250px'>Enter Your License Key</div>
					<div class='pm_gdpr_tgl_btn'>
						<input type='text' name='pm_gdpr_licence_key' size='45' style='padding:6px;' value=''>
					</div>
					<div style='clear:both'>&nbsp;</div>
				</div>
				<div class="pm_gdpr_submit">
					<input id="submit" class="pm_gdpr_primary_buttons" type="submit" value="   Register Plugin   " name="submit">
				</div>
				<br><br>
			</form>
	    
		</div>
	<?php } ?>
</div>