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
JHtml::_('behavior.framework', true);

$app = JFactory::getApplication();
$menu = $app->getMenu();

// Output as HTML5
$this->setHtml5(true);

$this->addStyleSheet($this->baseurl . '/templates/' . $this->template . '/css/template.css', 'text/css', 'screen');
$this->addStyleSheet($this->baseurl . '/templates/' . $this->template . '/fonts/font-awesome-4.7.0/css/font-awesome.css', 'text/css', 'screen');

JHtml::_('bootstrap.framework');
//$this->addScript($this->baseurl . '/templates/' . $this->template . '/js/template.js');
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=3.0, user-scalable=yes"/>
        <meta name="HandheldFriendly" content="true" />
        <meta name="apple-mobile-web-app-capable" content="YES" />

        <link rel="icon" href="<?php echo JURI::base(); ?>templates/protostar/images/favicon.png">

    <jdoc:include type="head" />

    <?php
    if ($menu->getActive() == $menu->getDefault()) {
        $this->addStyleSheet($this->baseurl . '/templates/' . $this->template . '/css/template.old.css', 'text/css', 'screen');
    }
    ?>
</head>
<body id="ete-games" class="page-<?php echo $menu->getActive()->id; ?>">
    <script>
        window.fbAsyncInit = function () {
            FB.init({
                appId: '740909926091380',
                cookie: true,
                xfbml: true,
                version: 'v2.8'
            });
            FB.AppEvents.logPageView();
        };

        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {
                return;
            }
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    <div id="mainwrapper">
        <jdoc:include type="modules" name="top" />                
        <div id="main-content" class="content">
            <div class="main-content-wrap">
                <jdoc:include type="modules" name="login" />                
                <jdoc:include type="component" />                
            </div>
        </div>
    </div>                
</body>
</html>