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

// server addresse
$serverAddress = (isset($_SERVER['HTTPS']) && 'on' == $_SERVER['HTTPS']) ?'https://' :'http://';
$serverAddress .= $_SERVER['SERVER_NAME'];

if ( isset( $_SERVER['HTTPS'] ) && 'on' == $_SERVER['HTTPS'] ) {
    if ($_SERVER['SERVER_PORT'] != '443') {
        $serverAddress .= ':'.$_SERVER['SERVER_PORT'];
    }
} else {
    if ($_SERVER['SERVER_PORT'] != '80') {
        $serverAddress .= ':'.$_SERVER['SERVER_PORT'];
    }
}

$serverAddress .= '/'.mb_substr( $_SERVER['REQUEST_URI'] , 0 , strrpos($_SERVER['REQUEST_URI'],'/')+1 );

$length = strlen($serverAddress);

if( '/' != $serverAddress[($length-1)] )
    $serverAddress .= '/';

define( 'WEB_GW' , $serverAddress );
define( 'WEB_ROOT' , '/' );

// includieren der passenden path php

if( isset($_SERVER['REDIRECT_conf_key']) && file_exists( PATH_GW.'/conf/host/'.$_SERVER['REDIRECT_conf_key'].'/path.php' ) ){
    
    include PATH_GW.'conf/host/'.$_SERVER['REDIRECT_conf_key'].'/path.php';

} else if( file_exists( PATH_GW.'/conf/host/'.$_SERVER['SERVER_NAME'].'/path.php' ) ){
    
    include PATH_GW.'conf/host/'.$_SERVER['SERVER_NAME'].'/path.php';

} else {

    include PATH_GW.'conf/host/web/path.php';
}

/**
 * path for tmp files
 * @var string
 */
if (!defined('PATH_TMP'))
    define( 'PATH_TMP'     , PATH_GW.'tmp/' );

/**
 * path for tmp files
 * @var string
 */
if (!defined('PATH_CACHE'))
    define( 'PATH_CACHE'     , PATH_GW.'cache/' );

/**
 * Path for all files
 * @var
 */
if (!defined('PATH_FILES'))
    define( 'PATH_FILES'    , PATH_GW );

/**
 * path for the uploads
 * @var string
 */
if (!defined('PATH_UPLOADS'))
    define( 'PATH_UPLOADS' , PATH_GW.'uploads/' );

/**
 * Source Path to the style
 * @var
 */
if (!defined('PATH_THEME'))
    define( 'PATH_THEME'    , PATH_ROOT.'BuizCore_Wgt/'  );

/**
 * Source Path to the style
 * @var
 */
if (!defined('PATH_ICONS'))
    define( 'PATH_ICONS'    , PATH_ROOT.'BuizCore_Wgt/'  );

/**
 * Source path to the buiz wgt
 * @var
 */
if (!defined('PATH_WGT'))
    define( 'PATH_WGT'      , PATH_ROOT.'BuizCore_Wgt/' );

////////////////////////////////////////////////////////////////////////////////
// Web Pfade
////////////////////////////////////////////////////////////////////////////////

/**
 * Root for The WebBrowser, all static files should be placed relativ to this
 * Constant
 * @var
*/
if (!defined('PATH_WGT'))
    define( 'WEB_ROOT'      , WEB_GW.'../' );

/**
 * Root for The WebBrowser, all static files should be placed relativ to this
 * Constant
 * @var
 */
if (!defined('WEB_FILES'))
    define( 'WEB_FILES', WEB_GW );

/**
 * Root from the activ Style Project
 * @var
 */
if (!defined('WEB_THEME'))
    define( 'WEB_THEME' , WEB_ROOT.'wgt/' );

/**
 * Root from the activ Style Project
 * @var
 */
if (!defined('WEB_ICONS'))
    define( 'WEB_ICONS' , WEB_ROOT.'wgt/' );

/**
 * ROOT path for the WebFrap Famework
 * @var
 */
if (!defined('WEB_WGT'))
    define( 'WEB_WGT'   , WEB_ROOT.'wgt/'  );

////////////////////////////////////////////////////////////////////////////////
// Wbf Config
////////////////////////////////////////////////////////////////////////////////

/**
 * Which Systemcontroller Should be used
* @var
*/
if (!defined('BUIZ_CONTROLLER'))
    define( 'BUIZ_CONTROLLER' , 'Apachemod' );

/**
 * @var
*/
if (!defined('BUIZ_RESPONSE_ADAPTER'))
    define( 'BUIZ_RESPONSE_ADAPTER' , 'Http' );

/**
 * @var
*/
if (!defined('BUIZ_ACL_ADAPTER'))
    define( 'BUIZ_ACL_ADAPTER' , 'Db' );

/**
 * db key
 * @var
*/
if (!defined('BUIZ_DB_KEY'))
    define( 'BUIZ_DB_KEY' , 'rowid' );

////////////////////////////////////////////////////////////////////////////////
// constants
////////////////////////////////////////////////////////////////////////////////

/**
 * @var
*/
define( 'NL' , "\n" );

/**
 * @var
*/
define( 'NLB' , "\r\n" );

/**
 * @var
*/
define( 'TEMP_SEP' , "~#&~" );

/**
 * @var
*/
define( 'P_S' , PATH_SEPARATOR );

/**
 * @var
*/
define( 'D_S' , '/' );


if( DEBUG )
  error_reporting( E_ALL | E_STRICT );
else
  error_reporting( 0 );

const PLAIN = 'plain';

include PATH_FW.'src/BuizCore.php';
include PATH_FW.'src/Debug.php';
include PATH_FW.'src/Conf.php';
include PATH_WGT.'src/View.php';

spl_autoload_register('BuizCore::indexAutoload');
spl_autoload_register('BuizCore::pathAutoload');

// Gateway Path
BuizCore::$autoloadPath[]  = PATH_GW.'src/';

// load only the sources from libs
BuizCore::loadModulePath(true);
//BuizCore::loadLibPath(true);

// Framework Path
BuizCore::$autoloadPath[]  = PATH_WGT.'src/';
BuizCore::$autoloadPath[]  = PATH_FW.'src/';

// set custom handlers
if( defined( 'BUIZ_ERROR_HANDLER' ) )
  set_error_handler( BUIZ_ERROR_HANDLER );

// clean the logs if in debug mode
if(DEBUG)
  Log::cleanDebugLog();

