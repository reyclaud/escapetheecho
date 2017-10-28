<?php
// namespace administrator\components\com_instantfblogin\controllers;
/**
 *
 * @package INSTANTFBLOGIN::USERS::administrator::components::com_instantfblogin
 * @subpackage controllers
 * @author Joomla! Extensions Store
 * @copyright (C) 2015 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html 
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );
jimport ( 'joomla.application.component.controller' );

/**
 * Users concrete implementation
 *
 * @package INSTANTFBLOGIN::USERS::administrator::components::com_instantfblogin
 * @subpackage controllers
 * @since 1.6
 */
class InstantfbloginControllerUsers extends InstantfbloginController { 
	/**
	 * Setta il model state a partire dallo userstate di sessione
	 * @access protected
	 * @param string $scope
	 * @param boolean $ordering
	 * @return void
	 */
	protected function setModelState($scope = 'default') {
		$option = $this->option;
		
		$fromPeriod = $this->getUserStateFromRequest( "$option.users.fromperiod", 'fromperiod');
		$toPeriod = $this->getUserStateFromRequest( "$option.users.toperiod", 'toperiod');
		$gender = $this->getUserStateFromRequest( "$option.users.gender", 'gender');
		$account_type = $this->getUserStateFromRequest( "$option.users.account_type", 'account_type');
		$geo = $this->getUserStateFromRequest( "$option.users.geo", 'geo');
		$filter_order = $this->getUserStateFromRequest("$option.users.filter_order", 'filter_order', 'a.registered_on', 'cmd');
		$filter_order_Dir = $this->getUserStateFromRequest("$option.users.filter_order_Dir", 'filter_order_Dir', 'desc', 'word');
		
		$defaultModel = parent::setModelState('users');
		
		// Set model state  
		$defaultModel->setState('fromPeriod', $fromPeriod);
		$defaultModel->setState('toPeriod', $toPeriod);
		$defaultModel->setState('gender', $gender);
		$defaultModel->setState('account_type', $account_type);
		$defaultModel->setState('geo', $geo);
		$defaultModel->setState('order', $filter_order);
		$defaultModel->setState('order_dir', $filter_order_Dir);
		
		return $defaultModel;
	}
	
	/**
	 * Default listEntities
	 * 
	 * @access public
	 * @return void
	 */
	public function display($cachable = false, $urlparams = false) {
		// Set model state 
		$this->setModelState();
		
		// Parent construction and view display
		parent::display();
	}

	/**
	 * Delete a db table entity
	 *
	 * @access public
	 * @return void
	 */
	public function deleteEntity() {
		$cids = $this->app->input->get ( 'cid', array (), 'array' );
		$option = $this->option;
		
		// Load della model e checkin before exit
		$model = $this->getModel ();
		
		$result = $model->deleteEntities ($cids);
		
		if (! $result) {
			// Model set exceptions for something gone wrong, so enqueue exceptions and levels on application object then set redirect and exit
			$modelException = $model->getError ( null, false );
			$this->app->enqueueMessage ( $modelException->getMessage (), $modelException->getErrorLevel () );
			$this->setRedirect ( "index.php?option=$option&task=users.display", JText::_ ( 'COM_INSTANTFBLOGIN_ERROR_DELETE' ) );
			return false;
		}
		
		$this->setRedirect ( "index.php?option=$option&task=users.display", JText::_ ( 'COM_INSTANTFBLOGIN_SUCCESS_DELETE' ) );
	}
	
	/**
	 * Avvia il processo di esportazione records
	 *
	 * @access public
	 * @return void
	 */
	public function exportUsers() { 
		// Set model state and get default model
		$model = $this->setModelState();
		
		// Retrieve dataset
		$dataSet = $model->getData(true);
		
		// If no data are available skip export CSV 
		if(!is_array($dataSet) || !count($dataSet)) {
			$this->setRedirect('index.php?option=' . $this->option . '&task=users.display', JText::_('COM_INSTANTFBLOGIN_NODATA_EXPORT'));
			return false;
		}
		
		// Get view and set default model
		$view = $this->getView();
		$view->setModel($model, true);
		
		// Format and export CSV report
		$view->sendCSVUsers($dataSet);
	}  
	
	/**
	 * Constructor.
	 *
	 * @access protected
	 * @param
	 *       	 array An optional associative array of configuration settings.
	 *       	 Recognized key values include 'name', 'default_task',
	 *       	 'model_path', and
	 *       	 'view_path' (this list is not meant to be comprehensive).
	 * @since 1.5
	 */
	function __construct($config = array()) {
		parent::__construct($config);
		
		$this->registerTask('deleteEntities', 'deleteEntity');
	}
}
