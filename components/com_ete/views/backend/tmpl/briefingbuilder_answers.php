<?php
defined('_JEXEC') or die('Restricted access');

$answers = $this->answers;

?>
<select name="answers"  onchange="briefingBuilder.getRespondents(this)">
    <option>-- Select Answer --</option>
<?php
foreach ($answers['username'][$this->questionName] as $answer => $respondents):
    ?>
    <?php $count_respondents++; ?>
    <option value="<?php echo serialize($respondents) ?>"><?php echo $answer . ' <strong>(' . count($respondents) . ' respondent(s))</strong>'; ?></a>    
<?php endforeach; ?> 
</select>
