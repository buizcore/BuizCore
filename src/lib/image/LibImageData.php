<?php
use Predis\Command\PubSubPublish;
/*******************************************************************************
*
* @author      : Dominik Bonsch <d.bonsch@buizcore.com>
* @date        :
* @copyright   : BuizCore GmbH <contact@buizcore.com>
* @project     : BuizCore the business core
* @projectUrl  : http://buizcore.net
*
* @licence     : BSD License see: LICENCE/BSD Licence.txt
*
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/

/**
 * @package net.webfrap
 */
class LibImageData
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

    /**
     * Der Dateiname
     * @var string
     */
    public $imageName = null;
    
    /**
     * Der der Pfad zur Datei
     * @var string
     */
    public $imagePath = null;
    
    /**
     * Das Resource Object zb von GD
     * @var string
     */
    public $res = null;
    
    public $width = null;
    
    public $height = null;
    
    public $type = null;
    
    /**
     * neue gewünschte weite
     * @var int
     */
    public $newWidth = null;
    
    /**
     * neue gewünschte höhe
     * @var int
     */
    public $newHeight = null;
    
    /**
     * Qualität wenn speichern gewünscht
     * @var int
     */
    public $quality = 90;
    
    /**
     * @param int $size
     * @return number
     */
    public function calcXRelation($size)
    {
        return $this->width / $size ;
    }// end public function calcXRelation */
    
    /**
     * @param int $size
     * @return number
     */
    public function calcYRelation($size)
    {
        return $this->height / $size;
    }// end public function calcYRelation */
    
    /**
     * @param int $size
     * @param float $relation
     * @return int
     */
    public function fixRelation($size, $relation)
    {
        return ceil($size * $relation);
    }// end public function calcRelation
    

}// end LibImageData

