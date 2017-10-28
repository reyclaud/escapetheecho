<?php
defined('_JEXEC') or die('Restricted access');

$submissions = $this->submissions;
?>

<h1 class="content-title"><?php echo $this->formTitle; ?></h1>
<div class="search-wrapper"><input type="text" value="" placeholder="Search ..." id="search-answer" /><button type="button" class="ete-button go-search-button">Go!</button></div>
<div class="overlay-content">
    <table>
        <col width="40%">
        <col width="60%">
        <thead>
            <tr>
                <th>Questions</th>
                <th>Answers and Votes</th>
            </tr>
        </thead>        <?php
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
                        $count_respondents = 0;
                        ?>
                        <div class="ete-backend-answer-div">
                            <div class="ete-backend-answer-div-left">
                                <i class="fa fa-check-square-o" aria-hidden="true"></i>
                                <span class="answer-text"><?php echo $item; ?></span>
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
                                    <button class="add-answer-btn" type="button"><span>Add</span></button>
                                    <button class="remove-answer-btn" type="button"><span>Remove</span></button>
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
</div>
<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery(".add-answer-btn").click(function () {
            jQuery(this).parent().parent().find("i.fa-check-square-o").fadeIn(500);
            jQuery(this).parent().parent().find("span.answer-text").delay(500).fadeOut(200).delay(200).fadeIn("fast").delay(200).fadeOut(200).delay(200).fadeIn("fast");
            jQuery(this).fadeOut("fast", function () {
                jQuery(this).siblings(".remove-answer-btn").fadeIn("fast");
            });
        });

        jQuery(".remove-answer-btn").click(function () {
            jQuery(this).parent().parent().find("i.fa-check-square-o").css({display: "none"});
            jQuery(this).fadeOut("fast", function () {
                jQuery(this).siblings(".add-answer-btn").fadeIn("fast");
            });
        });
    });
</script>