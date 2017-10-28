<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$totalResponders = $this->model->getTotalRespondents();

$recipients = array();

foreach ($this->get('LinkReviews') as $link) {
    $_resp = explode(",", $link->respondents);

    foreach ($_resp as $resp) {
        $recipient = explode("|", $resp);
        $_recipients = explode(";", $recipient[1]);

        foreach ($_recipients as $_recipient) {
            if (!in_array($_recipient, $recipients) && $_recipient>0) {                 
                array_push($recipients, $_recipient);
            }
        }
    }
}
?>

<div class="content-wrapper">
    <table class="link-review-table">
        <col width="25px" />
        <col />
        <col />
        <col width="130px" />        
        <col width="70px" />
        <col width="115px" />
        <col width="60px" />
        <col width="70px" />
        <thead>
            <tr>
                <td style="text-align: center" colspan="8">WEEK: 17/07/2017 - 23/07/2017 | <strong>Total IDs: <?php echo count($recipients); ?> of [<?php echo count($totalResponders); ?>]</strong></td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th></th>
                <th>Link</th>
                <th>Answer</th>
                <th>Countries (IPs)</th>
                <th>Count</th>
                <th>All/Matching</th>
                <th></th>
                <th></th>
            </tr>
            <?php
            $number = 0;
            foreach ($this->get('LinkReviews') as $link) {
                $_answers = explode(",", $link->respondents);

                $number++;
                ?>
            <tr class="qa-records-tr">
                    <td style="padding: 0; text-align: center;" class="number-column"><strong><?php echo $number; ?>.</strong></td>
                    <td>
                        <div class="link_url"><strong>URL:</strong> <?php echo $link->url; ?></div>
                        <div class="link_intro"><strong>Introduction:</strong> <?php echo $link->intro; ?></div>
                    </td>
                    <td>
                        <?php
                        $_fieldNames = array();
                        $ids = array();
                        $qa_counter = 1;
                        foreach ($_answers as $key => $_answer) {


                            $answer = explode("-", $_answer);
                            $answer2 = explode("|", $answer[1]);


                            $questions = $this->model->getQuestionAnswer($answer[0]);

                            $_ids = explode(";", $answer2[1]);

                            foreach ($_ids as $id) {
                                if (!in_array($id, $ids)) {
                                    array_push($ids, $id);
                                }
                            }

                            foreach ($questions as $question) {

                                if (!isset($_fieldNames[$question->FieldName])) {
                                    $_fieldNames[$question->FieldName] = $question->FieldName;
                                    $answers_ = explode("\n", $question->FieldValue);
                                    
//                                    print_r($question);
//                                    print_r($answer2[0]);

                                    echo '<p><strong>Q.' . $qa_counter . '</strong> ' . $question->FieldName . '</p>';
                                    echo '<p><strong>A.' . $qa_counter . '</strong> ' . $answers_[0] . '</p>';

                                    $qa_counter++;
                                }
                            }
                        }
                        ?>
                        <?php // echo $link->respondents; ?>
                    </td>
                    <td><?php echo implode('<br/>', $this->model->getCountryNameByCode(unserialize($link->countries))); ?></td>
                    <td><?php echo count($ids); ?></td>
                    <td>
                        <?php echo $link->matching_all == 1 ? 'MATCHING' : 'ALL' ?>
                    </td>
                    <td><a href="<?php echo JROUTE::_("index.php?Itemid=208&bid={$link->id}", false); ?>">Edit</a></td>
                    <td><a href="#" onclick="linkreview.delete(this, '<?php echo intval($link->id); ?>', event);">Delete</a></td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
</div>

<script type="text/javascript">
    jQuery(document).ready(function () {
        linkreview = {
            delete: function (ths, linkid, event) {
                event.preventDefault();
                if (confirm('Are you sure?')) {
                    jQuery(ths).parent().parent().fadeOut('slow', function () {
                        jQuery(ths).parent().parent().remove();

                        jQuery("table.link-review-table td.number-column").each(function (index) {
                            jQuery(this).html('<strong>' + (index + 1) + '.</strong>');
                        });

                        jQuery.ajax({
                            url: "<?php echo JURI::current(); ?>",
                            data: {
                                lid: linkid,
                                task: 'backend.deleteLinkReview'
                            },
                            type: "get",
                            beforeSend: function () {
                            },
                            success: function (resp) {

                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                console.log(jqXHR + ' - ' + textStatus + ' - ' + errorThrown);
                            }
                        });
                    });
                }

            }
        }
    });
</script>