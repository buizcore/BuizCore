<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <d.bonsch@buizcore.com>
* @date        :
* @copyright   : BuizCore GmbH <contact@buizcore.com>
* @project     : BuizCore the business core
* @projectUrl  : http://buizcore.net
*
* @licence     : BSD License see: LICENCE/BSD Licence.txt
*
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/


define( 'WEB_GW' , '/' );

include PATH_GW.'conf/host/cli/path.php';

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
 * ROOT path for the BuizCore Famework
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
    define( 'BUIZ_CONTROLLER' , 'Cli' );

/**
 * @var
 */
if (!defined('BUIZ_RESPONSE_ADAPTER'))
    define( 'BUIZ_RESPONSE_ADAPTER' , 'Cli' );


/**
 * @var string
*/
if (!defined('BUIZ_REQUEST_ADAPTER'))
    define( 'BUIZ_REQUEST_ADAPTER', 'Cli' );

/**
 * @var string
*/
if (!defined('BUIZ_MESSAGE_ADAPTER'))
    define( 'BUIZ_MESSAGE_ADAPTER', 'Cli' );

/**
 * @var
 */
if (!defined('BUIZ_META_LAYER'))
    define( 'BUIZ_META_LAYER' , true );

/**
 * @var
 */
if (!defined('BUIZ_ACL'))
    define( 'BUIZ_ACL' , 'Enterprise' );

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


// load the bootstrap files where it is shure that they will be embed
include PATH_FW.'src/BuizCore.php';
include PATH_FW.'src/Debug.php';
include PATH_FW.'src/Base.php';
include PATH_FW.'src/PBase.php';
include PATH_FW.'src/BaseChild.php';
include PATH_FW.'src/i/ITObject.php';
include PATH_FW.'src/t/TArray.php';
include PATH_FW.'src/t/TDataObject.php';
include PATH_WGT.'src/View.php';
include PATH_FW.'src/Conf.php';
include PATH_FW.'src/Log.php';
include PATH_FW.'src/lib/log/LibLogAdapter.php';
include PATH_FW.'src/lib/log/LibLogPool.php';
include PATH_FW.'src/Message.php';
include PATH_FW.'src/lib/message/LibMessagePool.php';
include PATH_FW.'src/Session.php';
include PATH_FW.'src/lib/session/LibSessionCli.php';
include PATH_FW.'src/Request.php';
include PATH_FW.'src/lib/request/LibRequestPhp.php';
include PATH_FW.'src/Response.php';
include PATH_FW.'src/lib/LibResponse.php';
include PATH_FW.'src/lib/response/LibResponseHttp.php';
include PATH_FW.'src/User.php';
include PATH_WGT.'src/lib/LibTemplate.php';
include PATH_WGT.'src/lib/template/LibTemplateCli.php';
include PATH_FW.'src/lib/flow/LibFlowApachemod.php';
include PATH_FW.'src/I18n.php';
include PATH_FW.'src/lib/i18n/LibI18nPhp.php';
include PATH_FW.'src/Validator.php';

// extended includes
include PATH_FW.'src/s/SFiles.php';
include PATH_FW.'src/s/parser/SParserString.php';
include PATH_FW.'src/s/SFilesystem.php';

include PATH_FW.'src/t/TTrait.php';
include PATH_FW.'src/Context.php';
include PATH_FW.'src/t/TFlag.php';
include PATH_FW.'src/t/TBitmask.php';

include PATH_FW.'src/lib/LibConf.php';

// include the cache
include PATH_FW.'src/lib/cache/LibCacheAdapter.php';
include PATH_FW.'src/lib/cache/LibCacheFile.php';

include PATH_FW.'src/mvc/MvcModule.php';
include PATH_FW.'src/mvc/MvcModel.php';
include PATH_FW.'src/mvc/MvcController.php';
include PATH_FW.'src/Manager.php';
include PATH_FW.'src/Controller.php';

// acl
include PATH_FW.'src/lib/acl/LibAclPermission.php';
include PATH_FW.'src/lib/acl/LibAcl_Db_Model.php';
include PATH_FW.'src/lib/acl/LibAclAdapter.php';
include PATH_FW.'src/lib/acl/LibAclAdapter_Db.php';

// log
include PATH_FW.'src/lib/log/LibLogFile.php';

// sql
include PATH_FW.'src/i/ISqlParser.php';
include PATH_FW.'src/lib/sql/LibSqlCriteria.php';
include PATH_FW.'src/lib/sql/LibSqlQuery.php';
include PATH_FW.'src/lib/db/LibDbResult.php';
include PATH_FW.'src/lib/parser/sql/LibParserSqlAbstract.php';
include PATH_FW.'src/lib/db/LibDbOrm.php';
include PATH_FW.'src/lib/db/LibDbConnection.php';



// register all used autoload methodes
spl_autoload_register('BuizCore::indexAutoload');
spl_autoload_register('BuizCore::pathAutoload');


// Gateway Path
BuizCore::$autoloadPath[]  = PATH_GW.'src/';
BuizCore::$autoloadPath[]  = PATH_GW.'module/';
View::$searchPathIndex[]    = PATH_GW.'templates/';
View::$searchPathTemplate[] = PATH_GW.'templates/';
I18n::$i18nPath[]         = PATH_GW.'i18n/';
Conf::$confPath[]         = PATH_GW.'conf/';


// load the modules an libs from the conf
BuizCore::loadModuleByPath('module');

if (BUIZ_DEVELOP_MODE) {
    
    BuizCore::$autoloadPath[]  = PATH_ROOT.'/BuizCore_Developer/src/';
    BuizCore::$autoloadPath[]  = PATH_ROOT.'/BuizCore_Developer/module/';
    BuizCore::loadModuleByPath('develop_module');
}

BuizCore::loadGmodPath();

// Framework Path
BuizCore::$autoloadPath[]    = PATH_WGT.'src/';  // search path for code / classes
BuizCore::$autoloadPath[]    = PATH_FW.'src/';  // search path for code / classes
BuizCore::$autoloadPath[]    = PATH_FW.'module/';  // search path for code / classes
View::$searchPathIndex[]    = PATH_WGT.'templates/'; // search path for index templates
View::$searchPathTemplate[] = PATH_FW.'templates/'; // searchpath for content templates
I18n::$i18nPath[]           = PATH_FW.'i18n/'; // search path for i18n files
Conf::$confPath[]           = PATH_FW.'conf/'; // search path for configuration files

// load the activ indexes and class files from the conf
$routePath = Buizcore::getRouteKey();

if ( !$routePath ) {
    $routePath = 'default';
}

BuizCore::loadClassIndex( $routePath );

// set custom handlers

//if( defined( 'BUIZ_ERROR_HANDLER' ) )
//  set_error_handler( BUIZ_ERROR_HANDLER );

// clean the logs if in debug mode
if(DEBUG)
  Log::cleanDebugLog();

