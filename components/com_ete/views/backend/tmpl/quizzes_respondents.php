<?php
defined('_JEXEC') or die('Restricted access');

$respondents = $this->respondents;
?>
<div class="respondents-wrapper">
    <table class="respondents-table">
        <thead><tr><th>Respondents</th><th>&nbsp;</th></tr></thead>
        <?php
        foreach ($respondents as $respondent):
            if ($respondent->name) {
                ?>
                <tr><td><input type="hidden" name="respondent_id[]" value="<?php echo $respondent->id; ?>" /><?php echo $respondent->name; ?></td><td><?php echo $respondent->email; ?></td></tr>
                <?php
            }
        endforeach;
        ?>
    </table>

    <div class="action-controls">
        <button type="button" id="add-to-bank" title="Add to 'Total Bank'" onclick="respondents.addToBank()"><span>Add</span></button>
    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function () {
        respondents = {
            addToBank: function () {
                var ids = [];
                var json_ids;
                jQuery("input[name=\"respondent_id\[\]\"]").each(function (indx, val) {
                    ids.push(jQuery(this).val());
                });

                json_ids = JSON.stringify(ids);

                this.showBank(ids);
            },
            showBank: function (ids) {
                jQuery.ajax({
                    url: '<?php echo JURI::current(); ?>',
                    data: 'ids=' + encodeURIComponent(JSON.stringify(ids)) + '&task=backend.addToBank',
                    type: 'post',
                    beforeSend: function () {

                    },
                    success: function (resp) {
                        jQuery(".respondents-wrapper").slideUp("slow", function () {
                            jQuery("#overlay-content-wrap").append(resp);
                        })
                    }
                });
            },
            nextAttachLink: function () {
                jQuery.ajax({
                    url: '<?php echo JURI::current(); ?>',
                    data: 'task=backend.attachLink',
                    type: 'post',
                    beforeSend: function () {

                    },
                    success: function (resp) {
                        jQuery(".total-bank-wrapper").slideUp("slow", function () {
                            jQuery("#overlay-content-wrap").append(resp);
                        })
                    }
                });
            },
            sendIds: function (url, description) {
                jQuery.ajax({
                    url: '<?php echo JURI::current(); ?>',
                    data: 'task=backend.sendIds&br_url=' + jQuery("#" + url).val() + '&br_description=' + jQuery("#" + description).val(),
                    type: 'post',
                    beforeSend: function () {

                    },
                    success: function (resp) {
                        jQuery(".briefing-link-wrapper").slideUp("slow", function () {
                            jQuery("#overlay-content-wrap").append(resp);
                        })
                    }
                });
            }
        };
    });
</script>