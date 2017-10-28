<?php
/*
* @copyright   Copyright (C) 2015 Kevin Olson, Inc. All rights reserved.
* @license     GNU General Public License version 2 or later; see LICENSE.txt
*/

defined('_JEXEC') or die;

class PlgButtontxtquizbtn extends JPlugin
{

	protected $autoloadLanguage = true;

	public function onDisplay($name)
	{
		$button = new JObject;
		$doc             = JFactory::getDocument();
		$doc->addStyleSheet(JURI::root() . 'plugins/editors-xtd/txtquizbtn/helper.css');
		$button->modal = true;
		$button->class = 'btn';
		$button->link = '../plugins/editors-xtd/txtquizbtn/insert.php';
		$button->text = JText::_('txtQuiz');
		$button->name = 'txtquizins';
		$button->options = "{handler: 'iframe', size: {x:500, y: 600}}";

		return $button;
	}
}
