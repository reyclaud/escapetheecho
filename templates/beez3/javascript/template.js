/**
 * @package     Joomla.Site
 * @subpackage  Templates.beez3
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @since       3.2
 */

(function ($)
{
    $(document).ready(function ()
    {
        $('*[rel=tooltip]').tooltip()

        // Turn radios into btn-group
        $('.radio.btn-group label').addClass('btn');

        $('fieldset.btn-group').each(function () {
            // Handle disabled, prevent clicks on the container, and add disabled style to each button
            if ($(this).prop('disabled')) {
                $(this).css('pointer-events', 'none').off('click');
                $(this).find('.btn').addClass('disabled');
            }
        });

        $(".btn-group label:not(.active)").click(function ()
        {
            var label = $(this);
            var input = $('#' + label.attr('for'));

            if (!input.prop('checked')) {
                label.closest('.btn-group').find("label").removeClass('active btn-success btn-danger btn-primary');
                if (input.val() == '') {
                    label.addClass('active btn-primary');
                } else if (input.val() == 0) {
                    label.addClass('active btn-danger');
                } else {
                    label.addClass('active btn-success');
                }
                input.prop('checked', true);
            }
        });
        $(".btn-group input[checked=checked]").each(function ()
        {
            if ($(this).val() == '') {
                $("label[for=" + $(this).attr('id') + "]").addClass('active btn-primary');
            } else if ($(this).val() == 0) {
                $("label[for=" + $(this).attr('id') + "]").addClass('active btn-danger');
            } else {
                $("label[for=" + $(this).attr('id') + "]").addClass('active btn-success');
            }
        });

        $("button[name='form[next]']").click(function () {
            $("#rsform_3_page_0 li.rsform-block").each(function () {

                if ($(this).is(":visible") && !$(this).hasClass("rsform-block-escapetheecho") && !$(this).hasClass("rsform-block-introtext")) {

                    if ($(this).next().find("input[type=checkbox]").length > 0 || $(this).next().find("input[type=radio]").length > 0) {

                        if ($(this).next().find("input:checked").length > 0) {

                            $(this).slideUp("500");

                            $(this).nextAll().each(function () {
                                if ($(this).find("input:checked").length < 1) {
                                    $(this).slideDown("500");

                                    if ($(this).hasClass("rsform-block-yourname")) {
                                        $("#rsform_3_page_0 li.rsform-block.rsform-block-emailaddress").slideDown("500");
                                        $("#rsform_3_page_0 li.rsform-block.rsform-block-socialmedia").slideDown("500");
                                        $("#rsform_3_page_0 li.rsform-block.rsform-block-secondchance").slideDown("500");
                                        $("#rsform_3_page_0 li.rsform-block.rsform-block-submit").slideDown("500");

                                        $("#rsform_3_page_0 li.rsform-block-next, #rsform_3_page_0 li.rsform-block-timer").css({display: 'none'});

                                        clearInterval(timer.timeinterval);
                                    } else {
                                        clearInterval(timer.timeinterval);
                                        timer.initializeClock('myTimer', timer.getToday(timer.deadline));
                                    }

                                    return false;
                                }
                            });

                            return false;
                        } else {
                            $(this).slideUp("500");
                            $(this).next().slideDown("500");

                            if ($(this).next().hasClass("rsform-block-yourname")) {
                                $("#rsform_3_page_0 li.rsform-block.rsform-block-emailaddress").slideDown("500");
                                $("#rsform_3_page_0 li.rsform-block.rsform-block-socialmedia").slideDown("500");
                                $("#rsform_3_page_0 li.rsform-block.rsform-block-secondchance").slideDown("500");
                                $("#rsform_3_page_0 li.rsform-block.rsform-block-submit").slideDown("500");

                                $("#rsform_3_page_0 li.rsform-block-next, #rsform_3_page_0 li.rsform-block-timer").css({display: 'none'});

                                clearInterval(timer.timeinterval);
                            } else {
                                clearInterval(timer.timeinterval);
                                timer.initializeClock('myTimer', timer.getToday(timer.deadline));
                            }
                        }

                        return false;
                    } else {
                        $(this).slideUp("500");
                        $(this).next().slideDown("500");

                        if ($(this).next().hasClass("rsform-block-yourname")) {
                            $("#rsform_3_page_0 li.rsform-block.rsform-block-emailaddress").slideDown("500");
                            $("#rsform_3_page_0 li.rsform-block.rsform-block-socialmedia").slideDown("500");
                            $("#rsform_3_page_0 li.rsform-block.rsform-block-secondchance").slideDown("500");
                            $("#rsform_3_page_0 li.rsform-block.rsform-block-submit").slideDown("500");

                            $("#rsform_3_page_0 li.rsform-block-next, #rsform_3_page_0 li.rsform-block-timer").css({display: 'none'});

                            clearInterval(timer.timeinterval);
                        } else {
                            clearInterval(timer.timeinterval);
                            timer.initializeClock('myTimer', timer.getToday(timer.deadline));
                        }


                        return false;
                    }
                }
            });
        });




        timer = {
            deadline: 30,
            timeinterval: null,
            leftPad: function (number, targetLength) {
                var output = number + '';
                while (output.length < targetLength) {
                    output = '0' + output;
                }
                return output;
            },
            getToday: function (endtime) {
                var today = new Date();
                today.setSeconds(today.getSeconds() + endtime);

                var msec = today.getMilliseconds();
                var sec = today.getSeconds();
                var min = today.getMinutes();
                var hh = today.getHours();
                var dd = today.getDate();
                var mm = today.getMonth() + 1;

                var yyyy = today.getFullYear();
                if (dd < 10) {
                    dd = '0' + dd;
                }
                if (mm < 10) {
                    mm = '0' + mm;
                }
                return yyyy + '-' + mm + '-' + dd + ' ' + hh + ':' + min + ':' + sec;
            },
            getTimeRemaining: function (deadline) {
                var t = Date.parse(deadline) - Date.parse(new Date());

                var milliseconds = ((t / 1000) - Math.floor(t / 1000)).toFixed(1) + '';
                var seconds = Math.floor((t / 1000) % 60) + 1;
                var minutes = Math.floor((t / 1000 / 60) % 60) + 1;

                return {
                    'total': t,
                    'minutes': timer.leftPad(minutes, 2),
                    'seconds': timer.leftPad(seconds, 2),
                    'milliseconds': milliseconds.split(".")[1]
                };
            },
            initializeClock: function (id, deadline) {
                var clock = document.getElementById(id);
                var secondsToShow = 9;
                var chimeStop = 8;

                this.timeinterval = setInterval(function () {
                    var t = timer.getTimeRemaining(deadline);

                    if (t.seconds >= 11 && t.seconds < 13) {
                        $('#audio')[0].play();
                    }

                    if (t.seconds <= secondsToShow) {
                        clock.innerHTML = "<span class=\"blue-text\">Seconds to Next Question:</span> " + t.seconds + ':' + t.milliseconds;
                    } else {
                        clock.innerHTML = "<span class=\"blue-text\">Seconds to Next Question:</span> " + (secondsToShow + 1) + ':' + "0";
                    }

                    if (t.seconds > (secondsToShow + 3) && jQuery("#myTimer").is(":visible")) {
                        jQuery("#myTimer").css({display: 'none'});
                    }


                    if (t.seconds <= (secondsToShow + 5) && t.seconds > secondsToShow && (parseInt(t.milliseconds) === 5 || parseInt(t.milliseconds) === 0)) {
                        jQuery("#myTimer").fadeToggle(500);
                    }

                    if (t.seconds <= secondsToShow && !jQuery("#myTimer").is(":visible")) {
                        jQuery("#myTimer").stop().clearQueue().fadeIn("fast");
                    }

                    if (t.seconds < 8) {
                        $('#audio')[0].pause();
                        $('#audio')[0].currentTime = 0;
                    }

                    if (t.total <= 0 && t.milliseconds < 1) {

                        if (!$("#rsform_3_page_0 li.rsform-block-submit").is(":visible")) {

                            $('#audio')[0].pause();
                            $('#audio')[0].currentTime = 0;
                            $("button#next").click();

                        } else {
//                            $("#rsform_3_page_0 li.rsform-block-next, #rsform_3_page_0 li.rsform-block-timer").css({display: 'none'});
                        }
                    }
                }, 100);
            }
        }

        $(".ete-button.go-button").click(function () {
            $("#rsform_3_page_0 li.rsform-block:nth-child(1)").slideUp("fast", function () {
                $("#rsform_3_page_0 li.rsform-block:nth-child(2)").slideUp("fast", function () {
                    $("#rsform_3_page_0 li.rsform-block:nth-child(3)").slideDown("fast", function () {
                        $("#rsform_3_page_0 li.rsform-block-next, #rsform_3_page_0 li.rsform-block-timer").css({display: 'inline-block'});
//                        $("#myTimer").html("<script type=\"text/javascript\">timer.initializeClock('myTimer', timer.getToday(timer.deadline))</script>");
                        clearInterval(timer.timeinterval);
                        timer.initializeClock('myTimer', timer.getToday(timer.deadline));
                    });
                });
            });

        });

        $(".rsform-block-timer .formBody").attr("id", "myTimer");

        $(".answerMissedQuestions").click(function (event) {
            event.preventDefault();
            $("#politicsandcommunity").find("ol.formContainer li.rsform-block").each(function () {
                if ($(this).find("input[type=checkbox]").length > 1 || $(this).find("input[type=radio]").length > 1) {
                    if ($(this).find("input:checked").length < 1) {

                        $("#rsform_3_page_0 li.rsform-block:gt(1)").css({display: 'none'});

                        $(this).css({display: 'list-item'});

                        $("#rsform_3_page_0 li.rsform-block-next, #rsform_3_page_0 li.rsform-block-timer").css({display: 'inline-block'});
                        clearInterval(timer.timeinterval);
                        timer.initializeClock('myTimer', timer.getToday(timer.deadline));

                        return false;
                    }
                }
            });
        });
    })
})(jQuery);
