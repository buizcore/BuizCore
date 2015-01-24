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
 *
 */
class V_Adaper
{
    
    public $safeVal = null;
    
    public $origVal = null;
    
    public $errorKey = null;
    
    public $isNull = false;
    
    /**
     * @return void
     */
    protected function clean()
    {
        $this->safeVal = null;
        $this->origVal = null;
        $this->errorKey = null;
        $this->isNull = false;
    }//end protected function clean */

}//end class V_Adaper

