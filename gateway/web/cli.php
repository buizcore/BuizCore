#!/usr/bin/php
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

try {

  if( php_sapi_name() != 'cli' || !empty($_SERVER['REMOTE_ADDR']))
    die('Invalid Call');
  
  include PATH_FW.'gateway/cli/bootstrap/bootstrap.php';


  View::setType('Cli');

  $buiz = BuizCore::init();

  // calling the main main function
  $buiz->main();

  $buiz->shutdown( );

} // ENDE TRY
catch( Exception $exception ) {
  $extType = get_class($exception);

  Error::addError
  (
    'Uncatched  Exception: '.$extType.' Message:  '.$exception->getMessage() ,
    null,
    $exception
  );

  LibTemplateCli::printErrorPage
  (
    $exception->getMessage(),
    $exception
  );

}
