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
    $countSql->where($db->quoteName('FormId') ." = ". '51');  
 	
 	if($v <> 'GETALLRECORDS'){
     	$countSql->where($db->quoteName('FieldValue') ." LIKE ". "'%".$v."%'");  
	}
	$db->setQuery($countSql);
 
	$count = $db->loadResult();
	return $count;
}
 

$item1 = array('yes'
			,'no'
			,'I’m unsure');
$item2 = array('yes'
			,'no'
			,'I’m unsure');
$item3 = array('of course, but if we believe something is truly important we’re of course morally bound to try to convert all others to our belief'
			,'no way ! That’s the way to start a fight if not a war'
			,'yes, but only to better understand them; never to try and convert them to our thinking'
			,'I’m unsure');
$item4 = array('your genes'
			,'your family upbringing '
			,'your friends'
			,'wider society'
			,'your own free will'
			,'I’m unsure');
$item5 = array('is what keeps us stuck and unable to improve ourselves'
			,'is what protects us from oncoming danger'
			,'I’m unsure');
$item6 = array('a lot more happy'
			,'about the same'
			,'a lot less happy');
$item7 = array('1'
			,'2'
			,'3'
			,'4'
			,'5'
			,'6'
			,'7'
			,'8'
			,'9'
			,'10');
$item8 = array('yes'
			,'no'
			,'I am unsure');
$item9 = array('age'
			,'race'
			,'nationality'
			,'religion'
			,'sex'
			,'good looks'
			,'disability'
			,'intelligence'
			,'I am unsure');
$item10 = array('a person’s race'
			,'a person’s nationality'
			,'a person’s religion'
			,'a person’s sex'
			,'a person’s sexuality'
			,'a person’s religion'
			,'all of the above'
			,'none of the above'
			,'I’m unsure');
$item11 = array('is to follow God’s calling'
			,'is to follow your passion'
			,'is to help others'
			,'is to help our species survive by rearing children better than ourselves'
			,'will always be a mystery,  presuming it has a purpose'
			,'none of the above'
			,'I’m unsure');
$item12 = array('we don’t'
			,'if you kick yourself hard you’ll wake up'
			,'it is a dream, in as much as we imagine and create it for ourselves'
			,'I’m unsure');
$item13 = array('is the way for everyone to be happy and all wars to end'
			,'is guaranteed to only cause depravity and self-centred misery'
			,'I’m unsure');
$item14 = array('to instantly change our feelings'
			,'since it has no earthly purpose, only to prove our spiritual existence'
			,'I’m unsure');
$item15 = array('atheism'
			,'christianity'
			,'islam'
			,'judaism'
			,'hinduism'
			,'I’m unsure');
$item16 = array('is something that all of us should at least try once'
			,'has caused more suffering in the world than good'
			,'has improved our morality more than it has corrupted us'
			,'I’m unsure');
$item17 = array('is a people free and liberated'
			,'is a people lost and miserable'
			,'I’m unsure');
$item18 = array('absolutely not - the state should always be separate from the spiritual'
			,'of course,  good leadership must always follow the will of God'
			,'it’s unavoidable,  religions effect ever political decision, and start most wars'
			,'I’m unsure');
$item19 = array('crucifix'
			,'hijab'
			,'skull cap'
			,'star of David'
			,'bindi'
			,'monk robes'
			,'burkha'
			,'I’m unsure');
$item20 = array('is a force of peace and love'
			,'has become a force of evil'
			,'shares very similar roots and morals to Judaism and Christianity'
			,'is no worse or better than any other religion'
			,'I’m unsure');
$item21 = array('is the greatest writer that the world has ever known'
			,'is overrated'
			,'I’m unsure');
$item22 = array('is only for the wealthy elite'
			,'is more satisfying than anything you can see on a screen'
			,'is usually boring and over long'
			,'is as relevant today as it’s ever been'
			,'I’m unsure');
$item23 = array('are the art form of the future, and getting better all the time'
			,'will never be equal to a good film or book'
			,'I’m unsure');
$item24 = array('is a brilliant way to connect with nature'
			,'is as boring as it is muddy'
			,'should be taught in all schools'
			,'is a waste of time when farms are so much better at growing food and plants'
			,'I’m unsure');
$item25 = array('there is none'
			,'erotica is beautiful while porn is sexy'
			,'erotica is harmless while porn makes you feel dirty'
			,'I’m unsure');
$item26 = array('is the key ingredient of any social occasion'
			,'is just fuel to do other things'
			,'should be savoured with love and great company'
			,'can too easily become a dangerous addiction'
			,'I’m unsure');
$item27 = array('is a disgusting idea'
			,'should at least be tried out of curiosity, like all foods'
			,'I’m unsure');
$item28 = array('is a sport for the lazy trying to escape their families'
			,'is a marvellous way of relaxing and reflecting'
			,'is only for those who don’t care about animal suffering'
			,'isn’t cruel because fish don’t feel pain'
			,'I’m unsure');
$item29 = array('is great because it brings out your survival skills'
			,'makes no sense sense when you have a nice comfortable home'
			,'I’m unsure');
$item30 = array('helps us appreciate different cultures, including our own'
			,'adds hugely to our global warming crisis'
			,'create millions of jobs'
			,'damages local traditional cultures'
			,'I’m unsure');


//FieldName : Question : tagPercent(:Y)      (:) Separator
$QuestionArr = array( 'LessOpenToNewIdeas:1.) Do you become less open to new ideas as you get older ?:' => $item1
                    , 'BeliefsAboutPoliticsorReligion:2.) Have you changed your belief about anything major over the last year, such as your politics or religion ?:' => $item2
                    , 'TalkAndDebateMore:3.) Should we talk and debate more with those with whom we most disagree ?:' => $item3
                    , 'PersonalityIsMostlyShapedBy:4.)  Your personality is mostly shaped by:' => $item4
                    , 'Fear:5.) Fear:' => $item5
                    , 'HowHappyAreYou:6.) Normally, how happy are you compared to most people ?:' => $item6
                    , 'StepsOfTheLadder:7.) Imagine the top of the ladder above represents the best possible life for you and the bottom of the ladder represents the worst possible life for you. On which step of the ladder would you say you stand at this time ?:' => $item7
                    , 'PrejudicedTowardsARace:8.) Is everyone prejudiced towards a race or nationality, or religion or sex ?:' => $item8
                    , 'FairGroundsToDiscriminate:9.) Which of the following are fair grounds to discriminate in favour of someone ?:' => $item9
                    , 'AlrightToTellJokes:10.) About which of the following is it alright to tell jokes ?:' => $item10
                    , 'OurPurposeInLife:11.) Our purpose in life:' => $item11
                    , 'LifeIsnotJustADream:12.) How do we know that life isn’t just a dream ?:' => $item12
					, 'HedonismOrThePleasure:13.) Hedonism, or the pursuit of pleasure:' => $item13
					, 'Music:14.) Why do we have music ?:' => $item14
					, 'Faiths:15.) Which of the following faiths is best suited to our modern times ?:' => $item15
					, 'Religion:16.) Religion:' => $item16
					, 'APeopleNoLongerFear:17.) A people no longer fearful of any God:' => $item17
					, 'InfluencedByReligion:18.) Should a government be influenced by religion:' => $item18
					, 'BannedInPublic:19.) Should any of the following types of religious attire be banned in public  ?:' => $item19
					, 'Islam:20.) Islam:' => $item20
					, 'Shakespeare:21.) Shakespeare:' => $item21
					, 'LiveTheatreBalletAndOpera:22.) Live theatre, ballet and opera:' => $item22
					, 'VideoGames:23.) Video games:' => $item23
					, 'Gardening:24.) Gardening:' => $item24
					, 'eroticaAndPornogaphy:25.) What is the difference between erotica and pornography ?:' => $item25
    				, 'Food:26.) Food:' => $item26            
					, 'EatingInsects:27.) Eating insects:' => $item27   
					, 'Fishing:28.) Fishing:' => $item28 
					, 'CampingInATent:29.) Camping in the wild in a tent:' => $item29 
					, 'TravellingAbroad:30.) Travelling abroad:' => $item30 
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
 
echo "<h3 style='display:inline;'>Quiz Title: </h3> Beliefs & Ideas";
 
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
