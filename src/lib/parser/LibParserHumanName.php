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
 * @package net.webfrap
 *
 */
class LibParserHumanName
{
/*////////////////////////////////////////////////////////////////////////////*/
// name
/*////////////////////////////////////////////////////////////////////////////*/

  public $firstName = null;

  public $lastName = null;

  public $academic = null;

  public $nobility = null;

  public $origin = null;

/*////////////////////////////////////////////////////////////////////////////*/
// parser attributes
/*////////////////////////////////////////////////////////////////////////////*/

  protected $listAcademic = array
  (
    'DR.',
    'DR.ING.',
    'ING.'
  );

  protected $listNobility = array
  (
    'GRAF',
    'VON',
    'DE',
  );

/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  public function parse($name)
  {
    $this->clean();

    $tmp = explode(' ', $name);

    $anz = count($tmp);

    foreach ($tmp as $value) {
      if (in_array($this->listAcademic)) {

      }

    }

  }

  public function clean()
  {
    $this->firstName = null;
    $this->lastName = null;
    $this->academic = null;
    $this->nobility = null;
    $this->origin = null;
  }

}//end class LibAnnotationParser

