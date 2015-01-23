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
 * Das Ausgabemodul für die Seite
 * 
 * @package net.webfrap
 * @deprecated use MvcUi instead
 */
class Ui extends BaseChild
{
/* //////////////////////////////////////////////////////////////////////////// */
// Attribute
/* //////////////////////////////////////////////////////////////////////////// */
    
    /**
     *
     * @var Model
     */
    protected $model = null;

/* //////////////////////////////////////////////////////////////////////////// */
// getter & setter
/* //////////////////////////////////////////////////////////////////////////// */
    
    /**
     *
     * @param Model $model            
     */
    public function setModel($model)
    {

        $this->model = $model;
    
    } // end public function setModel */

    /**
     *
     * @param Base $env            
     */
    public function __construct($env = null)
    {

        if (! $env)
            $env = BuizCore::getActive();
        
        $this->env = $env;
    
    } // end public function __construct */

}//end class Ui

