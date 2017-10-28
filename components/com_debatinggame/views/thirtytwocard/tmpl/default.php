<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
jimport('joomla.environment.request');

$jinput = JFactory::getApplication()->input;

function shuffle_assoc(&$array) {
    $keys = array_keys($array);

    shuffle($keys);

    foreach ($keys as $key) {
        $new[$key] = $array[$key];
    }

    $array = $new;

    return true;
}

$cards = array(
    'cp1' => '321a',
    'cp11' => '321a1',
    'cp2' => '321b',
    'cp21' => '321b1',
    'cp3' => '322a',
    'cp31' => '322a1',
    'cp4' => '322b',
    'cp41' => '322b1',
    'cp5' => '323a',
    'cp51' => '323a1',
    'cp6' => '323b',
    'cp61' => '323b1',
    'cp7' => '324a',
    'cp71' => '324a1',
    'cp8' => '324b',
    'cp81' => '324b1',
    'cp9' => '325a',
    'cp91' => '325a1',
    'cp10' => '325b',
    'cp101' => '325b1',
    'cp1a' => '326a',
    'cp1a1' => '326a1',
    'cp1b' => '326b',
    'cp1b1' => '326b1',
    'cp1c' => '327a',
    'cp1c1' => '327a1',
    'cp1d' => '327b',
    'cp1d1' => '327b1',
    'cp1e' => '328a',
    'cp1e1' => '328a1',
    'cp1f' => '328b',
    'cp1f1' => '328b1'
);

shuffle_assoc($cards);

$counter = 1;
?>

<audio id="audio" src="<?php echo JURI::base() . 'components/' . JRequest::getVar('option', '') . '/assets/audio/flip-over.mp3'; ?>"></audio>
<audio id="audio_paired" src="<?php echo JURI::base() . 'components/' . JRequest::getVar('option', '') . '/assets/audio/short_celebration.wav'; ?>"></audio>
<audio id="audio_wrong" src="<?php echo JURI::base() . 'components/' . JRequest::getVar('option', '') . '/assets/audio/fail_sound.mp3'; ?>"></audio>
<audio id="audio_complete" src="<?php echo JURI::base() . 'components/' . JRequest::getVar('option', '') . '/assets/audio/long_horn_cash_register.wav'; ?>"></audio>

<div class="game-instruction" style="display: none;">
    <div id="paired-text"><span class="green-text"><?php echo count($cards); ?></span> card game. <span class="green-text">Match</span> the <span class="green-text"><?php echo ceil(count($cards) / 2); ?></span> pairs of cards that share the same topic and the same side of an arguement - with the least number of moves</div>
    <div class="pair-button-wrap">Press <button type="button" class="button"><span>match</span></button> when you find a pair of cards that share the same side of an argument and win your first <img class="echoo-logo" src="<?php echo JURI::base(); ?>templates/protostar/images/echoo-logo.png" alt="echoo" /> !</div>
    <div class="start-button-wrap">
        <button type="button" class="start-button"><span>Start Game!</span></button>
    </div>
</div>

<div class="number-moves">
    <div class="min-number-moves">minimum number of moves:   <span class="green-text">0</span></div>
    <div class="number-moves-counter">moves made:  <span class="green-text">00</span></div>
    <div class="echo-coins">
        <img class="echoo-logo" src="<?php echo JURI::base(); ?>templates/protostar/images/echoo-logo.png" alt="echoo" />s to win: <span class="green-text"><?php echo floor(count($cards) / 4); ?></span>
        <span class="echoo-coins-wrap">
            <img class="echoo-coin echoo-coin-10" src="<?php echo JURI::base(); ?>templates/protostar/images/10-coin.png" alt="echoo coin" />
            <img class="echoo-coin echoo-coin-5" src="<?php echo JURI::base(); ?>templates/protostar/images/5-coin.png" alt="echoo coin" />
            <img class="echoo-coin echoo-coin-4" src="<?php echo JURI::base(); ?>templates/protostar/images/4-coin.png" alt="echoo coin" />
            <img class="echoo-coin echoo-coin-3" src="<?php echo JURI::base(); ?>templates/protostar/images/3-coin.png" alt="echoo coin" />
            <img class="echoo-coin echoo-coin-2" src="<?php echo JURI::base(); ?>templates/protostar/images/2-coin.png" alt="echoo coin" />
            <img class="echoo-coin echoo-coin-1" src="<?php echo JURI::base(); ?>templates/protostar/images/1-coin.png" alt="echoo coin" />
        </span>
    </div>
    <div class="match-wrap">
        <button type="button" class="button"><span>match</span></button>    
    </div>
    <div class="clear-float">&nbsp;</div>
</div>

<div class="flip-container-mainwrap">
    <?php /* <div class="what-echoos"><a href="#">What are <img class="echoo-logo" src="<?php echo JURI::base(); ?>templates/protostar/images/echoo-logo.png" alt="echoo" />?</a></div> */ ?>
    <div class="next-level-wrap pair-button-wrap">Continue with tougher <button type="button" class="button new-game"><span>NEW GAME</span></button> to win more <img class="echoo-logo" src="<?php echo JURI::base(); ?>templates/protostar/images/echoo-logo.png" alt="echoo" />s</div>
    <div class="flip-container-wrap">
        <?php foreach ($cards as $key => $card) { ?>
            <div class="flip-container">
                <div class="flipper c2p" data-bind="id:<?php echo $key; ?>">
                    <div class="front"></div>
                    <div class="back">
                        <div class="back-logo"></div>
                        <div class="back-title"><img src="<?php echo JURI::base() . 'components/' . $jinput->get('option') . '/assets/images/questions/' . $card . '.png'; ?>" alt="" /></div>
                    </div>
                </div>
            </div>
            <?php if ($counter == 8): ?>
                <div class="clearer">&nbsp;</div>        
            <?php endif; ?>
            <?php $counter++; ?>
        <?php } ?>        


        <div class="clearer">&nbsp;</div>
    </div>
</div>

<div class="scroll-arrows">
    <div class="arrow-up-wrap"><button type="button" class="up-down-btn"><span>up</span></button></div>
    <div class="arrow-down-wrap"><button type="button" class="up-down-btn"><span>down</span></button></div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function () {
        var scrollable = jQuery(document).height() - jQuery(window).height();

        if (jQuery(document).scrollTop() < scrollable) {
            jQuery(".arrow-down-wrap button").addClass("visible");
        } else {
            jQuery(".arrow-down-wrap button").removeClass("visible");
        }

        if (jQuery(document).scrollTop() > 0) {
            jQuery(".arrow-up-wrap button").addClass("visible");
        } else {
            jQuery(".arrow-up-wrap button").removeClass("visible");
        }

        jQuery("body").append("<div id=\"overlay-wrap\" />");
        jQuery("body").append("<div id=\"overlay-content\" />");

        jQuery("#overlay-content").html(jQuery(".game-instruction").html());

        jQuery(".start-button-wrap button").click(function () {
            jQuery("#overlay-content").fadeOut("fast", function () {
                jQuery("#overlay-wrap").fadeOut("fast");
            });
        });

        jQuery(".arrow-down-wrap button").click(function () {
            jQuery("html, body").stop().animate({scrollTop: 500}, '500', 'swing', function () {
                if (jQuery(document).scrollTop() < scrollable) {
                    jQuery(".arrow-down-wrap button").addClass("visible");
                } else {
                    jQuery(".arrow-down-wrap button").removeClass("visible");
                }

                if (jQuery(document).scrollTop() > 0) {
                    jQuery(".arrow-up-wrap button").addClass("visible");
                } else {
                    jQuery(".arrow-up-wrap button").removeClass("visible");
                }
            });
        });
        jQuery(".arrow-up-wrap button").click(function () {
            jQuery("html, body").stop().animate({scrollTop: 0}, '500', 'swing', function () {
                if (jQuery(document).scrollTop() < scrollable) {
                    jQuery(".arrow-down-wrap button").addClass("visible");
                } else {
                    jQuery(".arrow-down-wrap button").removeClass("visible");
                }

                if (jQuery(document).scrollTop() > 0) {
                    jQuery(".arrow-up-wrap button").addClass("visible");
                } else {
                    jQuery(".arrow-up-wrap button").removeClass("visible");
                }
            });
        });

        jQuery(window).scroll(function () {
            if (jQuery(document).scrollTop() < scrollable) {
                jQuery(".arrow-down-wrap button").addClass("visible");
            } else {
                jQuery(".arrow-down-wrap button").removeClass("visible");
            }

            if (jQuery(document).scrollTop() > 0) {
                jQuery(".arrow-up-wrap button").addClass("visible");
            } else {
                jQuery(".arrow-up-wrap button").removeClass("visible");
            }
        });
    });
</script>