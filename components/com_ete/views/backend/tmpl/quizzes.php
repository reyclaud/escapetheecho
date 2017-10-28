<?php
defined('_JEXEC') or die('Restricted access');

$submissions = $this->submissions;
?>

<h1><?php echo $this->formTitle; ?></h1>
<table>
    <col width="40%">
    <col width="60%">
    <thead>
        <tr>
            <th>Questions</th>
            <th>Answers and Votes</th>
        </tr>
    </thead>
    <?php
    foreach ($submissions as $submission) {
        if (!isset($this->properties[trim($submission->FieldName)]['CAPTION'])) {
            continue;
        }
        ?>
        <tr>
            <td><?php echo isset($this->properties[trim($submission->FieldName)]['CAPTION']) ? $this->properties[trim($submission->FieldName)]['CAPTION'] : ''; ?></td>
            <?php /* <td><?php echo $submission->FieldName; ?></td> */ ?>
            <td class="no-padding">
                <?php //echo isset($this->properties[trim($submission->FieldName)]['ITEMS']) ? nl2br($this->properties[trim($submission->FieldName)]['ITEMS']) : ''; ?>                
                <?php
                foreach (explode("\n", $this->properties[trim($submission->FieldName)]['ITEMS']) as $item):
                    ?>
                    <div class="ete-backend-answer-div">
                        <div class="ete-backend-answer-div-left">
                            <?php echo $item; ?>
                        </div>
                        <div class="ete-backend-answer-div-right">
                            <?php foreach ($this->answers[trim($submission->FieldName)] as $key => $answer): ?>
                                <?php if (trim($item) === trim($key)): ?>
                                    <a href="#" onclick='backend.showRespondents(<?php echo json_encode((object) $this->answers['username'][trim($submission->FieldName)][$key]); ?>, "<?php echo isset($this->properties[trim($submission->FieldName)]['CAPTION']) ? $this->properties[trim($submission->FieldName)]['CAPTION'] : ''; ?>", "<?php echo $key; ?>")'><strong><?php echo $answer; ?></strong></a>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            &nbsp;
                        </div>
                    </div>
                    <?php
                endforeach;
                ?>
            </td>
        </tr>        
        <?php
    }
    ?>
</table>

<script type="text/javascript">
    jQuery(document).ready(function () {
        backend = {
            showRespondents: function (ids, question, answer) {
                jQuery.ajax({
                    url: '<?php echo JURI::current(); ?>',
                    data: 'ids=' + encodeURIComponent(JSON.stringify(ids)) + '&task=backend.showRespondents',
                    type: 'post',
                    beforeSend: function () {
                        backend.overlay();
                    },
                    success: function (resp) {
                        jQuery("#overlay-content-wrap").append('<div class=\"close-overlay\" onclick=\"backend.closeOverlay();\">[x]</div>');
                        jQuery("#overlay-content-wrap").append('<div class=\"question-wrap\">Question: ' + question + '</div>');
                        jQuery("#overlay-content-wrap").append('<div class=\"answer-wrap\">Answer: ' + answer + '</div>');
                        jQuery("#overlay-content-wrap").append(resp);
                    }
                });
            },
            overlay: function () {
                jQuery("body").append("<div id=\"overlay-bg\" />");
                jQuery("body").append("<div id=\"overlay-content-wrap\" />");
            },
            closeOverlay: function () {
                jQuery("#overlay-content-wrap").fadeOut("fast", function () {
                    jQuery("#overlay-content-wrap").remove();
                });
                jQuery("#overlay-bg").fadeOut("fast", function () {
                    jQuery("#overlay-bg").remove();
                });
            }
        }
    });
</script>