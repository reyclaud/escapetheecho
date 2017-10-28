<?php
defined('_JEXEC') or die;

$day = date('w');
$week_start = date('m-d-Y', strtotime('-' . $day . ' days'));
$week_end = date('m-d-Y', strtotime('+' . (6 - $day) . ' days'));

$allIds = $this->model->getTotalRegisteredUsers();
$allIps = $this->model->getSubmissionsIp();

$countries = $this->model->getCountries();
?>
<div class="section-title">EMAIL REVIEW</div>

<?php
foreach ($this->briefingForms as $key => $form):
    $ips = unserialize($form->ip_address);

    $formid = $key + 1;
    ?>    
    <form action="#" method="post" id="email-builder-form-edit-<?php echo $formid; ?>">
        <div class="email-review-wrap email-review-wrap<?php echo $key + 1; ?>">
            <label class="email-review-label">FORM <?php echo $key + 1; ?> - <span class="email-builder-form-edit-<?php echo $key + 1; ?>"><?php echo strtoupper($form->title); ?></span> <span class="email-builder-form-edit-click email-review-<?php echo $key + 1; ?>-click">[click to show details]</span></label>
            <table class="email-review-tbl email-review-tbl-<?php echo $key + 1; ?>" id="email-review-<?php echo $key + 1; ?>">            
                <tr>
                    <td>Countries</td>
                    <td>
                        <div class="country-list-wrap">
                            <div class="category-title"></div>
                            <ul class="country-list country-list-options" id="country-list-options-<?php echo $key + 1; ?>">
                                <?php foreach ($countries as $_key => $country): ?>
                                    <?php if (!in_array($_key, $ips)): ?>
                                        <li data-value="<?php echo $_key; ?>"><i class="fa fa-plus-square-o"  aria-hidden="true" onclick="briefingForm2.selectCountry(this.parentElement, 'country-list-options')"></i><i class="fa fa-minus-square-o" aria-hidden="true" onclick="briefingForm2.removedSelectedCountry(this.parentElement, 'selected-countries')"></i><?php echo $country; ?></li>
                                    <?php endif; ?>
                                <?php endforeach; ?> 
                            </ul>
                        </div>
                        <div class="select-button-wrapper">
                            <button type="button" class="select-all-nationality" disabled="disabled" onclick="briefingForm2.selectAllCountry(<?php echo $key + 1; ?>)"><span>Select All >></span></button>
                            <button type="button" class="remove-all-nationality" disabled="disabled" onclick="briefingForm2.removeAllSelectedCountry(<?php echo $key + 1; ?>)"><span><< Remove All</span></button>
                        </div>
                        <div class="selected-country-list-wrap">
                            <div class="category-title"></div>
                            <ul class="country-list selected-countries" id="selected-countries-<?php echo $key + 1; ?>">
                                <?php foreach ($countries as $_key => $country): ?>
                                    <?php if (in_array($_key, $ips)): ?>
                                        <li data-value="<?php echo $_key; ?>"><i class="fa fa-plus-square-o" aria-hidden="true" onclick="briefingForm2.selectCountry(this.parentElement)"></i><i class="fa fa-minus-square-o" aria-hidden="true" onclick="briefingForm2.removedSelectedCountry(this.parentElement)"></i><?php echo $country; ?></li>
                                    <?php endif; ?>
                                <?php endforeach; ?> 
                            </ul>
                        </div>
                        <div class="clearer"></div>
                        <select name="ereview-nationality[]" class="country-select" multiple readonly="readonly">
                            <?php foreach ($countries as $_key => $country): ?>
                                <option value="<?php echo $_key; ?>" <?php echo in_array($_key, $ips) ? 'selected="selected"' : ''; ?>><?php echo $country; ?></option>
                            <?php endforeach; ?>                            
                        </select>
                    </td>                
                </tr>
                <tr>
                    <td>ID Count</td>
                    <td>
                        <input type="text" placeholder="[Text here ...]" name="ereview-briefing-id-count" readonly="readonly" value="<?php echo $this->model->countSelectedRespondents($ips); ?>" readonly="readonly" />                        
                    </td>
                </tr>
                <tr>
                    <td>Email Title</td>
                    <td>
                        <input type="text" placeholder="[Text here ...]" name="ereview-briefing-title" value="<?php echo $form->title; ?>" readonly="readonly" />
                        <div class="error-msg">*Title can't be empty.</div>
                    </td>
                </tr>
                <tr>
                    <td>Intro</td>
                    <td>
                        <textarea type="text" placeholder="[Text here ...]" name="ereview-briefing-intro" class="briefing-input-fields" readonly="readonly"><?php echo $form->intro; ?></textarea>
                        <div class="error-msg">*Intro can't be empty.</div>
                    </td>
                </tr>
                <tr>
                    <td>Sign-off</td>
                    <td>
                        <input type="text" placeholder="[Text here ...]" name="ereview-briefing-sign-off" value="<?php echo $form->signoff; ?>" readonly="readonly" />
                        <div class="error-msg">*Sign off can't be empty.</div>
                    </td>
                </tr>            
                <tr>
                    <td class="align-center" colspan="2">
                        <button type="button" class="briefings-update" onclick="briefingForm2.save('email-builder-form-edit-<?php echo $formid; ?>')"><span>Save</span></button>
                        <button type="button" class="briefings-edit"><span>Edit</span></button>
                        <button type="button" class="briefings-delete" onclick="briefingForm2.deleteBriefing(<?php echo $form->id; ?>, this);"><span>Delete</span></button>
                        <button type="button" class="briefings-send" onclick="briefingForm2.send(<?php echo $form->id; ?>, this);"><span>Send</span></button>
                        <input type="hidden" name="form_id" value="<?php echo $form->id; ?>" />
                    </td>
                </tr>
            </table>
        </div>
    </form>
<?php endforeach; ?>

<div class="section-action"><button type="button" class="send-to-all-btn" onclick="briefingForm2.sendAll()"><span>SEND TO ALL</span></button></div>


<script type="text/javascript">
    jQuery(document).ready(function () {

        jQuery(".briefings-edit").click(function () {
            jQuery(this).css({
                display: 'none'
            });

            jQuery(this).siblings("button.briefings-update").css({
                display: 'inline'
            });

            jQuery(this).parents("form").find("button").attr("disabled", false);
            jQuery(this).parents("form").find("button").attr("disabled", false);

            jQuery(this).parents("form").find("input").not("input[name=ereview-briefing-id-count]").attr("readonly", false);
            jQuery(this).parents("form").find("textarea").attr("readonly", false);
            jQuery(this).parents("form").find("select").attr("readonly", false);

            briefingForm2.enableEdit = true;
        });

        jQuery(".email-review-label").click(function () {
            jQuery(this).siblings(".email-review-tbl").slideToggle("fast", function () {
                if (jQuery(this).is(":visible")) {
                    jQuery('span.' + jQuery(this).attr('id') + '-click').text("[click here to hide details]");
                } else {
                    jQuery('span.' + jQuery(this).attr('id') + '-click').text("[click here to show details]");
                }
            });
        });

        briefingForm2 = {
            allIps: <?php echo intval($allIds); ?>,
            enableEdit: false,
            selectCountry: function (ths) {
                if (briefingForm2.enableEdit) {
                    jQuery(".selected-countries").append(jQuery(ths));
                    jQuery("select[name=ereview-nationality]").children("option").each(function (index) {
                        if (jQuery(this).attr('value') === jQuery(ths).data('value')) {
                            jQuery(this).attr("selected", true);
                        }
                    });
                }
            },
            removedSelectedCountry: function (ths) {
                if (briefingForm2.enableEdit) {
                    jQuery(".country-list-options").prepend(jQuery(ths));
                    jQuery("select[name=ereview-nationality]").children("option").each(function (index) {
                        if (jQuery(this).attr('value') === jQuery(ths).data('value')) {
                            jQuery(this).attr("selected", false);
                        }
                    });
                }

            },
            selectAllCountry: function (index) {
                jQuery("select[name='ereview-nationality\[\]']:eq(" + (index - 1) + ")").children("option").each(function () {
                    jQuery(this).attr("selected", true);
                    jQuery("input[name=briefing-id-count]").val(briefingForm2.allIps);
                });

                jQuery("#country-list-options-" + index).children("li").each(function () {
                    jQuery("#selected-countries-" + index).append(jQuery(this));
                });
            },
            removeAllSelectedCountry: function (index) {
                jQuery("#selected-countries-" + index).children("li").each(function () {
                    jQuery("#country-list-options-" + index).append(jQuery(this));
                });
                jQuery("select[name='ereview-nationality\[\]']:eq(" + (index - 1) + ")").children("option").each(function (index) {
                    jQuery(this).attr("selected", false);
                });
            },
            countIds: function (ccode) {
                jQuery.ajax({
                    url: "<?php echo JURI::current(); ?>",
                    data: {
                        ccode: ccode,
                        task: 'backend.getIpInfo'
                    },
                    type: "post",
                    beforeSend: function () {

                    },
                    success: function (resp) {
                        jQuery("input[name=briefing-id-count]").val(resp);
                    }
                });
            },
            editBriefing: function (event, bid) {
                event.preventDefault();
                jQuery.ajax({
                    url: "<?php echo JURI::current(); ?>",
                    data: {
                        bid: bid,
                        task: 'backend.getBriefingDetails'
                    },
                    type: "post",
                    beforeSend: function () {
                        briefingForm.overlay();
                    },
                    success: function (resp) {
                        jQuery("#overlay-content-wrap").html('');
                        jQuery("#overlay-content-wrap").append('<div class=\"close-overlay\" onclick=\"briefingForm.closeOverlay();\">[x]close</div>');
                        jQuery("#overlay-content-wrap").append(resp);
                    }
                });
            },
            deleteBriefing: function (bid, ths) {
                if (confirm("Are you sure you want to delete this email review?")) {
                    jQuery.ajax({
                        url: "<?php echo JURI::current(); ?>",
                        data: {
                            bid: bid,
                            task: 'backend.deleteBriefing'
                        },
                        type: "post",
                        beforeSend: function () {

                        },
                        success: function (resp) {
                            alert("Email review successfully deleted!");

                            jQuery(ths).parents("form").fadeOut("fast", function () {});
                        }
                    });
                }
            },
            send: function (bid, ths) {
                jQuery.ajax({
                    url: "<?php echo JURI::current(); ?>",
                    data: {
                        task: 'backend.send',
                        bid: bid
                    },
                    type: "post",
//                    dataType: "json",
                    beforeSend: function () {},
                    success: function (resp) {
                        console.log(resp);
                        jQuery(ths).parents("form").fadeOut("fast", function () {});

                        alert('Successfully sent!');
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR + ' - ' + textStatus + ' - ' + errorThrown);
                    }
                });
            },
            sendAll: function () {
                jQuery.ajax({
                    url: "<?php echo JURI::current(); ?>",
                    data: {
                        task: 'backend.sendAll'
                    },
                    type: "post",
                    dataType: "json",
                    beforeSend: function () {},
                    success: function (resp) {

                        jQuery("table.briefing-part1-tb2").find("tbody tr").not("tbody tr:last-child").remove();
                        jQuery("table.briefing-part1-tb2").find("tbody tr:last-child").slideUp("fast");
                        alert('Successfully sent to All!');
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR + ' - ' + textStatus + ' - ' + errorThrown);
                    }
                });
            },
            save: function (form) {
                var title = jQuery("#" + form + " input[name=ereview-briefing-title]").val();
                jQuery.ajax({
                    url: "<?php echo JURI::current(); ?>",
                    data: {
                        ips: jQuery("#" + form + " select[name='ereview-nationality\[\]']").val(),
                        title: title,
                        intro: jQuery("#" + form + " textarea[name=ereview-briefing-intro]").val(),
                        signoff: jQuery("#" + form + " input[name=ereview-briefing-sign-off]").val(),
                        fid: jQuery("#" + form + " input[name=form_id]").val(),
                        task: 'backend.saveBriefing'
                    },
                    type: "post",
                    beforeSend: function () {

                        var hasErrors = false;

                        jQuery(".briefings-edit").parents("form").find("button.select-all-nationality").attr("disabled", true);
                        jQuery(".briefings-edit").parents("form").find("button.remove-all-nationality").attr("disabled", true);

                        if (jQuery("#" + form + " textarea[name=ereview-briefing-intro]").val() == '') {
                            jQuery("#" + form + " textarea[name=ereview-briefing-intro]").siblings("div.error-msg").slideDown("fast");
                            jQuery("#" + form + " textarea[name=ereview-briefing-intro]").siblings("div.error-msg").delay(400).fadeOut(400).delay(400).fadeIn(400).delay(400).fadeIn(400);
                            hasErrors = true;
                        } else {
                            jQuery("#" + form + " textarea[name=ereview-briefing-intro]").siblings("div.error-msg").slideUp("fast");
                        }

                        if (jQuery("#" + form + " select[name='ereview-nationality\[\]']").val() == '' || jQuery("select[name='ereview-nationality\[\]']").val() == null) {
                            jQuery("#" + form + " select[name='ereview-nationality\[\]']").siblings("div.error-msg").slideDown("fast");
                            jQuery("#" + form + " select[name='ereview-nationality\[\]']").siblings("div.error-msg").delay(400).fadeOut(400).delay(400).fadeIn(400).delay(400).fadeIn(400);
                            hasErrors = true;
                        } else {
                            jQuery("#" + form + " select[name='ereview-nationality\[\]']").siblings("div.error-msg").slideUp("fast");
                        }

                        if (jQuery("#" + form + " input[name=ereview-briefing-title]").val() == '') {
                            jQuery("#" + form + " input[name=ereview-briefing-title]").siblings("div.error-msg").slideDown("fast");
                            hasErrors = true;
                        } else {
                            jQuery("#" + form + " textarea[name=ereview-briefing-title]").siblings("div.error-msg").slideUp("fast");
                        }

                        if (jQuery("#" + form + " input[name=ereview-briefing-sign-off]").val() == '') {
                            jQuery("#" + form + " input[name=ereview-briefing-sign-off]").siblings("div.error-msg").slideDown("fast");
                            hasErrors = true;
                        } else {
                            jQuery("#" + form + " textarea[name=ereview-briefing-sign-off]").siblings("div.error-msg").slideUp("fast");
                        }

                        return !hasErrors;


                    },
                    success: function (resp) {
                        console.log(resp);
                        jQuery("span." + form).text(title.toUpperCase());
                        jQuery("#" + form + " input").attr("readonly", true);
                        jQuery("#" + form + " textarea").attr("readonly", true);
                        jQuery("#" + form + " select[name='ereview-nationality\[\]']").attr("readonly", true);

                        jQuery("#" + form + " button.briefings-update").css({display: 'none'});
                        jQuery("#" + form + " button.briefings-edit").css({display: 'inline'});

                        alert("Briefing form updated successfully!");
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR + ' - ' + textStatus + ' - ' + errorThrown);
                    }
                });
            }
        };
    });
</script>