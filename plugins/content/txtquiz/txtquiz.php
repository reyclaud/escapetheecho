<?php
/*
* @copyright   Copyright (C) 2015 Kevin Olson, Inc. All rights reserved.
* @license     GNU General Public License version 2 or later; see LICENSE.txt
*/
defined('_JEXEC') or die;
//Import
jimport('joomla.event.plugin');

class PlgContenttxtquiz extends JPlugin
{
    function onContentPrepare($context, &$row, &$params, $page = 0)
    {
        //Make sure there is a txtquiz on this page
        $testQuizExists = substr_count($row->text, "txtquiz");
        if ($testQuizExists > 0) {


            //Get Config
            $displayNumbers = $this->params->get('disp_numbers', 'yes');
            $style = $this->params->get('style', 'material_white.css');
            $fbImgStyle = $this->params->get('feedbackImgStyle','default');
            $feedbackImages = $this->params->get('fbimgs', 'Yes');
            $singlequiz = $this->params->get('singlequiz', 'No');
            $displaybar = $this->params->get('displaybar', 'No');
            $displayanswercount = $this->params->get('displayanswercount', 'Yes');

            //References
            $document = JFactory::getDocument();
            $document->addStyleSheet('plugins/content/txtquiz/style/' . $style);
            $document->addStyleSheet('plugins/content/txtquiz/images/'.$fbImgStyle.'.css');

            //Language
            $lang = JFactory::getLanguage();
            $lang->load('plg_content_txtquiz', JPATH_ADMINISTRATOR, null, true);
            $langMessageCorrect = JText::_('PLG_CONTENT_TXTQUIZ_FEEDBACKMSGCORRECT');
            $langMessageWrong = JText::_('PLG_CONTENT_TXTQUIZ_FEEDBACKMSGWRONG');
            $langMessageNoResponse = JText::_('PLG_CONTENT_TXTQUIZ_FEEDBACKMSGNOFILL');
            $passmessage = JText::_('PLG_CONTENT_TXTQUIZ_SCOREBOXPASSMESSAGE');
            $failmessage = JText::_('PLG_CONTENT_TXTQUIZ_SCOREBOXFAILMESSAGE');




            //JQUERY
            JHtml::_('jquery.framework');

            //Include JavaScript
            $document->addScript('plugins/content/txtquiz/txtquiz.js');

            //Count amount of questions
            $question_count = substr_count($row->text, "{txtquiz");

            //Extract Each Question [1][i]
            preg_match_all('#{txtquiz(.*?)}#', $row->text, $questionParams);

            //Set plugin directory
            $plugin_directory = JURI::base() . "plugins/content/txtquiz";

            //Get HTML Content
            preg_match_all("/{txtquiz (.*?)}\s*(.*?)\s*{\/txtquiz}/s", $row->text, $htmlmatches);

            $qprintout = 0;
            //Generate Quiz for each Question
            for ($i = 0; $i < $question_count; $i++) {

                //Extract Params From Questions
                preg_match('#question=\"(.*?)\"#', $questionParams[1][$i], $extractVal);
                $question = $extractVal[1];
                preg_match('#answers=\"(.*?)\"#', $questionParams[1][$i], $extractVal);
                if (count($extractVal) != 0) {
                    $answers = $extractVal[1];
                    $answer = explode(",", $answers);
                } else {
                    $answers = "";
                }

                $answer_count = count($answer);


                preg_match('#correct=\"(.*?)\"#', $questionParams[1][$i], $extractVal);
                $correct = $extractVal[1];
                preg_match('#type=\"(.*?)\"#', $questionParams[1][$i], $extractVal);
                if (count($extractVal) != 0) {
                    $question_type = $extractVal[1];
                } else {
                    $question_type = "mchoice";
                }




                //Determine pass/fail messages if exists
                preg_match('#failreply=\"(.*?)\"#', $questionParams[1][$i], $extractVal);
                if (count($extractVal) != 0) {
                    $langMessageWrong = $extractVal[1];
                }
                else{
                    $langMessageWrong = JText::_('PLG_CONTENT_TXTQUIZ_FEEDBACKMSGWRONG');
                }

                preg_match('#passreply=\"(.*?)\"#', $questionParams[1][$i], $extractVal);
                if (count($extractVal) != 0) {
                    $langMessageCorrect = $extractVal[1];
                }
                else{
                    $langMessageCorrect = JText::_('PLG_CONTENT_TXTQUIZ_FEEDBACKMSGCORRECT');
                }
                preg_match('#noreply=\"(.*?)\"#', $questionParams[1][$i], $extractVal);
                if (count($extractVal) != 0) {
                    $langMessageNoResponse = $extractVal[1];
                }
                else{
                    $langMessageNoResponse = JText::_('PLG_CONTENT_TXTQUIZ_FEEDBACKMSGNOFILL');
                }
                preg_match('#points=\"(.*?)\"#', $questionParams[1][$i], $extractVal);
                if (count($extractVal) != 0) {
                    $points = $extractVal[1];
                } else {
                    $points = 1;
                }


                //Get HTML
                $html = $htmlmatches[2][$i];


                //Generate Quiz Name
                $quizname = preg_replace("/[^a-zA-Z0-9]+/", "", $question);
                $qprintout += 1;

                //Display numbers or not
                if ($displayNumbers == 'Yes') {
                    $genNums = $qprintout . ") ";
                } else {
                    $genNums = "";
                }

                //Display feedback image or not
                if ($feedbackImages == 'Yes') {
                    $tqFeedbackImage = '<div class="tqImgFeedback question"></div>';
                } else {
                    $tqFeedbackImage = "";
                }

                //Display Submit Button Per Quiz
                if ($singlequiz == 'Yes') {
                    $submitButton = "";
                } else {
                    $submitButton = '<button class="tqSubmit">'.JText::_('PLG_CONTENT_TXTQUIZ_SUBMITBTN').'</button><br>';
                }

                $feedbackMsg = '<span class="tqFeedbackMsg">'.JText::_('PLG_CONTENT_TXTQUIZ_FEEDBACKMSG').'</span>';
                //Store all the question info in data attributes
                $questionData = 'data-thisID="'.$i.'" data-msgCorrect="'.$langMessageCorrect.'" data-msgWrong="'.$langMessageWrong.'" data-msgNoResponse="'.$langMessageNoResponse.'" data-qPoints="'.$points.'" data-correct="'.$correct.'" data-plugdir="'.$plugin_directory.'"';


                //Generate mchoice
                if($question_type=='mchoice'){

                    $genanswers = '<form>';
                    //answer options
                    for($idx = 0; $idx < $answer_count; $idx++){
                        $genanswers .= '<input type="radio" id="tqMC_'.$i.'_'.$idx.'" name="tqMC_'.$i.'"><label for="tqMC_'.$i.'_'.$idx.'">'.$answer[$idx].'</label><br>';
                    }

                    $genanswers .= '</form>';
                    $genquiz = '<div class="tqQuestion" data-tqType="mchoice" '.$questionData.'>'.$tqFeedbackImage.'<span class="tqHeader">'.$genNums.$question.'</span>'.$html.$genanswers.$submitButton.$feedbackMsg.'</div>';
                }

                //Generate Text Question
                if($question_type=='text'){
                    $genanswers = '<input type="text" id="tqTX_'.$i.'" placeholder="'.JText::_('PLG_CONTENT_TXTQUIZ_TXTPLACEHOLD').'"><br>';
                    $genquiz = '<div class="tqQuestion" data-tqType="text" '.$questionData.'>'.$tqFeedbackImage.'<span class="tqHeader">'.$genNums.$question.'</span>'.$html.$genanswers.$submitButton.$feedbackMsg.'</div>';
                }

                $row->text = preg_replace("/{txtquiz (.*?)}(.*?){\/txtquiz}/s", $genquiz, $row->text, 1);


            }

            //Extract GradingBox Values

            if ($singlequiz == 'Yes') {

                preg_match('#passpercent=\"(.*?)\"#', $row->text, $extractVal);
                if (count($extractVal) != 0) {
                    $passpercentage = $extractVal[1];
                } else {
                    $passpercentage = "0.75";
                }
            }


            //Grade All Box
            $genanscount = "";

            if ($displayanswercount == 'Yes') {
                $genanscount = 'data-genanscount="yes"';
            }

            if ($feedbackImages == 'Yes') {
                $tqGradeAllImage = '<div class="tqImgGradeBox"></div>';
                } else {
                $tqGradeAllImage = "";
            }

            $printBar = '';
            if ($displaybar=='Yes'){
                $printBar = '<div class="tqFeedbackBar"><div class="tqColorBar"></div></div>';
            }

            $quizData = ' data-langpoints="'.JText::_('PLG_CONTENT_TXTQUIZ_RESULTPOINTS').'" data-langcorrect="'.JText::_('PLG_CONTENT_TXTQUIZ_RESULTCORRECT').'"  data-langincorrect="'.JText::_('PLG_CONTENT_TXTQUIZ_RESULTINCORRECT').'"  data-langnoanswer="'.JText::_('PLG_CONTENT_TXTQUIZ_RESULTNOANSWER').'"';


            if ($singlequiz == 'Yes') {
                $genScoreBox = '<div class="tqScoreBox" '.$genanscount.' data-passscore="'.$passpercentage.'" '.$quizData.' data-passmessage="'.$passmessage.'" data-failmessage="'.$failmessage.'"> '.$tqGradeAllImage.' <span class="tqHeader">'.JText::_('PLG_CONTENT_TXTQUIZ_SCOREBOX').'</span><br><input type="button" class="tqGradeAll" value="'.JText::_('PLG_CONTENT_TXTQUIZ_SUBMITALLBTN').'"><br>'.$printBar.'<span class="tqScoreBoxResults">'.JText::_('PLG_CONTENT_TXTQUIZ_SCOREBOXDEFAULT').'</span></div>';
                $row->text = preg_replace("/{txtqscorebox (.*?)}/s", $genScoreBox, $row->text, 1);
            }


        }

    }

}



?>