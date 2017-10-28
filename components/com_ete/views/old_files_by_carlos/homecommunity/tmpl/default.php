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
    $countSql->where($db->quoteName('FormId') ." = ". '48');  
 	
 	if($v <> 'GETALLRECORDS'){
     	$countSql->where($db->quoteName('FieldValue') ." LIKE ". "'%".$v."%'");  
	}
	$db->setQuery($countSql);
 
	$count = $db->loadResult();
	return $count;
}
 

$item1 = array('are more superficial than before because of social media'
			,'are as strong today as they have always been'
			,'I’m unsure');
$item2 = array('takes all the romance out of the dating process'
			,'saves so much time and hassle'
			,'is so easy that it causes promiscuity'
			,'avoids all the pointless embarrassment of old fashioned dating'
			,'I’m unsure');
$item3 = array('are as strong and as united as they have ever been'
			,'are constantly breaking apart due to the stresses of modern life'
			,'I’m unsure');
$item4 = array('1','2','3','4','5','6','7','8','9','10');
$item5 = array('don’t last as long as they used out of disrespect for their value'
			,'are more popular than they have ever been'
			,'I’m unsure');
$item6 = array('those resulting from two people falling in love'
			,'those ‘arranged’ by relatives'
			,'open’ ones where both partners agree to allow sexual relations with others'
			,'I’m unsure');
$item7 = array('have become much too easy to get'
			,'should become easier to obtain to limit the trauma to both parties, and their families'
			,'I’m unsure');
$item8 = array('should be legal and a matter of personal choice'
			,'should be stopped because marriage should only be between a man and a woman'
			,'I’m unsure');
$item9 = array('have allowed families to magically stay in touch -  wherever they are in the world'
			,'have damaged normal family face-to-face communications'
			,'I’m unsure');
$item10 = array('1','2','3','4','5','6','7','8','9','10');
$item11 = array('are fine so long as both partners are adults'
			,'usually quickly end'
			,'can teach both partners a lot'
			,'are difficult for bringing up children'
			,'I’m unsure');
$item12 = array('should be discouraged by any means necessary, because children can’t properly bring up children'
			,'can work well so long as the parents stay together and have enough money'
			,'I’m unsure ');
$item13 = array('someone married to the a member of the opposite sex'
			,'just anyone who adores children, whatever their sexuality or marital status might be'
			,'I’m unsure');
$item14 = array('they should have access to high quality affordable daycare'
			,'at least one of them should quit their job'
			,'I’m unsure');
$item15 = array('the mother should get paid leave from work'
			,'both parents should get paid leave from work'
			,'neither parent should get paid leave, they knew what was coming'
			,'I’m unsure');
$item16 = array('the parents','the school');
$item17 = array('worse','better');
$item18 = array('should be free and provide equal opportunity for all'
			,'should all be made private to generate more competition and quality'
			,'just need to work well for children, it’s irrelevant if they are publicly or privately run'
			,'I’m unsure');
$item19 = array('to be more ambitious and to fight for their dreams'
			,'that life is unfair. and some will be lucky while some will be cruelly unlucky'
			,'I’m unsure');
$item20 = array('always try our hardest to improve ourselves'
			,'learn to be accept what we have'
			,'I’m unsure');
$item21 = array('they should be forced to do some sort of community or military ‘national service’'
			,'they should be free to do what they want, like all other adults'
			,'I’m unsure');
$item22 = array('very wealthy','comfortable enough','very poor');
$item23 = array('a lot','not at all');
$item24 = array('an extra year of life','a million dollars','I’m unsure');
$item25 = array('a more equal society that was poorer'
			,'a less equal society where there is a greater chance of becoming very rich'
			,'I’m unsure');
$item26 = array('Yes','No','I’m unsure');
$item27 = array('choose to live on the streets'
			,'would choose conventional housing but cannot afford it'
			,'should get themselves a job'
			,'should be provided with adequate housing and support'
			,'I’m not sure');
$item28 = array('the right not to be used for experiments'
			,'the right not to be eaten'
			,'the right not be put in a zoo'
			,'none of the above ‘rights’ because they just aren’t practical'
			,'I’m unsure');
$item29 = array('we should be supported by the government to live and die in our own homes'
			,'we we should be looked after by our families'
			,'I’m unsure');
$item30 = array('to our nearest and dearest relatives'
			,'to the most needy (wherever they are in the world)');
$item31 = array('are not chosen by us so we shouldn’t feel obliged to stay with them'
			,'gave us life, so we owe them everything'
			,'I’m not sure');
$item32 = array('to live long and comfortably','to live short and blissfully');
$item33 = array('Yes','No','I’m unsure');
$item34 = array('very wealthy','comfortable enough','very poor');
$item35 = array('age','race','nationality','religion','sex','good looks','disability','Intelligence','I’m unsure');

//FieldName : Question : tagPercent(:Y)      (:) Separator
$QuestionArr = array( 'friendships:1.) Friendships:' => $item1
                    , 'OnlineDating:2.) Online Dating:' => $item2
                    , 'families:3.) Families:' => $item3	
                    , 'TopofTheLadder:4.) Imagine the top of the ladder above represents the best possible life for your family and friends and the bottom of the ladder represents the worst.<br/> <strong>On which step of the ladder would you say they stand at this time ?</strong>:' => $item4
                    , 'Marriages:5.) Marriages:' => $item5
                    , 'whichIsLongest:6.) Which of the following types of marriage last the longest ?:' => $item6
                    , 'Divorces:7.) Divorces:' => $item7
                    , 'GayMarriage:8.) Gay marriage:' => $item8
                    , 'computersAndPhones:9.) Computers and phones:' => $item9
                    , 'OnWhochStepAreyouthistime:10.) On which step of the ladder would you say your family stand at this time ?:' => $item10
                    , 'RelationshipsWithLargeDifferencesOfAge:11.) Relationships with large differences of age:' => $item11
                    , 'TeenageParenthood:12.) Teenage parenthood:' => $item12
                    , 'TheBestTypeOfParent:13.) The best type of parent is :' => $item13
                    , 'ifParentsAreTooBusyWorkingtolookAfterTheirChildren:14.) If parents are too busy working to look after their children:' => $item14
                    , 'BabyisBorn:15.) When a baby is born:' => $item15
                    , 'ResponsibleForChildEducation:16.) Who is most responsible for a child’s education ?:' => $item16
                    , 'EducatedTodayThanBefore:17.) Are children better educated today than before ?:' => $item17
                    , 'Schools:18.) Schools:' => $item18
                    , 'ChildrenShouldBeTaught:19.)  Children should be taught :' => $item19
                    , 'WeShouldAll:20.) We should all, at any age :' => $item20
                    , 'ChildrenReachAdulthood:21.) When children reach adulthood:' => $item21
                    , 'DoYouThinkOfYourFamilyAsBeing:22.) Do you think of your family as being:' => $item22
                    , 'WantToBeRich:23.) How much do you want to be rich ?:' => $item23
                    , 'ExtraYearOfLifeOrAMillionDollars:24.) Would you prefer an extra year of life, or a million dollars ?:' => $item24
                    , 'HappierLivingIn:25.) Would you be happier living in:' => $item25
                    , 'HaveAHome:26.) Should everyone have a home, as a human right ?:' => $item26
                    , 'HomelessPeople:27.) Homeless people:' => $item27
                    , 'AllAnimalsShouldHave:28.) Like our pets, all animals should have:' => $item28
                    , 'GetOld:29.) When we get old:' => $item29
                    , 'WhenWeDie:30.) When we die we should leave what we have:' => $item30
                    , 'OurFamilies:31.) Our families:' => $item31
                    , 'WhichIsBetter:32.) Which is better ?:' => $item32
                    , 'BoyOrGirl:33.) Should parents be able to decide if their baby will be a boy or girl ?:' => $item33
                    , 'ThinkOf YourselfAs:34.) Do you think of yourself as:' => $item34
                    , 'FairGrounds:35.) Which of the following are fair grounds to discriminate in favour of someone ? :' => $item35
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
 
echo "<h3 style='display:inline;'>Quiz Title: </h3> Home & Community";
 
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
