<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <d.bonsch@buizcore.com>
* @date        :
* @copyright   : buizcore.com (Dominik Bonsch) <contact@buizcore.com>
* @distributor : buizcore.com <contact@buizcore.com>
* @project     : BuizCore
* @projectUrl  : http://buizcore.com
*
* @licence     : BuizCore <contact@buizcore.com>
*
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/

// dirty hack
header("HTTP/1.0 200 OK");

$indexFile = isset($_GET['request'])?strtolower($_GET['request']):'cms';

$index = [
  'webfrap' => 'html',
  'html'    => 'html',
  'cms' => 'cms',
  'ajax' => 'ajax',
  'json' => 'json',
  'webservice' => 'webservice',
];

if( isset($index[$indexFile]) )
  include $index[$indexFile].'.php';
else
  include 'cms.php';

