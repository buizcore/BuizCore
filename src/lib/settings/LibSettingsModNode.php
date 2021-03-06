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
class LibSettingsModNode
{

    /**
   * Die ID des Nodes
   * kann auch der access key sein
   * @var int|string
   */
    public $id = null;

    /**
   * Value
   * @var string
   */
    public $value = null;

    /**
   * Eventuell vorhandene ID einens Datensatzes auf den referenziert wird
   * @var int
   */
    public $vid = null;

    /**
   * @param string $value
   * @param int $vid
   * @param int $id
   */
    public function __construct($value = null, $vid = null, $id = null)
    {

        // ein array und nicht leer
        if ($value && is_array($value)) {
            $this->value = $value['value'];
            $this->vid = $value['vid'];
            $this->id = $value['rowid'];
        } else if (is_object($value)) {
            $this->value = $value->value;
            $this->vid = $value->vid;
            $this->id = $value->rowid;
        } else {
            $this->value = $value;
            $this->vid = $vid;
            $this->id = $id;
        }
    } //end public function __construct */

    /**
     * to string
     * @return string
     */
    public function __toString()
    {

        if ($this->value) {
            return (string)$this->value;
        } else if ($this->vid) {
            return (string)$this->vid;
        } else {
            return '';
        }
    }

}// end class LibSettingsModNode

