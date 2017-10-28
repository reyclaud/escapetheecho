<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 

class EteViewSportPlay extends JViewLegacy{

	function display($tpl = null)
	{
		// Assign data to the view
		$this->msg = 'SportPlay';
 
		// Display the view
		parent::display($tpl);
	}
}