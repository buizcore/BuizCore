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
    
    ob_start();
    
    
    View::setType( 'Json' );
    BuizCore::init();
    
    $request = Request::getActive();
    
    $target = $request->param('goto', Validator::TEXT);
    $macAddr = $request->param('mac', Validator::TEXT);
    
    if(!$macAddr && isset($_SESSION['device-mac'])){
        $macAddr = $_SESSION['device-mac'];
    }
    
    if ($macAddr) {
        $networkManager = new NetworkAccess_Manager();
        $networkManager->ping($macAddr, $_SERVER['REMOTE_ADDR']  );
    }
    
    /// TODO add some reporting
    
    
    @ob_end_clean();
    

    header('Location: '.$target);

} // ENDE TRY
catch( Exception $exception ) {
    
    //echo $exception->getMessage();
    header('Location: '.$target);
}