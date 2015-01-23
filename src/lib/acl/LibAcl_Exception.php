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
 * @lang de:
 * Exception welche geworfen wird wenn technische Probleme beim zugriff auf
 * die ACL Datenquellen auftreten.
 * Diese Exception wird nicht geworfen wenn eine Person nur keinen Zugriff hat,
 * dieser Fall soll über Rückgaben der aufgerufenen Methoden abgehandelt werden!
 *
 * @package net.webfrap
 *
 */
class LibAcl_Exception extends Lib_Exception
{

}

