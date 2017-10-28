$(document).ready(function () {
    var getUrl = window.location;
    var baseUrl = getUrl.protocol + "//" + getUrl.host;
    $(".drag-drop-form").each(function () {
        $(this).find(".formControls").css({
            width: ($(this).find(".drag-drop-formbody").outerWidth() + $(this).find(".option-sort-wrapper").outerWidth() + $(this).find(".drag-drop-formbody-right").outerWidth()) + "px"
        });
    });
    $(".what-echoos a").attr("href", baseUrl + "/what-are-echoos");
    $(".what-echoos a").attr("target", "_blank");
    $(".dragdealer").each(function () {
        var parnt = $(this).parents("div.rsform-block");
        parnt.children(".formControlLabel").after($(this));
        parnt.addClass("lickert-scale");
    });

    setInterval(function () {
        $(".rsform-block.rsform-block-finishquizoverlay .blinking").toggleClass("show");
    }, 500);
    $("ul.nav.menu.ete-menu").children("li").hover(function () {
        $(this).children("a").addClass("hover");
    }, function () {
        $(this).children("a").removeClass("hover");
    });
    $("li.item-135 ul.nav-child").children("li").each(function (index) {
        if (index % 2) {
            if (index !== 3) {
                $(this).children("a").append("<span class=\"percentage-done\">&nbsp;20% done</span>");
            }
        } else {
            $(this).children("a").append("<span class=\"percentage-done\">&nbsp;<span class=\"all-done\"><i class=\"fa fa-check\" aria-hidden=\"true\"></i> Finished</span></span>");
        }

        if (index === 3) {
            $(this).children("a").append("<span class=\"percentage-done\">&nbsp;NOT done</span>");
        }
    });
    $(".rsform-block.rsform-block-echocoins, .what-are-echoos, .instruction-link").css({
        right: (jQuery(".nav.menu.ete-menu").children("li:last-child").outerWidth() / 2) - (jQuery(".nav.menu.ete-menu").children("li:last-child").children("a").width() / 2) + "px"
    });
    $(".rsform-block.rsform-block-next button").css({
        marginRight: (jQuery(".nav.menu.ete-menu").children("li:last-child").outerWidth() / 2) - (jQuery(".nav.menu.ete-menu").children("li:last-child").children("a").width() / 2) + "px"
    });
    $("input.dataimage:first-child").not(".rsformVerticalClear input.dataimage").each(function () {
        $(this).parent().parent().parent().prepend("<img src=\"" + baseUrl + "/" + $(this).attr("data-image") + "\" usemap=\"#" + $(this).attr("data-usemap") + "\" alt=\"\" />");
    });
    $(".rsformVerticalClear:first-child input.dataimage").each(function () {
        $(this).parent().parent().parent().parent().prepend("<img src=\"" + baseUrl + "/" + $(this).attr("data-image") + "\" alt=\"\" />");
    });
    $(".option-sort-wrapper").children(".formBody").addClass("drag-drop-formbody").prepend("<ol class=\"simple_with_animation drag horizontal\" />");
    $(".option-sort-wrapper").siblings(".formBody").addClass("drag-drop-formbody").prepend("<ol class=\"simple_with_animation drag vertical\" />");
    $(".option-sort-wrapper").siblings(".formBody").children(".rsformVerticalClear").each(function () {
        var _ths = $(this);
        _ths.siblings(".simple_with_animation").append("<li><div class=\"rsformVerticalClear\">" + _ths.html() + "</div></li>");
        _ths.remove();
    });
    $(".option-sort-wrapper").each(function () {
        $(this).parent().parent().addClass("drag-drop-form");
    });
    $(".drag-drop-formbody-right").each(function () {

        $(this).parent().siblings(".formControlLabel").css({textAlign: "center"});
        var dragdrop_li = $(this).siblings(".drag-drop-formbody").children("ol").children("li");
        dragdrop_li.each(function (index) {
            var indx = index + 1;
            if (dragdrop_li.length >= 10) {
                if (indx > (Math.floor(dragdrop_li.length / 4)) && indx <= (Math.floor(dragdrop_li.length / 4) * 2)) {
                    $(".drag-drop-formbody-right").children("ol").append($(this));
                }

                if (indx > (Math.floor(dragdrop_li.length / 4) * 2)) {
                    $(".drag-drop-formbody-center").children("ol").append($(this));
                }
            } else {
                if (indx > (Math.floor(dragdrop_li.length / 2)) && indx <= (Math.floor(dragdrop_li.length / 2) * 2)) {
                    $(".drag-drop-formbody-right").children("ol").append($(this));
                }
            }
        });
    });
    var coinCounter = -1;
    var coins = ['1', '5', '6'];
    var coinInterval = setInterval(function () {
        $("span.echoCoinsRandom").removeClass("coin" + coins[coinCounter]);
        coinCounter++;
        coinCounter = coinCounter >= coins.length ? 0 : coinCounter;
        $("span.echoCoinsRandom").addClass("coin" + coins[coinCounter]);
    }, 1000);
    $(".rsform-block").each(function () {
        $(this).find("input[data-area=\"echocoins\"]").parents("div.rsform-block").addClass("echocoins");
    });
    
    $(".formBody").each(function () {
        var bodyWidth = 0;
        var inputBodyWidth = 0;
        var parent_trigger = false;
        
        var formControlLabel = $(this).parent().siblings(".formControlLabel");

        formControlLabel.css({display: 'inline'});

        $(this).children(".rsformVerticalClear").each(function () {
            parent_trigger = true;
            if ($(this).find("label").outerWidth() > bodyWidth) {
                bodyWidth = $(this).find("label").outerWidth();
                inputBodyWidth = $(this).find("input[type=checkbox]").outerWidth();
            }

            $(this).find("label").before('<i class=\"fa fa-circle-thin\" aria-hidden=\"true\"></i>');

            $(this).find("label").click(function () {
                $(this).siblings("i").toggleClass("fa-circle-thin");
                $(this).siblings("i").toggleClass("fa-circle");
            });
        });

        if (parent_trigger) {
            $(this).parent().css({minWidth: formControlLabel.outerWidth() + 'px', width: (bodyWidth + inputBodyWidth + 100) + "px", marginLeft: "auto", marginRight: "auto"});
            $(this).parent().siblings(".formControlLabel").css({display: 'inline-block'});
        }
        
        formControlLabel.css({display: 'block'});
    });

    $(".formBody.options-has-image").each(function () {

        var bodyWidth = 0;
        var inputBodyWidth = 0;
        var parent_trigger = false;

        $(this).parent().siblings(".formControlLabel").css({display: 'inline'});

        $(this).children(".rsformVerticalClear").each(function () {
            parent_trigger = true;
            if ($(this).find("label").outerWidth() > bodyWidth) {
                bodyWidth = $(this).find("label").outerWidth();
                inputBodyWidth = $(this).find("input[type=checkbox]").outerWidth();
            }

            $(this).find("label").before('<i class=\"fa fa-circle-thin\" aria-hidden=\"true\"></i>');

            $(this).find("label").click(function () {
                $(this).siblings("i").toggleClass("fa-circle-thin");
                $(this).siblings("i").toggleClass("fa-circle");
            });

        });



        if (parent_trigger) {
            $(this).parent().css({minWidth: $(this).parent().siblings(".formControlLabel").outerWidth() + 'px', width: (bodyWidth + inputBodyWidth + 100) + "px", marginLeft: "auto", marginRight: "auto"});
            $(this).parent().siblings(".formControlLabel").css({display: 'inline-block'});
        }


    });

    $(".fa.fa-circle-thin").click(function () {
        $(this).toggleClass("fa-circle-thin");
        $(this).toggleClass("fa-circle");

        if ($(this).hasClass("fa-circle")) {
            $(this).siblings("input[type=checkbox]").click();
        }
    });



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

        $(this).fadeOut("fast");
        $("#myTimer").html("");

        if ($(".rsform-block.echocoins:visible").length > 0 && ((question.answered / question.totalQuestions) * 100) >= 75) {

            /*
             * coins fly effect
             */

            clearInterval(timer.timeinterval);
            $(".coin-fly-text").css({display: "none"});
            $(".rsform-block.rsform-block-coins").css({display: "block"});
            $(".rsform-block:visible")
                    .not(".rsform-block.rsform-block-coins")
                    .not(".rsform-block.rsform-block-echocoins")
                    .not(".rsform-block.rsform-block-next")
                    .not(".rsform-block.rsform-block-timer")
                    .css({overflow: 'hidden'})
                    .stop().animate({
                height: "0"
            }, 500, function () {
                var timeCounter = 0;
                clearInterval(timer.timeinterval);
                $(".coin-fly-text").css({display: "block"});
//                $(".congratz-coin").removeClass("show");

                $(".rsform-block.rsform-block-coins").stop().clearQueue().fadeIn(400, function () {
//Scroll to top if cart icon is hidden on top
                    $('html, body').animate({
                        'scrollTop': $(".echoosTotal").position().top
                    });

                    $('#trumpetaudio').prop("volume", 0.3);
                    $('#trumpetaudio')[0].play();

                    console.log('#trumpetaudio');

                    $(".congratz-coin").fadeIn(500).fadeOut(500).fadeIn(500, function () {
//                        $(".coin-fly-text").fadeIn("fast", function () {
                        //Select item image and pass to the function
                        var itemImg = $(".coin-fly-text .echoCoinsCoin1");
                        flyToElement($(itemImg), $('.echoosTotal'));
//                        });
                    });
                });
            });

        } else if ($(".rsform-block.echocoins:visible").length) {
            question.answered = 0;
            question.totalQuestions = 0;

            clearInterval(timer.timeinterval);

            $(".rsform-block.rsform-block-nocoins").fadeIn(250).fadeOut(250).fadeIn(250);

            $(".rsform-block:visible")
                    .not(".rsform-block.rsform-block-nocoins")
                    .not(".rsform-block.rsform-block-echocoins")
                    .not(".rsform-block.rsform-block-next")
                    .not(".rsform-block.rsform-block-timer")
                    .css({overflow: 'hidden'})
                    .stop()
                    .animate({
                        height: "0"
                    }, 500, function () {
                        setTimeout(function () {
                            $(".rsform-block.rsform-block-nocoins").slideUp("fast", function () {
                                question.next();
                            });

                        }, 8000);
                    });




        } else {
            question.next();
        }

    });
    question = {
        totalQuestions: 0,
        answered: 0,
        next: function () {
            $("#ete-questionnaires div.rsform-block").each(function () {


                if ($(this).is(":visible") && !$(this).hasClass("rsform-block-escapetheecho") && !$(this).hasClass("rsform-block-introtext")) {

                    question.totalQuestions++;

                    if ($(this).find("input:checked").length > 0) {
                        question.answered++;
                        console.log("answered");
                    }

                    if ($(this).next().find("input[type=checkbox]").length > 0 || $(this).next().find("input[type=radio]").length > 0) {

                        if ($(this).next().find("input:checked").length > 0) {

                            $(this).slideUp("500");
                            $(this).nextAll().each(function () {
                                if ($(this).find("input:checked").length < 1) {
                                    console.log($(this).find("input:checked").length);
                                    $(this).slideDown("500");
                                    if ($(this).hasClass("rsform-block-yourname")) {
                                        $("#ete-questionnaires div.rsform-block.rsform-block-emailaddress").slideDown("500");
                                        $("#ete-questionnaires div.rsform-block.rsform-block-socialmedia").slideDown("500");
                                        $("#ete-questionnaires div.rsform-block.rsform-block-secondchance").slideDown("500");
                                        $("#ete-questionnaires div.rsform-block.rsform-block-submit").slideDown("500");
                                        $("#ete-questionnaires div.rsform-block-next, #ete-questionnaires div.rsform-block-timer").css({display: 'none'});
                                        clearInterval(timer.timeinterval);
                                    } else {
                                        clearInterval(timer.timeinterval);
                                        timer.deadline = ($(this).find("input[type=checkbox]").length * 3) + 12;
                                        timer.initializeClock('myTimer', timer.getToday(timer.deadline));
                                    }

                                    return false;
                                }
                            });
                            return false;
                        } else {
                            $(this).slideUp("500");
                            $(this).next().slideDown("500");
                            timer.deadline = (parseInt($(this).next().find("input[type=checkbox]").length) * 3) + 10;
                            if ($(this).next().hasClass("lickert-scale")) {
                                timer.deadline += 5;
                            }

                            if ($(this).next().hasClass("rsform-block-yourname")) {
                                $("#ete-questionnaires div.rsform-block.rsform-block-emailaddress").slideDown("500");
                                $("#ete-questionnaires div.rsform-block.rsform-block-socialmedia").slideDown("500");
                                $("#ete-questionnaires div.rsform-block.rsform-block-secondchance").slideDown("500");
                                $("#ete-questionnaires div.rsform-block.rsform-block-submit").slideDown("500");
                                $("#ete-questionnaires div.rsform-block-next, #ete-questionnaires div.rsform-block-timer").css({display: 'none'});
                                clearInterval(timer.timeinterval);
                            } else {
                                clearInterval(timer.timeinterval);
                                timer.initializeClock('myTimer', timer.getToday(timer.deadline));
                            }
                        }

                        if ($(".rsform-block.rsform-block-submit").is(":visible")) {
                            questionnaire.overlay();
                            $(".rsform-block.rsform-block-next").slideUp("fast");
                        }

                        return false;
                    } else {
                        $(this).slideUp("500");
                        $(this).next().slideDown("500");
//                        timer.deadline = (parseInt($(this).next().find("input[type=checkbox]").length) * 3) + 10;                        

                        if ($(this).next().hasClass("rsform-block-endofquiz")) {

                            $('#completedaudio').prop("volume", 0.3);
                            ;
                            $('#completedaudio')[0].play();

                            $(".rsform-block-jackpotcongratulation").delay(400).css({display: "block"});

                            $("#page-header").slideUp("fast");
                            var interval = 0;
                            var _interval = setInterval(function () {
                                interval++;
                                if (interval % 2 === 0) {
                                    $(".flip2").fadeOut(250, function () {
                                        $(".flip1").fadeIn(250);
                                    });
                                } else {
                                    $(".flip1").fadeOut(250, function () {
                                        $(".flip2").fadeIn(250);
                                    });
                                }

                                if (interval === 8) {
                                    clearInterval(_interval);


                                    $(".flip2").fadeOut(250, function () { //hide the CONGRATULATION/JACKPOT first before showing the flyer                                        

                                        $(".rsform-block-jackpotcongratulation").slideUp("fast");

                                        $(".rsform-block.rsform-block-coins").stop().clearQueue().fadeIn("fast", function () {
                                            $(".coin-fly-text").css({display: "block"});
//                                            $(".rsform-block.rsform-block-coins").stop().clearQueue().fadeIn(400, function () {
                                            //Scroll to top if cart icon is hidden on top
                                            $('html, body').animate({
                                                'scrollTop': $(".echoosTotal").position().top
                                            });
                                            //$(".congratz-coin").fadeIn(500).fadeOut(500).fadeIn(500, function () {

//                                                $(".coin-fly-text").fadeIn("fast", function () {
                                            //Select item image and pass to the function

                                            var position = 'before-end';
                                            var _coinInterval = 0;
                                            var coinInterval = setInterval(function () {
                                                _coinInterval++;

                                                // 3 coins only on jackpot
                                                if (_coinInterval === 3) {
                                                    position = 'end';

                                                    clearInterval(coinInterval);
                                                }

                                                var itemImg = $(".coin-fly-text .echoCoinsCoin1");
                                                flyToElement($(itemImg), $('.echoosTotal'), position);

                                            }, 2000);

//                                                });
                                            //});
//                                            });

                                        });

                                    });

                                }

                            }, 500);
                            clearInterval(timer.timeinterval);
                        }
//                        else {
//                            clearInterval(timer.timeinterval);

//                            timer.initializeClock('myTimer', timer.getToday(timer.deadline));
//                        }

//
//                        if ($(".rsform-block.rsform-block-submit").is(":visible")) {
////                            questionnaire.overlay();
//                            $(".rsform-block.rsform-block-next").slideUp("fast");
//                        }

                        return false;
                    }
                }


            });
        },
        selectOption: function (ths) {
            $(ths).next("input[type=checkbox]").click();
        }
    };
    questionnaire = {
        overlay: function () {
            if ($("#overlay-bg").length < 1) {
                alert("PLEASE before you leave the site, so you don't have to start from the beginning again, quickly register with the site so you can not least get the benefits of the work that you've already done but you get to save your echo and get your first 'briefing' !");
                $("body").append("<div id=\"overlay-bg\" />");
                $("body").append("<div id=\"overlay-content-wrap\" />");
                $("#overlay-content-wrap").append("<div id=\"overlay-content-inner-wrap\" />");
                $("#overlay-content-inner-wrap").html($(".rsform-block.rsform-block-signoff .formBody").html());
                $("#overlay-content-inner-wrap").prepend("<div class=\"close-overlay\" onclick=\"questionnaire.closeOverlay();\">[x]</div>");
            }
        },
        endOfGameOverlay: function () {
//            $('#audio_celebration')[0].play();

            $(".rsform-block.rsform-block-coins").fadeOut(1000, function () {
                $(".rsform-block.rsform-block-finishquizoverlay .blinking").css({display: "none"});
                $(".rsform-block.rsform-block-finishquizoverlay").css({display: "block"});
                $(".rsform-block.rsform-block-chooseanotherquiz").css({display: "block"});
                $(".rsform-block.rsform-block-echocoins .what-echoos").not(".what-echoos.what-echoos-line2").slideUp("fast");
                $(".rsform-block.rsform-block-signofflinks").css({display: "block"});
            });

        },
        closeOverlay: function () {
            if ($("#overlay-bg").length > 0) {
                $("#overlay-bg").fadeOut("fast", function () {
                    $("#overlay-bg").remove();
                });
                $("#overlay-content-wrap").fadeOut("fast", function () {
                    $("#overlay-content-wrap").remove();
                });
            }
        }
    };
    timer = {
        deadline: 35,
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

                if (t.seconds <= 5) {
                    $('button[name="form\[next\]"]').css({display: "inline-block"});
                }

                //independently parse get the millisec from the current date
                var d = new Date();
                t.milliseconds = Math.floor(d.getMilliseconds() / 100);
                if (t.seconds <= secondsToShow) {
                    clock.innerHTML = "<span class=\"blue-text\">Seconds to next question:</span> " + t.seconds + ':' + t.milliseconds;
                } else if (t.seconds <= secondsToShow + 3) {
                    clock.innerHTML = "<span class=\"blue-text\">Seconds to next question:</span> " + (secondsToShow + 1) + ':' + "0";
                }

//                if (t.seconds > (secondsToShow + 3) && jQuery("#myTimer").is(":visible")) {
//                    jQuery("#myTimer").css({display: 'none'});
//                }


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

                if (t.total < 0 && t.milliseconds <= 0) {

                    clearInterval(timer.timeinterval);
                    clock.innerHTML = "";
                    if (!$("#ete-questionnaires div.rsform-block-submit").is(":visible")) {

                        $('#audio')[0].pause();
                        $('#audio')[0].currentTime = 0;
                        $("button#next").click();
                    } else {
                        $("#ete-questionnaires div.rsform-block-next, #ete-questionnaires div.rsform-block-timer").css({display: 'none'});
                    }
                }
            }, 100);
        }
    };
    $(".ete-button.go-button").click(function () {
        $("#ete-questionnaires h2").slideUp("fast");
        $("#ete-questionnaires-controls div.rsform-block-next button").css({display: 'none'});
        $("#ete-questionnaires-controls div.rsform-block-next").css({display: 'inline-block'});
        $("#ete-questionnaires div.rsform-block:nth-child(1)").slideUp("fast", function () {
            $("#ete-questionnaires div.rsform-block:nth-child(2)").slideDown("fast", function () {
                timer.deadline = (parseInt($(this).find("input[type=checkbox]").length) * 3) + 10;
                if ($(this).hasClass("lickert-scale")) {
                    timer.deadline += 5;
                }

//                    $("#ete-questionnaires div.rsform-block:nth-child(3)").slideDown("fast", function () {

//                setTimeout(function () {
//                    $("#ete-questionnaires div.rsform-block-next").css({display: 'inline-block'});
//                    $("button[name='form[next]']").css({visibility: 'visible'});
//                }, 15000);

//                $("#ete-questionnaires div.rsform-block-next, #ete-questionnaires div.rsform-block-timer").css({display: 'inline-block'});
                $("#ete-questionnaires-controls div.rsform-block-timer").css({display: 'block'});
                clearInterval(timer.timeinterval);
                timer.initializeClock('myTimer', timer.getToday(timer.deadline));
                $(".rsform-block.rsform-block-echocoins").addClass("shown");
//                    });


            });
        });
    });

    $(".rsform-block-timer .formBody").attr("id", "myTimer");
    $(".answerMissedQuestions").click(function (event) {
        event.preventDefault();
        $("#politicsandcommunity").find("ol.formContainer div.rsform-block").each(function () {
            if ($(this).find("input[type=checkbox]").length > 1 || $(this).find("input[type=radio]").length > 1) {
                if ($(this).find("input:checked").length < 1) {

                    $("#ete-questionnaires div.rsform-block:gt(1)").css({display: 'none'});
                    $(this).css({display: 'list-item'});
                    $("#ete-questionnaires-controls div.rsform-block-next, #ete-questionnaires-controls div.rsform-block-timer").css({display: 'block'});
                    clearInterval(timer.timeinterval);
                    timer.initializeClock('myTimer', timer.getToday(timer.deadline));
                    return false;
                }
            }
        });
    });
    $(document).keypress(function (e) {
        if (e.which == 13) {

            if ($('button.ete-button.go-button').is(":visible")) {
                $('button.ete-button.go-button').click();
            } else {

                if ($("#ete-questionnaires div.rsform-block:visible").find("input:checked").length > 0) {
                    $('button[name="form\[next\]"]').click();
                } else {
                    if ($('button[name="form\[next\]"]').is(":visible")) {
                        $('button[name="form\[next\]"]').click();
                    }
                }

            }

        }
    });
    $(".formBody").each(function () {
        var ths = $(this);
        $(this).find("input[type=checkbox]").each(function () {
            $(this).click(function () {
                if (ths.find("input[type=checkbox]:checked").length > 0) {
                    if (!$('button[name="form\[next\]"]').is(":visible")) {
                        $('button[name="form\[next\]"]').delay(1000).fadeIn("slow", function () {
                            $('button[name="form\[next\]"]').css({display: 'inline-block'});
                        });
                    }
                } else {
//                    $('button[name="form\[next\]"]').css({display: 'none'});
                    $('button[name="form\[next\]"]').stop().fadeOut("slow");
                }
            });
        });
    });


    var coinsWon = 0;

    function flyToElement(flyer, flyingTo, position = null) {
        var $func = $(this);
        var divider = 3;
        var flyerClone = $(flyer).clone();
        var _flyer = flyer;
        var _time = 2000;

//        $(flyer).css({visibility: "hidden"});
        $(flyerClone).css({position: 'absolute', top: $(_flyer).offset().top + "px", left: $(_flyer).offset().left + "px", opacity: 1, 'z-index': 1000});
        $('body').append($(flyerClone));

        var gotoX = $(flyingTo).offset().left - 10 + ($(flyingTo).width() / 2) - ($(_flyer).width() / divider) / 2;
        var gotoY = $(flyingTo).offset().top - 15 + ($(flyingTo).height() / 2) - ($(_flyer).height() / divider) / 2;
        var newTotal = (parseInt(coinsWon) + 1) < 10 ? '0' + (parseInt(coinsWon) + 1) : (parseInt(coinsWon) + 1) + '';
        coinsWon++;

        $("#coinsWon").val(coinsWon);
        console.log(coinsWon);
        var totalArray = newTotal.split('');
        var parsedValue = "";
        $.each(totalArray, function (indx, value) {
            if (parseInt(value) > 0) {
                parsedValue += "<span class=\"non-zero non-zero-" + value + " echo-coins-" + newTotal + "\" >" + value + "</span>";
            } else {
                parsedValue += "<span class=\"round-zero\">" + totalArray[indx] + "</span>";
            }
        });

//        var _newTotal = newTotal > 9 ? "<span class=\"non-zero\">" + newTotal.replace("0", "</span><span class=\"round-zero\">0") + "</span>": "<span class=\"round-zero\">0</span>" + "<span class=\"non-zero\">" + newTotal + "</span>";

        if (position === 'before-end' || position === 'end') {
//            _time = 1700;

            $('#trumpetaudio').prop("volume", 0.3);
            $('#trumpetaudio')[0].play();
        }

        $(flyerClone).delay(1500).stop().clearQueue().animate({
            opacity: 0.4,
            left: gotoX,
            top: gotoY,
            width: ($(_flyer).width() / divider) + 25,
            height: ($(_flyer).height() / divider) + 25
        }, _time, function () { });

        $(flyerClone).delay(1500).stop().clearQueue().animate({
            opacity: 0.4,
            left: gotoX,
            top: gotoY,
            width: ($(_flyer).width() / divider) + 25,
            height: ($(_flyer).height() / divider) + 25
        }, _time, function () {
//            $(flyingTo).stop().clearQueue().fadeOut('fast').fadeIn('fast', function () {
//                $(flyerClone).stop().clearQueue().fadeOut('fast', function () {
            $(flyerClone).remove();

            $('#coinslotaudio').prop("volume", 0.3);
            $('#coinslotaudio')[0].play();

            setTimeout(function () {
                $('#coinsDropAudio').prop("volume", 0.3);
                $('#coinsDropAudio')[0].play();
            }, 1100);

            $(".echoosNewTotal").html(parsedValue);
            $(".echoosTotal").stop().clearQueue().animate({
                marginTop: "-=42"
            }, 500, function () {
                $(".echoosTotal").html(parsedValue);
                $(".echoosTotal").css({marginTop: "3px"});
            });

            if (position === null) {
                $(".rsform-block.rsform-block-coins").fadeOut(2000, function () {
                    question.next();
//                    $(flyer).css({visibility: "visible"});
                });
            }

            if (position === 'before-end') {
//                $(flyer).css({visibility: "visible"});
            }

            if (position === 'end') {
                setTimeout(function () {
                    questionnaire.endOfGameOverlay();
//                    $(flyer).css({visibility: "hidden"});
                    $(".echoCoinsCoin1").css({visibility: "hidden"});
                }, 1000);
            }

//                });
//            });
        });
    }

//    $('#next').on('click', function () {
//        $(".rsform-block.rsform-block-coins").css({display: "block"});
//
//        //Scroll to top if cart icon is hidden on top
//        $('html, body').animate({
//            'scrollTop': $(".echoosTotal").position().top
//        });
//        //Select item image and pass to the function
//        var itemImg = $(".rsform-block.rsform-block-coins");
//        flyToElement($(itemImg), $('.echoosTotal'));
//    });


    var ladderClicked = null;
    var ladderClicked2 = null;
    $("map#LadderMap area").each(function () {
        $(this).on("click", function (e) {
            e.preventDefault();
            ladderClicked = $("input#TopofThe" + $(this).attr("id"));
            ladderClicked.toggleClass("checked").click();
            ladderClicked2 = $("input#StepsOfThe" + $(this).attr("id"));
            ladderClicked2.toggleClass("checked").click();
        });
    });
    $("input[id^=StepsOfTheLadder]").each(function () {
        $(this).click(function () {
            $("input[id^=StepsOfTheLadder]").not(ladderClicked).each(function () {
                $(this).attr("checked", false);
            });
            if (!$('button[name="form\[next\]"]').is(":visible")) {
                $('button[name="form\[next\]"]').delay(1000).fadeIn("slow", function () {
                    $('button[name="form\[next\]"]').css({display: 'inline-block'});
                });
            }
        });
    });
    $("input[id^=TopOfTheLadder]").each(function () {
        $(this).on("click", function (e) {
            $("input[id^=TopOfTheLadder]").not(this).each(function () {
                $(this).attr("checked", false);
            });
            if (!$('button[name="form\[next\]"]').is(":visible")) {
                $('button[name="form\[next\]"]').delay(1000).fadeIn("slow", function () {
                    $('button[name="form\[next\]"]').css({display: 'inline-block'});
                });
            }

        });
    });
//    $("input[name=\"form\[TopofTheLadder\]\[\]\]\"").each(function () {
//        $(this).on("click", function (e) {
//            $("input[name=\"form\[TopofTheLadder\]\[\]\]\"").not(this).each(function () {
//                $(this).attr("checked", false);
//            });
//        });
//    });

//    $(window).blur(function () {
//        questionnaire.overlay();
//    });

    $("input.options-with-image").each(function () {
        $(this).parent().addClass("options-has-image");
    });

    var option_images = [];
    $(".formBody.options-has-image").find("input.options-with-image").each(function (indx) {
        if (indx === 0) {
            option_images = $(this).attr("data-option-images").split("|");
        }

        if (indx < option_images.length) {
            $(this).before("<img src=\"" + baseUrl + "/images/questionnaires/religious-symbols/" + option_images[indx] + "\" onclick=\"question.selectOption(this);\" alt=\"\" />");
        }
    });
    
    if($("#main-content").outerWidth() < 1024){
        $(".custom.m_burger_menu").append("<div class=\"quiz-title-h2\">");
        $(".custom.m_burger_menu .quiz-title-h2").append($("#ete-questionnaires h2").text());
        $(".custom.m_burger_menu").append("<div class=\"clearer\">");
    }
});

$(window).load(function () {
    $("#ete-questionnaires").addClass("form-loaded");
    $(".ete-button.go-button").fadeIn("fast");
    $(".formResponsive input[type=\"radio\"], .formResponsive input[type=\"checkbox\"]").addClass("active");
});