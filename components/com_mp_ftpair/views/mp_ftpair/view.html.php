<?php
/**
 * Joomla! 2.5 - Erweiterungen programmieren
 *
 * Standard-Ansicht com_mythings im Frontend.
 *
 * @package    Mythings
 * @subpackage Frontend
 * @author     chmst.de, webmechanic.biz
 * @license	   GNU/GPLv2 or later
 */
defined('_JEXEC') or die;

/* Import der Basisklasse JView */
jimport('joomla.application.component.view');

/**
 * Erweiterung der Basisklasse JView
 */
class Mp_FtpairViewMp_Ftpair extends JView
{
  /**
   * Überschreiben der Methode display
   *
   * @param string $tpl Alternative Layoutdatei, leer = 'default'
   */
  public function display($tpl = null)
  {
    JFactory::getDocument()->setMimeEncoding( 'application/json' );
    JResponse::setHeader( 'Content-Disposition', 'attachment; filename="'.$this->getName().'.json"' );
    JRequest::setVar('tmpl','component');
    echo json_encode($data);
  }
}
