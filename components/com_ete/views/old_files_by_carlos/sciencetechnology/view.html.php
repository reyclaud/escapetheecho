<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 

class EteViewScienceTechnology extends JViewLegacy{

	function display($tpl = null)
	{
		// Assign data to the view
		$this->msg = 'ScienceTechnology';
 
		// Display the view
		parent::display($tpl);
	}
}