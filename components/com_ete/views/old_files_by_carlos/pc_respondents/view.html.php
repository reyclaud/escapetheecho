<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 

class EteViewPC_Respondents extends JViewLegacy{

	function display($tpl = null)
	{
		// Assign data to the view
		$this->msg = 'PCRespondents';
 
		// Display the view
		parent::display($tpl);
	}
}