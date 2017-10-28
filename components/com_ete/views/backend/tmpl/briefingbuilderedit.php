<?php
defined('_JEXEC') or die('Restricted access');

$countries = $this->model->getCountries();
$selected_countries = unserialize($this->LinkReview->countries);
?>

<div class="content-wrapper">
    <h1 class="content-title"></h1>

    <table class="content-table">
        <col width="25%">
        <col width="25%">
        <col width="25%">
        <col width="25%">
        <thead>
            <tr>
                <th colspan="4">Backend - Briefing Builder</th>
            </tr>
        </thead>
        <tbody>            
            <tr>
                <td colspan="4" class="table-label"><strong>URL:</strong></td>
            </tr>                
            <tr>
                <td colspan="4">
                    <input type="text" name="briefing_link" value="<?php echo $this->LinkReview->url; ?>" class="briefing-input-fields" placeholder="http://www.url.com" />
                    <div class="error-msg">*Wrong url format. Please include http:// or https://.</div>
                </td>
            </tr>
            <tr>
                <td colspan="4" class="table-label"><strong>Introduction:</strong></td>
            </tr>
            <tr>                
                <td colspan="4">
                    <textarea name="briefing_introduction" class="briefing-input-fields"><?php echo $this->LinkReview->intro; ?></textarea>
                    <div class="error-msg">*Introduction can't be empty. Please check.</div>
                </td>
            </tr> 
            <tr>
                <td colspan="4" class="table-label"><strong>Nationality:</strong></td>
            </tr>
            <tr>
                <td colspan="4">
                    <div class="country-list-wrap">
                        <div class="category-title"></div>
                        <ul class="country-list country-list-options" id="country-list-options">
                            <?php foreach ($countries as $key => $country): ?>
                                <?php if (!in_array($key, $selected_countries)): ?>
                                    <li data-value="<?php echo $key; ?>" data-isselected="<?php echo in_array($key, $selected_countries) ? 1 : 0; ?>"><i class="fa fa-plus-square-o" aria-hidden="true" onclick="briefingBuilder.selectCountry(this.parentElement, 'country-list-options')"></i><i class="fa fa-minus-square-o" aria-hidden="true" onclick="briefingBuilder.removedSelectedCountry(this.parentElement, 'selected-countries')"></i><?php echo $country; ?></li>
                                <?php endif; ?>
                            <?php endforeach; ?> 
                        </ul>
                    </div>
                    <div class="select-button-wrapper">
                        <button type="button" class="select-all-nationality" onclick="briefingBuilder.selectAllCountry()"><span>Select All >></span></button>
                        <button type="button" class="remove-all-nationality" onclick="briefingBuilder.removeAllSelectedCountry()"><span><< Remove All</span></button>
                    </div>
                    <div class="selected-country-list-wrap">
                        <div class="category-title"></div>
                        <ul class="country-list selected-countries" id="selected-countries">
                            <?php foreach ($countries as $key => $country): ?>
                                <?php if (in_array($key, $selected_countries)): ?>
                                    <li data-value="<?php echo $key; ?>" data-isselected="<?php echo in_array($key, $selected_countries) ? 1 : 0; ?>"><i class="fa fa-plus-square-o" aria-hidden="true" onclick="briefingBuilder.selectCountry(this.parentElement, 'country-list-options')"></i><i class="fa fa-minus-square-o" aria-hidden="true" onclick="briefingBuilder.removedSelectedCountry(this.parentElement, 'selected-countries')"></i><?php echo $country; ?></li>
                                <?php endif; ?>
                            <?php endforeach; ?> 
                        </ul>
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
                <td colspan="4">
                    <button type="button" id="send-to-all"><span>Send to all</span></button>
                    <button type="button" id="send-to-matching"><span>Send to matching</span></button>
                </td>
            </tr>
            <tr>
                <td colspan="4"><button type="button" id="search-answer"><span>Search Answer</span></button></td>            
            </tr>
            <tr>
                <td colspan="4" style="text-align: center; ">ANSWERS - Total IDs <span class="answers-count">0</span>  of [<?php echo $this->totalRegisteredUser; ?>]</td>            
            </tr>
            <tr class="after-selections">                
                <td colspan="4"><button type="button" id="start-new-link" onclick="briefingBuilder.save(<?php echo $this->LinkReview->id; ?>);"><span>Update Link</span></button></td>
            </tr>
        </tbody>
    </table>
</div>

<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery("#search-answer").click(function () {
            briefingBuilder.showQuestionAnswers();
        });
        jQuery("#send-to-all").click(function () {
            briefingBuilder.sendToAll();
        });
        jQuery("#send-to-matching").click(function () {
            briefingBuilder.sendMatching();
        });

//        briefingBuilder_ = {
//            ids: [],
//            allMatching: 0,
//            save: function () {
//
//                if (confirm('Are you sure?')) {
//                    jQuery.ajax({
//                        url: "<?php echo JURI::current(); ?>",
//                        data: {
//                            bid: '<?php echo $this->LinkReview->id; ?>',
//                            uids: (briefingBuilder.ids).toString(),
//                            url: jQuery("input[name=briefing_link]").val(),
//                            intro: jQuery("textarea[name=briefing_introduction]").val(),
//                            task: 'backend.update',
//                            allMatching: briefingBuilder.allMatching
//                        },
//                        type: "post",
//                        beforeSend: function () {
//
//                            var hasErrors = false;
//                            if (!briefingBuilder.validURL(jQuery("input[name=briefing_link]").val())) {
//                                jQuery("input[name=briefing_link]").siblings("div.error-msg").slideDown("fast");
//                                jQuery("input[name=briefing_link]").siblings("div.error-msg").delay(400).fadeOut(400).delay(400).fadeIn(400).delay(400).fadeIn(400);
//                                hasErrors = true;
//                            } else {
//                                jQuery("input[name=briefing_link]").siblings("div.error-msg").slideUp("fast");
//                            }
//
//                            if (jQuery("textarea[name=briefing_introduction]").val() == '') {
//                                jQuery("textarea[name=briefing_introduction]").siblings("div.error-msg").slideDown("fast");
//                                jQuery("textarea[name=briefing_introduction]").siblings("div.error-msg").delay(400).fadeOut(400).delay(400).fadeIn(400).delay(400).fadeIn(400);
//                                ;
//                                hasErrors = true;
//                            } else {
//                                jQuery("textarea[name=briefing_introduction]").siblings("div.error-msg").slideUp("fast");
//                            }
//
//                            if (!hasErrors && jQuery("tr.selected-qqa").length < 1) {
//                                jQuery("button#search-answer").click();
//                                hasErrors = true;
//                            }
//
//                            if (!hasErrors) {
//                                jQuery("tr.selected-qqa").each(function () {
//                                    jQuery(this).slideUp("fast", function () {
//                                        jQuery(this).remove();
//                                    });
//                                });
//                                jQuery.each(briefingBuilder.ids, function (index, value) {
//                                    jQuery("button.remove-answer-btn").each(function () {
//                                        if (jQuery(this).attr("data-ids") == value) {
//                                            jQuery(this).css({display: 'none'});
//                                            jQuery(this).siblings("button.add-answer-btn").css({display: 'inline-block'});
//                                            jQuery(this).parent().parent().find("i.fa-check-square-o").css({display: "none"});
//                                        }
//                                    });
//                                });
//                                jQuery(".answers-count").text(0);
//                            }
//
//                            return !hasErrors;
//                        },
//                        success: function (resp) {
//                            if (resp == 1) {
//                                alert("Saved successfully!");
//                                jQuery("input[name=briefing_link]").val("");
//                                jQuery("textarea[name=briefing_introduction]").val("");
//                                jQuery("tr.selected-qqa").remove();
//                                jQuery(".answers-count").text(0);
//                                briefingBuilder.ids = [];
//
//                                window.location = '<?php echo JROUTE::_('index.php?Itemid=207', false); ?>';
//                            }
//                        },
//                        error: function (jqXHR, textStatus, errorThrown) {
//                            console.log(jqXHR + ' - ' + textStatus + ' - ' + errorThrown);
//                        }
//                    });
//                }
//
//            },
//            showQuestionAnswers: function () {
//                jQuery.ajax({
//                    url: "<?php echo JURI::current(); ?>",
//                    data: "quizId=61&task=backend.showQuestionAnswers",
//                    type: "get",
//                    beforeSend: function () {
//                        briefingBuilder.overlay();
//                    },
//                    success: function (resp) {
//                        if (jQuery(".close-overlay").length < 1) {
//                            jQuery("#overlay-content-wrap").append('<div class=\"close-overlay\" onclick=\"briefingBuilder.closeOverlay();\">[x]close</div>');
//                            jQuery("#overlay-content-wrap").append(resp);
//                        }
//                    },
//                    error: function (jqXHR, textStatus, errorThrown) {
//                        console.log(jqXHR + ' - ' + textStatus + ' - ' + errorThrown);
//                    }
//                });
//            },
//            showLinkReview: function () {
//                jQuery.ajax({
//                    url: "<?php echo JURI::current(); ?>",
//                    data: {ids: briefingBuilder.ids} + "&task=backend.showLinkReview&url=" + jQuery("input[name=briefing_link]").val() + "&description=" + jQuery("input[name=briefing_introduction]").val(),
//                    type: "post",
//                    beforeSend: function () {
//
//                    },
//                    success: function (resp) {
//                        alert(resp);
//                    },
//                    error: function (jqXHR, textStatus, errorThrown) {
//                        console.log(jqXHR + ' - ' + textStatus + ' - ' + errorThrown);
//                    }
//                });
//            },
//            selectQuestions: function () {
//                jQuery.ajax({
//                    url: "<?php echo JURI::current(); ?>",
//                    data: "quizId=" + jQuery("select[name=category]").val() + '&task=backend.showAnswers',
//                    type: "get",
//                    beforeSend: function () {
//                        briefingBuilder.overlay();
//                    },
//                    success: function (resp) {
//
//                        jQuery("#overlay-content-wrap").append('<div class=\"close-overlay\" onclick=\"briefingBuilder.closeOverlay();\">[x]close</div>');
//                        jQuery("#overlay-content-wrap").append(resp);
//                    },
//                    error: function (jqXHR, textStatus, errorThrown) {
//                        console.log(jqXHR + ' - ' + textStatus + ' - ' + errorThrown);
//                    }
//                });
//            },
//            getQuestions: function () {
//                jQuery.ajax({
//                    url: "<?php echo JURI::current(); ?>",
//                    data: "quizId=" + jQuery("select[name=category]").val() + '&task=backend.getQuestions',
//                    type: "get",
//                    success: function (resp) {
//
//                        jQuery(".select-question-td").html(resp);
//                    },
//                    error: function (jqXHR, textStatus, errorThrown) {
//                        console.log(jqXHR + ' - ' + textStatus + ' - ' + errorThrown);
//                    }
//                });
//            },
//            getAnswers: function (ths) {
//                var selectedQuestionText = jQuery(ths).children("option:selected").text();
//                var selectedQuestionValue = jQuery(ths).val();
//                jQuery.ajax({
//                    url: "<?php echo JURI::current(); ?>",
//                    data: "quizId=" + jQuery("select[name=category]").val() + "&question=" + selectedQuestionValue + '&task=backend.getAnswers',
//                    type: "get",
//                    beforeSend: function () {
//                        jQuery("div.selected-question").remove();
//                        jQuery(ths).after("<div class=\"selected-question\"><i class=\"fa fa-arrow-right\" /> " + selectedQuestionText + "</div>");
//                    },
//                    success: function (resp) {
//                        jQuery(".select-answer-td").html(resp);
//                    },
//                    error: function (jqXHR, textStatus, errorThrown) {
//                        console.log(jqXHR + ' - ' + textStatus + ' - ' + errorThrown);
//                    }
//                });
//            },
//            getRespondents: function (ths) {
//                var selectedAnswerText = jQuery(ths).children("option:selected").text();
//                var selectedAnswerValue = jQuery(ths).val();
//                jQuery.ajax({
//                    url: "<?php echo JURI::current(); ?>",
//                    data: "quizId=" + jQuery("select[name=category]").val() + "&question=" + selectedAnswerValue + '&task=backend.getAnswers',
//                    type: "get",
//                    beforeSend: function () {
//                        jQuery("div.selected-answer").remove();
//                        jQuery(ths).after("<div class=\"selected-answer\"><i class=\"fa fa-arrow-right\" /> " + selectedAnswerText + "</div>");
//                    },
//                    success: function (resp) {
//
//                    },
//                    error: function (jqXHR, textStatus, errorThrown) {
//                        console.log(jqXHR + ' - ' + textStatus + ' - ' + errorThrown);
//                    }
//                });
//            },
//            overlay: function () {
//                if (jQuery("#overlay-bg").length < 1) {
//                    jQuery("body").append("<div id=\"overlay-bg\" style=\"display: none; \" />");
//                    jQuery("body").append("<div id=\"overlay-content-wrap\" style=\"display: none; \" />");
//                } else {
//                    jQuery("#overlay-bg").fadeIn("fast");
//                    jQuery("#overlay-content-wrap").fadeIn("fast");
//                }
//            },
//            closeOverlay: function () {
//                jQuery("#overlay-content-wrap").fadeOut("fast");
//                jQuery("#overlay-bg").fadeOut("fast");
//            },
//            removeQA: function (ids, qaid) {
//                var _ids = briefingBuilder.ids;
//                var index = _ids.indexOf(ids);
//                if (confirm("Are you sure you want to remove this Question/Answer from the list?")) {
//
//                    jQuery("tr.quiz-id-" + qaid + "-selected").fadeOut("fast", function () {
//                        jQuery(this).remove();
//                        if (index >= 0) {
//                            _ids.splice(index, 1);
//                        }
//                    });
//                    (briefingBuilder.ids).splice(index, 1);
//                    if (jQuery("#send-to-matching").hasClass("selected")) {
//                        briefingBuilder.sendMatching();
//                    } else {
//                        briefingBuilder.sendToAll();
//                    }
//
//                    jQuery("button.remove-answer-btn-" + qaid).parent().parent().find("i.fa-check-square-o").css({display: "none"});
//                    jQuery("button.remove-answer-btn-" + qaid).fadeOut("fast", function () {
//                        jQuery(this).siblings(".add-answer-btn").fadeIn("fast");
//                    });
//                    return true;
//                }
//
//                return false;
//            },
//            sendToAll: function () {
//                var _ids = briefingBuilder.ids;
//                var uids = [];
//                var _uids = [];
//                var uids_ = [];
//                briefingBuilder.allMatching = 0;
//                jQuery.each(_ids, function (index, value) {
//                    uids_ = value.split("|");
//                    _uids = uids_[1].split(";");
//                    jQuery.each(_uids, function (index, value) {
//                        if (uids.indexOf(value) < 0) {
//                            uids.push(value);
//                        }
//                    });
//                });
//                jQuery("#send-to-all").addClass("selected");
//                jQuery("#send-to-matching").removeClass("selected");
//                jQuery(".answers-count").text(uids.length);
//            },
//            sendMatching: function () {
//                var _ids = briefingBuilder.ids;
//                var nxtElement = [], nxtElement2 = [];
//                var commonElements = [];
//                briefingBuilder.allMatching = 1;
//                jQuery.each(_ids, function (index, value) {
//                    var _arr = value.split("|");
//                    var _arr2 = _arr[1].split(";");
//                    if (_ids.length > (index + 1)) {
//
//                        nxtElement = (_ids[index + 1]).split("|");
//                        nxtElement2 = nxtElement[1].split(";");
//                        jQuery.each(briefingBuilder.idIntersect(_arr2, nxtElement2), function (index, value) {
//                            if (commonElements.indexOf(value) < 0) {
//                                commonElements.push(value);
//                            }
//                        });
//                        console.log(commonElements);
//                    }
//                });
//                jQuery("#send-to-matching").addClass("selected");
//                jQuery("#send-to-all").removeClass("selected");
//                jQuery(".answers-count").text(commonElements.length);
//            },
//            idIntersect: function (a, b) {
//                var t;
//                if (b.length > a.length)
//                    t = b, b = a, a = t;
//                return a.filter(function (e) {
//                    return b.indexOf(e) > -1;
//                });
//            },
//            validURL: function (uri) {
//                var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
//                return regexp.test(uri);
//            }
//        };
        briefingBuilder.showQuestionAnswers(1);

        var _done = 0;
        var _timer = setInterval(function () {

            if (_done === 0) {
<?php
foreach (explode(",", $this->LinkReview->respondents) as $review) {
    ?>
                    jQuery(".add-answer-btn").each(function () {
                        if (jQuery(this).attr("data-ids") === '<?php echo $review; ?>') {
                            jQuery(this).click();
                            _done = 1;
                        }
                    });
    <?php
}
?>

                briefingBuilder.closeOverlay();

            } else {
                clearInterval(_timer);
            }
        }, 1000);


<?php if ($this->LinkReview->matching_all == 1) { ?>
            jQuery("#send-to-matching").click();
<?php } ?>

    });
</script>