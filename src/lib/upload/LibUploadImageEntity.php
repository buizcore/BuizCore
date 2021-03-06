<?php
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
 * @package net.buiz
 */
class LibUploadImageEntity extends LibUploadEntity
{

  /**
   *
   */
  public function save()
  {

    Debug::console('In save of file upload');

    $id = $this->entity->getId();

    $filePath = PATH_UPLOADS.'attachments/';
    $filePath .= $this->entity->getTable().'/'.$this->attrName.'/';
    $filePath .= SParserString::idToPath($id);

    //$this->newpath = $filePath;
    //$this->newname = $id;
    Debug::console('in save name'.$id.' path:'.$filePath);

    $this->copy($id, $filePath);

    $this->cleanThumbs();

  }//end public function save */

  /**
   *
   */
  public function cleanThumbs()
  {

    $id = $this->entity->getId();

    $filePath = PATH_UPLOADS.'thumbs/';
    $filePath .= $this->entity->getTable().'/'.$this->attrName.'/';
    $filePath .= SParserString::idToPath($id);

    // thumbs löschen bei neuem upload
    SFilesystem::delete($filePath);

  }//end public function cleanThumbs */

} // end class LibUploadEntity

