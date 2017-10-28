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
    $countSql->where($db->quoteName('FormId') ." = ". '44');  
 	
 	if($v <> 'GETALLRECORDS'){
     	$countSql->where($db->quoteName('FieldValue') ." LIKE ". "'%".$v."%'");  
	}
	$db->setQuery($countSql);
 
	$count = $db->loadResult();
	return $count;
}
 

$item1 = array('unimportant'
			,'highly  important');
$item2 = array('should support the arts to help them survive and thrive'
 			,'should never have to pay for ‘entertainment & culture’'
 			,'I’m unsure');
$item3 = array('watching TV'
			,'playing a musical instrument'
			,'playing games with friends and family'
			,'reading'
			,'surfing the web'
			,'cooking'
			,'gardening'
			,'having a hot bath'
			,'I’m unsure');
$item4 = array('too much'
			,'about the right amount of time'
			,'should include free higher education up to the age of twenty-one'
			,'not enough.  We need to know more about what’s happening'
			,'I’m unsure');
$item5 = array('allow ordinary people to showcase their talents'
			,'tempt people with success to cause them public humiliation'
			,'are great and harmless entertainment'
			,'depend on egos and conflicts rather than good teamwork'
			,'I’m unsure');
$item6 = array('is appropriate because it is a normal part of life'
			,'is wrong because sex is all about intimacy and privacy'
			,'is acceptable so long as children are not exposed to it'
			,'encourages promiscuity and an obsession with sex'
			,'I’m unsure');
$item7 = array('encourages violence in real life'
			,'is just an artistic response to our terribly violent world'
			,'makes people overly scared of the real world'
			,'puts people off being violent by showing its horrible reality'
			,'I’m unsure');
$item8 = array('are usually the best because they have the best actors, special effects and plots'
			,'are built on glossy stars and hype rather than good stories'
			,'are only disliked by cultural snobs'
			,'never show anything controversial or anti-American'
			,'I am unsure');
$item9 = array('are annoying to watch because of the subtitles'
			,'can be just as good as any film in English'
			,'are usually slow and pretentious'
			,'give us brilliant insight into different cultures'
			,'I am unsure');
$item10 = array('is stealing'
			,'is acceptable because all art should be free'
			,'risks the jobs of those working in the film industry'
			,'is justified for big budget Hollywood films because they make enough already'
			,'I’m unsure');
$item11 = array('shouldn’t be allowed for anything dangerous like alcohol and tobacco'
			,'should be allowed for everything legal because  we all have free will'
			,'cons the vulnerable into buying things they don’t need'
			,'is often an imaginative and useful way of telling people about the best deals'
			,'I’m unsure');
$item12 = array('inspire us to improve ourselves'
			,'create feelings of inadequacy and jealousy'
			,'are a harmless escape from the dullness of ordinary life'
			,'are a tool for the media to distract us from what’s important and sell us stuff'
			,'I’m unsure');
$item13 = array('shows a shallow and shameless celebrity'
			,'is a daring way for the star to promote herself'
			,'shows a liberated woman freeing herself from society’s constraints'
			,'shows a woman sexually exploited for the male gaze'
			,'I’m unsure');
$item14 = array('should be part of everyone’s education'
			,'is less important than learning to listen to good music'
			,'improves creative thinking and self confidence'
			,'can’t be a priority because it is extremely unlikely to result in a paid job'
			,'I’m unsure');
$item15 = array('is usually better composed than pop music'
			,'is outdated'
			,'I’m unsure');
$item16 = array('should only be done in public by the talented'
			,'should be practiced by everyone because it makes us all happier'
			,'is something best done when drunk'
			,'I’m unsure');
$item17 = array('no, not even if it’s an art gallery and worth millions. It’s just a toilet'
			,'yes, because it makes us question even the ordinary things around us'
			,'I’m unsure');
$item18 = array('is about looking and feeling good'
			,'is for lemmings with no individual style'
			,'I’m unsure');
$item19 = array('is an unfortunate necessity of life'
			,'is a great pastime if you have money to blow'
			,'is like some mad sport where we all end up buying stuff we don’t need'
			,'is the fuel that keeps the economy working'
			,'I’m unsure');
$item20 = array('will always be one of life’s greatest pleasures'
			,'just take too long to read for this ever faster world'
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
$QuestionArr = array( 'CultureAndThe:1.) Culture and ‘the Arts’ are:' => $item1
                    , 'taxpayers:2.) Taxpayers:' => $item2
                    , 'MostPleasure:3.) Which of these give you most pleasure?:' => $item3
                    , 'ComputerAndTVScreens:4.)  We watch our computer and TV screens:' => $item4
                    , 'RealityTVShows:5.) Reality TV shows:' => $item5
                    , 'SexOnTV:6.) Sex on TV :' => $item6
                    , 'ViolenceOnTV:7.) Violence on TV:' => $item7
                    , 'BigBudget:8.) Big budget Hollywood movies:' => $item8
                    , 'ForeignLanguageFilms:9.) Foreign language films:' => $item9
                    , 'IllegallyDownloading:10.) Illegally downloading and streaming movies:' => $item10
                    , 'Advertising:11.) Advertising:' => $item11
                    , 'Celebrities:12.) Celebrities:' => $item12
					, 'TheImageOnTheLeft:13.) The image on the left:' => $item13
					, 'LearningToPlay:14.) Learning to play an instrument:' => $item14
					, 'ClassicalMusic:15.) Classical music:' => $item15
					, 'Dancing:16.) Dancing:' => $item16
					, 'WorkOfArt:17.) Is the object on the left a work of art?:' => $item17
					, 'FollowingFashion:18.) Following fashion:' => $item18
					, 'Shopping:19.) Shopping:' => $item19
					, 'Books:20.) Books:' => $item20
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
 
echo "<h3 style='display:inline;'>Quiz Title: </h3> Entertainment & Culture";
 
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
