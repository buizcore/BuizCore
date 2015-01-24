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
class LibUploadEntity extends LibUploadAdapter
{

  /**
   *
   * Enter description here ...
   * @var Entity
   */
  public $entity = null;

  /**
   *
   * Enter description here ...
   * @var string
   */
  public $attrName = null;

/*////////////////////////////////////////////////////////////////////////////*/
//
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Speichern aller Relevater Daten für die Hochgeladene Datei
   * Der Konstruktor testet ob die Datei unseren Erwartungen entspricht.
   * Wenn ja kann Sie weitervrerarbeitet werden ansonsten wird sie direkt gelöscht
   *
   * @param array $fileData
   * @param string $attrName
   */
  public function __construct($fileData, $attrName, $import = false)
  {

    if (is_object($fileData)) {
      $this->oldname = $fileData->oldname;
      $this->tmpname = $fileData->tmpname;
      $this->type = $fileData->type;
      $this->size = $fileData->size;
      $this->error = $fileData->error;
    } else {
      $this->oldname = $fileData['name'];
      $this->tmpname = $fileData['tmp_name'];
      $this->type = $fileData['type'];
      $this->size = $fileData['size'];
      $this->error = $fileData['error'];
    }

    Debug::console('in upload '.$this->oldname);

    if ($import) {
      $tmp = BuizCore::uniqid();

      SFiles::copy($this->tmpname ,  PATH_GW.'tmp/upload/'.$tmp);
      $this->tmpname = PATH_GW.'tmp/upload/'.$tmp;
    }

    $this->attrName = $attrName;

  }//end public function __construct */

  /**
   *
   * @param Entity $entity
   */
  public function setEntity($entity)
  {

    Debug::console('SET upload entity');
    $this->entity = $entity;

  }//end public function setEntity */
  
  /**
   *  Den Originalnamen erfragen
   *
   *  @return string
   */
  public function getId()
  {
      return $this->oldname;
  } // end public function getId()

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

  }//end public function save */

} // end class LibUploadEntity

