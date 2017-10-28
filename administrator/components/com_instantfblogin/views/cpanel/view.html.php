<?php
// namespace administrator\components\com_instantfblogin\views\cpanel;
/**
 *
 * @package INSTANTFBLOGIN::CPANEL::administrator::components::com_instantfblogin
 * @subpackage views
 * @subpackage cpanel
 * @author Joomla! Extensions Store
 * @copyright (C) 2015 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html 
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );
jimport ( 'joomla.application.component.view' );

/**
 * CPanel view
 *
 * @package INSTANTFBLOGIN::CPANEL::administrator::components::com_instantfblogin
 * @subpackage views
 * @subpackage cpanel
 * @since 1.6
 */
class InstantfbloginViewCpanel extends InstantfbloginView {
	/**
	 * Renderizza l'iconset del cpanel
	 *
	 * @param $link string
	 * @param $image string
	 * @access private
	 * @return string
	 */
	private function getIcon($link, $image, $text, $target = '', $title = null, $class = 'icons') {
		$mainframe = JFactory::getApplication ();
		$lang = JFactory::getLanguage ();
		$option = $this->option;
		?>
		<div class="<?php echo $class;?>" style="float:<?php echo ($lang->isRTL()) ? 'right' : 'left'; ?>;">
			<div class="icon">
				<a <?php echo $title;?> <?php echo $target;?> href="<?php echo $link; ?>"> 
					<div class="task <?php echo $image;?>"></div> 
					<span class="task"><?php echo $text; ?></span>
				</a>
			</div>
		</div>
		<?php
		}
		
	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addDisplayToolbar() {
		$doc = JFactory::getDocument();
		JToolBarHelper::title( JText::_('COM_INSTANTFBLOGIN_CPANEL_TOOLBAR' ), 'instantfblogin' );
		JToolBarHelper::custom('cpanel.display', 'home', 'home', 'COM_INSTANTFBLOGIN_CPANEL', false);
	}
	
	/**
	 * Effettua il rendering del pannello di controllo
	 * @access public
	 * @return void
	 */
	public function display($tpl = null) {
		$doc = JFactory::getDocument ();
		$this->loadJQuery($doc);
		$this->loadBootstrap($doc);
		$doc->addStylesheet ( JURI::root ( true ) . '/administrator/components/com_instantfblogin/css/cpanel.css' );
		$doc->addScript ( JURI::root ( true ) . '/administrator/components/com_instantfblogin/js/chart.js' );
		$doc->addScript ( JURI::root ( true ) . '/administrator/components/com_instantfblogin/js/cpanel.js' );
		
		// Inject js translations
		$translations = array (	'COM_INSTANTFBLOGIN_TOTALUSERS_CHART',
								'COM_INSTANTFBLOGIN_JOOMLAUSERS_CHART',
								'COM_INSTANTFBLOGIN_FACEBOOKUSERS_CHART',
								'COM_INSTANTFBLOGIN_GPLUSUSERS_CHART',
								'COM_INSTANTFBLOGIN_TWITTERUSERS_CHART',
								'COM_INSTANTFBLOGIN_LINKEDINUSERS_CHART',
								'COM_INSTANTFBLOGIN_TOTALMESSAGES_CHART',
								'COM_INSTANTFBLOGIN_TOTALFILEMESSAGES_CHART');
		$this->injectJsTranslations($translations, $doc);
		
		// Buffer delle icons
		ob_start ();
		$this->getIcon ( 'index.php?option=com_instantfblogin&task=users.display', 'icon-users', JText::_ ( 'COM_INSTANTFBLOGIN_USERS' ) );
		$this->getIcon ( 'index.php?option=com_instantfblogin&task=config.display#_setup', 'icon-tools', JText::_ ( 'COM_INSTANTFBLOGIN_CONFIG_APPSETUP' ) );
		$this->getIcon ( 'index.php?option=com_instantfblogin&task=config.display#_preferences', 'icon-color-palette', JText::_ ( 'COM_INSTANTFBLOGIN_CONFIG_TEMPLATE' ) );
		$this->getIcon ( 'index.php?option=com_instantfblogin&task=config.display#_socialshare', 'icon-share', JText::_ ( 'COM_INSTANTFBLOGIN_CONFIG_SHARE' ) );
		$this->getIcon ( 'index.php?option=com_instantfblogin&task=config.display#_metatags', 'icon-list-view', JText::_ ( 'COM_INSTANTFBLOGIN_CONFIG_METATAGS' ) );
		$this->getIcon ( 'index.php?option=com_instantfblogin&task=config.display#_autoposting', 'icon-broadcast', JText::_ ( 'COM_INSTANTFBLOGIN_CONFIG_AUTOPOSTING' ) );
		$this->getIcon ( 'index.php?option=com_instantfblogin&task=config.display', 'icon-cog', JText::_ ( 'COM_INSTANTFBLOGIN_CONFIG' ) );
		$this->getIcon ( 'http://storejextensions.org/instant_facebook_login_documentation.html', 'icon-help', JText::_ ( 'COM_INSTANTFBLOGIN_HELP' ) );
		
		$contents = ob_get_clean ();
		
		$infoData = $this->getModel()->getData();
		$doc->addScriptDeclaration('var instantfbloginChartData = ' . json_encode($infoData));
		
		// Assign reference variables
		$this->icons = $contents;
		$this->componentParams = $this->getModel()->getComponentParams();
		$this->updatesData = $this->getModel()->getUpdates($this->get('httpclient'));
		$this->infodata = $infoData;
		$this->currentVersion = strval(simplexml_load_file(JPATH_COMPONENT_ADMINISTRATOR . '/instantfblogin.xml')->version);
		$moduleStatusCtrlClass = new InstantfbloginHtmlModulestatus();
		$this->moduleStatus = $moduleStatusCtrlClass->getHtmlCode();
		
		// Add toolbar
		$this->addDisplayToolbar();
		
		// Output del template
		parent::display ();
	}
}
?>