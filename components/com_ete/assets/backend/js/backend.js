jQuery(document).ready(function () {
    jQuery("select[name=category]").change(function () {
        briefingBuilder.getQuestions();
    });
    jQuery("#select-question-answers").click(function () {
        briefingBuilder.selectQuestions();
    });
    jQuery("#search-answer").click(function () {
        briefingBuilder.showQuestionAnswers();
    });
    jQuery("#send-to-all").click(function () {
        briefingBuilder.sendToAll();
    });
    jQuery("#send-to-matching").click(function () {
        briefingBuilder.sendMatching();
    });
    jQuery("#save-to-briefings").click(function () {
        briefingBuilder.showLinkReview();
    });

    jQuery("#select-all-nationality").click(function () {
        jQuery("select[name=nationality]").children("option").each(function () {
            jQuery(this).attr("selected", true);
        });
    });

    jQuery("select[name=nationality]").children("option").each(function () {
        jQuery(this).attr("selected", true);
    });


    briefingBuilder = {
        allIps: jQuery("input[name=allresp]").val(),
        ids: [],
        allMatching: 0,
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
                jQuery("input[name=briefing-id-count]").val(briefingBuilder.allIps);
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
                url: jQuery("form#emailBuilderForm").attr("action"),
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
        save: function (bid) {
            var selectedCountries = [];
            var _bid = parseInt(bid) > 0 ? parseInt(bid) : 0;
            var _task = parseInt(bid) > 0 ? 'backend.update' : 'backend.save';

            var body = $("html, body");
            body.stop().animate({scrollTop: 0}, 2000, 'swing', function () {

            });


            jQuery("#selected-countries").children("li").each(function () {
                selectedCountries.push(jQuery(this).data('value'));
            });

            jQuery.ajax({
                url: jQuery("form#emailBuilderForm").attr("action"),
                data: {
                    bid: _bid,
                    uids: (briefingBuilder.ids).toString(),
                    url: jQuery("input[name=briefing_link]").val(),
                    intro: jQuery("textarea[name=briefing_introduction]").val(),
                    countries: selectedCountries,
                    task: _task,
                    allMatching: briefingBuilder.allMatching
                },
                type: "post",
                beforeSend: function () {

                    if (confirm('Are you sure?')) {
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
                            ;
                            hasErrors = true;
                        } else {
                            jQuery("textarea[name=briefing_introduction]").siblings("div.error-msg").slideUp("fast");
                        }

                        if (!hasErrors && jQuery("tr.selected-qqa").length < 1) {
                            jQuery("button#search-answer").click();
                            hasErrors = true;
                        }

                        if (!hasErrors && _task !== 'backend.update') {
                            jQuery("tr.selected-qqa").each(function () {
                                jQuery(this).slideUp("fast", function () {
                                    jQuery(this).remove();
                                });
                            });

                            jQuery.each(briefingBuilder.ids, function (index, value) {
                                jQuery("button.remove-answer-btn").each(function () {
                                    if (jQuery(this).attr("data-ids") == value) {
                                        jQuery(this).css({display: 'none'});
                                        jQuery(this).siblings("button.add-answer-btn").css({
                                            display: 'inline-block'});

                                        jQuery(this).parent().parent().find("i.fa-check-square-o").css({
                                            display: "none"});
                                    }
                                });
                            });

                            jQuery(".answers-count").text(0);
                        }

                        return !hasErrors;

                    } else {
                        return false;
                    }


                },
                success: function (resp) {
                    if (resp == 1) {
                        alert("Saved successfully!");

                        if (_task !== 'backend.update') {
                            jQuery("input[name=briefing_link]").val("");
                            jQuery("textarea[name=briefing_introduction]").val("");
                            jQuery("tr.selected-qqa").remove();
                            jQuery(".answers-count").text(0);

                            briefingBuilder.ids = [];
                        }
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR + ' - ' + textStatus + ' - ' + errorThrown);
                }
            });
        },
        showQuestionAnswers: function (hidden) {
            jQuery.ajax({
                url: jQuery("form#emailBuilderForm").attr("action"),
                data: "quizId=62&task=backend.showQuestionAnswers",
                type: "get",
                beforeSend: function () {
                    briefingBuilder.overlay(hidden);
                },
                success: function (resp) {
                    if (jQuery(".close-overlay").length < 1) {
                        jQuery("#overlay-content-wrap").append('<div class=\"close-overlay\" onclick=\"briefingBuilder.closeOverlay();\">[x]close</div>');
                        jQuery("#overlay-content-wrap").append(resp);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR + ' - ' + textStatus + ' - ' + errorThrown);
                }
            });
        },
        showLinkReview: function () {
            jQuery.ajax({
                url: jQuery("form#emailBuilderForm").attr("action"),
                data: {ids: briefingBuilder.ids} + "&task=backend.showLinkReview&url=" + jQuery("input[name=briefing_link]").val() + "&description=" + jQuery("input[name=briefing_introduction]").val(),
                type: "post",
                beforeSend: function () {

                },
                success: function (resp) {
                    alert(resp);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR + ' - ' + textStatus + ' - ' + errorThrown);
                }
            });
        },
        selectQuestions: function () {
            jQuery.ajax({
                url: jQuery("form#emailBuilderForm").attr("action"),
                data: "quizId=" + jQuery("select[name=category]").val() + '&task=backend.showAnswers',
                type: "get",
                beforeSend: function () {
                    briefingBuilder.overlay();
                },
                success: function (resp) {

                    jQuery("#overlay-content-wrap").append('<div class=\"close-overlay\" onclick=\"briefingBuilder.closeOverlay();\">[x]close</div>');
                    jQuery("#overlay-content-wrap").append(resp);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR + ' - ' + textStatus + ' - ' + errorThrown);
                }
            });
        },
        getQuestions: function () {
            jQuery.ajax({
                url: jQuery("form#emailBuilderForm").attr("action"),
                data: "quizId=" + jQuery("select[name=category]").val() + '&task=backend.getQuestions',
                type: "get",
                success: function (resp) {

                    jQuery(".select-question-td").html(resp);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR + ' - ' + textStatus + ' - ' + errorThrown);
                }
            });
        },
        getAnswers: function (ths) {
            var selectedQuestionText = jQuery(ths).children("option:selected").text();
            var selectedQuestionValue = jQuery(ths).val();
            jQuery.ajax({
                url: jQuery("form#emailBuilderForm").attr("action"),
                data: "quizId=" + jQuery("select[name=category]").val() + "&question=" + selectedQuestionValue + '&task=backend.getAnswers',
                type: "get",
                beforeSend: function () {
                    jQuery("div.selected-question").remove();
                    jQuery(ths).after("<div class=\"selected-question\"><i class=\"fa fa-arrow-right\" /> " + selectedQuestionText + "</div>");
                },
                success: function (resp) {
                    jQuery(".select-answer-td").html(resp);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR + ' - ' + textStatus + ' - ' + errorThrown);
                }
            });
        },
        getRespondents: function (ths) {
            var selectedAnswerText = jQuery(ths).children("option:selected").text();
            var selectedAnswerValue = jQuery(ths).val();
            jQuery.ajax({
                url: jQuery("form#emailBuilderForm").attr("action"),
                data: "quizId=" + jQuery("select[name=category]").val() + "&question=" + selectedAnswerValue + '&task=backend.getAnswers',
                type: "get",
                beforeSend: function () {
                    jQuery("div.selected-answer").remove();
                    jQuery(ths).after("<div class=\"selected-answer\"><i class=\"fa fa-arrow-right\" /> " + selectedAnswerText + "</div>");
                },
                success: function (resp) {

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR + ' - ' + textStatus + ' - ' + errorThrown);
                }
            });
        },
        overlay: function (hidden) {
            var visibility = hidden === 1 ? 'none' : 'block';

            var body = $("html, body");
            body.stop().animate({scrollTop: 0}, 500, 'swing', function () {

            });

            if (jQuery("#overlay-bg").length < 1) {
                jQuery("body").append("<div id=\"overlay-bg\" />");
                jQuery("body").append("<div id=\"overlay-content-wrap\" style=\"display: " + visibility + "\" />");
            } else {
                jQuery("#overlay-bg").fadeIn("fast");
                jQuery("#overlay-content-wrap").fadeIn("fast");
            }
        },
        closeOverlay: function () {
            jQuery("#overlay-content-wrap").fadeOut("fast");
            jQuery("#overlay-bg").fadeOut("fast");
        },
        removeQA: function (ids, qaid) {
            var _ids = briefingBuilder.ids;
            var index = _ids.indexOf(ids);

            if (confirm("Are you sure you want to remove this Question/Answer from the list?")) {

                jQuery("tr.quiz-id-" + qaid + "-selected").fadeOut("fast", function () {
                    jQuery(this).remove();
                    if (index >= 0) {
                        _ids.splice(index, 1);
                    }
                });

                (briefingBuilder.ids).splice(index, 1);

                if (jQuery("#send-to-matching").hasClass("selected")) {
                    briefingBuilder.sendMatching();
                } else {
                    briefingBuilder.sendToAll();
                }

                jQuery("button.remove-answer-btn-" + qaid).parent().parent().find("i.fa-check-square-o").css({
                    display: "none"});
                jQuery("button.remove-answer-btn-" + qaid).fadeOut("fast", function () {
                    jQuery(this).siblings(".add-answer-btn").fadeIn("fast");
                });

                return true;

            }

            return false;
        },
        sendToAll: function () {
            var _ids = briefingBuilder.ids;
            var uids = [];
            var _uids = [];
            var uids_ = [];
            briefingBuilder.allMatching = 0;
            jQuery.each(_ids, function (index, value) {
                uids_ = value.split("|");
                _uids = uids_[1].split(";");
                jQuery.each(_uids, function (index, value) {
                    if (uids.indexOf(value) < 0) {
                        uids.push(value);
                    }
                });
            });

            jQuery("#send-to-all").addClass("selected");
            jQuery("#send-to-matching").removeClass("selected");
            jQuery(".answers-count").text(uids.length);
        },
        sendMatching: function () {
            var _ids = briefingBuilder.ids;
            var nxtElement = [], nxtElement2 = [];
            var commonElements = [];
            briefingBuilder.allMatching = 1;
            jQuery.each(_ids, function (index, value) {
                var _arr = value.split("|");
                var _arr2 = _arr[1].split(";");
                if (_ids.length > (index + 1)) {

                    nxtElement = (_ids[index + 1]).split("|");
                    nxtElement2 = nxtElement[1].split(";");
                    jQuery.each(briefingBuilder.idIntersect(_arr2, nxtElement2), function (index, value) {
                        if (commonElements.indexOf(value) < 0) {
                            commonElements.push(value);
                        }
                    });
                }
            });

            jQuery("#send-to-matching").addClass("selected");
            jQuery("#send-to-all").removeClass("selected");
            jQuery(".answers-count").text(commonElements.length);
        },
        idIntersect: function (a, b) {
            var t;
            if (b.length > a.length)
                t = b, b = a, a = t;
            return a.filter(function (e) {
                return b.indexOf(e) > -1;
            });
        },
        validURL: function (uri) {
            var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
            return regexp.test(uri);
        }
    };
}
);

jQuery(window).load(function () {
    var body = $("html, body");
    body.stop().animate({scrollTop: 0}, 500, 'swing', function () {

    });
});