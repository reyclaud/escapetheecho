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
    $countSql->where($db->quoteName('FormId') ." = ". '61');  
    
    if($v <> 'GETALLRECORDS'){
        $countSql->where($db->quoteName('FieldValue') ." LIKE ". "'%".$v."%'");  
    }
    $db->setQuery($countSql);
 
    $count = $db->loadResult();
    return $count;
}
 

$item1 = array('only chase power to steal from us','are unfairly abused because they all try their hardest at an impossible job','
get into politics with good intention but are corrupted by the system','I’m unsure');
$item2 = array('not at all','a medium amount','a lot');
$item3 = array('not at all','a medium amount','a lot');
$item4 = array('the politicians','big business and the banks','the media','we, the people','a few invisible people who we will never know','no one','
I’m unsure');
$item5 = array('bad politicians','the way we get our news','threat of dictatorship','low quality education','threat of war','spread of nuclear weapons','our energy running out','poor economy and lack of jobs','population growth','lack of clean drinking water','poverty and hunger','religious extremism','immigration','still unfinished wars','infectious diseases','terrorism','lack of religious faith','threat of alien invasion','climate change','refugees');
$item6 = array('run by an efficient and kindly dictator','democratically chosen by the people','I’m unsure');
$item7 = array('poor living in a democracy','rich living in a dictatorship','I’m unsure');
$item8 = array('no','yes','I’m unsure');
$item9 = array('yes','not necessarily','I’m unsure');
$item10 = array('is good for all countries','is bad because it creates a sense of superiority and often war','I’m unsure');
$item11 = array('despite its flaws is the only way to guarantee our freedoms','is made useless by big money and special interests','is the only way to protect against tyranny','only works if there is a well educated electorate','I’m unsure');
$item12 = array('Yes','No','I’m unsure');
$item13 = array('a democracy','a dictatorship');
$item14 = array('Donald Trump','Xi Jinpiang','Vladimir Putin','Angela Merkel','Theresa May','Kim Jong Un','Barack Obama','I’m unsure');
$item15 = array('keeps growing','is getting smaller','remains the same','I’m unsure');
$item16 = array('is getting better','is getting worse','remains the same','I’m unsure');
$item17 = array('socialism','capitalism');
$item18 = array('is a good because it makes us more enterprising and innovative','is wrong because it makes most of us miserable and anxious','I’m unsure');
$item19 = array('is good for most people because we get better quality for less cost','is bad because it just results in jobs being lost to countries with lower wages','I’m unsure');
$item20 = array('has to be restricted as much as possible','should ideally be allowed for everyone to anywhere','is extremely costly for those already in','the country','is actually good for the economy','I’m unsure');
$item21 = array('yes, if their life is at risk','realistically no.  Our duty is to first protect those already here','I’m unsure');
$item22 = array('allows us to all better understand each other and enjoy our diversity','is ‘political correctness’ that devalues the importance of our','own culture','I’m unsure');
$item23 = array('should be stopped entirely before it bankrupts us','is reason for us all to be proud because it so helps the poorest of the poor','should be cut back to one percent of our national income','I’m unsure');
$item24 = array('is totally out of control and public spending has to be slashed','is exaggerated to justify cutting social services for the poor','I’m unsure');
$item25 = array('obviously','realistically no','I’m unsure');
$item26 = array('should be the same for everyone','should go up when we earn more','should be as high as possible on the rich','should also be low for the rich to encourage new investment','I’m unsure');
$item27 = array('shouldn’t exist because nobody owes anyone anything','must be available for those who can’t cope properly','should only be for those who are trying their hardest to find a job','should be stopped because it encourages laziness','I’m unsure');
$item28 = array('conservative','liberal');
$item29 = array('are about protecting us from discrimination','are about protecting us from government interference','I’m unsure');
$item30 = array('is to be able to say what you want','is to pay no tax','is to be able to do what you want (without hurting others)','I’m unsure');
$item31 = array('should never be allowed','has to be possible if they think you’re a terrorist','I’m unsure');
$item32 = array('is our last protection against tyrannical government','has become a meaningless right that just causes death and destruction','I’m unsure');
$item33 = array('have a moral responsibility to prevent genocide wherever it might occur','should never interfere in the domestic affairs of another country','I’m unsure');
$item34 = array('is the fault of the Israelis','is the fault of the Palestinians','will never solve itself unless other countries push them to agree','I’m unsure');
$item35 = array('keep negotiating and never consider war','accept the limitations of negotiations and use force when they breakdown','keep talking to their enemies even when they are fighting a war with them','I’m unsure');
$item36 = array('is so incredibly dangerous that it should never be used','offers a chance to create almost unlimited electricity for nearly nothing, without causing climate change','I’m unsure');
$item37 = array('is totally out of control and it’s what’s really behind climate change and most wars','is no longer the problem that it once was','I’m unsure');
$item38 = array('humans never landed on the moon','the 9/11 attacks on the World Trade Center was an inside job by the Bush family','Barack Obama is an African born Muslim','vaccines are useless and just a way of keeping drug companies rich','aliens have already landed on earth','none of the above are true','I’m unsure');






//FieldName : Question : tagPercent(:Y)      (:) Separator
$QuestionArr = array( 'Politicians:1.) Politicians:' => $item1
                    , 'Q1:2.) How much do you follow the politics of the country ?:Y' => $item2
                    , 'Q2:3.) How much do you follow international politics ?:Y' => $item3
                    , 'MostlyControlledBy:4.) The world is mostly controlled by ?:' => $item4
                    , 'Q3:5.) these global challenges into the box below in order of size and importance:' => $item5
                    , 'TypeOfGovernment:6.) The best type of government is:' => $item6
                    , 'YouPreferTo:7.) Would you prefer to be:' => $item7
                    , 'PowerForTheGreaterGood :8.) Should all countries share some power for the greater good ?:' => $item8
                    , 'Governments:9.) Should all governments be separate from all religions ?:' => $item9
                    , 'Nationalism:10.) Nationalism:' => $item10
                    , 'Democracy:11.) Democracy:' => $item11
                    , 'VoteOnEveryIssue:12.) Now that we all have the internet should we be able to vote on every issue ?:' => $item12
                    , 'DemocracyOrDictatorship:13.) Do you live more in a democracy or a dictatorship ?:' => $item13
                    , 'GoodLeader:14.) Which of the following is a good leader ?:' => $item14
                    , 'TheRichAndPoor:15.) The gap between the rich and poor ?:' => $item15
                    , 'WorldStandardOfLiving:16.) The world’s standard of living:' => $item16
                    , 'SocialismAndCapitalism :17.) If socialism wants everything to be divided equally and capitalism wants the hardest workers to get the greatest rewards;<br/>where do you think we should be?:' => $item17
                    , 'CompetitionForMoney:18.) Competition for money:' => $item18
                    , 'FreeTrade:19.) The free trade of goods and services in the world:' => $item19
                    , 'Immigration:20.) Immigration:' => $item20
                    , 'FleeingAWarZone:21.) Do we have a moral duty to accept any refugee fleeing a war zone ?:' => $item21
                    , 'Multiculturalism:22.) Multiculturalism:' => $item22
                    , 'ForeignAid:23.) Foreign aid:' => $item23
                    , 'TheCountryDebt:24.) The country’s debt:' => $item24
                    , 'LifeHaveEqualValue:25.) Should every life have equal value ?:' => $item25
                    , 'Taxes:26.) Taxes:' => $item26
                    , 'FinancialSupport:27.) Financial support for the jobless:' => $item27
                    , 'ConservativeAndLiberal:28.) If liberals think we should be allowed to do anything that doesn’t hurt others and conservatives think we should not change our ‘traditional values’ relating to sex and family; <br/>we should be more:' => $item28
                    , 'CivilRights:29.) Civil rights:' => $item29
                    , 'Freedom:30.) Freedom:' => $item30
                    , 'GovernmentSurveillance:31.) Government surveillance of our email and phone calls:' => $item31
                    , 'RightToHaveGun:32.) The right to have gun:' => $item32
                    , 'AllCountries:33.) All countries:' => $item33
                    , 'IsraelisAndPalestinians:34.) The conflict between the Israelis and the Palestinians:' => $item34
                    , 'WhenInConflict:35.) When in conflict, all countries should:' => $item35
                    , 'NuclearEnergy:36.) Nuclear energy:' => $item36
                    , 'WorldsPopulation:37.) The growth of the world’s population:' => $item37
                    , 'TheFollowingAreTrue :38.) Which if any of the following are true:' => $item38
                                  
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
 
echo "<h3 style='display:inline;'>Quiz Title: </h3> Power & Politics";
 
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
        $explode    = explode(':',$x ); 
        $fieldName  = $explode[0]; 
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
     
            echo "<tr><td>".$question ." (".$totalRecords.") </td><td> $value </td> <td> ".$displayCount."</td></tr>";  
            $flag = false; 
        }else{   
             echo "<tr><td></td><td> $value </td> <td> ".$displayCount."</td></tr>";     
        }
   } 
}  
 
echo "</tbody> </table> </div>";