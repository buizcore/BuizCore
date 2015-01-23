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
 * @lang:de
 *
 * Container zum transportieren von acl informationen.
 *
 * Wird benötigt, da ACLs in der Regel aus mehr als nur einem Zugriffslevel bestehen
 * Weiter ermöglicht der Permission Container einfach zusätzliche Checks
 * mit einzubauen.
 *
 * @package net.webfrap
 */
class LibAclPermission_Node
{
/* //////////////////////////////////////////////////////////////////////////// */
// Attributes
/* //////////////////////////////////////////////////////////////////////////// */
    
    /**
     * das einfach zugriffslevel für eine besimmte area, bzw das höchste level
     * für eine gruppe von areas
     *
     * Das höchste Level vererbt die Rechte an die jeweils tieferen.
     * > Im Moment können rechte nur erweitert und nicht eingeschränkt werden
     *
     * @var int
     */
    public $level = null;

    /**
     * @lang de:
     *
     * Liste mit allen vorhandene Zugriffsleveln.
     * Geprüft wird immer auf den maximal wert.
     * Das heißt wenn eine person zb. insert bekommt, erbt sie dadurch
     * auch alle rechte die einen kleineres zugriffslevel benötigen
     * @var array
     */
    public static $accessLevels = [
        'denied' => 0,
        'listing' => 1,
        'access' => 2,
        'assign' => 4,
        'insert' => 8,
        'update' => 16,
        'delete' => 32,
        'publish' => 64,
        'maintenance' => 128,
        'rights' => 256,
        'admin' => 256
    ];
    
/* //////////////////////////////////////////////////////////////////////////// */
// Constructor
/* //////////////////////////////////////////////////////////////////////////// */
    
    /**
     * @lang:de
     * Einfacher Konstruktor,
     * Der Konstruktor stell sicher, dass die minimal notwendigen daten vorhanden sind.
     *
     * @param int $level
     *            das zugriffslevel
     */
    public function __construct($level = null)
    {

        $this->level = $level;
    
    } // end public function __construct */

    /**
     * 
     * @param int $level
     */
    public function setLevel($level)
    {

        $this->level = $level;
    
    }//end public function setLevel */
    
/* //////////////////////////////////////////////////////////////////////////// */
// Setter
/* //////////////////////////////////////////////////////////////////////////// */
    
    /**
     * @lang:de
     *
     * gibt einfach das level als string mit, um das einbinden des
     * containers zu erleichtern
     *
     * @return string das level als string
     */
    public function __toString()
    {

        return (string) $this->level;
    
    } // end public function __toString */

    /**
     * @lang:de
     *
     * Einfache Abfrage des Access Levels
     *
     * @return boolean
     */
    public function __get($key)
    {

        $key = strtolower($key);
        return ($this->level >= self::$accessLevels[$key]) ? true : false;
    
    } // end public function __get */

    /**
     * @lang:de
     *
     * Einfache Abfrage des Access Levels
     *
     * @return boolean
     */
    public function __isset($key)
    {

        return $this->__get($key);
    
    } // end public function __isset */

}//end class LibAclPermission_Node

