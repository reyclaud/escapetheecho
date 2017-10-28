<?php
defined('_JEXEC') or die('Restricted access');

$submissions = $this->submissions;
?>

<table class="question-answer-table" id="quiz-id-<?php echo $this->form->FormId; ?>" data-quiz-title="<?php echo $this->formTitle; ?>">
    <col width="40%">
    <col width="60%">
    <thead>
        <tr>
            <th>Questions</th>
            <th>Answers and Votes</th>
        </tr>
    </thead>        <?php
    foreach ($submissions as $_skey => $submission) {
        if (!isset($this->properties[trim($submission->FieldName)]['CAPTION'])) {
            continue;
        }

        $_question = trim(strtolower(str_replace(" ", "", $this->properties[trim($submission->FieldName)]['NAME'])));
        ?>
        <tr>
            <td class="question-<?php echo $_question; ?>"><?php echo isset($this->properties[trim($submission->FieldName)]['CAPTION']) ? $this->properties[trim($submission->FieldName)]['CAPTION'] : ''; ?></td>
            <?php /* <td><?php echo $submission->FieldName; ?></td> */ ?>
            <td class="no-padding">
                <?php //echo isset($this->properties[trim($submission->FieldName)]['ITEMS']) ? nl2br($this->properties[trim($submission->FieldName)]['ITEMS']) : '';   ?>                
                <?php
                foreach (explode("\n", $this->properties[trim($submission->FieldName)]['ITEMS']) as $_key => $item):
                    $count_respondents = 0;
                    ?>
                    <div class="ete-backend-answer-div">
                        <div class="ete-backend-answer-div-left">
                            <i class="fa fa-check-square-o" aria-hidden="true"></i>
                            <span class="answer-text <?php echo $_question; ?>-answer-<?php echo $_key; ?>"><?php echo $item; ?></span>
                        </div>
                        <div class="ete-backend-answer-div-right ete-backend-answer-div-right-1">
                            <?php foreach ($this->answers[trim($submission->FieldName)] as $key => $answer): ?>
                                <?php if (trim($item) === trim($key)): ?>
                                    <?php $count_respondents++; ?>
                                    <a href="#" onclick='backend.showRespondents(<?php echo json_encode((object) $this->answers['username'][trim($submission->FieldName)][$key]); ?>, "<?php echo isset($this->properties[trim($submission->FieldName)]['CAPTION']) ? $this->properties[trim($submission->FieldName)]['CAPTION'] : ''; ?>", "<?php echo $key; ?>")'><strong><?php echo $answer; ?></strong></a>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            &nbsp;
                        </div>
                        <div class="ete-backend-answer-div-right">
                            <?php if ($count_respondents): ?>
                                <button class="add-answer-btn" type="button" data-qaid="<?php echo $_skey . '-' . $_key . '-' . implode(";", $this->answers['userid'][trim($submission->FieldName)][$key]); ?>" data-ids="<?php echo $_question; ?>-<?php echo $_key . '|' . implode(";", $this->answers['userid'][trim($submission->FieldName)][$key]); ?>" data-respondents="<?php echo $respondents_count; ?>" data-title="title-<?php echo $_question; ?>" data-question="question-<?php echo $_question; ?>" data-answer="<?php echo $_question; ?>-answer-<?php echo $_key; ?>"><span>Add</span></button>
                                <button class="remove-answer-btn remove-answer-btn-<?php echo $_skey . '-' . $_key . '-' . implode(";", $this->answers['userid'][trim($submission->FieldName)][$key]); ?>" data-qaid="<?php echo $_skey . '-' . $_key . '-' . implode(";", $this->answers['userid'][trim($submission->FieldName)][$key]); ?>" data-ids="<?php echo $_question; ?>-<?php echo $_key . '|' . implode(";", $this->answers['userid'][trim($submission->FieldName)][$key]); ?>" type="button"><span>Remove</span></button>
                                <input type="hidden" name="rusername[]" value="<?php echo json_encode((object) $this->answers['username'][trim($submission->FieldName)][$key]); ?>" />
                            <?php endif; ?>
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
        jQuery(".add-answer-btn").click(function () {
            var dataQaid = (jQuery(this).attr("data-qaid")).replace(/;/g, "-");
            jQuery(this).parent().parent().find("i.fa-check-square-o").fadeIn(500);
            jQuery(this).parent().parent().find("span.answer-text").delay(500).fadeOut(200).delay(200).fadeIn("fast").delay(200).fadeOut(200).delay(200).fadeIn("fast");
            jQuery(this).fadeOut("fast", function () {
                jQuery(this).siblings(".remove-answer-btn").fadeIn("fast");
            });
            (briefingBuilder.ids).push(jQuery(this).attr("data-ids"));
            if (!jQuery("tr.quiz-id-" + dataQaid + "-selected").length) {
                jQuery("tr.after-selections").before("<tr class=\"selected-qqa quiz-id-" + dataQaid + "-selected\"><td colspan=\"3\"></td><td><div class=\"button-wrapper\"><button type=\"button\" class=\"delete-button\" onclick=\"briefingBuilder.removeQA('" + jQuery(this).attr("data-ids") + "','" + dataQaid + "')\" ><span>Remove</span></button></div></td></tr>");
                jQuery("tr.quiz-id-" + dataQaid + "-selected td:first-child").append("<div class=\"added-quiz-title\">" + jQuery(this).parents("table").attr("data-quiz-title") + "</div>");
            }
            jQuery("tr.quiz-id-" + dataQaid + "-selected td:first-child").append("<div class=\"added-quiz-question\">Q: " + jQuery("td." + jQuery(this).attr("data-question")).html() + "</div>");
            jQuery("tr.quiz-id-" + dataQaid + "-selected td:first-child").append("<div class=\"added-quiz-answer\">A: " + jQuery("span." + jQuery(this).attr("data-answer")).html() + " (" + jQuery(this).attr("data-respondents") + ")</div>");
            jQuery("tr.quiz-id-" + dataQaid + "-selected td:first-child").append("<div class=\"added-quiz-answer\">IDs: " + ((jQuery(this).attr("data-ids")).split("|")).slice(1, 2) + "</div>");
            if (jQuery("#send-to-matching").hasClass("selected")) {
                briefingBuilder.sendMatching();
            } else {
                briefingBuilder.sendToAll();
            }
        });
        jQuery(".quizzes-menu-ul li a").click(function (event) {
            event.preventDefault();
            jQuery(".quizzes-menu-ul li").each(function () {
                jQuery(this).removeClass("active");
            });
            jQuery(this).parent().addClass("active");
        });
        jQuery(".remove-answer-btn").click(function () {
            var dataQaid = (jQuery(this).attr("data-qaid")).replace(/;/g, "-");
            if (briefingBuilder.removeQA(jQuery(this).attr("data-ids"), dataQaid)) {
                jQuery(this).parent().parent().find("i.fa-check-square-o").css({display: "none"});
                jQuery(this).fadeOut("fast", function () {
                    jQuery(this).siblings(".add-answer-btn").fadeIn("fast");
                });
            }

        });
    });
</script>