<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class DebatingGameViewTwentyfourcard extends JViewLegacy {

    function display($tpl = null) {
        $doc = JFactory::getDocument();
        $app = JFactory::getApplication();
        $getTemplateName = $app->getTemplate('template')->template;

        $doc->addStyleSheet('templates/' . $getTemplateName . '/css/games.css');
        $doc->addStyleSheet('templates/' . $getTemplateName . '/css/games4x4.css');
        $doc->addStyleSheet('templates/' . $getTemplateName . '/css/games24.css');
        
        $doc->addScript( "http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" );
        $doc->addScript('/templates/' . $getTemplateName . '/js/games24.js', 'text/javascript');
        // Display the view
        parent::display($tpl);
    }

}
