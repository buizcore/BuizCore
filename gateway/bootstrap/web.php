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
include PATH_FW.'src/lib/session/LibSessionPhp.php';
include PATH_FW.'src/Request.php';
include PATH_FW.'src/lib/request/LibRequestPhp.php';
include PATH_FW.'src/Response.php';
include PATH_FW.'src/lib/LibResponse.php';
include PATH_FW.'src/lib/response/LibResponseHttp.php';
include PATH_FW.'src/User.php';
include PATH_WGT.'src/lib/LibTemplate.php';
include PATH_WGT.'src/lib/template/LibTemplatePublisher.php';
include PATH_FW.'src/lib/flow/LibFlowApachemod.php';
include PATH_FW.'src/I18n.php';
include PATH_FW.'src/lib/i18n/LibI18nPhp.php';
include PATH_FW.'src/Validator.php';

// extended includes
include PATH_FW.'src/s/SFiles.php';
include PATH_FW.'src/s/parser/SParserString.php';
include PATH_FW.'src/s/SFilesystem.php';

include PATH_FW.'src/t/TTrait.php';
include PATH_FW.'src/t/TFlowFlag.php';
include PATH_FW.'src/t/TFlag.php';
include PATH_FW.'src/t/TBitmask.php';

include PATH_FW.'src/lib/LibConf.php';

// include the cache
include PATH_FW.'src/lib/cache/LibCacheAdapter.php';
include PATH_FW.'src/lib/cache/LibCacheFile.php';

include PATH_FW.'src/Model.php';
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

// templatesystem / view
include PATH_WGT.'src/lib/template/LibTemplatePresenter.php';
include PATH_WGT.'src/lib/template/LibTemplateHtml.php';
include PATH_WGT.'src/lib/template/LibTemplateAjax.php';

// register all used autoload methodes
spl_autoload_register('BuizCore::indexAutoload');
spl_autoload_register('BuizCore::pathAutoload');

// extend the auto search pathes for all elements that can be splitet in
// different projects
// first written here has the highest priority

BuizCore::announceIncludePaths('develop',true);

// Gateway Path
BuizCore::$autoloadPath[]  = PATH_GW.'src/';
View::$searchPathIndex[]    = PATH_GW.'templates/';
View::$searchPathTemplate[] = PATH_GW.'templates/';
I18n::$i18nPath[]         = PATH_GW.'i18n/';
Conf::$confPath[]         = PATH_GW.'conf/';


// load the modules an libs from the conf
BuizCore::loadModulePath();
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
if ( !isset( $_GET['c'] ) ) {
  BuizCore::loadClassIndex( 'default' );
} else {
  BuizCore::loadClassIndex( $_GET['c'] );
}

// set custom handlers

//if( defined( 'BUIZ_ERROR_HANDLER' ) )
//  set_error_handler( BUIZ_ERROR_HANDLER );

// clean the logs if in debug mode
if(DEBUG)
  Log::cleanDebugLog();