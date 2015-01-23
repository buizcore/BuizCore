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
 * Eine Komponente hat Parameter bekommen mit der sie nichts anfangen kann
 * Das hätte vorher abgefangen werden müssen
 *
 * Daher ganz klar ein Programmierfehler
 *
 * @package net.webfrap
 *
 */
class InvalidParam_Exception extends WebfrapSys_Exception
{

}

