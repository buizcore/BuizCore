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

  $webfrap = BuizCore::init();
  $request = BuizCore::$env->getRequest();
  $graphKey = $request->param( 'graph', Validator::CKEY );

  $graphClass = SParserString::subToCamelCase( $graphKey ).'_Graph';

  if ( BuizCore::classExists( $graphClass ) ) {

    try {

      /* @var $graph LibGraphEz  */
      $graph = new $graphClass( BuizCore::$env );
      $graph->prepare();
      $graph->render();
      $errors = Response::getOutput();

      if( '' != trim($errors)  )
        echo 'ERROR: '.$errors;
      else
        $graph->out();

    } catch ( Exception $e ) {
      header( "Content-type: text/html" );
      $errors = Response::getOutput();
      echo $errors;
      echo $e;
    }
  } else {

    $errors = Response::getOutput();

    echo 'Missing Graph '.$graphKey.' '.$errors;
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

