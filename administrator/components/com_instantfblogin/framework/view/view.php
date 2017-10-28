<?php
// namespace administrator\components\com_instantfblogin\framework\view;
/**
 * @package INSTANTFBLOGIN::FRAMEWORK::administrator::components::com_instantfblogin
 * @subpackage framework
 * @subpackage view
 * @author Joomla! Extensions Store
 * @copyright (C) 2015 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html  
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );
jimport ( 'joomla.application.component.view' );
jimport ( 'joomla.html.pagination' );
 
/**
 * Base view for all display core
 * 
 * @package INSTANTFBLOGIN::FRAMEWORK::administrator::components::com_instantfblogin
 * @subpackage framework
 * @subpackage view
 * @since 1.6
 */
class InstantfbloginView extends JViewLegacy {
	/**
	 * Reference to application
	 *
	 * @access public
	 * @var Object
	 */
	public $app;
	
	/**
	 * Reference to option executed
	 *
	 * @access public
	 * @var string
	 */
	public $option;
	/**
	 * Inject language constant into JS Domain maintaining same name mapping
	 * 
	 * @access protected
	 * @param $translations Object&
	 * @param $document Object&
	 * @return void
	 */
	protected function injectJsTranslations($translations, $document) {
		$jsInject = null;
 		// Do translations
		foreach ( $translations as $translation ) {
			$jsTranslation = strtoupper ( $translation );
			$translated = JText::_( $jsTranslation, true );
			$jsInject .= <<<JS
				var $translation = '{$translated}'; 
JS;
		}
		$document->addScriptDeclaration($jsInject);
	}
	
	/**
	 * Manage injecting jQuery framework into document with class inheritance support
	 *
	 * @access protected
	 * @param Object& $doc
	 * @return void
	 */
	protected function loadJQuery($document, $fullStack = true) {
		if($fullStack) {
			JHTML::_ ( 'bootstrap.framework' );
		} else {
			JHTML::_ ( 'jquery.framework' );
		}
		
		try { JHtml::_('behavior.core'); } catch (Exception $e){} // Compatibility fix ensured for Joomla 3.4+
		
		// jQuery foundation framework
		$document->addScript ( JURI::root ( true ) . '/administrator/components/com_instantfblogin/js/jstorage.min.js' );
		$base = JURI::root();
		$document->addScriptDeclaration("var instantfbloginBaseURI='$base';");
	}
	
	/**
	 * Manage injecting Bootstrap framework into document
	 * 
	 * @access protected
	 * @param Object& $doc
	 * @return void
	 */
	protected function loadBootstrap($document) {
		// Main styles for admin interface
		$document->addStylesheet ( JURI::root ( true ) . '/administrator/components/com_instantfblogin/css/bootstrap-interface.css' );
		
		// Main JS file for admin interface
		$document->addScript ( JURI::root ( true ) . '/administrator/components/com_instantfblogin/js/bootstrap-interface.js' );
	}
	
	/**
	 * Manage injecting valildation plugin into document
	 *
	 * @access protected
	 * @param Object& $doc
	 * @return void
	 */
	protected function loadValidation($document) {
		$document->addStylesheet ( JURI::root ( true ) . '/administrator/components/com_instantfblogin/css/simplevalidation.css' );
		$document->addScript ( JURI::root ( true ) . '/administrator/components/com_instantfblogin/js/jquery.simplevalidation.js' );
	}
	
	/**
	 * Manage injecting jQuery UI framework into document
	 *
	 * @access protected
	 * @param Object& $doc
	 * @return void
	 */
	protected function loadJQueryUI($document) {
		$document->addStylesheet ( JURI::root ( true ) . '/administrator/components/com_instantfblogin/css/jqueryui/jquery.ui.all.css' );
		$document->addScript ( JURI::root ( true ) . '/administrator/components/com_instantfblogin/js/jquery.ui.js' );
	}
	
	/**
	 * Class constructor
	 *
	 * @param array $config
	 *        	return Object
	 */
	public function __construct($config = array()) {
		parent::__construct ( $config );
	
		$this->app = JFactory::getApplication ();
		$this->user = JFactory::getUser ();
		$this->option = $this->app->input->get ( 'option' );
	}
}