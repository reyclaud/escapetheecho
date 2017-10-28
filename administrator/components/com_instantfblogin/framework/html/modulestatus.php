<?php
//namespace administrator\components\com_instantfblogin\models\fields;
/**  
 * @package INSTANTFBLOGIN::components::com_instantfblogin::administrator
 * @subpackage framework
 * @subpackage html
 * @author Joomla! Extensions Store
 * @copyright (C) 2015 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html   
 */ 
defined ( '_JEXEC' ) or die ();

/**  
 * @package INSTANTFBLOGIN::components::com_instantfblogin::administrator
 * @subpackage framework
 * @subpackage html
 * @since 1.6 
 */ 
class JFormFieldModuleStatus extends JFormField {
	/**
	 * The form field type.
	 *
	 * @var string
	 * @since 11.1
	 */
	protected $type = 'ModuleStatus';
	
	/**
	 * Method to get the radio button field input markup.
	 *
	 * @return string The field input markup.
	 *        
	 * @since 11.1
	 */
	protected function getInput() {
		// Initialize variables.
		$html = array ();
		
		// Retrieve status informations about the login module
		$db = JFactory::getDbo();
		$queryModuleStatus = "SELECT id, published, position" .
							 "\n FROM #__modules" .
							 "\n WHERE " . $db->quoteName('module') . "=" . $db->quote('mod_instantfblogin') .
							 "\n AND " . $db->quoteName('published') . ">= 0" ;
		$db->setQuery($queryModuleStatus);
		$publishedModule = $db->loadObject();
		if (is_object($publishedModule)) {
			$isModulePublished = $publishedModule->published && ($publishedModule->position != '');
		}
		
		// Initialize some field attributes.
		
		if ($isModulePublished) {
			$html [] = 	'<a target="_blank" href="index.php?option=com_modules&amp;task=module.edit&amp;id=' . $publishedModule->id . '">' .
						'<span data-content="' . JText::sprintf ( 'COM_INSTANTFBLOGIN_MODULE_ENABLED_DESC', $publishedModule->position) . 
						'" class="label label-success label-large hasPopover modulestatus">' . '<span class="icon-checkmark icon-inline"></span>' . 
						JText::sprintf ( 'COM_INSTANTFBLOGIN_MODULE_ENABLED' ) . '</span></a>';
		} else {
			$html [] = 	'<a target="_blank" href="index.php?option=com_modules&amp;task=module.edit&amp;id=' . $publishedModule->id . '">' .
						'<span data-content="' . JText::_ ( 'COM_INSTANTFBLOGIN_MODULE_DISABLED_DESC' ) . 
						'" class="label label-important label-large hasPopover modulestatus">' . '<span class="icon-remove icon-inline"></span>' . 
						JText::sprintf ( 'COM_INSTANTFBLOGIN_MODULE_DISABLED' ) . '</span></a>';
		}
		
		return implode ( $html );
	}
}

/**
 * HTML generic accessor to the JFormField element
 *
 * @package INSTANTFBLOGIN::components::com_instantfblogin::administrator
 * @subpackage framework
 * @subpackage html
 * @since 1.6
 */
class InstantfbloginHtmlModulestatus extends JFormFieldModuleStatus {
	/**
	 * Return the module status html for the control
	 *
	 * @access public
	 * @return string The control html
	 */
	public function getHtmlCode() {
		return $this->getInput();
	}
}
