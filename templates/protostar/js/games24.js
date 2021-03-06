jQuery(window).load(function () {    

    jQuery(".flip-container-wrap").css({
        width: Math.ceil((1020 / 783) * jQuery(".flip-container-wrap").outerHeight()) + "px",
        minWidth: '1020px'
    });


    var bgsize = "100% auto";
    var wrapWidth = "100%";

    setTimeout(function () {
        if (jQuery(".flip-container-wrap").outerHeight() < 433) {
            if (jQuery(window).width() >= 1020) {
                wrapWidth = Math.ceil(jQuery(".flip-container:nth-child(4)").position().left + jQuery(".flip-container:nth-child(4)").outerWidth() - jQuery(".flip-container:first-child").position().left) + "px";
            }
        }

        jQuery(".flip-container-wrap").css({
            width: wrapWidth,
            backgroundSize: bgsize
        });

    }, 2000);

//    jQuery(".flip-container-mainwrap .what-echoos, .flip-container-mainwrap .number-moves").css({
//        left: (jQuery(".flip-container-wrap").offset().left + jQuery(".flip-container-wrap").outerWidth() + 10) + 'px'
//    });
    jQuery(".flip-container-mainwrap .what-echoos, .flip-container-mainwrap .number-moves").fadeIn(500);
});




jQuery(document).ready(function () {

    var timeout, timeout2, flipContainerWrapHeight;

    jQuery.preloadImages = function () {
        for (var i = 0; i < arguments.length; i++) {
            jQuery("<img />").attr("src", arguments[i]);
        }
    };

    jQuery.preloadImages("./templates/protostar/images/bg1.jpg");

    var bgsize = "100% auto";
    var wrapWidth = "100%";

    if (jQuery(".flip-container-wrap").outerHeight() < 433) {
        if (jQuery(window).width() >= 1020) {
            wrapWidth = Math.ceil(jQuery(".flip-container:nth-child(4)").position().left + jQuery(".flip-container:nth-child(4)").outerWidth() - jQuery(".flip-container:first-child").position().left) + "px";
        }
    }

    jQuery(".flip-container-wrap").css({
        width: wrapWidth,
        backgroundSize: bgsize
    });

    jQuery(".pair-button-wrap button").click(function () {
        debatingGame.match();
    });

    flipContainerWrapHeight = jQuery(window).height() - jQuery(".flip-container-wrap").offset().top - 20;

//    if (jQuery(window).width() >= 1020) {
//        jQuery(".flip-container").css({
//            height: (flipContainerWrapHeight / 2 - 12) + "px",
//            maxWidth: (((flipContainerWrapHeight / 2 - 12) * 40) / 60) + "px"
//        });
//    } else {
    jQuery(".flip-container").css({
        height: (478 * jQuery(".flip-container").outerWidth() / 310) + "px"
    });
//    }

    debatingGame = {
        echoCoins: 6,
        minimumMoves: Math.ceil(jQuery(".flip-container-wrap").children(".flip-container").length),
        flipAudio: jQuery('#audio')[0],
        counter: 0,
        cardParentTop: 0,
        cardHeight: 0,
        cardOriginalHeight: jQuery(".flip-container-wrap .flip-container:first").find(".back").height(),
        containerWrap: 0,
        cardParentLeft: 0,
        cardWidth: 0,
        cardOriginalWidth: jQuery(".flip-container-wrap .flip-container:first").find(".back").width(),
        heightRatio: 110 * jQuery(".flip-container-wrap .flip-container:first").find(".back").height() / jQuery(".flip-container-wrap .flip-container:first").find(".back").width(),
        containerWrapW: 0,
        _top: 0,
        _left: 0,
        processing: 0,
        zoomedIn: 0,
        zoomOutTimer: 0,
        zoomedCard: null,
        ini: function () {
            var flipContainer = jQuery(".flip-container").length;

            jQuery(".flip-container:eq(7)").find(".back").css({left: 'auto', right: '-2px'});
            jQuery(".flip-container:eq(15)").find(".back").css({left: 'auto', right: '-2px'});
//            jQuery(".flip-container:eq(23)").find(".back").css({left: 'auto', right: '-2px'});

            jQuery(".flip-container:gt(" + ((16) - 1) + ")").find(".back").css({left: 0, right: 'auto', top: 'auto', bottom: 0, marginBottom: '0'});

            jQuery(".flip-container:eq(23)").find(".back").css({left: 'auto', right: '-2px'});

            console.log(jQuery(".flip-container:eq(0)").length);
        },
        flip: function (ths) {
//            var echooCoins = debatingGame.echoCoins;

            debatingGame.flipAudio.play();
            debatingGame.counter++;
            jQuery(".number-moves-counter").children("span.green-text").text(debatingGame.counter > 9 ? debatingGame.counter : '0' + debatingGame.counter);
//            if (debatingGame.counter > debatingGame.minimumMoves && debatingGame.echoCoins > 0) {
//
//                jQuery(".echoo-coin").each(function () {
//                    jQuery(this).css({
//                        display: 'none'
//                    });
//                });
//
//                debatingGame.echoCoins--;
//
//                echooCoins = debatingGame.echoCoins;
//
//                if (parseInt(echooCoins) >= 10) {
//                    jQuery(".echoo-coin-10").css({display: 'inline'});
//
//                    echooCoins = echooCoins - 10;
//                }
//                if (echooCoins >= 5) {
//                    jQuery(".echoo-coin-5").css({display: 'inline'});
//                    echooCoins = echooCoins - 5;
//                }
//                if (echooCoins >= 4) {
//                    jQuery(".echoo-coin-4").css({display: 'inline'});
//                    echooCoins = echooCoins - 4;
//                }
//                if (echooCoins >= 3) {
//                    jQuery(".echoo-coin-3").css({display: 'inline'});
//                    echooCoins = echooCoins - 3;
//                }
//                if (echooCoins >= 2) {
//                    jQuery(".echoo-coin-2").css({display: 'inline'});
//                    echooCoins = echooCoins - 2;
//                }
//                if (echooCoins >= 1) {
//                    jQuery(".echoo-coin-1").css({display: 'inline'});
//                }
//
//            }

            if (jQuery("div.front.flipped").length > 1) {
                debatingGame.flipBack();
            }


            jQuery(ths).find(".back").addClass("flipped").css({
                '-webkit-transform': 'rotateY(0deg)',
                '-moz-transform': 'rotateY(0deg)',
                '-o-transform': 'rotateY(0deg)',
                '-ms-transform': 'rotateY(0deg)',
                transform: 'rotateY(0deg)'
            });
            jQuery(ths).find(".front").addClass("flipped").css({
                '-webkit-transform': 'rotateY(180deg)',
                '-moz-transform': 'rotateY(180deg)',
                '-o-transform': 'rotateY(180deg)',
                transform: 'rotateY(180deg)'
            });


            debatingGame.zoomin(ths);
            debatingGame.zoomedCard = ths;


//            if (jQuery("div.front.flipped").length > 1) {
//                return jQuery("div.flipped.front:eq(0)").parent().attr("data-bind") == jQuery("div.flipped.front:eq(1)").parent().attr("data-bind");
//            } else {
//
//            }

            timeout = setTimeout(function () {

                if (jQuery(".back.flipped").length > 0 && debatingGame.zoomout(ths)) {
                    debatingGame.flipBack();
                }

            }, 20000);


            if (jQuery(".flip-container").not(".paired_cards").length <= 2) {

                clearTimeout(timeout);

                console.log(jQuery(".flip-container-wrap").find(".front.flipped").length);
                if (jQuery(".flip-container-wrap").find(".front.flipped").length >= 2) {
                    setTimeout(function () {
                        debatingGame.match();
                    }, 8000);
                }
            }

            return false;
        },
        flipBack: function () {
            jQuery(".front.flipped").each(function () {
                jQuery(this).removeClass("flipped").css({
                    '-webkit-transform': 'rotateY(0deg)',
                    '-moz-transform': 'rotateY(0deg)',
                    '-o-transform': 'rotateY(0deg)',
                    transform: 'rotateY(0deg)'
                });
            });
            jQuery(".back.flipped").each(function () {
                jQuery(this).removeClass("flipped").css({
                    '-webkit-transform': 'rotateY(-180deg)',
                    '-moz-transform': 'rotateY(-180deg)',
                    '-o-transform': 'rotateY(-180deg)',
                    '-ms-transform': 'rotateY(-180deg)',
                    transform: 'rotateY(-180deg)'
                });
            });

        },
        match: function () {
            if (debatingGame.countFlipped() > 1) {
                clearTimeout(timeout);

                if ((jQuery("div.flipped.front:eq(0)").parent().attr("data-bind") == jQuery("div.flipped.front:eq(1)").parent().attr("data-bind") + '1') || (jQuery("div.flipped.front:eq(1)").parent().attr("data-bind") == jQuery("div.flipped.front:eq(0)").parent().attr("data-bind") + '1')) {

                    jQuery('#audio_paired')[0].play();
                    jQuery("div.flipped").parent().parent().fadeOut(300).fadeIn(300, function () {
                        var ths = this;
                        var position, bgsize;

                        jQuery(ths).addClass("paired_cards");
                        jQuery(ths).children("div").fadeOut(700);

                        position = "-" + (parseInt(jQuery(ths).position().left) - 2) + "px -" + jQuery(ths).position().top + "px";

                        if (jQuery(".flip-container-wrap").outerHeight() < 433) {
                            bgsize = (jQuery(".flip-container-wrap").outerWidth() - 4) + "px auto";
                        } else {
                            bgsize = (jQuery(".flip-container-wrap").outerWidth() - 4) + "px auto";
                        }
//                        bgsize = (jQuery(".flip-container:first-child").position().left + jQuery(".flip-container:nth-child(4)").position().left + jQuery(".flip-container.paired_cards:nth-child(4)").outerWidth()) + "px";

                        jQuery(ths).css({backgroundImage: 'url(./templates/protostar/images/echo13.jpg)', backgroundSize: bgsize, backgroundPosition: position, backgroundRepeat: "no-repeat"});

                        if (jQuery(".paired_cards").length >= jQuery(".flip-container").length) {

                            jQuery(".flip-container-wrap").css({backgroundImage: 'url(./templates/protostar/images/echo13.jpg)'});
                            setTimeout(function () {
                                jQuery(".flip-container-wrap").css({backgroundImage: 'url(./templates/protostar/images/echo132.jpg)'});
                            }, 2000);

                            jQuery(".flip-container.paired_cards").css({visibility: 'hidden'});
                            jQuery('#audio_complete')[0].play();
                            jQuery(".separator_line").fadeOut("fast");

                            jQuery(".can-you-escape").css({
                                display: 'none'
                            });

                            setTimeout(function () {
                                jQuery(".next-level-wrap.pair-button-wrap").fadeIn("fast", function () {
                                    setInterval(function () {
                                        jQuery("button.button.new-game").fadeToggle(700);
                                    }, 700);
                                });
                            }, 1000);
                        }

//                        if (jQuery(".flip-container").not(".paired_cards").length <= 2) {
//                            console.log(jQuery(".flip-container").find(".font.flipped").length);
//                            if (jQuery(".flip-container").find(".font.flipped").length >= 2) {
//                                setTimeout(function () {
//                                    debatingGame.match();
//                                }, 8000);
//                            }
////                            setTimeout(function () {
////                                jQuery(".flip-container").not(".paired_cards").each(function () {
////                                    debatingGame.checkFlipped(this);
////                                    debatingGame.hoverOut(this);
////
////                                    setTimeout(function () {
////                                        debatingGame.match();
////                                    }, 2000);
////
////                                });
////                            }, 1000);
//                        }

                    });
                    jQuery("div.flipped").removeClass("flipped");

                } else {
                    jQuery('#audio_wrong')[0].play();
                    jQuery(".back.flipped").removeClass("flipped").css({
                        '-webkit-transform': 'rotateY(180deg)',
                        '-moz-transform': 'rotateY(180deg)',
                        '-o-transform': 'rotateY(180deg)',
                        '-ms-transform': 'rotateY(180deg)',
                        transform: 'rotateY(180deg)'
                    });
                    jQuery(".front.flipped").removeClass("flipped").css({
                        '-webkit-transform': 'rotateY(0deg)',
                        '-moz-transform': 'rotateY(0deg)',
                        '-o-transform': 'rotateY(0deg)',
                        transform: 'rotateY(0deg)'
                    });
                }
            }
        },
        zoomin: function (ths) {
            clearTimeout(debatingGame.zoomOutTimer);

            jQuery(".flip-container.zoomin").not(ths).removeClass("zoomin");
            jQuery(ths).addClass("zoomin");

            debatingGame.processing = 1;
            debatingGame.zoomedIn = 1;

            jQuery(ths).find(".back.flipped").css({
                width: (debatingGame.cardOriginalWidth + 110) + 'px',
                height: (debatingGame.cardOriginalHeight + debatingGame.heightRatio + 5) + 'px'
            });

//            debatingGame.zoomOutTimer = setTimeout(function () {
//                debatingGame.zoomout(ths);
//            }, 5000);


        },
        zoomout: function (ths) {
            if (debatingGame.zoomedIn === 1) {
                debatingGame.zoomedIn = 0;
                debatingGame.processing = 0;
                jQuery(ths).find(".back.flipped").css({
                    width: debatingGame.cardOriginalWidth + 'px',
                    height: debatingGame.cardOriginalHeight + 'px'
                });


                debatingGame.zoomOutTimer = setTimeout(function () {
                    jQuery(ths).removeClass("zoomin");
//                    jQuery(ths).css({zIndex: 9999});
                }, 1000);

            }

            return true;
        },
        hoverIn: function (ths) {
            if (jQuery(ths).find(".back.flipped").length > 0) {
                debatingGame.zoomin(ths);
            }
        },
        hoverOut: function (ths) {
            if (jQuery(ths).find(".back.flipped").length > 0) {
                debatingGame.zoomout(ths);
            }
        },
        countFlipped: function () {
            return jQuery("div.flipped.front").length;
        },
        evaluateFlip: function () {
            return jQuery("div.flipped.front:eq(0)").parent().attr("data-bind") == jQuery("div.flipped.front:eq(1)").parent().attr("data-bind");
        },
        resetFlip: function (ths) {
            var frontFlip, backFlip;
            clearTimeout(timeout);
            clearTimeout(timeout2);

            frontFlip = jQuery(ths).find(".front.flipped");
            backFlip = jQuery(ths).find(".back.flipped");

            debatingGame.zoomout(ths);

            backFlip.removeClass("flipped").css({
                '-webkit-transform': 'rotateY(180deg)',
                '-moz-transform': 'rotateY(180deg)',
                '-o-transform': 'rotateY(180deg)',
                '-ms-transform': 'rotateY(180deg)',
                transform: 'rotateY(180deg)'
            });
            frontFlip.removeClass("flipped").css({
                '-webkit-transform': 'rotateY(0deg)',
                '-moz-transform': 'rotateY(0deg)',
                '-o-transform': 'rotateY(0deg)',
                transform: 'rotateY(0deg)'
            });
        },
        checkFlipped: function (ths) {
            if (jQuery(ths).find(".front.flipped").length > 0) {
                debatingGame.resetFlip(ths);
            } else {
                clearTimeout(timeout);

                if (debatingGame.processing === 0) {
                    debatingGame.flip(ths);
                } else {
                    debatingGame.zoomout(debatingGame.zoomedCard);
                    debatingGame.flip(ths);
                }

            }
        }
    };


    debatingGame.ini();
    jQuery(".min-number-moves span").text(debatingGame.minimumMoves);
    jQuery(".flip-container").click(function () {
        debatingGame.checkFlipped(this);
    });

    var echooCoins = debatingGame.echoCoins;

    if (echooCoins >= 10) {
        jQuery(".echoo-coin-10").css({display: 'inline'});
        echooCoins = echooCoins - 10;
    }
    if (echooCoins >= 5) {
        jQuery(".echoo-coin-5").css({display: 'inline'});
        echooCoins = echooCoins - 5;
    }
    if (echooCoins >= 4) {
        jQuery(".echoo-coin-4").css({display: 'inline'});
        echooCoins = echooCoins - 4;
    }
    if (echooCoins >= 3) {
        jQuery(".echoo-coin-3").css({display: 'inline'});
        echooCoins = echooCoins - 3;
    }
    if (echooCoins >= 2) {
        jQuery(".echoo-coin-2").css({display: 'inline'});
        echooCoins = echooCoins - 2;
    }
    if (echooCoins >= 1) {
        jQuery(".echoo-coin-1").css({display: 'inline'});
    }

    jQuery(".flip-container").hover(function () {
        debatingGame.hoverIn(this);
    }, function () {
        debatingGame.hoverOut(this);
    });
});