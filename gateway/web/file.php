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

  include PATH_FW.'gateway/web/bootstrap/bootstrap.php';

  // Buffer Output
  if(BUFFER_OUTPUT)
    ob_start();

  $errors = '';
  $buiz = BuizCore::init();

  $request = $buiz->getRequest();


  $key = $request->param('f',Validator::CKEY);

  if ($key) {

    $name = $request->param('n', Validator::TEXT);

    /* @var $fileManager Buiz_File_Manager */
    $fileManager = Manager::get('Buiz_File');
    $fileManager->readFile($key,$name );
    return;
  }

  $objId = $request->param('obj',Validator::EID);

  if ($objId) {

    /* @var $fileManager BuizDms_File_Manager */
    $fileManager = Manager::get('BuizDms_File');
    $fileManager->readFile($objId);
    return;
  }


}  catch( Exception $exception ) {

  $extType = get_class($exception);

  Error::addError(
    'Uncatched  Exception: '.$extType.' Message:  '.$exception->getMessage() ,
    null,
    $exception
  );

  if (BUFFER_OUTPUT) {
    $errors .= ob_get_contents();
    ob_end_clean();
  }

  if (!DEBUG) {
    if ( isset($view) and is_object($view) ) {
      $view->publishError( $exception->getMessage() , $errors );
    } else {
      View::printErrorPage(
        $exception->getMessage(),
        '500',
        $errors
      );
    }
  } else {
    echo $errors;
  }

}