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

define('WGT_ERROR_LOG','log.js.html');
include PATH_FW.'gateway/web/bootstrap/bootstrap.plain.php';

BuizCore::$indexCache = 'cache/autoload_js/';

// eventuelles repo
$repo = null;

if (isset($_GET['l'])) {
  $tmp      = explode('.',$_GET['l']);

  $type     = $tmp[0];
  $id       = $tmp[1];

  if( !ctype_alnum($type) )
    $type = 'list';

  if( !ctype_alnum(str_replace(array('-','_'),array('',''), $id)) )
    $id = 'default';

} else if(isset($_GET['f'])) {
  $type     = 'file';
  $id       = $_GET['f'];
  $repo     = isset($_GET['r'])?$_GET['r']:null;
} else {
  $type     = 'list';
  $id       = 'default';
}

BuizCore::loadClassIndex( $type.'/'.$id );

$buiz  = BuizCore::init();
$cache    = new LibCacheRequestJavascript();

if( isset($_GET['clean']) )
  $cache->clean();

if ('file' == $type) {
  if( !$cache->loadFileFromCache( $id, $repo ) )
    $cache->publishFile( $id, $repo );
} else { // default ist eine liste
  if( !$cache->loadListFromCache( $id ) )
    echo $cache->publishList( $id );
}

