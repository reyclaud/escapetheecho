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


<div class="flip-container-mainwrap">    

    <div class="next-level-wrap pair-button-wrap">
        <div class="ender-top">Brilliant !  You've earned your first <img class="echoo-logo" src="<?php echo JURI::base(); ?>templates/protostar/images/echoo-logo.png" alt="echoo" /> !</div>
        <div class="ender-top">So now try the <button type="button" class="button new-game" onclick="window.location = '<?php echo JROUTE::_("index.php?Itemid=122", FALSE); ?>'"><span>NEXT GAME</span></button> to think wider</div>
        <div class="ender-top">and win some more <img class="echoo-logo" src="<?php echo JURI::base(); ?>templates/protostar/images/echoo-logo.png" alt="echoo" />s !</div>
        <?php /* Continue with tougher <button type="button" class="button new-game" onclick="window.location = '<?php echo JROUTE::_("index.php?Itemid=122", FALSE); ?>'"><span>NEW GAME</span></button> to win more <img class="echoo-logo" src="<?php echo JURI::base(); ?>templates/protostar/images/echoo-logo.png" alt="echoo" />s</div> */ ?>
    </div>
	
	<div class="can-you-escape">Dare you <img class="escape-echoo-logo" src="<?php echo JURI::base(); ?>templates/protostar/images/escape-the-echo-logo2-1.png" alt="echoo" /> ?</div>
    
    <div class="flip-container-wrap">
        <div class="flip-container">
            <div class="flipper c1p" data-bind="id:c1p">
                <div class="front"></div>
                <div class="back">
                    <div class="back-logo"></div>
                    <div class="back-title"><img src="<?php echo JURI::base() . 'components/' . $jinput->get('option') . '/assets/images/questions/politics1.png'; ?>" alt="" /></div>
                </div>
            </div>    
        </div>        

        <div class="flip-container">    
            <div class="flipper c2p" data-bind="id:c2p">
                <div class="front"></div>
                <div class="back">
                    <div class="back-logo"></div>
                    <div class="back-title"><img src="<?php echo JURI::base() . 'components/' . $jinput->get('option') . '/assets/images/questions/politics3.png'; ?>" alt="" /></div>
                </div>
            </div>
        </div>

        <div class="flip-container">
            <div class="flipper c2p" data-bind="id:c1p">
                <div class="front"></div>
                <div class="back">
                    <div class="back-logo"></div>
                    <div class="back-title"><img src="<?php echo JURI::base() . 'components/' . $jinput->get('option') . '/assets/images/questions/politics2.png'; ?>" alt="" /></div>
                </div>
            </div>
        </div>

        <div class="flip-container">    
            <div class="flipper c1p" data-bind="id:c2p">
                <div class="front"></div>
                <div class="back">
                    <div class="back-logo"></div>
                    <div class="back-title"><img src="<?php echo JURI::base() . 'components/' . $jinput->get('option') . '/assets/images/questions/politics4.png'; ?>" alt="" /></div>
                </div>
            </div>
        </div>                

        <div class="clearer">&nbsp;</div>

        <div class="clearer">&nbsp;</div>
    </div>
    <div class="number-moves">
        <div class="min-number-moves">Minimum number of Moves:   <span class="green-text">0</span></div>
        <div class="number-moves-counter">Moves made:  <span class="green-text">00</span></div>
        <div class="echo-coins">
            <img class="echoo-logo" src="<?php echo JURI::base(); ?>templates/protostar/images/echoo-logo.png" alt="echoo" />s to win: <span class="green-text">1</span>                
            <span class="echoo-coins-wrap">
                <img class="echoo-coin echoo-coin-10" src="<?php echo JURI::base(); ?>templates/protostar/images/10-coin.png" alt="echoo coin" />
                <img class="echoo-coin echoo-coin-5" src="<?php echo JURI::base(); ?>templates/protostar/images/5-coin.png" alt="echoo coin" />
                <img class="echoo-coin echoo-coin-4" src="<?php echo JURI::base(); ?>templates/protostar/images/4-coin.png" alt="echoo coin" />
                <img class="echoo-coin echoo-coin-3" src="<?php echo JURI::base(); ?>templates/protostar/images/3-coin.png" alt="echoo coin" />
                <img class="echoo-coin echoo-coin-2" src="<?php echo JURI::base(); ?>templates/protostar/images/2-coin.png" alt="echoo coin" />
                <img class="echoo-coin echoo-coin-1" src="<?php echo JURI::base(); ?>templates/protostar/images/1-coin.png" alt="echoo coin" />
                <span class="save-coin-wrap pair-button-wrap"><button type="button" class="button" onclick="window.location = '<?php echo JROUTE::_("index.php?Itemid=123", FALSE); ?>'"><span>Save</span></button></span>
            </span>
        </div>    
        <div class="clear-float">&nbsp;</div>
    </div>

    <div class="pair-button-wrap">Press <button type="button" class="button"><span>match</span></button> when you find a pair of cards that share the same side of an argument and win your first <img class="echoo-logo" src="<?php echo JURI::base(); ?>templates/protostar/images/echoo-logo.png" alt="echoo" /> !</div>
    <div class="what-echoos">
        <div class="what-is-escape-echo-wrap">
            <a class="what-is-escape-echo" href="<?php echo JROUTE::_("index.php?Itemid=124", FALSE); ?>">What is <img class="escape-echoo-logo" src="<?php echo JURI::base(); ?>templates/protostar/images/escape-the-echo-logo2-1.png" alt="echoo" /> ?</a>
        </div>
        <div class="what-are-echoo-wrap">
            <a class="what-are-echoo" href="<?php echo JROUTE::_("index.php?Itemid=125", FALSE); ?>">What are <img class="echoo-logo" src="<?php echo JURI::base(); ?>templates/protostar/images/echoo-logo.png" alt="echoo" />s ?</a>
        </div>
        <div class="clear-float">&nbsp;</div>
    </div>
</div>