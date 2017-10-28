<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.beez3
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access.
defined('_JEXEC') or die;

JLoader::import('joomla.filesystem.file');

// Check modules
$showRightColumn = ($this->countModules('position-3') or $this->countModules('position-6') or $this->countModules('position-8'));
$showbottom = ($this->countModules('position-9') or $this->countModules('position-10') or $this->countModules('position-11'));
$showleft = ($this->countModules('position-4') or $this->countModules('position-7') or $this->countModules('position-5'));

if ($showRightColumn == 0 and $showleft == 0) {
    $showno = 0;
}

JHtml::_('behavior.framework', true);

// Get params
$color = $this->params->get('templatecolor');
$logo = $this->params->get('logo');
$navposition = $this->params->get('navposition');
$headerImage = $this->params->get('headerImage');
$config = JFactory::getConfig();
$bootstrap = explode(',', $this->params->get('bootstrap'));
$option = JFactory::getApplication()->input->getCmd('option', '');

// Output as HTML5
$this->setHtml5(true);

if (in_array($option, $bootstrap)) {
    // Load optional rtl Bootstrap css and Bootstrap bugfixes
    JHtml::_('bootstrap.loadCss', true, $this->direction);
}

$this->addStyleSheet($this->baseurl . '/templates/' . $this->template . '/css/template.css', 'text/css', 'screen');

// Check for a custom CSS file
$userCss = JPATH_SITE . '/templates/' . $this->template . '/css/user.css';

JHtml::_('bootstrap.framework');
$this->addScript($this->baseurl . '/templates/' . $this->template . '/javascript/template.js');
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=3.0, user-scalable=yes"/>
        <meta name="HandheldFriendly" content="true" />
        <meta name="apple-mobile-web-app-capable" content="YES" />
    <jdoc:include type="head" />
    <!--[if IE 7]><link href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/ie7only.css" rel="stylesheet" /><![endif]-->
    <!--[if lt IE 9]><script src="<?php echo JUri::root(true); ?>/media/jui/js/html5.js"></script><![endif]-->

    <link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/fonts/font-awesome/css/font-awesome.min.css">

    <script type="text/javascript">
        jQuery(document).ready(function () {
            jQuery("#politicsandcommunity").submit(function (event) {
                if (ajaxValidation(document.getElementById('politicsandcommunity'))) {
                    event.preventDefault();

                    jQuery.ajax({
                        url: jQuery("form#politicsandcommunity").attr("action") + "?tmpl=component",
                        data: jQuery("form#politicsandcommunity").serialize(),
                        type: "post",
                        success: function (resp) {
                            jQuery("#overlay-wrapper").fadeIn("fast");
                            jQuery("#overlay-content").html(resp);
                            ;
                            jQuery("#overlay-content").fadeIn("fast");
                        }
                    });
                }
            });
        });
    </script>
</head>
<body id="shadow">
    <?php if ($this->countModules('ete-home')) : ?>
    <div class="home-account">
        <jdoc:include type="modules" name="home-account" />
    </div>
    <div class="home-title">
        <jdoc:include type="modules" name="home-title" />
    </div>
    <div class="home-body">
        <jdoc:include type="modules" name="home-body" />
        <jdoc:include type="modules" name="home-links" />
        <jdoc:include type="modules" name="home-menu" />
    </div>
    <?php else: ?>

        <audio id="audio" src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/media/StoreDoorChime2.mp3"></audio>
        <div id="main-wrapper">
            <div id="main-content">
                <jdoc:include type="message" />
                <jdoc:include type="component" />

                <jdoc:include type="modules" name="debug" />
            </div>
        </div>

        <div id="overlay-wrapper"></div>
        <div id="overlay-content"></div>

        <!-- Go to www.addthis.com/dashboard to customize your tools --> <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-585c1ee61db091c3"></script> 
    <?php endif; ?>
</body>
</html>
