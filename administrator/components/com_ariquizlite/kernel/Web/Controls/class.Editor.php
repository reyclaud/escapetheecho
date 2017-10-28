<?php
/*
 *
 * @package		ARI Framework
 * @author		ARI Soft
 * @copyright	Copyright (c) 2011 www.ari-soft.com. All rights reserved
 * @license		GNU/GPL (http://www.gnu.org/copyleft/gpl.html)
 * 
 */

defined('_JEXEC') or die ('Restricted access');

class AriEditor
{
	static public function display($ctrlName, $value, $width, $height, $cols, $rows)
	{
		$needHack = (strpos($ctrlName, '[') !== false);
		$correctedCtrlName = self::getCorrectedName($ctrlName);
        $ctrlId = str_replace(array('[', ']'), array('',''), $ctrlName);

		$editor = self::getEditor();
		$html = $editor->display(
			$correctedCtrlName, 
			htmlspecialchars($value),
			$width,
			$height,
			$cols,
			$rows);
				
		if ($needHack)
		{
			$html .= sprintf('<textarea name="%1$s" id="%2$s" style="display: none !important;"></textarea>',
				$ctrlName,
				$ctrlId);
				
			$document = JFactory::getDocument();
			if (J1_5)
				$document->addScriptDeclaration(sprintf('window.addEvent("domready", function() {
						var oldSubmitHandler = submitform;
						submitform = function() {
							var val = %2$s;
							$("%1$s").value = typeof(val) != "undefined" ? val : "";
							oldSubmitHandler.apply(this, arguments);
						}
					});',
					$ctrlId,
					self::getContent($correctedCtrlName)));
			else
				$document->addScriptDeclaration(sprintf('window.addEvent("domready", function() {
						var oldSubmitHandler = Joomla.submitform;						 	
						Joomla.submitform = function() {
							var val = %2$s;
							$("%1$s").value = typeof(val) != "undefined" ? val : "";
							oldSubmitHandler.apply(this, arguments);
						}
					});',
					$ctrlId,
					self::getContent($correctedCtrlName)));
		}
	
		return '<div class="el-editor">' . $html . '</div>';
	}

    static private function getEditor()
	{
		return JFactory::getEditor();
	}

    static private function getCorrectedName($name)
	{
		return str_replace(array('[', ']'), array('_', ''), $name);
	}

    static public function getContent($correctedName)
	{
		$editor = self::getEditor();
		$content = $editor->getContent($correctedName);
			
		$content = str_replace('tinyMCE.getContent()', sprintf('tinyMCE.getContent("%s")', $correctedName), $content);
		$content = str_replace('tinyMCE.activeEditor.getContent()', sprintf('tinyMCE.get("%s").getContent()', $correctedName), $content);
		$content = str_replace(
			sprintf('JContentEditor.getContent(\'%s\')', $correctedName), 
			sprintf('(tinyMCE.get("%s") ? tinyMCE.get("%1$s").getContent() : JContentEditor.getContent(\'%1$s\'))', $correctedName),
			$content);
			
		return $content;
	}
}