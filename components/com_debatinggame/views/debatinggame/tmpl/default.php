<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>

<style type="text/css">
    @media (min-width: 1024px){
        .content {
            padding-top: 0;
        }
    }
    
    #mainwrapper{
        background: none;
    }
    
    .content {
        padding-top: 0px;
    }

    .clearer{
        clear: both;
        height: 0;
    }
    /* simple */
    .flip-container {
        -webkit-perspective: 1000;
        -moz-perspective: 1000;
        -ms-perspective: 1000;
        perspective: 1000;

        -ms-transform: perspective(1000px);
        -moz-transform: perspective(1000px);
        -moz-transform-style: preserve-3d; 
        -ms-transform-style: preserve-3d; 

        border: 1px solid transparent;
    }

    /* START: Accommodating for IE */
    /*    .flip-container:hover .back, .flip-container.hover .back {
            -webkit-transform: rotateY(0deg);
            -moz-transform: rotateY(0deg);
            -o-transform: rotateY(0deg);
            -ms-transform: rotateY(0deg);
            transform: rotateY(0deg);
        }
    
        .flip-container:hover .front, .flip-container.hover .front {
            -webkit-transform: rotateY(180deg);
            -moz-transform: rotateY(180deg);
            -o-transform: rotateY(180deg);
            transform: rotateY(180deg);
        }*/

    /* END: Accommodating for IE */

    .flip-container, .front, .back {
        width: calc(25% - 2px);
        height: 427px;
        float: left;        
    }

    .flipper {
        -webkit-transition: 0.6s;
        -webkit-transform-style: preserve-3d;
        -ms-transition: 0.6s;

        -moz-transition: 0.6s;
        -moz-transform: perspective(1000px);
        -moz-transform-style: preserve-3d;
        -ms-transform-style: preserve-3d;

        transition: 0.6s;
        transform-style: preserve-3d;

        position: relative;
    }

    .front, .back {
        -webkit-backface-visibility: hidden;
        -moz-backface-visibility: hidden;
        -ms-backface-visibility: hidden;
        backface-visibility: hidden;

        -webkit-transition: 0.6s;
        -webkit-transform-style: preserve-3d;
        -webkit-transform: rotateY(0deg);

        -moz-transition: 0.6s;
        -moz-transform-style: preserve-3d;
        -moz-transform: rotateY(0deg);

        -o-transition: 0.6s;
        -o-transform-style: preserve-3d;
        -o-transform: rotateY(0deg);

        -ms-transition: 0.6s;
        -ms-transform-style: preserve-3d;
        -ms-transform: rotateY(0deg);

        transition: 0.6s;
        transform-style: preserve-3d;
        transform: rotateY(0deg);

        position: absolute;
        top: 0;
        left: 0;
    }

    .front {
        -webkit-transform: rotateY(0deg);
        -ms-transform: rotateY(0deg);
        background: #efefef;
        z-index: 2;
        text-align: center;
        background: url(./red-fox.jpg) no-repeat;
        background-size: auto 100%;
        width: 100%;
    }

    .back {
        background: lightblue;
        -webkit-transform: rotateY(-180deg);
        -moz-transform: rotateY(-180deg);
        -o-transform: rotateY(-180deg);
        -ms-transform: rotateY(-180deg);
        transform: rotateY(-180deg);
        background: url(./fox-hunt.jpg) no-repeat;
        background-size: 100%;
        width: 100%;
    }

    .front .name {
        font-size: 2em;
        display: inline-block;
        background: rgba(33, 33, 33, 0.9);
        color: #f8f8f8;
        font-family: Courier;
        padding: 5px 10px;
        border-radius: 5px;
        bottom: 60px;
        left: 25%;
        position: absolute;
        text-shadow: 0.1em 0.1em 0.05em #333;
        display: none;

        -webkit-transform: rotate(-20deg);
        -moz-transform: rotate(-20deg);
        -ms-transform: rotate(-20deg);
        transform: rotate(-20deg);
    }

    .front img{
        opacity: 0.3;
    }

    .back-logo {
        position: absolute;
        top: 40px;
        left: 90px;
        width: 160px;
        height: 117px;
        background: url(logo.png) 0 0 no-repeat;
    }

    .back-title {
        font-weight: bold;
        color: #fff;
        position: absolute;
        top: 180px;
        left: 0;
        right: 0;
        text-align: center;
        text-shadow: 0.1em 0.1em 0.05em #000;
        font-family: Courier;
        font-size: 22px;
    }

    .back p {
        position: absolute;
        bottom: 40px;
        left: 0;
        right: 0;
        text-align: center;
        padding: 0 20px;
        font-size: 18px;
    }

    /* vertical */
    .vertical.flip-container {
        position: relative;
    }

    .vertical .back {
        -webkit-transform: rotateX(180deg);
        -moz-transform: rotateX(180deg);
        -ms-transform: rotateX(180deg);
        transform: rotateX(180deg);
    }

    .vertical.flip-container .flipper {
        -webkit-transform-origin: 100% 213.5px;
        -moz-transform-origin: 100% 213.5px;
        -ms-transform-origin: 100% 213.5px;
        transform-origin: 100% 213.5px;
    }

    /*
    .vertical.flip-container:hover .flipper {
            -webkit-transform: rotateX(-180deg);
            -moz-transform: rotateX(-180deg);
            -ms-transform: rotateX(-180deg);
            transform: rotateX(-180deg);
    }
    */

    /* START: Accommodating for IE */
    /*    .vertical.flip-container:hover .back, .vertical.flip-container.hover .back {
            -webkit-transform: rotateX(0deg);
            -moz-transform: rotateX(0deg);
            -o-transform: rotateX(0deg);
            -ms-transform: rotateX(0deg);
            transform: rotateX(0deg);
        }
    
        .vertical.flip-container:hover .front, .vertical.flip-container.hover .front {
            -webkit-transform: rotateX(180deg);
            -moz-transform: rotateX(180deg);
            -o-transform: rotateX(180deg);
            transform: rotateX(180deg);
        }*/
    /* END: Accommodating for IE */

    .flip-container-wrap{
        background-size: auto 100%;
        background-repeat: no-repeat;
    }
</style>

<div class="flip-container-wrap">
    <div class="flip-container">
        <div class="flipper">
            <div class="front"><img src="images/question.gif" alt="" /></div>
            <div class="back">
                <div class="back-logo"></div>
                <div class="back-title">Fox hunting is a cheap and effective way of controlling vermin</div>            
            </div>
        </div>    
    </div>
    <div class="flip-container">    
        <div class="flipper">
            <div class="front"><img src="images/question.gif" alt="" /></div>
            <div class="back">
                <div class="back-logo"></div>
                <div class="back-title">Fox hunting upsets the majority because it makes sport out of cruelty to animals</div>
            </div>
        </div>
    </div>
    <div class="flip-container">
        <div class="flipper">
            <div class="front"><img src="images/question.gif" alt="" /></div>
            <div class="back">
                <div class="back-logo"></div>
                <div class="back-title">Fox hunting is a great tradition that’s existed for a thousand years</div>            
            </div>
        </div>    
    </div>
    <div class="flip-container">    
        <div class="flipper">
            <div class="front"><img src="images/question.gif" alt="" /></div>
            <div class="back">
                <div class="back-logo"></div>
                <div class="back-title">Fox hunting damages farmers' fields and their livestock</div>
            </div>
        </div>
    </div>

    <div class="clearer">&nbsp;</div>
    <div class="flip-container">
        <div class="flipper">
            <div class="front"><img src="images/question.gif" alt="" /></div>
            <div class="back">
                <div class="back-logo"></div>
                <div class="back-title">Fox hunting provides countless good jobs</div>            
            </div>
        </div>    
    </div>
    <div class="flip-container">    
        <div class="flipper">
            <div class="front"><img src="images/question.gif" alt="" /></div>
            <div class="back">
                <div class="back-logo"></div>
                <div class="back-title">Fox hunting results in the hounds dying prematurely</div>
            </div>
        </div>
    </div>
    <div class="flip-container">
        <div class="flipper">
            <div class="front"><img src="images/question.gif" alt="" /></div>
            <div class="back">
                <div class="back-logo"></div>
                <div class="back-title">Fox hunting is less cruel than shooting which often just maims the foxes</div>            
            </div>
        </div>    
    </div>
    <div class="flip-container">    
        <div class="flipper">
            <div class="front"><img src="images/question.gif" alt="" /></div>
            <div class="back">
                <div class="back-logo"></div>
                <div class="back-title">Hunted foxes suffer a lot, and most significantly, hunting is not control anyway</div>
            </div>
        </div>
    </div>

    <div class="clearer">&nbsp;</div>
</div>

<script type="text/javascript">
    jQuery(window).load(function () {
        jQuery(".flip-container-wrap").css({
            backgroundImage: 'url(./fox-hunting.jpg)'
        });
    });
    jQuery(document).ready(function () {

        debatingGame = {
            flip: function (ths) {
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

//                var ths = jQuery(this);
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
                    setTimeout(function () {
                        jQuery("div.flipped").parent().parent().css({visibility: 'hidden'});
                        jQuery("div.flipped").removeClass("flipped");
                    }, 5000)
                }

                setTimeout(function () {
                    jQuery(ths).find(".back.flipped").removeClass("flipped").css({
                        '-webkit-transform': 'rotateY(180deg)',
                        '-moz-transform': 'rotateY(180deg)',
                        '-o-transform': 'rotateY(180deg)',
                        '-ms-transform': 'rotateY(180deg)',
                        transform: 'rotateY(180deg)'
                    });
                    jQuery(ths).find(".front.flipped").removeClass("flipped").css({
                        '-webkit-transform': 'rotateY(0deg)',
                        '-moz-transform': 'rotateY(0deg)',
                        '-o-transform': 'rotateY(0deg)',
                        transform: 'rotateY(0deg)'
                    });
                }, 7000);
            },
            checkFlipped: function (ths) {
                if (jQuery("div.front.flipped").length < 2) {
                    debatingGame.flip(ths);
                }
            }
        }

        jQuery(".flip-container").click(function () {

            debatingGame.checkFlipped(this);

        });
    });
</script>