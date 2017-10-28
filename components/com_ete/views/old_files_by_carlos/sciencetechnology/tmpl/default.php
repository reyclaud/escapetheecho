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
    $countSql->where($db->quoteName('FormId') ." = ". '52');  
 	
 	if($v <> 'GETALLRECORDS'){
     	$countSql->where($db->quoteName('FieldValue') ." LIKE ". "'%".$v."%'");  
	}
	$db->setQuery($countSql);
 
	$count = $db->loadResult();
	return $count;
}
 

$item1 = array('not at all','totally');
$item2 = array('easier','more complicated');
$item3 = array('what’s ‘the Large Hadron Collider’ ?'
			,'which is an obscene amount on something we will never use, let alone understand'
			,'which is money truly well spent on discovering not least the ‘Higgs boson’ particle'
			,'I’m unsure');
$item4 = array('satisfy our curiosity about everything - for better or worse'
			,'keep a lot of scientists in jobs'
			,'rid the world of suffering'
			,'show that religion is nonsense'
			,'find out how we can delay our extinction'
			,'I’m unsure');
$item6 = array('are a great development that will save billions in transportation costs'
			,'will result in millions of lost jobs'
			,'will save lives by being much safer'
			,'will cause terrible accidents'
			,'I’m unsure');
$item7 = array('the occupants','the kids','I’m unsure');
$item8 = array('have changed not much','be electric','fly','I’m unsure');
$item10 = array('is vital so the human race has somewhere to survive if earth becomes uninhabitable'
			,'would be a horrific waste of resources best spent on the needs of this planet'
			,'I’m unsure');
$item11 = array('yes,  because the internet lets us work and socialise from home without causing any  environmental damage'
			,'no, we all need to travel more to appreciate how tiny and interconnected the world is'
			,'I’m unsure');
$item12 = array('yes,  because no one should have to work pointlessly'
			,'no, because when they take away all our jobs we will lose any sense of self-worth'
			,'I’m unsure');
$item13 = array('obviously, if only to pay for retraining or support for the new unemployed'
			,'no, that would just slow down the technology and prevent us from moving forward'
			,'I’m unsure');
$item14 = array('not for the long serving driver who has to slash his prices and earnings to compete'
			,'yes, so long as everyone is paying the same taxes'
			,'I’m unsure');
$item15 = array('yes, so they become better at detecting danger'
			,'no,  they’ll end up complaining all the time'
			,'I’m sure');
$item16 = array('no more than leaving them in the hands of potentially mad politicians'
			,'yes, because they could become too ‘intelligent’ and impossible to control'
			,'I’m unsure');
$item17 = array('yes, trespass is trespass and your privacy is sacred'
			,'not unless you want a gun fight with a neighbour'
			,'I’m unsure');
$item18 = array('result in far less deaths than conventional weapons'
			,'should be classed as a war-crime because they’re murderously unfair'
			,'I’m unsure');
$item19 = array('should be banned globally before they kill us all'
			,'have been proven to be incredibly effective by never having been used since 1945'
			,'I’m unsure');
$item20 = array('is so incredibly dangerous that it should never be used'
			,'offers a chance to create almost unlimited electricity for nearly nothing, without causing climate change'
			,'I’m unsure');
$item21 = array('can only be stopped if we all personally consume and waste much less'
			,'can and will be stopped via technological breakthroughs to come'
			,'I’m unsure');
$item22 = array('is much cleaner than alternatives like coal and has proven safe in other countries'
			,'contaminates the land and the water table and even causes earthquakes'
			,'I’m unsure');
$item23 = array('have damaged biodiversity, caused serious allergies and may trigger new diseases'
			,'have miraculously resulted in more nutritious crops grown with less pesticides that have prevented<br/>malnourishment and famine in the world’s poorest countries'
			,'I’m unsure');
$item24 = array('absolutely','no, they’re an invention of the computer industry, like ‘the millennium bug’ in 2000','I’m unsure');
$item25 = array('yes, who wants anyone reading their banking details or email ?'
			,'no, I have nothing to hide and choose not to be paranoid'
			,'I’m unsure');
$item26 = array('it’s only to keep us all safe.  It’s only a problem if you’ve got something to hide'
			,'it’s a dangerous violation of our privacy which could easily be used to control and dictate to us'
			,'I’m unsure');
$item27 = array('with the latest TVs being connected to the internet, this is indeed now possible'
			,'another ‘urban myth’ is proven to be total nonsense'
			,'I’m unsure');
$item28 = array('could also be used to bug and film a room'
			,'are convenient and energy efficient'
			,'leak radiation and can cause cancer'
			,'have proven to be perfectly safe like cell phones'
			,'I’m unsure');
$item29 = array('have allowed friends and families to magically stay in touch -  wherever they are in the world'
			,'have damaged normal face-to-face communication'
			,'I’m unsure');
$item30 = array('can now provide an excellent education to everyone wherever they are, whether or not they have a<br/>good teacher - any second of the day or night'
			,'have been shown to weaken focus and undermine children’s education'
			,'I’m unsure');
$item31 = array('have been shown to improve logic, problem solving and spatial perception'
			,'can be dangerously addictive and can even cause psychosis and violence'
			,'I’m unsure');
$item32 = array('is inhumane and can now be better done either using cell cultures in a laboratory or human subjects'
			,'has an irreplaceable role in the discovery of many life-saving medicines'
			,'I’m unsure');
$item33 = array('have wiped out horrific diseases like polio and are vital for everyone’s safety'
			,'can damage a child’s immune system and cause autism'
			,'I’m unsure');
$item35 = array('deaf','tall, or without dwarfism','gay','with a higher than average IQ'
			,'with or without a particular colour of hair or eyes','none of the above','I’m unsure');
$item36 = array('should be possible to enable parents without suitable eggs or sperm to have children,<br/>and allow others who’ve lost a child to redress their loss'
			,'would be a high risk procedure that would reduce a child’s uniqueness and value'
			,'I’m unsure');
$item37 = array('offers the incredible hope of amputees being able to get back lost limbs'
			,'are totally unethical to use since they would inevitably result in the harvesting<br/>of organs from those specifically bred to donate'
			,'I’m unsure');
$item38 = array('make us lazier,  as well as more exposed to outside surveillance and control'
			,'give us the option, when our brains begin to deteriorate, of a brain transplant'
			,'I’m unsure');
$item39 = array('yes, it’s already happening in some fields of medicine like cardiology'
			,'not in a significant sense; the body will always be more complex than any technology'
			,'I’m unsure');
$item40 = array('inevitably.  New technology will make you immortal if that’s really what you want to be'
			,'sadly not.  While life spans will increase enormously for the wealthy few, all of us have to die sooner or later'
			,'I’m unsure');
$item41 = array('constantly monitored to protect us all from killing ourselves and our planet'
			,'given more leeway because just as scientists are the first to discover problems<br/>they are also the first to solve them'
			,'I’m unsure');

$itemYNI = array('Yes','No','I’m unsure');

//FieldName : Question : tagPercent(:Y)      (:) Separator
$QuestionArr = array( 'TrustScientists:1.) How much do you trust scientists ?:' => $item1
                    , 'TechnologyMakesLife:2.) Technology makes life:' => $item2
                    , 'TheLargeHadronCollider:3.)  18 billion dollars has so far been spent on ‘the Large Hadron Collider’:' => $item3
                    , 'TruePurposeOfScience:4.) The true purpose of science is to:' => $item4
                    , 'CarWithoutADriver:5.) Are you prepared to be driven around in car without a driver ?:' => $itemYNI
                    , 'CarsAndTrucksThatDriveThemselves:6.) Cars and trucks that drive themselves - without drivers:' => $item6
                    , 'TheKidsOrTheOccupants:7.) When you’re travelling very fast in a ‘driverless’ car, a group of kids run in front of you. Should your car be programmed to first save your life or the kids’ lives ? :' => $item7
                    , 'By2050:8.) By 2050 most cars will :' => $item8
                    , 'PrepareToFlyWithoutAnOnboardPilot:9.) Are you prepare to fly in a computer-controlled plane without an onboard pilot ?:' => $itemYNI
                    , 'ColonisingMars:10.) Colonising Mars:' => $item10
                    , 'TravelLess:11.) Should we travel less ?:' => $item11
                    , 'DoneByARobot:12.) If something can be done better by a robot,  should it be done by a robot?:' => $item12
                    , 'IfRobotsTakeOurJobs:13.) If robots take our jobs shouldn’t they have to pay taxes ?:' => $item13
                    , 'TypeOfGigEconomyFair :14.) New software allows anyone with a car and driving license to instantly do a ‘gig’ as a taxi driver. ​ Is this type type of ‘gig’ economy fair ? :' => $item14
                    , 'ShouldRobotsBeDesignedToFeelPain:15.) Should robots be designed to feel pain ?:' => $item15
                    , 'TooRiskyToLeaveRobots:16.)  Is it too risky to leave robots in charge of deadly weapons ?:' => $item16
                    , 'DroneFlies:17.) If a drone flies over your home without your permission, should you be allowed to shoot it down ?:' => $item17
                    , 'DronesUsedForTheAssasination:18.) Drones used for the assasination of your political opponents:' => $item18
                    , 'NuclearWeapons:19.) Nuclear weapons:' => $item19
                    , 'NuclearEnergy:20.) Nuclear energy:' => $item20
                    , 'ClimateChange:21.) Climate change:' => $item21
                    , 'FrackingForShaleGas:22.) ‘Fracking’ for shale gas:' => $item22
                    , 'Genetically Modified:23.)  ‘GM’ (Genetically Modified) crops and foods:' => $item23
                    , 'CyberAttacks:24.) Are ‘cyber-attacks’ a genuine threat to national and global security ?:' => $item24
                    , 'PersonalThreatToYou:25.) Are ‘cyber-attacks’ a personal threat to you ?:' => $item25
                    , 'TheGovernmentHasAccess:26.) If the government has access to our email and phone calls:' => $item26
                    , 'CouldSomeoneUseYourTV:27.) Could someone use your TV to film you and everyone looking at it ?:' => $item27
                    , 'MicrowaveOvens:28.) Microwave ovens:' => $item28
                    , 'ComputersAndCellPhones:29.) Computers and cell phones :' => $item29
                    , 'CompAndCellPhones:30.) Computers and cell phones:' => $item33
                    , 'ComputerGames:31.) Computer games:' => $item31
                    , 'UsingAnimalsForScientificTesting:32.) Using animals for scientific testing:' => $item32
                    , 'Vaccinations:33.) Vaccinations:' => $item33
                    , 'ChooseTheSexOfTheirBaby:34.) Should parents be allowed to choose the sex of their baby ?:' => $itemYNI
                    , 'NewGeneTherapy:35.) New gene therapy already allows you to ‘design’ your baby to exclude many hereditary diseases.<br/>Should it also be allowed to decide if your baby is or isn’t:' => $item35
                    , 'CloningHumans:36.) Cloning humans:' => $item36
                    , 'StemCells:37.) Stem cells derived from human cloning:' => $item37
                    , 'OurAbilityToDigitiseAndStore:38.) Our ability to digitise and store all our knowledge and thoughts will:' => $item38
                    , 'HumansEvolveIntoRobots:39.) Will humans evolve into part robots ?:' => $item39
                    , 'DeathBecomeOptional:40.) Will death become optional ?:' => $item40
                    , 'SciencAndTechnology:41.) Science and Technology need be:' => $item41                   
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
 
echo "<h3 style='display:inline;'>Quiz Title: </h3> Science & Technology";
 
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
