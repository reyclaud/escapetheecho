<?php 
defined('_JEXEC') or die;
	<div class="jfbl-pretext">
		<p><?php echo $params->get('pretext', null); ?></p>
	</div>
<?php endif;
if(!isset($gplusLoginURL) && $app->get('ifblgp_login_url', false)) {
	$gplusLoginURL = $app->get('ifblgp_login_url');
}

if(!isset($twitterLoginURL) && $app->get('ifbltw_login_url', false)) {
	$twitterLoginURL = $app->get('ifbltw_login_url');
}

if(!isset($linkedinLoginURL) && $app->get('ifbldn_login_url', false)) {
	$linkedinLoginURL = $app->get('ifbldn_login_url');
}
			$socialPic = modInstantfbloginHelper::getTwitterPicture($joomlaUserObject->id);
		}
		$syncedLogout = $params->get('facebook_logout', 1) ? 'gpluslogout(this);return false;' : null;
			$socialPic = modInstantfbloginHelper::getGPlusPicture($joomlaUserObject->id);
		}
			$socialPic = modInstantfbloginHelper::getLinkedinPicture($joomlaUserObject->id);
		}
	<form method="post" id="jfbl-logout-form" onsubmit="<?php echo $syncedLogout;?>">
	if($params->get('use_custom_gplus_text', 0)) {
		$customGPlusText = $params->get('custom_gplus_text', null);
	}
	if($params->get('use_custom_linkedin_text', 0)) {
		$customLinkedinText = $params->get('custom_linkedin_text', null);
	}