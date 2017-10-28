<?php
/**
 * Joomla! 2.5 - Erweiterungen programmieren
 *
 * Standard-Ansicht com_mythings im Frontend.
 *
 * @package    Mythings
 * @subpackage Frontend
 * @author     chmst.de, webmechanic.biz
 * @license	   GNU/GPLv2 or later
 */
defined('_JEXEC') or die;

/* Import der Basisklasse JView */
jimport('joomla.application.component.view');

/**
 * Erweiterung der Basisklasse JView
 */
class Mp_FtpairViewGetCards extends JViewLegacy
{
  /**
   * Überschreiben der Methode display
   *
   * @param string $tpl Alternative Layoutdatei, leer = 'default'
   */
  protected $path;
  protected $cards;
    
  public function display($tpl = null)
  {
    //JFactory::getDocument()->setMimeEncoding( 'application/json' );
    //JResponse::setHeader( 'Content-Disposition', 'attachment; filename="'.$this->getName().'.json"' );
    //JRequest::setVar('tmpl','component');
    //echo json_encode($data);
    
      
          /* getItem() aus JModelList aufrufen */
        $this->path	= $this->get('Path');
        $this->cards	= $this->get('Cards');
        
        //$this->listDirImages('modules/mod_mp_jigsaw/gallery');
        $this->listDirImages($this->path, $this->cards);
  }
  
function listDirImages($dir, $cards) { //$dir is the name of the directory you want to list the images.
    
    $preg = "/.(jpg|gif|png|jpeg)/i"; //match the following files, can be changed to limit or extend range, ie: png,jpeg,etc.
    $images = array();
    $id = 0;
    if( $checkDir = opendir($dir) ) {
        while( $file = readdir($checkDir) ) {
            if(preg_match($preg, $file)) {
                if( !is_dir($dir . "/" . $file) ) {
                    //$images[basename($file)]= $file;
                    $images[$id]= $file;
                    $id++;
                }
            }
        }
    }
    $memoryCards = array ();
    
    for ($y = 0; $y < $cards; $y++)
    {
        $num = rand(0, count($images)-1 );
        array_push($memoryCards, $images[$num]);
        array_splice($images, $num, 1);
    }
    $x = count($memoryCards);
    for ($y = 0; $y < $x; $y++)
    {
        $memoryCards[] = $memoryCards[$y];
    }
    shuffle($memoryCards);shuffle($memoryCards);
    $data = json_encode($memoryCards);
    echo $_GET['callback'] . '(' . $data . ');';
  }
}
