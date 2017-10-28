<?php
/**
mod_mp_ftpair for Joomla! 
Author   : Mypuzzle.org
Website  : http://www.mypuzzle.org
Date     : 02 October 2012
Licence  : GPL-2
Copyright: mypuzzle.org
Notes    : Visible Copyrights and Hyperlink to mypuzzle.org required
*/
//require_once dirname(__FILE__).'/jigsaw-plugin.php';

// no direct access
defined('_JEXEC') or die('Restricted access');

if(!defined('DS')){
    define('DS',DIRECTORY_SEPARATOR);
}

$document = JFactory::getDocument();
$document->addScript( "http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" );
$document->addCustomTag( '<script type="text/javascript">jQuery.noConflict();</script>' );
$document->addScript(JURI::base(). 'modules/mod_mp_ftpair/js/ftpair-mypuzzle.js');
$document->addStyleSheet(JURI::base() . 'modules/mod_mp_ftpair/css/ftpair-mypuzzle.css');

$upload_location = 'images';
$uriBase = JURI::base();
$urlPath = JURI::base().'modules/mod_mp_ftpair/';
$mod_folder = 'modules/mod_mp_ftpair/';

$default_gallery = 'modules/mod_mp_ftpair/gallery';

$width = ($params->get( 'width' )!='') ? $params->get( 'width' ) : '300';
if (!mod_mp_ftpair_testRange($width, 100, 1000)) $width = 300;

$height = ($params->get( 'height' )!='') ? $params->get( 'height' ) : '300';
if (!mod_mp_ftpair_testRange($height, 100, 1000)) $height = 300;

$pairs = ($params->get( 'pairs' )!='') ? $params->get( 'pairs' ) : '8';

$bgcolor = ($params->get( 'bgcolor' )!='') ? $params->get( 'bgcolor' ) : '#ffffff';
$bgcolor = str_replace('#', '', $bgcolor);
if (!preg_match('/^[a-f0-9]{6}$/i', $bgcolor)) $bgcolor = 'FFFFFF';        

$cardcolor = ($params->get( 'cardcolor' )!='') ? $params->get( 'cardcolor' ) : '#FEC';
$cardcolor = str_replace('#', '', $cardcolor);
if (!preg_match('/^[a-f0-9]{6}$/i', $cardcolor)) $cardcolor = 'FEC';        

$cardbordercolor = ($params->get( 'cardbordercolor' )!='') ? $params->get( 'cardbordercolor' ) : '#F96';
$cardbordercolor = str_replace('#', '', $cardbordercolor);
if (!preg_match('/^[a-f0-9]{6}$/i', $cardbordercolor)) $cardbordercolor = 'F96';

$gallery = ($params->get( 'gallery' )!='') ? $params->get( 'gallery' ) : $default_gallery;

$sitePath = JPATH_SITE;
$siteUrl  = JURI::root(true);

$galleryDir = $gallery;
$galleryPath = JURI::base() . $gallery;
$galleryFolder = JPATH_SITE . DS . $gallery;
$isurl = false;

$output = "<style>\r";
$output .= "#mem-grid {float:left;cursor: pointer;margin:5px;border:0px solid #e0e0e0;background-color:#".$bgcolor.";width:".$width."px;}";
$output .= ".memCard {border: 1px solid #".$cardbordercolor."; border-radius: 10px;float: left;margin: 0px;background-color: #".$cardcolor."; overflow: hidden;position: relative; cursor: pointer;}";
$output .= ".memImage {border-radius:10px; margin:2px;border:#".$cardbordercolor." 1px solid; vertical-align: top;alignment-adjust: central;}";
$output .= ".memCard.selected {border-color: #".$bgcolor."; background-color: #".$bgcolor.";}";
$output .= ".memCard.selected img {display: block;}";
$output .= ".memCard img {display: none; position: absolute;}";
$output .= ".memCard.empty {border-color: #".$bgcolor."; background: #".$bgcolor."; cursor: default;}";

$output .= "</style>";

$output .= "<div style='background-color:#".$bgcolor.";width:".$width."px'>";
$output .= "  <div id='mem-grid'></div>";
$output .= "  <div style='float: right;font-size:12px;'><a href='http://mypuzzle.org'>".mod_mp_ftpair_mp_getrndanchor()."</a> by mypuzzle.org</div>";
$output .= "  <div style='width:".intval($width/2)."px;float: left;font-size:12px;'><a id='aRestart' href=''>Restart</a></div>";
$output .= "</div>";

//add diff for the image wrapper template
$output .= "<div id='imgWrapTemplate' class='memCard' style='visibility:hidden;'>\r"; //
$output .= "    <img src='' class='memImage'/>\r";
$output .= "</div>\r";

//add invisible variables for jquery access
$output .= "<div id='var_ftpair_width' style='visibility:hidden;position:absolute'>".$width."</div>\r";
$output .= "<div id='var_ftpair_height' style='visibility:hidden;position:absolute'>".$height."</div>\r";
$output .= "<div id='var_ftpair_pairs' style='visibility:hidden;position:absolute'>".$pairs."</div>\r";
$output .= "<div id='var_galleryDir' style='visibility:hidden;position:absolute'>".$galleryDir."</div>\r";

$output .= "<div id='var_galleryPath_ftpair' style='visibility:hidden;position:absolute'>".$galleryPath."</div>\r";
$output .= "<div id='var_galleryFolder_ftpair' style='visibility:hidden;position:absolute'>".$galleryFolder."</div>\r";
$output .= "<div id='var_uribase_ftpair' style='visibility:hidden;position:absolute'>".$uriBase."</div>\r";

//add jscript to start gallery from flash
$output .= "<script language='javascript'>\r";
$output .= "jQuery('#aRestart').click(function(event) {event.preventDefault();ftpair_mp_memory(".$pairs.");});";
$output .= "ftpair_mp_memory(".$pairs.");\r";
$output .= "</script>\r";
//echo "Test";
echo $output;


function mod_mp_ftpair_rndfile($dir) {
    
    if (!is_dir($dir)) return(null);
    if( $checkDir = opendir($dir) ) {
        $cFile = 0;
        // check all files in $dir, add to array listFile
        $preg = "/.(jpg|gif|png|jpeg)/i";
        while( $file = readdir($checkDir) ) {
            if(preg_match($preg, $file)) {
                if( !is_dir($dir . "/" . $file) ) {
                    $listFile[$cFile] = $file;
                    $cFile++;
                }
            }
        }
    }
    $num = rand(0, count($listFile)-1 );
    return($listFile[$num]);
}
function mod_mp_ftpair_clearpath($inputpath) {
    if (substr($inputpath, 0, 1)=='/') $inputpath = substr($inputpath, 1);
    if (substr($inputpath, strlen($inputpath)-1, 1)=='/') $inputpath = substr($inputpath, 0, strlen($inputpath)-1);
    return($inputpath);
}
function mod_mp_ftpair_testRange($int,$min,$max) {     
    return ($int>=$min && $int<=$max);
}
function mod_mp_ftpair_mp_getrndanchor()
{
    $asKW = array('Puzzle','Puzzle','Puzzles','Puzzle'
        ,'Puzzles','Puzzle', 'Puzzle', 'Puzzles'
        , 'Puzzle', 'Puzzles', 'Puzzle', 'Puzzle'
        , 'Puzzle', 'Puzzle', 'Puzzle', 'Puzzle');
    $asHC = array('a', 'b', 'c', 'd', 'e', 'f', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0');        
    $md5Str = strtolower(substr(strval(md5(strtolower($_SERVER['HTTP_HOST']))), 0, 1));    
    $idx = array_search($md5Str, $asHC);
    return($asKW[$idx]);
}
?>