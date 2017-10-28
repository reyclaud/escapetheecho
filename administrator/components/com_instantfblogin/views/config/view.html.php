<?php
// namespace administrator\components\com_instantfblogin\views\cpanel;
/**
 *
 * @package INSTANTFBLOGIN::CONFIG::administrator::components::com_instantfblogin
 * @subpackage views
 * @subpackage config
 * @author Joomla! Extensions Store
 * @copyright (C) 2015 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html 
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );
jimport ( 'joomla.application.component.view' );

/**
 * Config view
 *
 * @package INSTANTFBLOGIN::CONFIG::administrator::components::com_instantfblogin
 * @subpackage views
 * @since 1.6
 */
class InstantfbloginViewConfig extends InstantfbloginView {

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addDisplayToolbar() {
		$doc = JFactory::getDocument();
		JToolBarHelper::title( JText::_('COM_INSTANTFBLOGIN_MAINTITLE_TOOLBAR') . JText::_('COM_INSTANTFBLOGIN_CONFIG' ), 'instantfblogin' );
		JToolBarHelper::save('config.saveentity', 'COM_INSTANTFBLOGIN_SAVECONFIG');
		JToolBarHelper::custom('cpanel.display', 'home', 'home', 'COM_INSTANTFBLOGIN_CPANEL', false);
	}
	
	/**
	 * Effettua il rendering dei tabs di configurazione del componente
	 * @access public
	 * @return void
	 */
	public function display($tpl = null) {
		$doc = JFactory::getDocument();
		$this->loadJQuery($doc);
		$this->loadBootstrap($doc);
		
		/*$doc->addScriptDeclaration("Joomla.submitbutton = function(task) {
										if (document.formvalidator.isValid(document.getElementById('adminForm'))) {
											Joomla.submitform(task, document.getElementById('adminForm'));
										}
									}");*/
		
		$params = $this->get('Data');
		$form = $this->get('form');
		
		// Bind the form to the data.
		if ($form && $params) {
			$form->bind($params);
		}
		
		$this->params_form = $form;
		$this->params = $params;
		$this->fieldset = $this->getModel()->getState('fieldset');
		
		// Aggiunta toolbar
		$this->addDisplayToolbar();
		
		// Output del template
		parent::display();
	}
}
?>