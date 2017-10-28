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
    'cp1' => '16a',
    'cp11' => '16a1',
    'cp2' => '16b',
    'cp21' => '16b1',
    'cp3' => '16c',
    'cp31' => '16c1',
    'cp4' => '16d',
    'cp41' => '16d1',
    'cp5' => '16e',
    'cp51' => '16e1',
    'cp6' => '16f',
    'cp61' => '16f1',
    'cp7' => '16g',
    'cp71' => '16g1',
    'cp8' => '16h',
    'cp81' => '16h1');

shuffle_assoc($cards);

$counter = 1;
?>

<audio id="audio" src="<?php echo JURI::base() . 'components/' . JRequest::getVar('option', '') . '/assets/audio/flip-over.mp3'; ?>"></audio>
<audio id="audio_paired" src="<?php echo JURI::base() . 'components/' . JRequest::getVar('option', '') . '/assets/audio/short_celebration.wav'; ?>"></audio>
<audio id="audio_wrong" src="<?php echo JURI::base() . 'components/' . JRequest::getVar('option', '') . '/assets/audio/fail_sound.mp3'; ?>"></audio>
<audio id="audio_complete" src="<?php echo JURI::base() . 'components/' . JRequest::getVar('option', '') . '/assets/audio/long_horn_cash_register.wav'; ?>"></audio>

<div id="paired-text"><span class="green-text"><?php echo count($cards); ?></span> card game. <span class="green-text">Match</span> the <span class="green-text"><?php echo ceil(count($cards)/2); ?></span> pairs of cards that share the same topic and the same side of an arguement - with the least number of moves</div>

<div class="number-moves">
    <div class="min-number-moves">minimum number of moves:   <span class="green-text">0</span></div>
    <div class="number-moves-counter">moves made:  <span class="green-text">00</span></div>
    <div class="echo-coins">
        <img class="echoo-logo" src="<?php echo JURI::base(); ?>templates/protostar/images/echoo-logo.png" alt="echoo" />s to win: <span class="green-text"><?php echo floor(count($cards)/4); ?></span>
        <span class="echoo-coins-wrap">
            <img class="echoo-coin echoo-coin-10" src="<?php echo JURI::base(); ?>templates/protostar/images/10-coin.png" alt="echoo coin" />
            <img class="echoo-coin echoo-coin-5" src="<?php echo JURI::base(); ?>templates/protostar/images/5-coin.png" alt="echoo coin" />
            <img class="echoo-coin echoo-coin-4" src="<?php echo JURI::base(); ?>templates/protostar/images/4-coin.png" alt="echoo coin" />
            <img class="echoo-coin echoo-coin-3" src="<?php echo JURI::base(); ?>templates/protostar/images/3-coin.png" alt="echoo coin" />
            <img class="echoo-coin echoo-coin-2" src="<?php echo JURI::base(); ?>templates/protostar/images/2-coin.png" alt="echoo coin" />
            <img class="echoo-coin echoo-coin-1" src="<?php echo JURI::base(); ?>templates/protostar/images/1-coin.png" alt="echoo coin" />
        </span>
    </div>    
    <div class="clear-float">&nbsp;</div>
</div>

<div class="pair-button-wrap">Press <button type="button" class="button"><span>match</span></button> when you find a pair of cards that share the same side of an argument and win your first <img class="echoo-logo" src="<?php echo JURI::base(); ?>templates/protostar/images/echoo-logo.png" alt="echoo" /> !</div>
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