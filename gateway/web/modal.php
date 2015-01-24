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

  // calling the main main function
  if ( isset($_GET['rqt']) ) {

    View::setType( View::MODAL );
    $buiz = BuizCore::init();
    View::getActive()->setIndex( 'ajax' );

    $request = Request::getInstance();

    // only allow get,put,post and delete
    if ( !$request->inMethod( array('GET','POST','PUT','DELETE') ) ) {
      $buiz->httpError(405,$request->method());
      $errors = $buiz->out();
      $buiz->shutdown( $errors );
    } else {
      $buiz->main();
      $errors = $buiz->out();
      $buiz->shutdown( $errors );
    }

  } else {
    View::setType( 'Html' );
    $buiz = BuizCore::init();
    $request = Request::getInstance();

    // only allow get,post
    if ( !$request->inMethod(array('GET','POST','PUT','DELETE')) ) {
      $buiz->httpError(405,$request->method());
      $errors = $buiz->out();
      $buiz->shutdown( $errors );
    } else {
      // works only with desktop
      $buiz->redirectByKey( 'tripple_desktop' );

      $view = View::getActive();
      $view->openWindow( 'modal.php?'.$request->getResource() );

      $errors = $buiz->out();
      $buiz->shutdown( $errors );
    }
  }

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