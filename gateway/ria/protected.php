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

  include PATH_FW.'gateway/ria/bootstrap/bootstrap.php';

  // Buffer Output
  if( BUFFER_OUTPUT )
    ob_start();

  $errors = '';
  $buiz = BuizCore::init();

  $request  = Request::getInstance();
  $fileRequest = $request->param( 'file',Validator::FULLNAME );

  $fileName = PATH_GW.'data/'.$fileRequest;

  $name = basename($fileName);

  $contentType = 'application/octet-stream' ;

  if (BUFFER_OUTPUT) {
    $errors .= ob_get_contents();
    ob_end_clean();
  }

  header('Content-Type: '.$contentType);
  header('Content-Disposition: attachment;filename="'.urlencode($name).'"');
  header('ETag: '.md5_file($fileName));
  header('Content-Length: '.filesize( $fileName ));

  readfile($fileName);

} // ENDE TRY
catch( Exception $exception ) {
  $extType = get_class($exception);

  Error::addError
  (
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
      View::printErrorPage
      (
        $exception->getMessage(),
        '500',
        $errors
      );
    }
  } else {
    echo $errors;
  }

}