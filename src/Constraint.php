<?php

/*******************************************************************************
 *
 * @author      : Dominik Bonsch <dominik.bonsch@buiz.net>
 * @date        :
 * @copyright   : Buiz Developer Network <contact@buiz.net>
 * @project     : Buiz Web Frame Application
 * @projectUrl  : http://buiz.net
 *
 * @licence     : BSD License see: LICENCE/BSD Licence.txt
 *
 * @version: @package_version@  Revision: @package_revision@
 *
 * Changes:
 *
 *******************************************************************************/

/**
 * Static Interface to get the activ configuration object
 * @package net.buiz
 *
 */
class Constraint extends BaseChild
{
/*////////////////////////////////////////////////////////////////////////////*/
// pool logic
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param PBase $env
   */
  public function __construct($env = null)
  {

  	if(!$env)
  		$env = BuizCore::$env;
  	
    $this->env = $env;

  } //end public function __construct */


}// end class Constraint
