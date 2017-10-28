<?php
// namespace administrator\components\com_instantfblogin\views\users;
/**
 *
 * @package INSTANTFBLOGIN::USERS::administrator::components::com_instantfblogin
 * @subpackage views
 * @subpackage users
 * @author Joomla! Extensions Store
 * @copyright (C) 2015 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );
define ( 'INDEX_REGISTEREDON', 9 );
define ( 'INDEX_VERIFIED', 11 );
jimport ( 'joomla.utilities.date' );

/**
 * Users view implementation
 *
 * @package INSTANTFBLOGIN::USERS::administrator::components::com_instantfblogin
 * @subpackage views
 * @since 1.6
 */
class InstantfbloginViewUsers extends InstantfbloginView {
	/**
	 * Date object to manage user datetimezone
	 *
	 * @access private
	 * @var Object
	 */
	protected $joomlaConfig;
	
	/**
	 * Add the page title and toolbar.
	 *
	 * @since 1.6
	 */
	protected function addDisplayToolbar() {
		// Model state cparams
		$cParams = $this->getModel ()->getState ( 'cparams' );
		$keepDays = $cParams->get ( 'keep_latest_msgs', 7 );
		
		$doc = JFactory::getDocument ();
		JToolBarHelper::title ( JText::_ ( 'COM_INSTANTFBLOGIN_MAINTITLE_TOOLBAR' ) . JText::_ ( 'COM_INSTANTFBLOGIN_LIST_MESSAGES' ), 'instantfblogin' );
		JToolBarHelper::deleteList ( 'COM_INSTANTFBLOGIN_DELETE_MESSAGES', 'users.deleteEntities' );
		JToolBarHelper::custom ( 'users.exportUsers', 'download', 'download', 'COM_INSTANTFBLOGIN_EXPORT_MSG', false );
		JToolBarHelper::custom ( 'cpanel.display', 'home', 'home', 'COM_INSTANTFBLOGIN_CPANEL', false );
	}
	
	// Funzione di scrittura nell'output stream
	protected function outputCSV(&$vals, $key, $userData) {
		// Fields value transformations
		if (isset ( $vals ['registered_on'] ) && $vals ['registered_on']) {
			$dateObject = JFactory::getDate ( $vals ['registered_on'] );
			$dateObject->setTimezone ( new DateTimeZone ( $this->joomlaConfig ) );
			$vals ['registered_on'] = $dateObject->format ( 'Y-m-d H:i:s', true, false );
		}
		if (isset ( $vals ['verified'] )) {
			$vals ['verified'] = ( int ) $vals ['verified'] ? JText::_ ( 'JYES' ) : JText::_ ( 'JNO' );
		}
		// Always verified
		if(isset ( $vals ['account_type'] ) && $vals['account_type'] == 'goog') {
			$vals ['verified'] = JText::_ ( 'JYES' );
		}
		if(isset ( $vals ['account_type'] ) && $vals['account_type'] == 'twit') {
			$vals ['last_name'] = JText::_ ( 'COM_INSTANTFBLOGIN_ND' );
		}
		if(isset ( $vals ['account_type'] )) {
			$vals ['account_type'] = JText::_('COM_INSTANTFBLOGIN_ACCOUNT_TYPE_' . strtoupper($vals ['account_type']));
		}
		
		if (isset ( $vals ['geolocation'] )) {
			$code = strtoupper($vals ['geolocation']);
			if (strlen ( $vals ['geolocation'] ) > 2 && strpos($vals ['geolocation'], '_')) {
				$spliced = explode ( '_', $vals ['geolocation'] );
				$code = substr ( $spliced [1], 0, 2 );
			}
			$vals ['geolocation'] = array_key_exists ( $code, $this->geoTranslations ) ? $this->geoTranslations [$code] ['name'] : $vals ['geolocation'];
		}
		
		fputcsv ( $userData [0], $vals, $userData [1], $userData [2] ); // add parameters if you want
	}
	
	/**
	 * Default listEntities
	 *
	 * @access public
	 */
	public function display($tpl = 'list') {
		$doc = JFactory::getDocument ();
		$this->loadJQuery ( $doc );
		$this->loadJQueryUI ( $doc ); // Required for draggable feature
		$this->loadBootstrap ( $doc );
		$doc->addScriptDeclaration ( "
						jQuery(function($) {
							$('input[data-role=calendar]').datepicker({
								dateFormat:'yy-mm-dd'
							}).prev('span').on('click', function(){
								$(this).datepicker('show');
							});
						});
					" );
		$doc->addScriptDeclaration ( "
						Joomla.submitbutton = function(pressbutton) {
							Joomla.submitform( pressbutton );
							if (pressbutton == 'users.exportUsers') {
								jQuery('#adminForm input[name=task]').val('users.display');
							}
							return true;
						}
					" );
		// Get main records
		$rows = $this->get ( 'Data' );
		$lists = $this->get ( 'Filters' );
		$total = $this->get ( 'Total' );
		
		$orders = array ();
		$orders ['order'] = $this->getModel ()->getState ( 'order' );
		$orders ['order_Dir'] = $this->getModel ()->getState ( 'order_dir' );
		// Pagination view object model state populated
		$pagination = new JPagination ( $total, $this->getModel ()->getState ( 'limitstart' ), $this->getModel ()->getState ( 'limit' ) );
		$dates = array (
				'start' => $this->getModel ()->getState ( 'fromPeriod' ),
				'to' => $this->getModel ()->getState ( 'toPeriod' ) 
		);
		
		$this->pagination = $pagination;
		$this->order = $this->getModel ()->getState ( 'order' );
		$this->searchword = $this->getModel ()->getState ( 'searchword' );
		$this->lists = $lists;
		$this->orders = $orders;
		$this->items = $rows;
		$this->option = $this->getModel ()->getState ( 'option' );
		$this->dates = $dates;
		$this->geoTranslations = $this->get ( 'GeoTranslations' );
		
		// Add toolbar
		$this->addDisplayToolbar ();
		
		parent::display ( $tpl );
	}
	
	/**
	 * Effettua l'output view del file in attachment al browser
	 *
	 * @access public
	 * @param array $data        	
	 * @return void
	 */
	public function sendCSVUsers($data) {
		$delimiter = ';';
		$enclosure = '"';
		
		// Prepopulate model with geotranslations data
		$this->geoTranslations = $this->get('GeoTranslations');
		
		// Clean dirty buffer
		ob_end_clean ();
		// Open buffer
		ob_start ();
		// Open out stream
		$outstream = fopen ( "php://output", "w" );
		
		// Echo delle intestazioni
		$headersTranslated = array ();
		$headersFields = array_keys ( $data [0] );
		foreach ( $headersFields as $value ) {
			$headersTranslated [] = JText::_ ( 'COM_INSTANTFBLOGIN_' . strtoupper ( $value ) );
		}
		$this->outputCSV ( $headersTranslated, null, array (
				$outstream,
				$delimiter,
				$enclosure,
				true 
		) );
		// Output di tutti i records
		array_walk ( $data, array (
				$this,
				'outputCSV' 
		), array (
				$outstream,
				$delimiter,
				$enclosure,
				false 
		) );
		fclose ( $outstream );
		// Recupero output buffer content
		$contents = ob_get_clean ();
		$size = strlen ( $contents );
		
		header ( 'Pragma: public' );
		header ( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
		header ( 'Expires: ' . gmdate ( 'D, d M Y H:i:s' ) . ' GMT' );
		header ( 'Content-Disposition: attachment; filename="users.csv"' );
		header ( 'Content-Type: text/plain' );
		header ( "Content-Length: " . $size );
		echo $contents;
		
		exit ();
	}
	
	/**
	 * Class constructor
	 *
	 * @param array $config        	
	 */
	public function __construct($config = array()) {
		// Parent view object
		parent::__construct ( $config );
		
		$joomlaConfig = JFactory::getConfig ();
		$this->joomlaConfig = $this->user->getParam ( 'timezone', $joomlaConfig->get ( 'offset' ) );
	}
}
?>