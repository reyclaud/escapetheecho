<?php
defined('_JEXEC') or die('Restricted access');
?>

<div class="content-wrapper">
    <form action="" method="post">
        <table>
            <thead>
                <tr>
                    <th colspan="2">Edit Details</th>
                </tr>
            </thead>
            <tr>
                <td>URL:</td>
                <td>
                    <input type="text" name="briefing_link" value="<?php echo $this->briefing->url; ?>" placeholder="http://www.domain.com" class="briefing-input-fields" />
                    <div class="error-msg">*Wrong url format. Please include http:// or https://.</div>
                </td>
            </tr>
            <tr>
                <td>Introduction:</td>
                <td>
                    <textarea type="text" name="briefing_introduction" class="briefing-input-fields"><?php echo $this->briefing->intro; ?></textarea>
                    <div class="error-msg">*Introduction can't be empty. Please check.</div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="button" id="briefing-save" onclick="briefingBuilder.save(<?php echo $this->briefing->id; ?>)"><span>Save</span></button>
                </td>
            </tr>
        </table>
    </form>
</div>

<script type="text/javascript">
    jQuery(document).ready(function () {

        briefingBuilder = {
            save: function (bid) {
                jQuery.ajax({
                    url: "<?php echo JURI::current(); ?>",
                    data: {
                        bid: bid,
                        url: jQuery("input[name=briefing_link]").val(),
                        intro: jQuery("textarea[name=briefing_introduction]").val(),
                        task: 'backend._saveBriefing'
                    },
                    type: "post",
                    beforeSend: function () {

                        var hasErrors = false;

                        if (!briefingBuilder.validURL(jQuery("input[name=briefing_link]").val())) {
                            jQuery("input[name=briefing_link]").siblings("div.error-msg").slideDown("fast");
//                            jQuery("input[name=briefing_link]").siblings("div.error-msg").delay(400).fadeOut(400).delay(400).fadeIn(400).delay(400).fadeIn(400);
                            hasErrors = true;
                        } else {
                            jQuery("input[name=briefing_link]").siblings("div.error-msg").slideUp("fast");
                        }

                        if (jQuery("textarea[name=briefing_introduction]").val() == '') {
                            jQuery("textarea[name=briefing_introduction]").siblings("div.error-msg").slideDown("fast");
//                            jQuery("textarea[name=briefing_introduction]").siblings("div.error-msg").delay(400).fadeOut(400).delay(400).fadeIn(400).delay(400).fadeIn(400);
                            hasErrors = true;
                        } else {
                            jQuery("textarea[name=briefing_introduction]").siblings("div.error-msg").slideUp("fast");
                        }

                        return !hasErrors;

                    },
                    success: function (resp) {
                        if (resp == 1) {
                            alert("Saved successfully!");
                            
                            jQuery("#briefing_intro_"+bid).html(jQuery("textarea[name=briefing_introduction]").val());
                            jQuery("#briefing_url_"+bid).html(jQuery("input[name=briefing_link]").val());
                            
                            briefingBuilder.closeOverlay();
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR + ' - ' + textStatus + ' - ' + errorThrown);
                    }
                });
            },            
            closeOverlay: function () {
                jQuery("#overlay-content-wrap").fadeOut("fast");
                jQuery("#overlay-bg").fadeOut("fast");
            },
            validURL: function (uri) {
                var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
                return regexp.test(uri);
            }
        };
    }
    );
</script>