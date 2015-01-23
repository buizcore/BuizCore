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

if ( !function_exists('apc_fetch') ) {
  header("HTTP/1.1 501 Not Implemented");
  echo json_encode('not_available');
  exit;
}

if ( isset( $_GET['key'] ) ) {
  $status = apc_fetch( 'upload_'.$_GET['key'] );
  echo json_encode($status);
} else {
  echo json_encode('null');
}
