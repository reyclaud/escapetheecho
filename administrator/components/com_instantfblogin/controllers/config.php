<?php
// namespace administrator\components\com_instantfblogin\controllers;
/**
 *
 * @package INSTANTFBLOGIN::CONFIG::administrator::components::com_instantfblogin
 * @subpackage controllers
 * @author Joomla! Extensions Store
 * @copyright (C) 2015 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html 
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );
jimport ( 'joomla.application.component.controller' );

/**
 * Config controller concrete implementation
 *
 * @package INSTANTFBLOGIN::CPANEL::administrator::components::com_instantfblogin
 * @subpackage controllers
 * @since 1.6
 */
class InstantfbloginControllerConfig extends InstantfbloginController {

	/**
	 * Show configuration
	 * @access public
	 * @return void
	 */
	public function display($cachable = false, $urlparams = false) {
		parent::display($cachable);
	}

	/**
	 * Save config entity
	 * @access public
	 * @return void
	 */
	public function saveEntity() {
		$model = $this->getModel();
		$option = $this->option;
		
		if(!$model->storeEntity()) {
			// Model set exceptions for something gone wrong, so enqueue exceptions and levels on application object then set redirect and exit
			$modelException = $model->getError(null, false);
			$this->app->enqueueMessage($modelException->getMessage(), $modelException->getErrorLevel());
			$this->setRedirect ( "index.php?option=$option&task=config.display", JText::_('COM_INSTANTFBLOGIN_ERROR_SAVING_PARAMS'));
			return false;
		}
		$this->setRedirect( "index.php?option=$option&task=config.display", JText::_('COM_INSTANTFBLOGIN_SAVED_PARAMS'));
	}
}