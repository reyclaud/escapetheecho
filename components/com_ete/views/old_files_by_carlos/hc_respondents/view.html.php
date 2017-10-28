<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 

class EteViewHC_Respondents extends JViewLegacy{

	function display($tpl = null)
	{
		// Assign data to the view
		$this->msg = 'HCRespondents';
 
		// Display the view
		parent::display($tpl);
	}
}