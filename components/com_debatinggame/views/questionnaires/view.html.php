<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class DebatingGameViewQuestionnaires extends JViewLegacy {

    function display($tpl = null) {
        $doc = JFactory::getDocument();
        $app = JFactory::getApplication();
        $getTemplateName = $app->getTemplate('template')->template;

        $doc->addStyleSheet('templates/' . $getTemplateName . '/drager/lib/jasmine.css');
        $doc->addStyleSheet('templates/' . $getTemplateName . '/drager/lib/font-awesome/css/font-awesome.min.css');
        $doc->addStyleSheet('templates/' . $getTemplateName . '/drager/src/dragdealer.css');
        $doc->addStyleSheet('templates/' . $getTemplateName . '/drager/demo/style/index.css');
        $doc->addStyleSheet('templates/' . $getTemplateName . '/drager/demo/style/jasmine-reporter.css');
        $doc->addStyleSheet('templates/' . $getTemplateName . '/drager/demo/style/demos.css');
        $doc->addStyleSheet('templates/' . $getTemplateName . '/sorter/css/application.css');
        $doc->addStyleSheet('templates/' . $getTemplateName . '/sorter/css/example.css');
        
        $doc->addScript( "http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" );
        $doc->addScript('/templates/' . $getTemplateName . '/drager/lib/jquery.simulate.js', 'text/javascript');
        $doc->addScript('/templates/' . $getTemplateName . '/drager/lib/jasmine.js', 'text/javascript');
        $doc->addScript('/templates/' . $getTemplateName . '/drager/lib/jasmine-jsreporter.js', 'text/javascript');
        $doc->addScript('/templates/' . $getTemplateName . '/drager/lib/jasmine-html.js', 'text/javascript');
        $doc->addScript('/templates/' . $getTemplateName . '/drager/lib/jasmine-jquery.js', 'text/javascript');
        $doc->addScript('/templates/' . $getTemplateName . '/drager/src/dragdealer.js', 'text/javascript');
        $doc->addScript('/templates/' . $getTemplateName . '/drager/demo/script/index.js', 'text/javascript');
        $doc->addScript('/templates/' . $getTemplateName . '/drager/demo/script/demos.js', 'text/javascript');        
        
        $doc->addScript('/templates/' . $getTemplateName . '/sorter/js/jquery-sortable.js', 'text/javascript');
        // Display the view
        parent::display($tpl);
    }

}