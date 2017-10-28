<?php 
/** 
 * @package INSTANTFBLOGIN::CPANEL::administrator::components::com_instantfblogin
 * @subpackage views
 * @subpackage cpanel
 * @subpackage tmpl
 * @author Joomla! Extensions Store
 * @copyright (C) 2015 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html 
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' ); 
?>
<!-- CPANEL ICONS -->
<div class="row no-margin">
	<div class="accordion-group span5">
		<div class="accordion-heading opened">
			<div class="accordion-toggle accordion_lightblue noaccordion">
				<h3><span class="icon-pencil"></span><?php echo JText::_('COM_INSTANTFBLOGIN_CPANEL_TASKS' ); ?></h3>
			</div>
		</div>
		<div id="placeholder_cpanelicons" class="accordion-body accordion-inner collapse in">
			<div id="cpanel">
				<div id="updatestatus">
					<?php 
					if(is_object($this->updatesData)) {
						if(version_compare($this->updatesData->latest, $this->currentVersion, '>')) { ?>
							<a href="http://storejoomla.org/extensions/instant_facebook_login.html" target="_blank" alt="storejoomla link">
								<label data-content="<?php echo JText::sprintf('COM_INSTANTFBLOGIN_GET_LATEST', $this->currentVersion, $this->updatesData->latest, $this->updatesData->relevance);?>" class="label label-important hasPopover">
									<span class="icon-warning"></span>
									<?php echo JText::sprintf('COM_INSTANTFBLOGIN_OUTDATED', $this->updatesData->latest);?>
								</label>
							</a>
						<?php } else { ?>
							<label data-content="<?php echo JText::sprintf('COM_INSTANTFBLOGIN_YOUHAVE_LATEST', $this->currentVersion);?>" class="label label-success hasPopover">
								<span class="icon-checkmark"></span>
								<?php echo JText::sprintf('COM_INSTANTFBLOGIN_UPTODATE', $this->updatesData->latest);?>
							</label>	
						<?php }
					}
					?>
				</div>
				<?php echo $this->icons; ?>
				<div id="facebook-apikey_status">
				<?php 
					$fbClassName = $this->componentParams->get('fblogin_active', null) ? 'important' : 'warning';
					if($this->componentParams->get('fblogin_active', null) && $this->componentParams->get('appId', null) && $this->componentParams->get('secret', null)) { ?>
						<a href="index.php?option=com_instantfblogin&amp;task=config.display#_setup">
							<label data-content="<?php echo JText::_('COM_INSTANTFBLOGIN_ACCESS_FBCONFIG');?>" class="label label-success hasPopover">
								<span class="icon-checkmark"></span>
								<?php echo JText::_('COM_INSTANTFBLOGIN_CREDENTIALS_OK');?>
							</label>
						</a>
					<?php } else { ?>
						<a href="index.php?option=com_instantfblogin&amp;task=config.display#_setup">
							<label data-content="<?php echo JText::_('COM_INSTANTFBLOGIN_ACCESS_FBCONFIG');?>" class="label label-<?php echo $fbClassName;?> hasPopover">
								<span class="icon-warning"></span>
								<?php echo JText::_('COM_INSTANTFBLOGIN_CREDENTIALS_KO');?>
							</label>
						</a>
					<?php } ?>
				</div>
				
				<div id="google-apikey_status">
				<?php 
					$gplusClassName = $this->componentParams->get('gpluslogin_active', null) ? 'important' : 'warning';
					if($this->componentParams->get('gpluslogin_active', null) && $this->componentParams->get('gplusClientID', null) && $this->componentParams->get('gplusKey', null)) { ?>
						<a href="index.php?option=com_instantfblogin&amp;task=config.display#_setup">
							<label data-content="<?php echo JText::_('COM_INSTANTFBLOGIN_ACCESS_GPLUSCONFIG');?>" class="label label-success hasPopover">
								<span class="icon-checkmark"></span>
								<?php echo JText::_('COM_INSTANTFBLOGIN_GPLUS_CREDENTIALS_OK');?>
							</label>
						</a>
					<?php } else { ?>
						<a href="index.php?option=com_instantfblogin&amp;task=config.display#_setup">
							<label data-content="<?php echo JText::_('COM_INSTANTFBLOGIN_ACCESS_GPLUSCONFIG');?>" class="label label-<?php echo $gplusClassName;?> hasPopover">
								<span class="icon-warning"></span>
								<?php echo JText::_('COM_INSTANTFBLOGIN_GPLUS_CREDENTIALS_KO');?>
							</label>
						</a>
					<?php } ?>
				</div>
				
				<div id="twitter-apikey_status">
				<?php 
					$twitterClassName = $this->componentParams->get('twitterlogin_active', null) ? 'important' : 'warning';
					if($this->componentParams->get('twitterlogin_active', null) && $this->componentParams->get('twitterSecret', null) && $this->componentParams->get('twitterKey', null)) { ?>
						<a href="index.php?option=com_instantfblogin&amp;task=config.display#_setup">
							<label data-content="<?php echo JText::_('COM_INSTANTFBLOGIN_ACCESS_TWITTERCONFIG');?>" class="label label-success hasPopover">
								<span class="icon-checkmark"></span>
								<?php echo JText::_('COM_INSTANTFBLOGIN_TWITTER_CREDENTIALS_OK');?>
							</label>
						</a>
					<?php } else { ?>
						<a href="index.php?option=com_instantfblogin&amp;task=config.display#_setup">
							<label data-content="<?php echo JText::_('COM_INSTANTFBLOGIN_ACCESS_TWITTERCONFIG');?>" class="label label-<?php echo $twitterClassName;?> hasPopover">
								<span class="icon-warning"></span>
								<?php echo JText::_('COM_INSTANTFBLOGIN_TWITTER_CREDENTIALS_KO');?>
							</label>
						</a>
					<?php } ?>
				</div>
				
				<div id="linkedin-apikey_status">
				<?php 
					$linkedClassName = $this->componentParams->get('linkedinlogin_active', null) ? 'important' : 'warning';
					if($this->componentParams->get('linkedinlogin_active', null) && $this->componentParams->get('linkedinSecret', null) && $this->componentParams->get('linkedinAppid', null)) { ?>
						<a href="index.php?option=com_instantfblogin&amp;task=config.display#_setup">
							<label data-content="<?php echo JText::_('COM_INSTANTFBLOGIN_ACCESS_LINKEDINCONFIG');?>" class="label label-success hasPopover">
								<span class="icon-checkmark"></span>
								<?php echo JText::_('COM_INSTANTFBLOGIN_LINKEDIN_CREDENTIALS_OK');?>
							</label>
						</a>
					<?php } else { ?>
						<a href="index.php?option=com_instantfblogin&amp;task=config.display#_setup">
							<label data-content="<?php echo JText::_('COM_INSTANTFBLOGIN_ACCESS_LINKEDINCONFIG');?>" class="label label-<?php echo $linkedClassName;?> hasPopover">
								<span class="icon-warning"></span>
								<?php echo JText::_('COM_INSTANTFBLOGIN_LINKEDIN_CREDENTIALS_KO');?>
							</label>
						</a>
					<?php } ?>
				</div>
				
				<?php echo $this->moduleStatus; ?>
			</div>
		</div>
	</div>
	<div class="accordion span7" id="instantfblogin_accordion_cpanel">
		<div class="accordion-group">
	    	<div class="accordion-heading">
	    		<div class="accordion-toggle" data-toggle="collapse" data-parent="#instantfblogin_accordion_cpanel" href="#instantfblogin_stats">
		      		<h4 class="accordion-title">
		      			<span class="icon-chart"></span>
		      			<?php echo JText::_('COM_INSTANTFBLOGIN_CPANEL_STATS');?>
	      			</h4>
	      		</div>
	    	</div>
	    	
	    	 <div id="instantfblogin_stats" class="accordion-body collapse">
				<div class="accordion-inner">
					<div class="single_stat_container">
						<div class="statcircle">
							<span class="icon-users icon-large"></span>
						</div>
						<ul class="subdescription_stats">
							<li class="es-stat-no"><?php echo $this->infodata['chart_users_canvas']['totalusers']; ?></li>
							<li class="es-stat-title"><?php echo JText::_('COM_INSTANTFBLOGIN_TOTAL_USERS');?></li>
						</ul>
					</div>
					
					<div class="single_stat_container">
						<div class="statcircle">
							<span class="icon-users icon-large"></span>
						</div>
						<ul class="subdescription_stats">
							<li class="es-stat-no"><?php echo $this->infodata['chart_users_canvas']['joomlausers']; ?></li>
							<li class="es-stat-title"><?php echo JText::_('COM_INSTANTFBLOGIN_JOOMLA_USERS');?></li>
						</ul>
					</div>
					
					<div class="single_stat_container">
						<div class="statcircle">
							<span class="icon-users icon-large"></span>
						</div>
						<ul class="subdescription_stats">
							<li class="es-stat-no"><?php echo $this->infodata['chart_users_canvas']['facebookusers']; ?></li>
							<li class="es-stat-title"><?php echo JText::_('COM_INSTANTFBLOGIN_FACEBOOK_USERS');?></li>
						</ul>
					</div>
					<div class="single_stat_container">
						<div class="statcircle">
							<span class="icon-users icon-large"></span>
						</div>
						<ul class="subdescription_stats">
							<li class="es-stat-no"><?php echo $this->infodata['chart_users_canvas']['gplususers']; ?></li>
							<li class="es-stat-title"><?php echo JText::_('COM_INSTANTFBLOGIN_GPLUS_USERS');?></li>
						</ul>
					</div>
					<div class="single_stat_container">
						<div class="statcircle">
							<span class="icon-users icon-large"></span>
						</div>
						<ul class="subdescription_stats">
							<li class="es-stat-no"><?php echo $this->infodata['chart_users_canvas']['twitterusers']; ?></li>
							<li class="es-stat-title"><?php echo JText::_('COM_INSTANTFBLOGIN_TWITTER_USERS');?></li>
						</ul>
					</div>
					
					<div class="single_stat_container">
						<div class="statcircle">
							<span class="icon-users icon-large"></span>
						</div>
						<ul class="subdescription_stats">
							<li class="es-stat-no"><?php echo $this->infodata['chart_users_canvas']['linkedinusers']; ?></li>
							<li class="es-stat-title"><?php echo JText::_('COM_INSTANTFBLOGIN_LINKEDIN_USERS');?></li>
						</ul>
					</div>
					
					<div class="chart_container">
						<canvas id="chart_users_canvas"></canvas>
					</div>
					
				</div>
			</div>
		</div>
		
		<div class="accordion-group">
		    <div class="accordion-heading">
				<div class="accordion-toggle" data-toggle="collapse" data-parent="#instantfblogin_accordion_cpanel" href="#instantfblogin_status">
					<h4 class="accordion-title">
						<span class="icon-help"></span>
						<?php echo JText::_('COM_INSTANTFBLOGIN_ABOUT');?>
					</h4>
		      	</div>
	    	</div>
		    <div id="instantfblogin_status" class="accordion-body collapse">
		 		<div class="accordion-inner">
					<div class="single_container">
				 		<label class="label label-warning"><?php echo JText::_('COM_INSTANTFBLOGIN_CURRENT_VERSION') . $this->currentVersion;?></label>
			 		</div>
			 		
			 		<div class="single_container">
				 		<label class="label label-info"><?php echo JText::_('COM_INSTANTFBLOGIN_AUTHOR_COMPONENT');?></label>
			 		</div>
			 		
			 		<div class="single_container">
				 		<label class="label label-info"><?php echo JText::_('COM_INSTANTFBLOGIN_SUPPORTLINK');?></label>
			 		</div>
			 		
			 		<div class="single_container">
				 		<label class="label label-info"><?php echo JText::_('COM_INSTANTFBLOGIN_DEMOLINK');?></label>
			 		</div>
				</div>
		    </div>
	 	</div>
	</div>
</div>
<form name="adminForm" id="adminForm" action="index.php">
	<input type="hidden" name="option" value="<?php echo $this->option;?>"/>
	<input type="hidden" name="task" value=""/>
</form>