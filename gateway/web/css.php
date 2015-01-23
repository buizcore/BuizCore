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

define('WGT_ERROR_LOG','log.css.html');
include PATH_FW.'gateway/web/bootstrap/bootstrap.plain.php';

BuizCore::$indexCache = 'cache/autoload_css/';

if (isset($_GET['l'])) {
  $tmp = explode('.',$_GET['l']);

  $type = $tmp[0];
  $id = $tmp[1];

  if( !ctype_alnum($type) )
    $type = 'list';

  if( !ctype_alnum(str_replace(array('-','_'),array('',''), $id)) )
    $id = 'default';

} else {
  $type = 'list';
  $id = 'default';
}

BuizCore::loadClassIndex( $type.'/'.$id );

$webfrap = BuizCore::init();
BuizCore::$autoloadPath[] = View::$themePath.'src/';
$cache = new LibCacheRequestCss();

if( isset($_GET['clean']) )
  $cache->clean();

if ('file' == $type) {
  if( !$cache->loadFileFromCache( $id ) )
    $cache->publishFile( $id );
} else { // default ist eine liste
  if( !$cache->loadListFromCache( $id ) )
    echo $cache->publishList( $id );
}
