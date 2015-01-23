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
 * Download Klasse für WebFrap
 * 
 * @package net.webfrap
 */
class LibDownload
{
    
    /**
     * Name der Tabelle auf welchen sich der Datensatz bezieht
     * @var string
     */
    public $table = 'wbfsys_file';
    
    /**
     * Name des Attributes wo sich die Datei befindet
     * @var string
     */
    public $attr = 'name';
    
    /**
     * 
     * @var Pbase
     */
    protected $env = null;
    
    /**
     * @param Pbase $env
     */
    public function __construct($env)
    {
        $this->env = $env;
    }//end public function __construct */
    
    /**
     * @param string $fileId
     * @param array $params
     */
    public function getFileNode($fileId, $params)
    {
        
        return null;
        
    }//end public function getFileNode */
    
} // end class LibDownload

