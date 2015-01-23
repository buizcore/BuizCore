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

define( 'WEB_GW' , '/' );

include PATH_GW.'conf/host/web/path.php';

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
 * Source path to the webfrap wgt
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
if (!defined('WEB_ROOT'))
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
if (!defined('WBF_CONTROLLER'))
    define( 'WBF_CONTROLLER' , 'Cli' );

/**
 * @var
*/
if (!defined('WBF_RESPONSE_ADAPTER'))
    define( 'WBF_RESPONSE_ADAPTER' , 'Cli' );


/**
 * @var string
*/
if (!defined('WBF_REQUEST_ADAPTER'))
    define( 'WBF_REQUEST_ADAPTER', 'Cli' );

/**
 * @var string
*/
if (!defined('WBF_MESSAGE_ADAPTER'))
    define( 'WBF_MESSAGE_ADAPTER', 'Cli' );

/**
 * @var
*/
if (!defined('WBF_ACL_ADAPTER'))
    define( 'WBF_ACL_ADAPTER' , 'Db' );

/**
 * db key
 * @var
*/
if (!defined('WBF_DB_KEY'))
    define( 'WBF_DB_KEY' , 'rowid' );

/**
 * @var string
 */
if (!defined('CONF_KEY'))
    define( 'CONF_KEY' , 'cli' );

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
if( defined( 'WBF_ERROR_HANDLER' ) )
  set_error_handler( WBF_ERROR_HANDLER );

// clean the logs if in debug mode
if(DEBUG)
  Log::cleanDebugLog();

