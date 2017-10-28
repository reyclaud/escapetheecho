<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
jimport('joomla.environment.request');

$jinput = JFactory::getApplication()->input;
?>

<audio id="audio" src="<?php echo JURI::base() . 'components/' . JRequest::getVar('option', '') . '/assets/audio/sip22.mp3'; ?>"></audio>

<script type="text/javascript">
    $(function () {
        var adjustment;

        $("ol.simple_with_animation").sortable({
            group: 'simple_with_animation',
            pullPlaceholder: false,
            // animation on drop
            onDrop: function ($item, container, _super) {
                var $clonedItem = $('<li/>').css({height: 0});

                $item.css({background: "#fff"});


                if ($item.parent().parent().siblings(".sorts").hasClass("not-serious-sorts")) {
                    $item.parent().parent().siblings(".sorts").html("Thank You!").fadeIn(500).fadeOut(500).fadeIn(500).fadeOut(500).fadeIn(500).fadeOut(500).fadeIn(500, function () {
                        $item.parent().parent().siblings(".sorts").html("This is not a serious problem");
                    });
                } else {
                    $item.parent().parent().siblings(".sorts").html("Thank You!").fadeIn(500).fadeOut(500).fadeIn(500).fadeOut(500).fadeIn(500).fadeOut(500).fadeIn(500, function () {
                        $item.parent().parent().siblings(".sorts").html("Our next biggest challenge is");
                    });
                }

                $item.before($clonedItem);
                $clonedItem.animate({'height': $item.height()});

                $item.animate($clonedItem.position(), function () {
                    $clonedItem.detach();
                    _super($item, container);
                });

                $("#audio")[0].play();

                $item.fadeOut("fast");
                $("#thank-you").fadeIn(400).fadeOut(400);
            },
            // set $item relative to cursor position
            onDragStart: function ($item, container, _super) {
                var offset = $item.offset(),
                        pointer = container.rootGroup.pointer;

                adjustment = {
                    left: pointer.left - offset.left,
                    top: pointer.top - offset.top
                };

                _super($item, container);
            },
            onDrag: function ($item, position) {
                $item.css({
                    left: position.left - adjustment.left,
                    top: position.top - adjustment.top
                });
            }
        });

    });
</script>

<div id="content">
    <div class="content-slides">
        <div class="slide demo">
            <div class="inner-wrapper">
                <div class="licket-questions">How much do you follow the politics of the country ?</div>
                <div class="scale-container">
                    <div class="scale-left">Very little</div>
                    <div class="scale-right">A lot</div>
                    <div style="clear: both; height: 0">&nbsp;</div>
                </div>
                <div id="just-a-slider" class="dragdealer">
                    <div class="handle red-bar">
                        <i class="fa fa-angle-double-left" aria-hidden="true"></i>
                        <span class="value">0</span>
                        <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                    </div>
                </div>

                <div class="licket-questions">How much do you follow international ?</div>
                <div class="scale-container">
                    <div class="scale-left">Very little</div>
                    <div class="scale-right">A lot</div>
                    <div style="clear: both; height: 0">&nbsp;</div>
                </div>
                <div id="just-a-slider2" class="dragdealer">
                    <div class="handle red-bar">
                        <i class="fa fa-angle-double-left" aria-hidden="true"></i>
                        <span class="value">0</span>
                        <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                    </div>
                </div>
            </div>                    
        </div>
    </div>
    <div style="clear: both">&nbsp;</div>
    <div class="sorter-wrap"> 
        <div class="questions-wrap">
            <div class="question">
                In order of priority, please put the following problems in order of size
                (please pull and drag) 
            </div>
            <ol class="simple_with_animation vertical">            
                <li>bad politicians</li>
                <li>the way we get our news</li>
                <li>low quality education</li>
                <li>the threat of dictatorship</li>
                <li>the threat of war</li>
                <li>still unfinished wars</li>
                <li>terrorism</li>
                <li>immigration</li>
                <li>refugees</li>
                <li>climate change</li>
                <li>the spread of nuclear weapons</li>
                <li>energy running out</li>
                <li>the poor economy and lack of jobs</li>
                <li>global debt</li>
                <li>population growth</li>
                <li>religious extremism</li>
                <li>the lack of religious faith</li>
                <li>the threat of infectious diseases </li>
                <li>poverty and hunger </li>
                <li>the lack of clean drinking water</li>
                <li>the threat of alien invasion</li>
            </ol>
        </div>

        <div class="option-sort-wrap">
            <div class="sorts">Our biggest challenge on the list is</div>
            <div class="ty-wrapper">
                <img id="thank-you" src="<?php echo JURI::base(); ?>templates/protostar/images/questionnaires/thank-you.png" alt="Thank You" />
                <ol class="simple_with_animation vertical dropbox"></ol>
            </div>

            <div class="box-wrapper">
                <div class="not-serious-sorts sorts">This is not a serious problem</div>
                <div class="ty-wrapper">
                    <ol class="simple_with_animation vertical dropbox not-serious"></ol>
                </div>
            </div>
        </div>
    </div>
</div>