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

  View::setType( 'Html' );
  $buiz = BuizCore::init();

  // calling the main main function

  $buiz->main();
  $errors = $buiz->out();
  $buiz->shutdown( $errors );

} // ENDE TRY
catch( Exception $exception ) {
  $extType = get_class( $exception );

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
    View::printErrorPage(
      $exception->getMessage(),
      '500',
      $errors
    );
  } else {
    echo $errors;
  }

}