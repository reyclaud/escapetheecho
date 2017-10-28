<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 

class EteViewHomeCommunity extends JViewLegacy{

	function display($tpl = null)
	{
		// Assign data to the view
		$this->msg = 'HomeCommunity';
 
		// Display the view
		parent::display($tpl);
	}
}