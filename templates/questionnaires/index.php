<?php
defined('_JEXEC') or die('Restricted access');
// Output as HTML5
$app = JFactory::getApplication();
$menu = $app->getMenu();
$this->setHtml5(true);
$this->setGenerator("EscapeTheEcho");
$this->addStyleSheet('templates/' . $this->template . '/drager/lib/jasmine.css');
//$this->addStyleSheet('templates/' . $this->template . '/drager/lib/font-awesome/css/font-awesome.min.css');
$this->addStyleSheet('templates/' . $this->template . '/drager/src/dragdealer.css');
$this->addStyleSheet('templates/' . $this->template . '/drager/demo/style/index.css');
$this->addStyleSheet('templates/' . $this->template . '/drager/demo/style/jasmine-reporter.css');
$this->addStyleSheet('templates/' . $this->template . '/drager/demo/style/demos.css');
$this->addStyleSheet('templates/' . $this->template . '/sorter/css/application.css');
$this->addStyleSheet('templates/' . $this->template . '/sorter/css/example.css');
$this->addScript('/templates/' . $this->template . '/js/jquery-sortable.js', 'text/javascript');
$this->addScript('/templates/' . $this->template . '/drager/lib/jquery.simulate.js', 'text/javascript');
$this->addScript('/templates/' . $this->template . '/drager/lib/jasmine.js', 'text/javascript');
$this->addScript('/templates/' . $this->template . '/drager/lib/jasmine-jsreporter.js', 'text/javascript');
$this->addScript('/templates/' . $this->template . '/drager/lib/jasmine-html.js', 'text/javascript');
$this->addScript('/templates/' . $this->template . '/drager/lib/jasmine-jquery.js', 'text/javascript');
$this->addScript('/templates/' . $this->template . '/drager/src/dragdealer.js', 'text/javascript');
$this->addScript('/templates/' . $this->template . '/drager/demo/script/index.js', 'text/javascript');
$this->addScript('/templates/' . $this->template . '/drager/demo/script/demos.js', 'text/javascript');
$this->addScript('/templates/' . $this->template . '/sorter/js/jquery-sortable.js', 'text/javascript');
JHtml::_('bootstrap.framework');
if ($menu->getActive() != $menu->getDefault()):
    $this->addScript($this->baseurl . '/templates/' . $this->template . '/javascript/template.js');
    $this->addScript($this->baseurl . '/templates/' . $this->template . '/javascript/overlay.js');
endif;
?>
<!DOCTYPE html>
<html xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
    <head>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>        
    <jdoc:include type="head" />
    <link rel="shortcut icon" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/favicon.png" />
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/template.css" type="text/css" />    
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/media.css" type="text/css" />    
    <link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/fonts/font-awesome/css/font-awesome.min.css">
    <?php if ($menu->getActive() != $menu->getDefault()): ?>
        <script type="text/javascript">
            $(document).ready(function () {
                $("#ete-questionnaires").submit(function (event) {
                    if (ajaxValidation(document.getElementById('ete-questionnaires'))) {
                        event.preventDefault();
                        $.ajax({
                            url: $("form#ete-questionnaires").attr("action") + "?tmpl=component",
                            data: $("form#ete-questionnaires").serialize(),
                            type: "post",
                            success: function (resp) {
                                $("#overlay-wrapper").fadeIn("fast");
                                $("#overlay-content").html(resp);
                                ;
                                $("#overlay-content").fadeIn("fast");
                            }
                        });
                    }
                });

                $("i.fa.fa-bars").click(function () {
                    $(".nav.menu.ete-menu").slideToggle("fast");
                });
            });
        </script>
        <script type="text/javascript">
            $(window).load(function () {
                var adjustment;
                var arrowTimer = setInterval(function () {
                    $(".option-sort-wrap").toggleClass("no-bg");
                }, 800);
                $("ol.simple_with_animation.dropbox").sortable({
                    group: 'simple_with_animation',
                    pullPlaceholder: false,
                    drag: false,
                    onDragStart: function ($item, container, _super) {
                        $item.find(".rsformVerticalClear").css({background: "#0467be"});
                        $item.find("label").css({color: "#fff"});
                        var offset = $item.offset(),
                                pointer = container.rootGroup.pointer;
                        adjustment = {
                            left: pointer.left - offset.left + 30,
                            top: pointer.top - offset.top + 5
                        };
                        _super($item, container);
                    },
                    onDrag: function ($item, position) {
                        $item.find(".rsformVerticalClear").css({background: "#0467be"});
                        $item.find("label").css({color: "#fff"});
                        $item.css({
                            left: position.left - adjustment.left,
                            top: position.top - adjustment.top
                        });
                    },
                    // animation on drop
                    onDrop: function ($item, container, _super) {
                        var $clonedItem = $('<li/>').css({height: 0});
                        var itemsLeft = 0;
                        $item.find("label").css({color: "#fff"});
                        if ($item.parent().parent().siblings(".sorts").hasClass("not-serious-sorts")) {
                            $item.parent().siblings(".sorts").html("Thank You!").fadeIn(500).fadeOut(500).fadeIn(500).fadeOut(500).fadeIn(500).fadeOut(500).fadeIn(500, function () {
                                $item.parent().siblings(".sorts").html("This is not a serious problem");
                            });
                        } else {
                            $item.parent().siblings(".sorts").html("");
                            //                        $item.parent().siblings(".sorts").html("").fadeOut(500).fadeIn(500).fadeOut(500).fadeIn(500, function () {
                            //                        });
                        }
                        $item.before($clonedItem);
                        $clonedItem.animate({'height': $item.height()});
                        $item.animate($clonedItem.position(), function () {
                            $clonedItem.detach();
                            _super($item, container);
                            if ($item.parent().hasClass("dropbox")) {
                                clearInterval(arrowTimer);
                                $(".option-sort-wrap").addClass("no-bg");
                                $("#coinsaudio")[0].play();
                                $item.stop(true).fadeOut(1000, function () {
                                    if ($(".thankyou-wrap").length === 0) {
                                        $item.parent().siblings(".sorts").after("<div class=\"thankyou-wrap\">Thank You !</div>");
                                    }
                                    $(".thankyou-wrap").stop(true).fadeIn(800).fadeOut(800).fadeIn(800).fadeOut(800, function () {
                                        $(".simple_with_animation.drag").each(function () {
                                            itemsLeft += $(this).children("li").length;
                                        });
                                        if (itemsLeft > 0) {
                                            $item.parent().siblings(".sorts").not(".sort_pleasure").html("The world's next biggest challenge is");
                                            $item.parent().siblings(".sort_pleasure").html("The next thing I get most pleasure from is");
                                            clearInterval(arrowTimer);
                                            arrowTimer = setInterval(function () {
                                                $(".option-sort-wrap").stop(true).toggleClass("no-bg");
                                            }, 800);
                                        } else {
                                            $item.parent().siblings(".sorts").after("<div class=\"next-question-message\"><div class=\"line1\"><span class=\"blink green-text\">BRILLIANT !</div><div class=\"line2\">Now go to</div><div class=\"line3\"><span class=\"green-next-question\">NEXT QUESTION</span></div></div></div>");
                                            var blink = setInterval(function () {
                                                $("span.blink").stop(true).toggleClass("green-text");
                                            }, 800);
                                            $(".green-next-question").click(function () {
                                                $("button[name='form[next]']").click();
                                            });
                                        }
                                    });
                                });
                            } else {
                                $item.find(".rsformVerticalClear").css({background: "#fff"});
                                $item.find("label").css({color: "#0467be"});
                            }
                        });
                        //                    $item.css({background: "#0467be", marginTop: "42px"});
                        //                    $("#thank-you").fadeIn(400).fadeOut(400);
                    }
                });
                $("ol.simple_with_animation.drag").sortable({
                    group: 'simple_with_animation',
                    pullPlaceholder: false,
                    drop: false,
                    // set $item relative to cursor position
                    onDragStart: function ($item, container, _super) {
                        $item.find(".rsformVerticalClear").css({background: "#0467be"});
                        $item.find("label").css({color: "#fff"});
                        var offset = $item.offset(),
                                pointer = container.rootGroup.pointer;
                        adjustment = {
                            left: pointer.left - offset.left + 30,
                            top: pointer.top - offset.top + 5
                        };
                        _super($item, container);
                    },
                    onDrag: function ($item, position) {
                        $item.find(".rsformVerticalClear").css({background: "#0467be"});
                        $item.find("label").css({color: "#fff"});
                        console.log($item.find(".rsformVerticalClear").length);
                        $item.css({
                            left: position.left - adjustment.left,
                            top: position.top - adjustment.top
                        });
                    }
                });
            });
        </script>
    <?php endif; ?>
</head>
<body id="main-wrapper" class="<?php
echo $menu->getActive() == $menu->getDefault() ? ('frontpage') : ('page') . '-' . $menu->getActive()->id;
?>">
    <audio id="audio" src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/media/StoreDoorChime2.mp3"></audio>
    <audio id="coinsaudio" src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/media/CoinDrop.mp3"></audio>
    <audio id="coinslotaudio" src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/media/SlotMachineCoinDrop3.1.mp3"></audio>
    <audio id="coinsDropAudio" src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/media/cash_register_sound_effect.mp3"></audio>
    <audio id="audio_celebration" src="<?php echo $this->baseurl; ?>/components/com_debatinggame/assets/audio/Trumpet_3.mp3"></audio>
    <audio id="trumpetaudio" src="<?php echo $this->baseurl; ?>/components/com_debatinggame/assets/audio/short_celebration.wav"></audio>
    <audio id="completedaudio" src="<?php echo $this->baseurl; ?>/components/com_debatinggame/assets/audio/long_horn_cash_register.wav"></audio>
    <div id="page-header" class="<?php echo 'page-header-' . $menu->getActive()->id; ?>">
        <?php if ($this->countModules('top')) : ?>
            <jdoc:include type="modules" name="backend-top" style="xhtml"  />
        <?php endif; ?>
        <?php if ($this->countModules('top')) : ?>
            <div class="modtop page-banner">
                <jdoc:include type="modules" name="top" style="xhtml"  />
                <div class="clearer"></div>
            </div>
        <?php endif; ?>
        <?php if ($this->countModules('mainmenu')) : ?>
            <div class="mainmenu-wrap">                
                <jdoc:include type="modules" name="mainmenu" />
            </div>
        <?php endif; ?>
        <?php if ($this->countModules('backend')) : ?>
            <div class="mainmenu-wrap">                
                <jdoc:include type="modules" name="backend" />
            </div>
        <?php endif; ?>
    </div>
    <div id="main-content">
        <?php if ($this->countModules('form_top')) : ?>
            <jdoc:include type="modules" name="form_top" style="xhtml" /> 
        <?php endif; ?>
        <jdoc:include type="component" />
        <?php if ($this->countModules('quizeslist')) : ?>
            <jdoc:include type="modules" name="quizeslist" style="xhtml" /> 
        <?php endif; ?>

        <?php if ($this->countModules('form_controls')) : ?>
            <jdoc:include type="modules" name="form_controls" style="xhtml" /> 
        <?php endif; ?>
        <?php if ($this->countModules('popups_form')) : ?>
            <jdoc:include type="modules" name="popups_form" style="xhtml" /> 
        <?php endif; ?>
        <?php if ($this->countModules('bottom_form')) : ?>
            <jdoc:include type="modules" name="bottom_form" style="xhtml" /> 
        <?php endif; ?>
        <jdoc:include type="modules" name="footer" />
    </div>
</body>
</html>