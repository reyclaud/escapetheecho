<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 

class EteViewBeliefsIdeas extends JViewLegacy{

	function display($tpl = null)
	{
		// Assign data to the view
		$this->msg = 'BeliefsIdeas';
 
		// Display the view
		parent::display($tpl);
	}
}