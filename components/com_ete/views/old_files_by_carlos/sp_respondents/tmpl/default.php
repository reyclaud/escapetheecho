<?php
error_reporting(E_ALL & ~E_NOTICE);

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>

<!--You can place html anywhere within the source tags -->
<script language = "javascript" type = "text/javascript">
// You can place JavaScript like this
</script>
<?php
// You can place PHP like this
$db = JFactory::getDbo();

$sp = $db->getQuery(true);
$sp->select('UserId');
$sp->from($db->quoteName('jos_rsform_submissions'));
$sp->where($db->quoteName('FormId') . " = " . '46');
$db->setQuery($sp);
$sp_count = $db->loadObjectList();

//FRONT END
 
 
echo "<br>";
 
echo "<div class='answers-count'>";
 
echo "<div class='answers-count-nav'>"; 
echo "<br>";
 
echo "</div>";
 
echo "<h3 style='display:inline;'>Quiz Title: </h3> Sports & Play";
echo "<h5> List of Respondents </h5>";
 
echo "</div>"; 
 
echo "<div class='pd-holder'>
 
<br> 
 
<table class='answers-count-holder' style='width: 100%;'>
 
<tbody>
 
<tr class='table-head'>
 <td></td>
<td><strong>Respondent Name</strong></td>
 
</tr>";
if($sp_count){
foreach($sp_count as $x => $x_value) { 
	
	$u = $db->getQuery(true);
	$u->select(array('name'));
	$u->from($db->quoteName('jos_users'));
	$u->where($db->quoteName('id') . " = " . $x_value->UserId);
	$db->setQuery($u);
	$user = $db->loadResult();
	$count = $x + 1;
	
	echo "<tr><td>$count</td><td> ".$user."</td></tr>"; 	 
}
}else{
	echo "<tr><td></td><td>No data available in table</td></tr>"; 
}
 
 
echo "</tbody> </table> </div>";
