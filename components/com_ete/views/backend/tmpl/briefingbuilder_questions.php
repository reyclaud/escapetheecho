<?php
defined('_JEXEC') or die('Restricted access');

$submissions = $this->submissions;
?>
<select name="questions" onchange="briefingBuilder.getAnswers(this)">
    <option value="">-- Choose Question --</option>
    <?php
    foreach ($submissions as $submission) {
        if (!isset($this->properties[trim($submission->FieldName)]['CAPTION'])) {
            continue;
        }
        ?>        
        <option value="<?php echo trim($submission->FieldName); ?>"><?php echo isset($this->properties[trim($submission->FieldName)]['CAPTION']) ? $this->properties[trim($submission->FieldName)]['CAPTION'] : ''; ?></option>
        <?php
    }
    ?>
</select>