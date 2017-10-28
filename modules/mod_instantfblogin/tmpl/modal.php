<?php 
//namespace modules\mod_instantfblogin
/**
 * @package INSTANTFBLOGIN::modules
 * @subpackage mod_instantfblogin
 * @author Joomla! Extensions Store
 * @copyright (C) 2015 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html
 */
defined('_JEXEC') or die;
?>
<!-- Button trigger modal -->
<div class="jes">
	<button type="button" class="btn btn-primary" data-toggle="jesmodal" data-target="#myModal">
		<?php echo $joomlaUserObject->id ? JText::sprintf('COM_INSTANTFBLOGIN_SOCIAL_LOGIN_HI', $joomlaUserObject->name) : JText::_('COM_INSTANTFBLOGIN_SOCIAL_LOGIN_BUTTON'); ?>
	</button>
	
	<!-- Modal -->
	<div class="jesmodal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="jesmodal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel"><?php echo JText::_('COM_INSTANTFBLOGIN_SOCIAL_LOGIN_DO'); ?></h4>
	      </div>
	      <div class="modal-body">
	        <?php require JModuleHelper::getLayoutPath ( 'mod_instantfblogin','default' ); ?>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="jesmodal"><?php echo JText::_('COM_INSTANTFBLOGIN_SOCIAL_LOGIN_CLOSE'); ?></button>
	      </div>
	    </div>
	  </div>
	</div>
</div>
