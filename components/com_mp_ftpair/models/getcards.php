<?php
/**
 * Joomla! 2.5 - Erweiterungen programmieren
 *
* Datenmodell, Ausgabe eines einzelnen Items
 *
 * @package    Mythings
 * @subpackage Frontend
 * @author     chmst.de, webmechanic.biz
 * @license	   GNU/GPLv2 or later
 */
defined('_JEXEC') or die;

/* Import der Basisklasse JModelItem für genau einen Datensatz */
jimport('joomla.application.component.modelitem');

/**
 * Erweiterung der Basisklasse JModelItem
 */
class Mp_FtpairModelGetCards extends JModelItem
{
  /**
   * Die Methode wird überschrieben, um den Tabellennamen und die
   * benötigten Spalten anzugeben.
   *
   * @return $result - Ergebnis der Datenbankabfrage
   */
    public function getPath()
    {

	  /* Applikationspbjekt anfpordern  */
      $app = JFactory::getApplication();

	  /* Die Id des Datensatzes, den der Benutzer angeklicht hat  */
      return $app->input->get('path', 0, 'varchar');

    }
    public function getCards()
    {

	  /* Applikationspbjekt anfpordern  */
      $app = JFactory::getApplication();

	  /* Die Id des Datensatzes, den der Benutzer angeklicht hat  */
      return $app->input->get('cards', 0, 'int');

    }
}
