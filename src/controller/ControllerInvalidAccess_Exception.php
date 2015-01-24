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
 * Exception to throw if you want to throw an unspecific Exception inside the
 * bussines logic.
 * If you don't catch it it will be catched by the system and you will get an
 * Error Screen Inside the Applikation.
 * @package net.buiz
 */
class ControllerInvalidAccess_Exception extends Controller_Exception
{

} // end class ControllerInvalidAccess_Exception

