jQuery(window).load(function () {
//    jQuery(".flip-container-wrap").css({
    jQuery("body").css({
//        backgroundImage: 'url(./templates/protostar/images/bg1.jpg)'
    });
});

jQuery(document).ready(function () {

    var timeout, timeout2;

    debatingGame = {
        flip: function (ths) {
            jQuery('#audio')[0].play();
            if (jQuery("div.front.flipped").length > 1) {
                jQuery(".front.flipped").each(function () {
                    jQuery(this).removeClass("flipped").css({
                        '-webkit-transform': 'rotateY(0deg)',
                        '-moz-transform': 'rotateY(0deg)',
                        '-o-transform': 'rotateY(0deg)',
                        transform: 'rotateY(0deg)'
                    });
                });

                jQuery(".back.flipped").removeClass("flipped").each(function () {
                    jQuery(this).css({
                        '-webkit-transform': 'rotateY(-180deg)',
                        '-moz-transform': 'rotateY(-180deg)',
                        '-o-transform': 'rotateY(-180deg)',
                        '-ms-transform': 'rotateY(-180deg)',
                        transform: 'rotateY(-180deg)'
                    });

                });
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

            if (jQuery("div.front.flipped").length > 1) {
//                var txt = '';
//                
//                if (jQuery("div.flipped.front:eq(0)").parent().attr("data-bind") === jQuery("div.flipped.front:eq(1)").parent().attr("data-bind")) {
//                    txt = '<span class="correct-icon"></span>'+jQuery("div.flipped.back:eq(0)").find(".back-title").html() + '<span class="correct-icon"></span>' + jQuery("div.flipped.back:eq(1)").find(".back-title").html();
//                }else{
//                    txt = '<span class="correct-icon"></span>'+jQuery("div.flipped.back:eq(0)").find(".back-title").html() + '<span class="wrong-icon"></span>' + jQuery("div.flipped.back:eq(1)").find(".back-title").html();
//                }
//                
//                jQuery("#paired-text").html(txt);


                timeout = setTimeout(function () {
                    if (debatingGame.countFlipped() > 1) {
                        if ((jQuery("div.flipped.front:eq(0)").parent().attr("data-bind") == jQuery("div.flipped.front:eq(1)").parent().attr("data-bind"))) {
                            jQuery('#audio_paired')[0].play();
                            jQuery("div.flipped").parent().parent().fadeOut(300).fadeIn(300).fadeOut(300).fadeIn(300).fadeOut(300).fadeIn(300, function () {
                                jQuery(this).css({visibility: 'hidden'})
                            });
                            jQuery("div.flipped").removeClass("flipped");
                        } else {
                            timeout2 = setTimeout(function () {
                                jQuery(".back.flipped").removeClass("flipped").css({
                                    '-webkit-transform': 'rotateY(180deg)',
                                    '-moz-transform': 'rotateY(180deg)',
                                    '-o-transform': 'rotateY(180deg)',
                                    '-ms-transform': 'rotateY(180deg)',
                                    transform: 'rotateY(180deg)'
                                });
//                                jQuery('#audio_wrong')[0].play();
                                jQuery(".front.flipped").removeClass("flipped").css({
                                    '-webkit-transform': 'rotateY(0deg)',
                                    '-moz-transform': 'rotateY(0deg)',
                                    '-o-transform': 'rotateY(0deg)',
                                    transform: 'rotateY(0deg)'
                                });

                            }, 3000);
                        }
                    }
                }, 3000);

                return jQuery("div.flipped.front:eq(0)").parent().attr("data-bind") == jQuery("div.flipped.front:eq(1)").parent().attr("data-bind");
            }

            return false;
        },
        countFlipped: function () {
            return jQuery("div.flipped.front").length;
        },
        evaluateFlip: function () {
            return jQuery("div.flipped.front:eq(0)").parent().attr("data-bind") == jQuery("div.flipped.front:eq(1)").parent().attr("data-bind");
        },
        resetFlip: function () {
            clearTimeout(timeout);
            clearTimeout(timeout2);

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
        },
        checkFlipped: function (ths) {
            if (jQuery("div.front.flipped").length < 2) {
                debatingGame.flip(ths);
            } else {
                console.log(debatingGame.evaluateFlip());
                if (!debatingGame.evaluateFlip()) {
                    console.log(jQuery("div.front.flipped").length);
                    debatingGame.resetFlip();
                }
            }
        }
    };

    jQuery(".flip-container").click(function () {

        debatingGame.checkFlipped(this);

    });
});