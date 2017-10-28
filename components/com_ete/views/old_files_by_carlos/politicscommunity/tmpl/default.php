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

//ALJONCODE START
 function getCount($db, $fn, $v){
    $countSql = $db->getQuery(true); 
    $countSql->select('COUNT(*)'); 
    $countSql->from($db->quoteName('jos_rsform_submission_values'));  
    $countSql->where($db->quoteName('FieldName') ."=". "'".$fn."'"); 
    $countSql->where($db->quoteName('FormId') ." = ". '3');  
 	
 	if($v <> 'GETALLRECORDS'){
     	$countSql->where($db->quoteName('FieldValue') ." LIKE ". "'%".$v."%'");  
	}
	$db->setQuery($countSql);
 
	$count = $db->loadResult();
	return $count;
}
 

$item1 = array('keep negotiating and never consider war as a legitimate option'
			,'take care of themselves as best as they know how'
			,'keep talking to their opponents even when they are fighting a violent war with them.'
			,'accept the limitations of negotiations and move on to fight their corner, by any means necessary'
			,'I’m unsure');
$item2 = array('keep a healthy distance from our neighbours'
 			,'don’t try and understand enough the views of those with whom we most disagree'
 			,'keep a healthy distance from our opponents but stay close to our friends'
 			,'don’t talk enough with those with whom we disagree'
 			,'I’m unsure');
$item3 = array('offers us all hope for a better future'
			,'is the worst choice America could have chosen for itself and the world'
			,'is mad and dangerous'
			,'is no worse or better than any other politician'
			,'I’m unsure');
$item4 = array('should be a matter for parents to decide, and not the government'
			,'should be guaranteed only up to the age of sixteen, since after that it has questionable value'
			,'should include free higher education up to the age of twenty-one'
			,'is a continuous process and should be available at no cost for all our lives'
			,'is less important than free medical care'
			,'I’m unsure');

$item5 = array('as low as possible'
			,'set at a fixed rate which is the same for everyone'
			,'progressively higher as we earn more'
			,'as high as possible on the rich'
			,'just accepted as they are'
			,'I’m unsure');
$item6 = array('should be a human right in any country from cradle to grave, whatever your wealth'
			,'is already provided by the best system in the world'
			,'Is a luxury that we can no longer afford'
			,'should be provided by way of a privatised health service'
			,'should not be provided to those who choose to smoke heavily'
			,'should only be provided to the poor'
			,'I’m unsure');
$item7 = array('is a huge threat to our future survival and largely caused by mankind'
			,'is potentially dangerous, but for now is not a serious problem'
			,'may not be the result of human activity, but still poses a threat'
			,'is an invention of those with vested interests'
			,'is a myth because I can personally testify that the world is actually getting colder'
			,'I’m unsure');
$item8 = array('is incredibly dangerous and should never be employed'
			,'has been proven to be very safe'
			,'shouldn’t be used unless it becomes much cheaper'
			,'offers a miraculous opportunity to create almost unlimited electricity for nearly nothing'
			,'is not without its dangers but is a vital part of the fight against global warming'
			,'I am unsure');
$item9 = array('have proven to be very safe'
			,'will always be very dangerous to our biosphere and should be banned everywhere'
			,'could provide high quality food for everyone and end famine forever'
			,'should be subject to further cautious experimentation before being made available to everyone'
			,'is in the hands of large companies who are controlling the debate'
			,'I am unsure');
$item10 = array('should only be available for a limited time after someone loses their job'
			,'should be available only for those with dependent children'
			,'should not exist because nobody owes anyone anything'
			,'should always be available as a safety net for anyone unable to properly look after themselves'
			,'should be just for the unemployed who can prove that they are trying their hardest to find a job'
			,'I’m unsure');
$item11 = array('are that way by choice'
			,'are mostly mentally ill'
			,'are that way because they can’t afford housing'
			,'should just get themselves a job'
			,'should be provided with adequate housing and support'
			,'I’m unsure');
$item12 = array('cut taxes because it’s our money'
			,'restore services that were cut and fund new initiatives'
			,'save the surplus for a rainy day'
			,'cut taxes and improve services a little'
			,'I’m unsure');

//FieldName : Question : tagPercent(:Y)      (:) Separator
$QuestionArr = array( 'conflictCountries:1.) When in conflict, all countries in conflict should:' => $item1
                    , 'asSocietyWe:2.) As a society we:' => $item2
                    , 'presidentTrump:3.) President Trump:' => $item3
                    , 'education:4.) Education:' => $item4
                    , 'taxesShouldBe:5.) Taxes should be:' => $item5
                    , 'guaranteedHealthcare:6.) Guaranteed healthcare:' => $item6
                    , 'globalWarming:7.) Global Warming:' => $item7
                    , 'nuclearEnergy:8.) Nuclear energy:' => $item8
                    , 'geneticallyModifiedCrops:9.) Genetically modified crops and foods:' => $item9
                    , 'financialSupportForTheUnemployed:10.) Financial support for the unemployed:' => $item10
                    , 'theHomeless:11.) The homeless:' => $item11
                    , 'governmentSuddenlyEarnsSurplus:12.) If the government suddenly earns a surplus, should we:' => $item12
                );
$pp = $db->getQuery(true);
$pp->select('COUNT(*)');
$pp->from($db->quoteName('jos_rsform_submissions'));
$pp->where($db->quoteName('FormId') . " = " . '61');
$db->setQuery($pp);
$pp_count = $db->loadResult();

$sp = $db->getQuery(true);
$sp->select('COUNT(*)');
$sp->from($db->quoteName('jos_rsform_submissions'));
$sp->where($db->quoteName('FormId') . " = " . '46');
$db->setQuery($sp);
$sp_count = $db->loadResult();

$pc = $db->getQuery(true);
$pc->select('COUNT(*)');
$pc->from($db->quoteName('jos_rsform_submissions'));
$pc->where($db->quoteName('FormId') . " = " . '3');
$db->setQuery($pc);
$pc_count = $db->loadResult();

$ec = $db->getQuery(true);
$ec->select('COUNT(*)');
$ec->from($db->quoteName('jos_rsform_submissions'));
$ec->where($db->quoteName('FormId') . " = " . '44');
$db->setQuery($ec);
$ec_count = $db->loadResult();

$hc = $db->getQuery(true);
$hc->select('COUNT(*)');
$hc->from($db->quoteName('jos_rsform_submissions'));
$hc->where($db->quoteName('FormId') . " = " . '48');
$db->setQuery($hc);
$hc_count = $db->loadResult();

$bi = $db->getQuery(true);
$bi->select('COUNT(*)');
$bi->from($db->quoteName('jos_rsform_submissions'));
$bi->where($db->quoteName('FormId') . " = " . '51');
$db->setQuery($bi);
$bi_count = $db->loadResult();

$st = $db->getQuery(true);
$st->select('COUNT(*)');
$st->from($db->quoteName('jos_rsform_submissions'));
$st->where($db->quoteName('FormId') . " = " . '52');
$db->setQuery($st);
$st_count = $db->loadResult();

//FRONT END
 
 
echo "<br>";
 
echo "<div class='answers-count'>";
 
echo "<div class='answers-count-nav'>";
echo "<ul>";
echo "<li><a href='http://escapetheecho.org/index.php?option=com_ete&view=backend'>Power & Politics</a><a href='http://escapetheecho.org/index.php?option=com_ete&view=pp_respondents'> ($pp_count)</a></li>";
echo "<li><a href='http://escapetheecho.org/index.php?option=com_ete&view=sportplay'>Sports & Play</a><a href='http://escapetheecho.org/index.php?option=com_ete&view=sp_respondents'> ($sp_count)</a></li>";
echo "<li><a href='http://escapetheecho.org/index.php?option=com_ete&view=politicscommunity'>Politics & Community</a><a href='http://escapetheecho.org/index.php?option=com_ete&view=pc_respondents'> ($pc_count)</a></li>";
echo "<li><a href='http://escapetheecho.org/index.php?option=com_ete&view=entertainmentculture'>Entertainment & Culture</a><a href='http://escapetheecho.org/index.php?option=com_ete&view=ec_respondents'> ($ec_count)</a></li>";
echo "<li><a href='http://escapetheecho.org/index.php?option=com_ete&view=homecommunity'>Home & Community</a><a href='http://escapetheecho.org/index.php?option=com_ete&view=hc_respondents'> ($hc_count)</a></li>";
echo "<li><a href='http://escapetheecho.org/index.php?option=com_ete&view=beliefsideas'>Beliefs & Ideas</a><a href='http://escapetheecho.org/index.php?option=com_ete&view=bi_respondents'> ($bi_count)</a></li>";
echo "<li><a href='http://escapetheecho.org/index.php?option=com_ete&view=sciencetechnology'>Science & Technology</a><a href='http://escapetheecho.org/index.php?option=com_ete&view=st_respondents'> ($st_count)</a></li>";
echo "</ul>";
echo "<br>";
 
echo "</div>";
 
echo "<h3 style='display:inline;'>Quiz Title: </h3> Politics & Community";
 
echo "</div>"; 
 
echo "<div class='pd-holder'>
 
<br> 
 
<table class='answers-count-holder' style='width: 100%;'>
 
<tbody>
 
<tr class='table-head'>
 
<td><strong>Questions</strong></td>
 
<td><strong>Answers</strong></td>
 
<td><strong>Counts</strong></td>
 
</tr>";
 
 
foreach($QuestionArr as $x => $x_value) { 
        $explode 	= explode(':',$x ); 
        $fieldName 	= $explode[0]; 
        $question   = $explode[1];      
        $tagPercent = $explode[2];
 
        $totalRecords = getCount($db,  $fieldName, 'GETALLRECORDS');
 
        $flag = true;
 
    foreach ($x_value as $value) {

    	$count = getCount($db, $fieldName ,$value);

    	if($tagPercent == 'Y'){ //Display Percent 
            $percent = ($count / $totalRecords) * 100; 
            $displayCount = round($percent, 2).' %'; 
        }else{ 
        	$displayCount = $count; 
        }
 
	    if($flag ){ //for display of Question
	 
	    	echo "<tr><td>".$question ." (".$totalRecords.")</td><td> $value </td> <td> ".$displayCount."</td></tr>";  
	        $flag = false; 
	    }else{	 
	         echo "<tr><td></td><td> $value </td> <td> ".$displayCount."</td></tr>"; 	 
        }
   } 
}  
 
echo "</tbody> </table> </div>";

 

 

 


 

 

 
