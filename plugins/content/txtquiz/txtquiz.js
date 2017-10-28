jQuery(document).ready(function(){

	//Single Grading
    jQuery('.tqSubmit').click(function(e){

        //Determine Question Type
        var questionType = jQuery(this).closest('.tqQuestion').data('tqtype');
        if(questionType=="mchoice"){
            gradeMchoice(jQuery(this).parent());
        }
        else if(questionType=="text"){
            gradeText(jQuery(this).closest('.tqQuestion'));
        }

    });

    //Scorebox Grading
    jQuery('.tqGradeAll').click(function(e){

        var pointsAccum = 0;
        var totalPoints = 0;
        var unanswered = 0;
        var correctans = 0;
        var wrongans = 0;
        var totalans = 0;
        var displayAnsCount = jQuery(this).parent().data('genanscount');
        var passScore = jQuery(this).parent().data('passscore');
        var langPoints = jQuery(this).parent().data('langpoints');
        var langCorrect = jQuery(this).parent().data('langcorrect');
        var langIncorrect = jQuery(this).parent().data('langincorrect');
        var langNoAnswer = jQuery(this).parent().data('langnoanswer');
        var passmessage = jQuery(this).parent().data('passmessage');
        var failmessage = jQuery(this).parent().data('failmessage');
        jQuery('.tqQuestion').each(function(x){
            totalans ++;
            var thisPoints = jQuery(this).data('qpoints');
            totalPoints = +totalPoints + +thisPoints;
            var getGrade = 0;
            var questionType = jQuery(this).data('tqtype');
            if(questionType=="mchoice") {
                getGrade = gradeMchoice(jQuery(this));
            }
            else if(questionType=="text"){
                getGrade = gradeText(jQuery(this));
            }

            if (getGrade == 0){
                wrongans ++;
            }
            else if (getGrade == -1){
                unanswered ++;
            }
            else if (getGrade > 0){
                pointsAccum = +pointsAccum + +getGrade;
                correctans++;
            }
        });
        var percentScore = pointsAccum / totalPoints * 100;
        var percentScore = percentScore.toFixed(2);
        var passFail = 0;
        if (percentScore >= passScore){
            var output = passmessage + percentScore+"%.";
            passFail = 1;
        }
        else{
            var output= failmessage +percentScore+"%";
        }
        if(displayAnsCount=="yes"){

            output += ('<br\>'+langPoints+' '+pointsAccum+'/'+totalPoints);
            output += ('<br\>'+langCorrect+' '+correctans+'/'+totalans);
            output += ('<br\>'+langIncorrect+' '+wrongans+'/'+totalans);
            output += ('<br\>'+langNoAnswer+' '+unanswered+'/'+totalans);
        }
        jQuery(this).siblings('span.tqScoreBoxResults').html(output);

        //Feedback Bar
        if(jQuery(this).siblings('.tqFeedbackBar').length > 0){
            jQuery(this).siblings('.tqFeedbackBar').children('.tqColorBar').animate({right: 100 - percentScore + '%'});
            if(passFail == 1){
                jQuery(this).siblings('.tqFeedbackBar').children('.tqColorBar').css('background-color','green');
            }
            else{
                jQuery(this).siblings('.tqFeedbackBar').children('.tqColorBar').css('background-color','red');
            }
        }

    });

    //Grades a mchoice given the tqQuestion elt, returns points, sets feedback
    function gradeMchoice(elt){
        //Determine correct ans
        var correctAns = jQuery(elt).data('correct');
        var plugindir = jQuery(elt).data('plugdir');
        var thisID = jQuery(elt).data('thisid');
        var msgCorrect = jQuery(elt).data('msgcorrect');
        var msgNoResponse = jQuery(elt).data('msgnoresponse');
        var msgWrong = jQuery(elt).data('msgwrong');
        //Check against RBs

        //Determine if no answers were chosen
        var rbCheck = jQuery('#tqMC_'+thisID+'_0');
        var rbChecked = 0;
        var rbID = 0;
        var returnScore = 0;
        while (rbCheck.length > 0){
            if(rbCheck.is(':checked')){
                rbChecked = 1;
            }
            rbID ++;
            var rbCheck = jQuery('#tqMC_'+thisID+'_'+rbID+'');
        }
        if(rbChecked == 0){
            jQuery(elt).find('.tqFeedbackMsg').text(msgNoResponse);
            //Change feedback image if exists
            if(jQuery(elt).find('.tqImgFeedback').length > 0){
                jQuery(elt).find('.tqImgFeedback').removeClass().addClass('tqImgFeedback question');
            }
            returnScore = -1;
        }

        //Correct
        if (jQuery('#tqMC_'+thisID+'_'+correctAns+'').is(':checked')){
            //Change feedback image if exists
            if(jQuery(elt).find('.tqImgFeedback').length > 0){
                jQuery(elt).find('.tqImgFeedback').removeClass().addClass('tqImgFeedback correct');
            }
            //Write Correct
            jQuery(elt).find('.tqFeedbackMsg').text(msgCorrect);
            returnScore = jQuery(elt).data('qpoints');
        }
        //Incorrect
        else if(rbChecked == 1){
            //Write Incorrect
            jQuery(elt).find('.tqFeedbackMsg').text(msgWrong);
            //Change feedback image if exists
            if(jQuery(elt).find('.tqImgFeedback').length > 0){
                jQuery(elt).find('.tqImgFeedback').removeClass().addClass('tqImgFeedback incorrect');
            }
            returnScore = 0;
        }

        return returnScore;
    }

    //Grades a text question given elt
    function gradeText(elt){
        //Determine correct ans
        var correctAns = jQuery(elt).data('correct');
        console.log(correctAns);
        //Split correct ans for multiple correct
        if(typeof correctAns == "string"){
            var correctAnswers=correctAns.split(",");
        }
        else{
            var correctAnswers = [correctAns];
        }


        //Get Info
        var plugindir = jQuery(elt).data('plugdir');
        var thisID = jQuery(elt).data('thisid');
        var msgCorrect = jQuery(elt).data('msgcorrect');
        var msgNoResponse = jQuery(elt).data('msgnoresponse');
        var msgWrong = jQuery(elt).data('msgwrong');
        returnScore = 0;
        //Determine if correct answer was chosen
        for(idx=0; idx<correctAnswers.length ; idx++){
            //found correct
            if(jQuery('#tqTX_'+thisID).val()==correctAnswers[idx]){
                //Change feedback image if exists
                if(jQuery(elt).find('.tqImgFeedback').length > 0){
                    jQuery(elt).find('.tqImgFeedback').removeClass().addClass('tqImgFeedback correct');
                }
                //Write Correct
                jQuery(elt).find('.tqFeedbackMsg').text(msgCorrect);
                return jQuery(elt).data('qpoints');

            }
        }

        //Determine if no answers were chosen
        if (jQuery('#tqTX_'+thisID).val()==''){
            jQuery(elt).find('.tqFeedbackMsg').text(msgNoResponse);
            if(jQuery(elt).find('.tqImgFeedback').length > 0){
                jQuery(elt).find('.tqImgFeedback').removeClass().addClass('tqImgFeedback question');

            }
            return -1;
        }
        else{
            //Write Incorrect
            jQuery(elt).find('.tqFeedbackMsg').text(msgWrong);
            //Change feedback image if exists
            if(jQuery(elt).find('.tqImgFeedback').length > 0){
                jQuery(elt).find('.tqImgFeedback').removeClass().addClass('tqImgFeedback incorrect');
            }
            return 0;
        }



    }

});

