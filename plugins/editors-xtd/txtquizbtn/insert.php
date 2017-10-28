<?php
// Get Joomla! framework define( '_JEXEC', 1 ); 

define( '_JEXEC', 1 );
define( 'DS', DIRECTORY_SEPARATOR );
define( 'JPATH_BASE', $_SERVER[ 'DOCUMENT_ROOT' ] );

require_once( JPATH_BASE . DS . 'includes' . DS . 'defines.php' );
require_once( JPATH_BASE . DS . 'includes' . DS . 'framework.php' );
require_once( JPATH_BASE . DS . 'libraries' . DS . 'joomla' . DS . 'factory.php' );
@$mainframe =& JFactory::getApplication('administrator');

$user = JFactory::getUser();
if ($user->get('guest')
	|| (
		!$user->authorise('core.edit', 'com_content')
		&& !$user->authorise('core.create', 'com_content')
	)
)
{
	JError::raiseError(403, JText::_("ALERTNOTAUTH"));
}
?>
<head>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="stuff.js"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>

<body>
<div id="pageHome" class="page">
	<div class="text-center">
		<h3>txtQuiz Insertion Helper</h3>
		<p>Click where you want to add the question in your editor before using this tool.</p>
		<br>
	<h4>Select An Element To Add</h4>
		<a id="btnAddMchoice" class="btn btn-default"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>  Insert Multiple Choice Question</a><br><br>
		<a id="btnAddText" class="btn btn-default"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>  Insert Text Response Question</a><br><br>
		<a id="btnAddScoreBox" class="btn btn-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span>  Insert Score Box</a>
	</div>
</div>
<div id="pageMchoice" class="page" style="padding-right:10px;">
	<div class="text-center">
		<h3>Insert Multiple Choice Question</h3>
	</div>
	<br><br>
	<label>Question Text: </label><input type="text" id="txtMchoiceQuestion" style="width:100%;">
	<br><hr>

	<div id="MchoiceAnswers">
		<label>Answer 0</label>
		<input type="text" style="width:100%;" id="txtMchoiceAnswer_0" class="txtMchoiceAns">
		<label>Answer 1</label>
		<input type="text" style="width:100%;" id="txtMchoiceAnswer_1" class="txtMchoiceAns">
	</div>
	<hr>
	<a id="MchoiceInsertAnswer" class="btn btn-default">Add Answer Option</a><br><hr>
	<div class="form-group">
		<label for="MchoiceCorrectAns">Select Correct Answer:</label>
		<select class="form-control" id="MchoiceCorrectAns">
			<option>0</option>
			<option>1</option>
		</select>
	</div>
	<label>Question Point Value (Only Works With Scorebox)</label>
	<input type="text" style="width:100%;" id="MchoicePoints" value="1">
	<hr>
	<label>User Answered Correctly Feedback (optional)</label>
	<input type="text" style="width:100%;" id="MchoiceFeedbackCorrect">
	<label>User Answered Incorrectly Feedback (optional)</label>
	<input type="text" style="width:100%" id="MchoiceFeedbackIncorrect">
	<hr>
	<a id="MchoiceInsertQuestion" class="btn btn-success">Insert Question To Editor</a>
</div>
<div id="pageText" class="page" style="padding-right:15px;">
	<div class="text-center">
		<h3>Insert Text Question</h3>
	</div>
	<hr>
	<label>Question Text:</label>
	<input type="text" id="txtTextQuestion" style="width:100%;">
	<hr>
	<label>Acceptable Answer(s)</label>
	<div id="TextCorrectAns">
		<input type="text" class="txtCorrectAns" style="width:100%;">
	</div>
	<br>
	<a class="btn btn-default" id="txtTextInsertAnswer">Add Additional Answer</a>
	<hr>
	<label>Question Point Value (Only Works With Scorebox)</label>
	<input type="text" style="width:100%;" id="TextPoints" value="1">
	<hr>
	<label>User Answered Correctly Feedback (optional)</label>
	<input type="text" style="width:100%;" id="TextFeedbackCorrect">
	<label>User Answered Incorrectly Feedback (optional)</label>
	<input type="text" style="width:100%" id="TextFeedbackIncorrect">
	<hr>
	<a class="btn btn-success" id="TextInsertQuestion">Insert Question</a>
</div>

<div id="pageScoreBox" class="page">
	<div class="text-center">
		<h3>Insert Score Box</h3>
		<p>You must make sure Grade all Questions Together is set to Yes in txtQuiz plugin config to use scorebox.</p>

	</div>
	<hr>
	<label>Type the percentage that counts as passing. Do not include percent sign.</label>
	<input type="text" id="scoreboxPassPercent" value="70">
	<hr>
	<a class="btn btn-success" id="insertScoreBox">Insert Score Box</a>
</div>
</body>

