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
include PATH_FW.'gateway/ria/bootstrap/bootstrap.plain.php';

BuizCore::$indexCache = 'cache/autoload_js/';

if (isset($_GET['l'])) {
  $tmp      = explode('.',$_GET['l']);

  $type     = $tmp[0];
  $id       = $tmp[1];

  if( !ctype_alnum($type) )
    die('Invalid Request');

  if( !ctype_alnum(str_replace(array('-','_'),array('',''), $id)) )
    die('Invalid Request');

}

BuizCore::loadClassIndex( $type.'/'.$id );

$buiz  = BuizCore::init();
$cache    = new LibCacheRequestJavascript();

if( isset($_GET['clean']) )
  $cache->clean();

if ('file' == $type) {
  if( !$cache->loadFileFromCache( $id ) )
    $cache->publishFile( $id );
} else { // default ist eine liste
  if( !$cache->loadListFromCache( $id ) )
    echo $cache->publishList( $id );
}

