<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
jimport('joomla.environment.request');

$jinput = JFactory::getApplication()->input;
?>

<audio id="audio" src="<?php echo JURI::base() . 'components/' . JRequest::getVar('option', '') . '/assets/audio/flip-over.mp3'; ?>"></audio>
<audio id="audio_paired" src="<?php echo JURI::base() . 'components/' . JRequest::getVar('option', '') . '/assets/audio/short_celebration.wav'; ?>"></audio>
<audio id="audio_wrong" src="<?php echo JURI::base() . 'components/' . JRequest::getVar('option', '') . '/assets/audio/fail_sound.mp3'; ?>"></audio>
<audio id="audio_complete" src="<?php echo JURI::base() . 'components/' . JRequest::getVar('option', '') . '/assets/audio/long_horn_cash_register.wav'; ?>"></audio>

<div id="paired-text"><span class="green-text">8</span> card game. <span class="green-text">Match</span> the <span class="green-text">4</span> pairs of cards that share the same topic and the same side of an arguement - with the least number of moves</div>

<div class="number-moves">
    <div class="min-number-moves">minimum number of moves:   <span class="green-text">0</span></div>
    <div class="number-moves-counter">moves made:  <span class="green-text">00</span></div>
    <div class="echo-coins">
        <img class="echoo-logo" src="<?php echo JURI::base(); ?>templates/protostar/images/echoo-logo.png" alt="echoo" />s to win: <span class="green-text">2</span>
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
    <div class="what-echoos"><a href="#">What are <img class="echoo-logo" src="<?php echo JURI::base(); ?>templates/protostar/images/echoo-logo.png" alt="echoo" />?</a></div>
    <div class="flip-container-wrap">
        <div class="next-level-wrap pair-button-wrap">Continue with tougher <button type="button" class="button new-game"><span>NEW GAME</span></button> to win more <img class="echoo-logo" src="<?php echo JURI::base(); ?>templates/protostar/images/echoo-logo.png" alt="echoo" />s</div>
        <div class="flip-container">
            <div class="flipper c2p" data-bind="id:c6p">
                <div class="front"></div>
                <div class="back">
                    <div class="back-logo"></div>
                    <div class="back-title"><img src="<?php echo JURI::base() . 'components/' . $jinput->get('option') . '/assets/images/questions/8.41.png'; ?>" alt="" /></div>
                </div>
            </div>
        </div>
        <!--<div class="separator_line back-masked1"></div>-->

        <div class="flip-container">
            <div class="flipper c1p" data-bind="id:c1p">
                <div class="front"></div>
                <div class="back">
                    <div class="back-logo"></div>
                    <div class="back-title"><img src="<?php echo JURI::base() . 'components/' . $jinput->get('option') . '/assets/images/questions/8.2.png'; ?>" alt="" /></div>
                </div>
            </div>    
        </div>
        <!--<div class="separator_line back-masked2"></div>-->

        <div class="flip-container">
            <div class="flipper c2p" data-bind="id:c1p">
                <div class="front"></div>
                <div class="back">
                    <div class="back-logo"></div>
                    <div class="back-title"><img src="<?php echo JURI::base() . 'components/' . $jinput->get('option') . '/assets/images/questions/8.21.png'; ?>" alt="" /></div>
                </div>
            </div>
        </div>
        <!--<div class="separator_line back-masked3"></div>-->

        <div class="flip-container">    
            <div class="flipper c2p" data-bind="id:c2p">
                <div class="front"></div>
                <div class="back">
                    <div class="back-logo"></div>
                    <div class="back-title"><img src="<?php echo JURI::base() . 'components/' . $jinput->get('option') . '/assets/images/questions/8.1.png'; ?>" alt="" /></div>
                </div>
            </div>
        </div>

        <div class="clearer">&nbsp;</div>

        <div class="flip-container">
            <div class="flipper c1p" data-bind="id:c5p">
                <div class="front"></div>
                <div class="back">
                    <div class="back-logo"></div>
                    <div class="back-title"><img src="<?php echo JURI::base() . 'components/' . $jinput->get('option') . '/assets/images/questions/8.3.png'; ?>" alt="" /></div>
                </div>
            </div>    
        </div>
        <!--<div class="separator_line back-masked4"></div>-->

        <div class="flip-container">    
            <div class="flipper c1p" data-bind="id:c2p">
                <div class="front"></div>
                <div class="back">
                    <div class="back-logo"></div>
                    <div class="back-title"><img src="<?php echo JURI::base() . 'components/' . $jinput->get('option') . '/assets/images/questions/8.11.png'; ?>" alt="" /></div>
                </div>
            </div>
        </div>
        <!--<div class="separator_line back-masked5"></div>-->
        <!-- // -->

        <div class="flip-container">    
            <div class="flipper c4p" data-bind="id:c6p">
                <div class="front"></div>
                <div class="back">
                    <div class="back-logo"></div>
                    <div class="back-title"><img src="<?php echo JURI::base() . 'components/' . $jinput->get('option') . '/assets/images/questions/8.4.png'; ?>" alt="" /></div>
                </div>
            </div>
        </div>
        <!--<div class="separator_line back-masked6"></div>-->    

        <div class="flip-container">
            <div class="flipper c3p" data-bind="id:c5p">
                <div class="front"></div>
                <div class="back">
                    <div class="back-logo"></div>
                    <div class="back-title"><img src="<?php echo JURI::base() . 'components/' . $jinput->get('option') . '/assets/images/questions/8.31.png'; ?>" alt="" /></div>            
                </div>
            </div>    
        </div>    

        <div class="clearer">&nbsp;</div>
    </div>
</div>
<!--
<div id="overlay"></div>
<div class="overlay-content">
    <div class="overlay-form">
        <div class="email-form-message">
                <h1>We Want To Hear From You</h1>
<h3>Please fill out the from below and we will gladly to contact you as soon as possible.</h3>
</div>
        <div class="field-wrap">
            <label for="your-name">Your Name:</label>
            <input type="text" id="your-name" />
        </div>
        <div class="field-wrap">
            <label for="your-email">Your Email:</label>
            <input type="email" id="your-email" />
        </div>
        <div class="field-wrap">            
            <button type="button" class="button"><span>Submit</span></button>
        </div>
    </div>
</div>
-->