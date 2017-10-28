<?php
/**
 * Joomla! 2.5 - Erweiterungen programmieren
 *
 * Einstiegspunkt im Frontend
 * @package     Frontend
 * @subpackage  com_mythings
 * @author      chmst.de, webmechanic.biz
 * @license     GNU/GPL
 */
defined('_JEXEC') or die;
jimport('joomla.application.component.controller');

/* Einstieg in die Komponente - MyThingsController instanziieren */
$controller = JControllerLegacy::getInstance('mp_ftpair');

/* Eingabe des Applikationsobjekts besorgen */
$input = JFactory::getApplication()->input;

/* Aufgabe (task) ausführen. Hier ist das die Ausgabe des Standardviews */
$controller->execute($input->get('task'));




