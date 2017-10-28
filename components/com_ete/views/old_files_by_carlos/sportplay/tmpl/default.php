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
    $countSql->where($db->quoteName('FormId') ." = ". '46');  
 	
 	if($v <> 'GETALLRECORDS'){
     	$countSql->where($db->quoteName('FieldValue') ." LIKE ". "'%".$v."%'");  
	}
	$db->setQuery($countSql);
 
	$count = $db->loadResult();
	return $count;
}
 

$item1 = array('not at all'
			,'hugely');
$item2 = array('I agree'
			,'I disagree'
			,'I’m unsure');
$item3 = array('usually lets you see more than watching it in real life'
			,'can never be as exciting as watching it in real life'
			,'I’m unsure');
$item4 = array('is understandable because your team is like your religion'
			,'is bad manners and unsporting'
			,'I’m unsure');
$item5 = array('true'
			,'untrue'
			,'I’m unsure');
$item6 = array('should never mix'
			,'will always overlap'
			,'I’m unsure');
$item7 = array('because they have the best fans'
			,'because they are rich enough to buy up the best players'
			,'I’m unsure');
$item8 = array('improves its quality'
			,'just makes it all about money rather than better performance'
			,'gives it more publicity and public recognition'
			,'results in it becoming more expensive and often corrupt'
			,'I’m unsure');
$item9 = array('can inspire excellence and more participation'
			,'can give poor kids false expectations'
			,'are role models who need to behave themselves at all times'
			,'are just entertainers who usually take themselves too seriously'
			,'I’m unsure');
$item10 = array('because we live in an age of sexual equality'
			,'only if their fans are prepared to pay the same to watch them'
			,'I’m unsure');
$item11 = array('has been a flourishing part of our history for thousands of years'
			,'is unfair because the horses are forced to race'
			,'is practiced kindly because the owners need their horses to be happy to be fast'
			,'is wrong because the horses get whipped, injured, and sometimes even put down'
			,'I’m unsure');
$item12 = array('should be banned'
			,'should be accepted as parts of mankind’s cultural heritage'
			,'I’m unsure');
$item13 = array('are about killing not sport'
			,'is misunderstood by city dwellers who don’t understand the realities of rural life'
			,'is for the wealthy and bloody thirsty'
			,'are vital for farmers to control vermin and stock'
			,'I’m unsure');
$item14 = array('incites violence in everyday life'
			,'satisfies people’s violent urges and so actually helps keep the peace'
			,'is not so different to watching a public hanging for entertainment'
			,'is about appreciating athletic skill rather than violence'
			,'I’m unsure');
$item15 = array('are worth every penny'
			,'have become a colossal waste of money'
			,'inspire the whole world to connect'
			,'just make us more tribal and divided than ever'
			,'I’m unsure');
$item16 = array('true'
			,'untrue'
			,'I’m unsure');
$item17 = array('of course, they’re highly competitive and exercise the brain like nothing else'
			,'of course not, you might as well allow in poker and computer games'
			,'I’m unsure');
$item18 = array('are used for competitive advantage in all sports'
			,'are now only a problem in a few sports like cycling'
			,'are a bigger problem than ever because there’s so much more money in sport'
			,'is a problem exaggerated by the media if only because it makes a good story'
			,'I’m unsure');
$item19 = array('can make even a boring sport fun to watch'
			,'inevitably causes some sports to be ‘fixed’ in advance'
			,'I’m unsure');
$item20 = array('is constantly creating better technologies for everyone’s benefit'
			,'is a devious loophole to avoid advertising restrictions'
			,'is all about brilliant drivers bravely risking their lives'
			,'sets a terrible example for a world trying to fight pollution'
			,'I’m unsure');
$item21 = array('correct. Not working is a human right and ‘switching off’ is our greatest pleasure'
			,'wrong.  Life’s purpose is to work hard and play hard'
			,'I’m unsure');

//FieldName : Question : tagPercent(:Y)      (:) Separator
$QuestionArr = array( 'CareAboutSport:1.) How much do you care about sport ?:' => $item1
                    , 'WatchingSportAndPlay:2.) Watching sport is less sweaty and much more fun than having to play it yourself:' => $item2
                    , 'WatchingYourTeam:3.) Watching your team on TV:' => $item3
                    , 'SupportingYourTeam:4.) Supporting your team rather than the ‘best’ team:' => $item4
                    , 'YogaOrgoingToTheGym:5.) Yoga or going to the gym aren’t sports because they’re not competitive:' => $item5
                    , 'SportAndPolitics:6.) Sport and politics:' => $item6
                    , 'TheSameTeamsWin:7.) The same teams always win:' => $item7
                    , 'SportProfessional:8.) Making a sport professional:' => $item8
                    , 'SportStars:9.) Sport Stars:' => $item9
                    , 'FemaleShouldBe:10.) Female sports stars should be paid the same as male ones:' => $item10
                    , 'HorseRacing:11.) Horse racing:' => $item11
                    , 'BloodSports:12.) ‘Blood sports’ like fox hunting and bull-fighting:' => $item12
					, 'HuntingAndFishing:13.) Hunting and fishing:' => $item13
					, 'ContactSports:14.) Watching ‘contact’ sports like boxing and wrestling:' => $item14
					, 'TheOlympics:15.) The Olympics:' => $item15
					, 'SkatingAndSynchronisedSwimming:16.) Figure skating and synchronised swimming are types of art rather than sport:' => $item16
					, 'ChessAndBridge:17.) Should chess and bridge be in the Olympics ?:' => $item17
					, 'Drugs:18.) Drugs:' => $item18
					, 'Gambling:19.) Gambling:' => $item19
					, 'MotorRacing:20.) Motor Racing:' => $item20
					, 'MankindsFinestPastime:21.) Mankind’s finest pastime is to do absolutely nothing on the beach:' => $item21 
                );	
//FRONT END

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
 
echo "<h3 style='display:inline;'>Quiz Title: </h3> Sports & Play";
 
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
