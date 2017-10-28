<?php
/**
 * Joomla! 2.5 - Erweiterungen programmieren
 *
 * Standard-Layout für das Frontend. Ausgabe als HTML-Tabelle.
 *
 * @package    Mythings
 * @subpackage Frontend
 * @author     chmst.de, webmechanic.biz
 * @license	   GNU/GPLv2 or later
 *
 * @todo  HTML-Ausgabe mit CSS anhübschen
 * @todo  HTML-Ausgabe escapen
 */
defined('_JEXEC') or die;

/* Das Null-Datum der Datenbank, als Vergleichswert */
$nullDate = JFactory::getDbo()->getNullDate();
?>

<h1><?php echo'Wir verleihen viele Dinge!'; ?></h1>
<?php if ($this->items) { ?>
<table>
<tr>
	<th style="background: #ccc;">
		<?php echo 'Bezeichnung'; ?>
	</th>
	<th style="background: #ccc;">
		<?php echo 'Kategorie'; ?>
	</th>
	<th style="background: #ccc;">
		<?php echo 'Ausgeliehen an'; ?>
	</th>
	<th style="background: #ccc;">
		<?php echo 'Ausgeliehen am'; ?>
	</th>
</tr>
<?php foreach ($this->items as $item) : ?>
<tr>
	<td>
	<?php
	/* Link zur Detailansicht */
	$link = JRoute::_("index.php?option=com_mythings&view=mything&id=" .$item->id);
	echo '<a href="' .$link .'">' .$item->title .'</a>';
	?>
	</td>
	<td>
		<?php echo $item->category; ?>
	</td>
	<td>
		<?php echo $item->lent_by; ?>
	</td>
	<td><?php
	if ($item->lent != $nullDate) {
		echo JHtml::_('date', $item->lent, 'd.m.Y');
	} ?>
	</td>
</tr>
<?php endforeach;?>
</table>
<?php } ?>
