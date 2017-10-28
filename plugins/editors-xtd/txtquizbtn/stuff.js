//This file does stuff


function insertStuff(insertThis) {
	window.parent.jInsertEditorText(insertThis, 'jform_articletext');
	window.parent.jModalClose();
}

jQuery(document).ready(function (happySuki) {

	//Hide pages
	jQuery('.page').each(function(){
		jQuery(this).hide();
	});
	//Show home
	jQuery('#pageHome').show();

	//Open Pages
	jQuery('#btnAddMchoice').click(function(){
		jQuery('#pageHome').hide();
		jQuery('#pageMchoice').fadeIn();
	});

	jQuery('#btnAddText').click(function(){
		jQuery('#pageHome').hide();
		jQuery('#pageText').fadeIn();
	});
	jQuery('#btnAddScoreBox').click(function(){
		jQuery('#pageHome').hide();
		jQuery('#pageScoreBox').fadeIn();
	});

	//Mchoice Page
	var MchoiceAnswers = 1;
		//Add additional options
		jQuery('#MchoiceInsertAnswer').click(function(){
			MchoiceAnswers ++;
			jQuery('#MchoiceCorrectAns').append('<option>'+MchoiceAnswers+'</option>');
			jQuery('#MchoiceAnswers').append('<label>Answer '+MchoiceAnswers+'</label><input type="text" style="width:100%;" id="txtMchoiceAnswer_'+MchoiceAnswers+'" class="txtMchoiceAns">');
		});
		//Insert to editor
		jQuery('#MchoiceInsertQuestion').click(function(){
			//Generate Answers
			var answers = '';
			jQuery('.txtMchoiceAns').each(function(){
				answers += jQuery(this).val() +',';
			});
			//Remove last comma
			answers = answers.replace(/,\s*$/, "");
			//Get Feedback
			var feedCorrect = '';
			var feedIncorrect = '';
			if(jQuery('#MchoiceFeedbackCorrect').val() != ''){
				feedCorrect = 'passreply="'+jQuery('#MchoiceFeedbackCorrect').val()+'" ';
			}
			if(jQuery('#MchoiceFeedbackIncorrect').val() != ''){
				feedIncorrect = 'failreply="'+jQuery('#MchoiceFeedbackIncorrect').val()+'" ';
			}

			var output = '<p>{txtquiz type="mchoice" question="'+jQuery('#txtMchoiceQuestion').val()+'" answers="'+answers+'" correct="'+jQuery('#MchoiceCorrectAns option:selected').text()+'" '+feedCorrect+feedIncorrect+' points="'+jQuery('#MchoicePoints').val()+'"}</p>';
			output += '<p>Delete this text or add additional question info here</p>';
			output += '<p>{/txtquiz}</p>';
			insertStuff(output);
		});
	//Text Page
		//Additional Correct Answers
		jQuery('#txtTextInsertAnswer').click(function(){
			jQuery('#TextCorrectAns').append('<input type="text" class="txtCorrectAns" style="width:100%;">');
		});

		//Insert
		jQuery('#TextInsertQuestion').click(function(){
			//Determine correct answers
			var correct = '';
			jQuery('.txtCorrectAns').each(function(){
				correct += jQuery(this).val() + ',';
			});
			correct = correct.replace(/,\s*$/, "");
			//Get Feedback
			var feedCorrect = '';
			var feedIncorrect = '';
			if(jQuery('#TextFeedbackCorrect').val() != ''){
				feedCorrect = 'passreply="'+jQuery('#TextFeedbackCorrect').val()+'" ';
			}
			if(jQuery('#TextFeedbackIncorrect').val() != ''){
				feedIncorrect = 'failreply="'+jQuery('#TextFeedbackIncorrect').val()+'" ';
			}

			var output = '<p>{txtquiz type="text" question="'+jQuery('#txtTextQuestion').val()+'" correct="'+correct+'" '+feedCorrect+feedIncorrect+' points="'+jQuery('#TextPoints').val()+'"}</p>';
			output += '<p>Delete this text or add additional question info here</p>';
			output += '<p>{/txtquiz}</p>';
			insertStuff(output);
		});


	//Score Box
		jQuery('#insertScoreBox').click(function(){
			var output = '<p>{txtqscorebox passpercent="'+jQuery('#scoreboxPassPercent').val()+'"}</p>'
			insertStuff(output);
		});


	
});