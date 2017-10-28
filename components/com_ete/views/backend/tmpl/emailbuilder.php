<?php
defined('_JEXEC') or die;

$day = date('w');
$week_start = date('F d, Y', strtotime('-' . $day . ' days'));
$week_end = date('F d, Y', strtotime('+' . (6 - $day) . ' days'));

$allIds = $this->model->getTotalRespondents();
$allIps = $this->model->getSubmissionsIp();

$allCountriesCode = $this->model->getAllCountryCode();
$allRespondents = $this->model->countSelectedRespondents($allCountriesCode);

$addedRespondents = $this->model->getBriefingRespondents();
$_addedRespondents = $this->model->countSelectedRespondents($addedRespondents);

$_unique_ips = array();

foreach ($allIps as $ip) {
    $_unique_ips[$ip->UserId] = $ip->UserId;
}

$countries = $this->model->getCountries();
?>

<div class="email-builder-wrap content-wrapper">
    <div class="email-builder-week">
        <div class="field-label-wrap">WEEK</div>
        <div class="field-value-wrap"><?php echo $week_start . ' - ' . $week_end; ?></div>
        <div class="clearer">&nbsp;</div>
    </div>
    <div class="email-builder-total-ids">
        <table class="email-builder-total-ids-table">
            <colgroup width="20%" />
            <colgroup width="30%" />
            <colgroup width="20%" />
            <colgroup width="30%" />
            <tr>
                <td class="table-td-label">IDs addressed</td>
                <td><?php echo $_addedRespondents; ?></td>
                <td class="table-td-label">IDs remaining</td>
                <td><?php echo $allRespondents - $_addedRespondents; ?></td>
            </tr>
        </table>

        <div class="section-title">EMAIL BUILDER</div>
        <form action="#" method="post" id="email-builder-form-new">
            <table class="email-builder-tbl">
                <thead>
                    <tr>
                        <th colspan="2">FORM</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="2" class="table-label">Countries</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="country-list-wrap">
                                <div class="category-title"></div>
                                <ul class="country-list country-list-options" id="country-list-options">
                                    <?php foreach ($countries as $key => $country): ?>
                                        <li data-value="<?php echo $key; ?>"><i class="fa fa-plus-square-o" aria-hidden="true" onclick="briefingForm.selectCountry(this.parentElement, 'country-list-options')"></i><i class="fa fa-minus-square-o" aria-hidden="true" onclick="briefingForm.removedSelectedCountry(this.parentElement, 'selected-countries')"></i><?php echo $country; ?></li>
                                    <?php endforeach; ?> 
                                </ul>
                            </div>
                            <div class="select-button-wrapper">
                                <button type="button" class="select-all-nationality" onclick="briefingForm.selectAllCountry()"><span>Select All >></span></button>
                                <button type="button" class="remove-all-nationality" onclick="briefingForm.removeAllSelectedCountry()"><span><< Remove All</span></button>
                            </div>
                            <div class="selected-country-list-wrap">
                                <div class="category-title"></div>
                                <ul class="country-list selected-countries" id="selected-countries"></ul>
                            </div>
                            <div class="clearer"></div>

                            <select name="nationality" class="country-select" multiple>
                                <?php foreach ($countries as $key => $country): ?>
                                    <option value="<?php echo $key; ?>"><?php echo $country; ?></option>
                                <?php endforeach; ?> 
                            </select>

                            <div class="error-msg">*Please select at least one.</div>
                        </td>                
                    </tr>
                    <tr>                        
                        <td colspan="2" class="table-label">ID Count</td>
                    </tr>
                    <tr>
                        <td>                        
                            <input type="text" placeholder="" name="briefing-id-count" readonly="readonly" value="<?php echo $allRespondents; ?>" />
                            <div class="error-msg">*Title can't be empty.</div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="table-label">Email Title</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="text" placeholder="[Text here ...]" name="briefing-title" value="" />
                            <div class="error-msg">*Title can't be empty.</div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="table-label">Intro</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <textarea type="text" placeholder="[Text here ...]" name="briefing-intro" class="briefing-input-fields"></textarea>
                            <div class="error-msg">*Intro can't be empty.</div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="table-label">Sign-off</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="text" placeholder="[Text here ...]" name="briefing-sign-off" value="" />
                            <div class="error-msg">*Sign off can't be empty.</div>
                        </td>
                    </tr>
                    <tr>
                        <td class="align-center" colspan="2">
                            <button type="button" id="briefing-form-save" class="briefings-save" onclick="briefingForm.save('email-builder-form-new');"><span>Save</span></button>                    
                            <input type="hidden" name="form_id" value="0" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>

        <div class="email-review-section"></div>

    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function () {
//        var adjustment;
//
//        $("ul.country-list").sortable({
//            group: 'country-list',
//            pullPlaceholder: false,
//            // animation on drop
//            onDrop: function ($item, container, _super) {
//                var $clonedItem = $('<li/>').css({height: 0});
//                $item.before($clonedItem);
//                $clonedItem.animate({'height': $item.height()});
//
//                $item.animate($clonedItem.position(), function () {
//                    $clonedItem.detach();
//                    _super($item, container);
//                });
//            },
//
//            // set $item relative to cursor position
//            onDragStart: function ($item, container, _super) {
//                var offset = $item.offset(),
//                        pointer = container.rootGroup.pointer;
//
//                adjustment = {
//                    left: pointer.left - offset.left,
//                    top: pointer.top - offset.top
//                };
//
//                _super($item, container);
//            },
//            onDrag: function ($item, position) {
//                $item.css({
//                    left: position.left - adjustment.left,
//                    top: position.top - adjustment.top
//                });
//            }
//        });



        jQuery(".email-review-label").click(function () {
            jQuery(this).siblings(".email-review-tbl").slideToggle("fast", function () {
                if (jQuery(this).is(":visible")) {
                    console.log(jQuery(this).siblings(".email-review-label").siblings('span').length);
                    jQuery('span.' + jQuery(this).attr('id')).text("[click here to hide details]");
                } else {
                    jQuery('span.' + jQuery(this).attr('id')).text("[click here to show details]");
                }
            });
        });
//        jQuery("select[name=nationality]").children("option").attr("selected", true);

        jQuery(".select-all-nationality").click(function () {
            jQuery("select[name=nationality]").children("option").each(function () {
                jQuery(this).attr("selected", true);
                jQuery("input[name=briefing-id-count]").val(briefingForm.allIps);
            });
            jQuery("#country-list-options").children("li").each(function () {
                jQuery("#selected-countries").append(jQuery(this));
            });
        });

        jQuery("select[name=nationality]").change(function () {
            if (jQuery("select[name=nationality] :selected").length === jQuery("select[name=nationality] option").length) {
                jQuery("input[name=briefing-id-count]").val(briefingForm.allIps);
            } else {
                briefingForm.countIds(jQuery("select[name=nationality]").val());
            }
        });
//        jQuery(".country-list-options").children("li").children("i.fa-plus-square-o").dblclick(function(){
//            jQuery(".selected-countries").append(jQuery(this).parent());
//        });
//        jQuery(".country-list-options").children("li").children("i.fa-plus-square-o").click(function(){
//            jQuery(".selected-countries").append(jQuery(this).parent());
//        });

//        jQuery(".selected-countries").children("li").dblclick(function(){
//            jQuery(".country-list-options").prepend(jQuery(this));
//        });

        briefingForm = {
            allIps: <?php echo intval($allRespondents); ?>,
            sortList: function (ul) {
                var ul = document.getElementById(ul);
                Array.from(ul.getElementsByTagName("LI"))
                        .sort((a, b) => a.textContent.localeCompare(b.textContent))
                        .forEach(li => ul.appendChild(li));
            },
            selectCountry: function (ths, ul) {
                jQuery(".selected-countries").append(jQuery(ths));
                jQuery("select[name=nationality]").children("option").each(function (index) {
                    if (jQuery(this).attr('value') === jQuery(ths).data('value')) {
                        jQuery(this).attr("selected", true);
                    }
                });

//                briefingForm.sortList(ul);
            },
            removedSelectedCountry: function (ths, ul) {
                jQuery("#country-list-options").prepend(jQuery(ths));
                jQuery("select[name=nationality]").children("option").each(function (index) {
                    if (jQuery(this).attr('value') === jQuery(ths).data('value')) {
                        jQuery(this).attr("selected", false);
                    }
                });

//                briefingForm.sortList(ul);
            },
            selectAllCountry: function () {
                jQuery("select[name=nationality]").children("option").each(function () {
                    jQuery(this).attr("selected", true);
                    jQuery("input[name=briefing-id-count]").val(briefingForm.allIps);
                });
                jQuery("#country-list-options").children("li").each(function () {
                    jQuery("#selected-countries").append(jQuery(this));
                });
            },
            removeAllSelectedCountry: function () {
                jQuery("#selected-countries").children("li").each(function () {
                    jQuery("#country-list-options").append(jQuery(this));
                });
                jQuery("select[name=nationality]").children("option").each(function (index) {
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
            getEmailReviews: function () {
                jQuery.ajax({
                    url: "<?php echo JURI::current(); ?>",
                    data: {
                        task: 'backend.emailReviewsForms'
                    },
                    type: "post",
                    beforeSend: function () {
                    },
                    success: function (resp) {
                        jQuery(".email-review-section").html(resp);
                    }
                });
            },
            sendToArchive: function (event, bid) {
                event.preventDefault();
            },
            save: function (form) {

                jQuery.ajax({
                    url: "<?php echo JURI::current(); ?>",
                    data: {
                        ips: jQuery("#" + form + " select[name=nationality]").val(),
                        title: jQuery("#" + form + " input[name=briefing-title]").val(),
                        intro: jQuery("#" + form + " textarea[name=briefing-intro]").val(),
                        signoff: jQuery("#" + form + " input[name=briefing-sign-off]").val(),
                        fid: jQuery("#" + form + " input[name=form_id]").val(),
                        task: 'backend.saveBriefing'
                    },
                    type: "post",
                    beforeSend: function () {

                        var hasErrors = false;
                        if (jQuery("#" + form + " textarea[name=briefing-intro]").val() == '') {
                            jQuery("#" + form + " textarea[name=briefing-intro]").siblings("div.error-msg").slideDown("fast");
                            jQuery("#" + form + " textarea[name=briefing-intro]").siblings("div.error-msg").delay(400).fadeOut(400).delay(400).fadeIn(400).delay(400).fadeIn(400);
                            hasErrors = true;
                        } else {
                            jQuery("#" + form + " textarea[name=briefing-intro]").siblings("div.error-msg").slideUp("fast");
                        }

                        if (jQuery("#" + form + " select[name=nationality]").val() == '' || jQuery("select[name=nationality]").val() == null) {
                            jQuery("#" + form + " select[name=nationality]").siblings("div.error-msg").slideDown("fast");
                            jQuery("#" + form + " select[name=nationality]").siblings("div.error-msg").delay(400).fadeOut(400).delay(400).fadeIn(400).delay(400).fadeIn(400);
                            hasErrors = true;
                        } else {
                            jQuery("#" + form + " select[name=nationality]").siblings("div.error-msg").slideUp("fast");
                        }

                        if (jQuery("#" + form + " input[name=briefing-title]").val() == '') {
                            jQuery("#" + form + " input[name=briefing-title]").siblings("div.error-msg").slideDown("fast");
                            hasErrors = true;
                        } else {
                            jQuery("#" + form + " textarea[name=briefing-title]").siblings("div.error-msg").slideUp("fast");
                        }

                        if (jQuery("#" + form + " input[name=briefing-sign-off]").val() == '') {
                            jQuery("#" + form + " input[name=briefing-sign-off]").siblings("div.error-msg").slideDown("fast");
                            hasErrors = true;
                        } else {
                            jQuery("#" + form + " textarea[name=briefing-sign-off]").siblings("div.error-msg").slideUp("fast");
                        }

                        return !hasErrors;
                    },
                    success: function (resp) {
//                        if (resp == 1) {
                        alert("Briefing form saved successfully!");
                        jQuery("#" + form + " input").val('');
                        jQuery("#" + form + " textarea").val('');
                        jQuery(".select-all-nationality").click();
                        jQuery(".email-review-section").html(resp);
//                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR + ' - ' + textStatus + ' - ' + errorThrown);
                    }
                });
            },
            addNew: function () {
                jQuery("select[name=nationality]").val('');
                jQuery("input[name=briefing-title]").val('');
                jQuery("textarea[name=briefing-intro]").val('');
                jQuery("input[name=briefing-sign-off]").val('');
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
            overlay: function () {
                if (jQuery("#overlay-bg").length < 1) {
                    jQuery("body").append("<div id=\"overlay-bg\" />");
                    jQuery("body").append("<div id=\"overlay-content-wrap\" class=\"overlay-edit-content\" />");
                } else {
                    jQuery("#overlay-bg").fadeIn("fast");
                    jQuery("#overlay-content-wrap").fadeIn("fast");
                }
            },
            closeOverlay: function () {
                jQuery("#overlay-content-wrap").fadeOut("fast");
                jQuery("#overlay-bg").fadeOut("fast");
            },
            loadForm: function (fid) {

                if (fid < 1) {
                    jQuery("select[name=nationality]").children("option").attr("selected", false);
                    jQuery("input[name=\"briefing-title\"]").val('');
                    jQuery("textarea[name=\"briefing-intro\"]").val('');
                    jQuery("input[name=\"briefing-sign-off\"]").val('');
                    jQuery("input[name=\"form_id\"]").val(0);
                } else {
                    jQuery.ajax({
                        url: "<?php echo JURI::current(); ?>",
                        data: {
                            fid: fid,
                            task: 'backend.getFormDetails'
                        },
                        type: "post",
                        dataType: "json",
                        beforeSend: function () {},
                        success: function (resp) {
                            var ips = resp.ipaddress;
                            var _ips = [];
                            jQuery.each(ips, function (index, value) {
                                jQuery("select[name=nationality]").children("option[value=" + value + "]").attr("selected", true);
                            });
                            jQuery("input[name=\"briefing-title\"]").val(resp.title);
                            jQuery("textarea[name=\"briefing-intro\"]").val(resp.intro);
                            jQuery("input[name=\"briefing-sign-off\"]").val(resp.signoff);
                            jQuery("input[name=\"form_id\"]").val(resp.id);
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            console.log(jqXHR + ' - ' + textStatus + ' - ' + errorThrown);
                        }
                    });
                }

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
            }
        };
        briefingForm.getEmailReviews();
    });
</script>