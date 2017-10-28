<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
jimport('joomla.environment.request');
?>

<audio id="audio" src="<?php echo JURI::base() . 'components/' . JRequest::getVar('option', '') . '/assets/audio/flip-over.mp3'; ?>"></audio>
<audio id="audio_paired" src="<?php echo JURI::base() . 'components/' . JRequest::getVar('option', '') . '/assets/audio/bugle_call2.mp3'; ?>"></audio>
<audio id="audio_wrong" src="<?php echo JURI::base() . 'components/' . JRequest::getVar('option', '') . '/assets/audio/fail_sound.mp3'; ?>"></audio>
<audio id="audio_complete" src="<?php echo JURI::base() . 'components/' . JRequest::getVar('option', '') . '/assets/audio/bugle_call_complete.mp3'; ?>"></audio>

<div id="paired-text"><span class="green-text">Match</span> pairs of cards that share the same topic and the same side of an argument - with the least number of moves</div>

<div class="number-moves">
    <div class="number-moves-counter">Number of Moves :  <span class="green-text">00</span></div>
    <div class="min-number-moves">Minimum number of Moves:   <span class="green-text">0</span></div>
    <div class="echo-coins">Maximum Echoos to earn:   <span class="green-text">5</span></div>
    <div class="clear-float">&nbsp;</div>
</div>

<div class="pair-button-wrap"><button type="button" class="button"><span>match</span></button></div>

<div class="flip-container-wrap">
    <div class="flip-container">
        <div class="flipper c2p" data-bind="id:c6p">
            <div class="front"></div>
            <div class="back">
                <div class="back-logo"><img src="<?php echo JURI::base() . 'components/' . JRequest::getVar('option', '') . '/assets/images/news-media.gif'; ?>" width="42" alt="" /></div>
                <div class="back-title"> If the media report a new health scare dont doubt it</div>
            </div>
        </div>
    </div>

    <div class="flip-container">
        <div class="flipper c1p" data-bind="id:c1p">
            <div class="front"></div>
            <div class="back">
                <div class="back-logo"><img src="<?php echo JURI::base() . 'components/' . JRequest::getVar('option', '') . '/assets/images/stethoscope.png'; ?>" width="42" alt="" /></div>
                <div class="back-title">Doctors know no more than their patients</div>
            </div>
        </div>    
    </div>
    <div class="flip-container">    
        <div class="flipper c4p" data-bind="id:c3p">
            <div class="front"></div>
            <div class="back">
                <div class="back-logo"><img src="<?php echo JURI::base() . 'components/' . JRequest::getVar('option', '') . '/assets/images/protection.png'; ?>" width="42" alt="" /></div>
                <div class="back-title">Unprotected sex causes unwanted pregnancies and diseases</div>
            </div>
        </div>
    </div>
    <div class="flip-container">
        <div class="flipper c3p" data-bind="id:c4p">
            <div class="front"></div>
            <div class="back">
                <div class="back-logo"><img src="<?php echo JURI::base() . 'components/' . JRequest::getVar('option', '') . '/assets/images/protection.png'; ?>" width="42" alt="" /></div>
                <div class="back-title">Unprotected sex is really only a problem if you're a gay man</div>            
            </div>
        </div>    
    </div>
    <div class="flip-container">
        <div class="flipper c2p" data-bind="id:c2p">
            <div class="front"></div>
            <div class="back">
                <div class="back-logo"><img src="<?php echo JURI::base() . 'components/' . JRequest::getVar('option', '') . '/assets/images/stethoscope.png'; ?>" width="42" alt="" /></div>
                <div class="back-title">Doctors save lives and should be respected</div>
            </div>
        </div>
    </div>

    <div class="flip-container">
        <div class="flipper c4p" data-bind="id:c4p">
            <div class="front"></div>
            <div class="back">
                <div class="back-logo"><img src="<?php echo JURI::base() . 'components/' . JRequest::getVar('option', '') . '/assets/images/protection.png'; ?>" width="42" alt="" /></div>
                <div class="back-title">Unprotected sex is perfectly safe so long as there is no penetration</div>
            </div>
        </div>    
    </div>
    <div class="flip-container">    
        <div class="flipper c2p" data-bind="id:c1p">
            <div class="front"></div>
            <div class="back">
                <div class="back-logo"><img src="<?php echo JURI::base() . 'components/' . JRequest::getVar('option', '') . '/assets/images/stethoscope.png'; ?>" width="42" alt="" /></div>
                <div class="back-title">Doctors are basically just salesmen for drug companies</div>
            </div>
        </div>
    </div>
    <div class="flip-container">
        <div class="flipper c1p" data-bind="id:c5p">
            <div class="front"></div>
            <div class="back">
                <div class="back-logo"><img src="<?php echo JURI::base() . 'components/' . JRequest::getVar('option', '') . '/assets/images/news-media.gif'; ?>" width="42" alt="" /></div>
                <div class="back-title">If your social media report a health scare be suspcious</div>
            </div>
        </div>    
    </div>

    <div class="flip-container">
        <div class="flipper c3p" data-bind="id:c8p">
            <div class="front"></div>
            <div class="back">
                <div class="back-logo"><img src="<?php echo JURI::base() . 'components/' . JRequest::getVar('option', '') . '/assets/images/family2.png'; ?>" width="42" alt="" /></div>
                <div class="back-title">Incest should be judged only by God and one's religious faith</div>
            </div>
        </div>    
    </div>

    <div class="flip-container">
        <div class="flipper c3p" data-bind="id:c3p">
            <div class="front"></div>
            <div class="back">
                <div class="back-logo"><img src="<?php echo JURI::base() . 'components/' . JRequest::getVar('option', '') . '/assets/images/protection.png'; ?>" width="42" alt="" /></div>
                <div class="back-title">Unprotected sex is only for those in a secure relationship who want a baby</div>
            </div>
        </div>    
    </div>
    <div class="flip-container">    
        <div class="flipper c1p" data-bind="id:c2p">
            <div class="front"></div>
            <div class="back">
                <div class="back-logo"><img src="<?php echo JURI::base() . 'components/' . JRequest::getVar('option', '') . '/assets/images/stethoscope.png'; ?>" width="42" alt="" /></div>
                <div class="back-title">Doctors will always be our best source of healthcare</div>
            </div>
        </div>
    </div>




    <!-- // -->

    <div class="flip-container">    
        <div class="flipper c4p" data-bind="id:c6p">
            <div class="front"></div>
            <div class="back">
                <div class="back-logo"><img src="<?php echo JURI::base() . 'components/' . JRequest::getVar('option', '') . '/assets/images/news-media.gif'; ?>" width="42" alt="" /></div>
                <div class="back-title">If the your friends report a health scare believe it</div>
            </div>
        </div>
    </div>

    <div class="flip-container">
        <div class="flipper c4p" data-bind="id:c8p">
            <div class="front"></div>
            <div class="back">
                <div class="back-logo"><img src="<?php echo JURI::base() . 'components/' . JRequest::getVar('option', '') . '/assets/images/family2.png'; ?>" width="42" alt="" /></div>
                <div class="back-title">Incest should always be illegal for health reasons</div>
            </div>
        </div>    
    </div>
    <div class="flip-container">    
        <div class="flipper c2p" data-bind="id:c7p">
            <div class="front"></div>
            <div class="back">
                <div class="back-logo"><img src="<?php echo JURI::base() . 'components/' . JRequest::getVar('option', '') . '/assets/images/family2.png'; ?>" width="42" alt="" /></div>
                <div class="back-title">Incest should be acceptable amongst consenting adults</div>
            </div>
        </div>
    </div>


    <div class="flip-container">
        <div class="flipper c3p" data-bind="id:c5p">
            <div class="front"></div>
            <div class="back">
                <div class="back-logo"><img src="<?php echo JURI::base() . 'components/' . JRequest::getVar('option', '') . '/assets/images/news-media.gif'; ?>" width="42" alt="" /></div>
                <div class="back-title">If the media report a new health scare it's probably a lie</div>            
            </div>
        </div>    
    </div> 

    <div class="flip-container">    
        <div class="flipper c1p" data-bind="id:c7p">
            <div class="front"></div>
            <div class="back">
                <div class="back-logo"><img src="<?php echo JURI::base() . 'components/' . JRequest::getVar('option', '') . '/assets/images/family2.png'; ?>" width="42" alt="" /></div>
                <div class="back-title">Incest is only a problem if it results in pregnancies</div>
            </div>
        </div>
    </div>



    <div class="clearer">&nbsp;</div>
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