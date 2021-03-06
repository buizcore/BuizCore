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

// define needed constantes
if (!defined('BUIZ_DB_KEY'))
  define('BUIZ_DB_KEY','rowid');

if (!defined('DEBUG'))
  define('DEBUG',false);

if (!defined('BUIZ_DEVELOP_MODE'))
  define('BUIZ_DEVELOP_MODE',false);

if (!defined('BUIZ_NO_LOGIN'))
  define('BUIZ_NO_LOGIN',false);

if (!defined('BUIZ_ACL_DISABLED'))
  define('BUIZ_ACL_DISABLED',false);

if (!defined('BUIZ_SHOW_MOCKUP'))
  define('BUIZ_SHOW_MOCKUP', false);

if (DEBUG)
  BuizCore::$scriptStart = BuizCore::startMeasure();

/**
 * Die Hautptklasse für BuizCore
 * @package net.buiz
 * @author Dominik Bonsch <dominik.bonsch@buiz.net>
 */
class BuizCore
{
/*////////////////////////////////////////////////////////////////////////////*/
// attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * singleton instance
   * @var LibFlowApachemod
   */
  private static $instance = null;

  /**
   * singleton instance
   * @var LibFlowApachemod
   */
  public static $env = null;

  /**
   * @var string
   */
  protected static $runkey = null;

  /**
   *
   * @var array
   */
  public static $loadAble = [];

  /**
   * Include Path
   * @var array
   */
  protected static $includePath = [];

  /**
   * Autoload methods
   * @var array
   */
  protected static $autoload = array(
    'BuizCore::autoload' => true
  );

  /**
   * alle projektpfade durch die die standard Autoload Itterieren muss
   * @var array
   */
  public static $autoloadPath = [];

  /**
   * Klassenindex für die Schnelle Autoload Methode
   * @var array
   */
  public static $classIndex = [];

  /**
   * Template Index to save all requested templates per request
   * @var array
   */
  public static $tplIndex = [];

  /**
   * Template Cache index
   * @var array
   */
  public static $tplCacheIndex = [];

  /**
   * where there any changes in the classindex in the autoload?
   * if true the system writes the new index in the cache
   * @var boolean
   */
  public static $indexChanged = false;

  /**
   * the key for fetching the autoload class index
   * @var string
   */
  public static $indexKey = null;

  /**
   * path to the index cache for the autoload method
   * @var string
   */
  public static $indexCache = 'cache/autoload/';

  /**
   * nicht persistente sequence für die script laufzeit
   * @var int
   */
  public static $sequence = 0;

  /**
   * Classes that should be initialized
   * @var array
   */
  public static $initClasses = [];

  /**
   * Number of PHP Errors from the own error handler
   * @var int
   */
  public static $numPhpErrors = 0;

  /**
   * the first php error as string
   * @var string
   */
  public static $firstError = null;

  /**
   * the first php error as string
   * @var int
   */
  public static $scriptStart = null;

/*////////////////////////////////////////////////////////////////////////////*/
// constantes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param int
   */
  const MAX_PACKAGE_LEVEL = 5 ;

/*////////////////////////////////////////////////////////////////////////////*/
// protect construct and clone
/*////////////////////////////////////////////////////////////////////////////*/

 /**
  * Der Standart Konstruktor
  * @return void
  */
  protected function __construct()
  {
  } // end protected function __construct */

  /**
   * Klonen per 'clone' von außen verbieten
   */
  protected function __clone()
  {
  }//end protected function __clone */

/*////////////////////////////////////////////////////////////////////////////*/
// fake singleton
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Erfragen des aktiven Flow Controllers
   * @return LibFlowApachemod
   *
   * @deprecated use BuizCore::getActive
   */
  public static function getInstance()
  {
    if (is_null(self::$instance))
      self::init();

    return self::$instance;
  } // end public static function getInstance */

  /**
   * Erfragen des aktiven Flow Controllers
   * @return LibFlowApachemod
   */
  public static function getActive()
  {

    if (is_null(self::$instance))
      self::init();

    return self::$instance;

  } // end public static function getActive */

  /**
   * set the flow controller for buiz
   * @param string $key
   */
  public static function setEnvironment($key)
  {

    define('BUIZ_CONTROLLER',$key);
    define('BUIZ_REQUEST_ADAPTER',$key);

  }//end public static function setEnvironment */

  /**
   * create a single instance for the workflow controller
   *
   * @return void
   * @throws ClassNotFound_Exception
   */
  protected static function createInstance()
  {

    if (defined('BUIZ_CONTROLLER'))
      $flowController = 'LibFlow'.ucfirst(BUIZ_CONTROLLER);
    else
      $flowController = 'LibFlowApachemod';

    self::$instance = new $flowController();

  } // end protected static function createInstance */



/*////////////////////////////////////////////////////////////////////////////*/
// Include Path
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * set the php include path for the script
   *
   * @param string $includePath
   */
  public static function setIncludePath($includePath)
  {
    if (!isset(self::$includePath[$includePath])) {
      set_include_path(get_include_path().P_S.$includePath);
      self::$includePath[$includePath] = true;
    }
  }//end public static function setIncludePath */

  /**
   * add a new path to the include path
   *
   * @param string $includePath
   */
  public static function addIncludePath($includePath)
  {

    if (!isset(self::$includePath[$includePath])) {
      set_include_path(get_include_path().P_S.$includePath);
      self::$includePath[$includePath] = true;
    }

  }//end public static function addIncludePath */

/*////////////////////////////////////////////////////////////////////////////*/
// Classloading
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $path
   */
  public static function addAutoloadPath($path)
  {

    self::$autoloadPath[] = $path;

  }//end public static function addAutoloadPath */

  /**
   * wrapper for class exists
   * cause class exists always throws an exception if the class not exists
   * @param string $classname
   * @return boolean
   */
  public static function classLoadable($classname)
  {

    if (!isset(self::$loadAble[$classname])) {
      try {
        $back = class_exists($classname);
        self::$loadAble[$classname] = $back;

        return $back;
      } catch (ClassNotFound_Exception $e) {
        self::$loadAble[$classname] = false;

        return false;
      }
    } else {
      return self::$loadAble[$classname];
    }

  }//end function classLoadable */

  /**
   * wrapper for class exists
   * cause class exists always throws an exception if the class not exists
   * @param string $classname
   * @return boolean
   */
  public static function interfaceLoadable($classname)
  {

    if (!isset(self::$loadAble[$classname])) {
      try {
        $back = interface_exists($classname);
        self::$loadAble[$classname] = $back;

        return $back;
      } catch (ClassNotFound_Exception $e) {
        self::$loadAble[$classname] = false;

        return false;
      }
    } else {
      return self::$loadAble[$classname];
    }

  }//end function interfaceLoadable */

  /**
   * wrapper for class exists
   * cause class exists always throws an exception if the class not exists
   * @param string $classname
   * @return boolean
   */
  public static function classExists($classname)
  {

    if (!isset(self::$loadAble[$classname])) {
      try {
        $back = class_exists($classname);
        self::$loadAble[$classname] = $back;

        return $back;
      } catch (ClassNotFound_Exception $e) {
        self::$loadAble[$classname] = false;

        return false;
      }
    } else {
      return self::$loadAble[$classname];
    }

  }//end function classExists */

  /**
   * wrapper for class exists
   * cause class exists always throws an exception if the class not exists
   * @param string $classname
   * @return boolean
   */
  public static function interfaceExists($classname)
  {

    if (!isset(self::$loadAble[$classname])) {
      try {
        $back = interface_exists($classname);
        self::$loadAble[$classname] = $back;

        return $back;
      } catch (ClassNotFound_Exception $e) {
        self::$loadAble[$classname] = false;

        return false;
      }
    } else {
      return self::$loadAble[$classname];
    }

  }//end function interfaceExists */


  /**
   * Enter description here...
   *
   * @param string $includePath
   */
  public static function addAutoload($autoload)
  {

    if (!isset(self::$autoload[$autoload])) {
      spl_autoload_register($autoload);
      self::$autoload[$autoload] = true;
    }
  }//end public static function addAutoload */

  /**
   *
   * @return unknown_type
   */
  public static function loadClassIndex( $key = 'default'  )
  {

    $key = strtolower($key);
    $key = str_replace(['/','..',' '] , ['','',''] , $key);

    self::$indexChanged = false;
    self::$indexKey = $key;

    $keyPath = str_replace('.' , '/' , $key  );
    $path = PATH_GW.self::$indexCache.$keyPath.'/'.$key.'.php';

    if (file_exists($path))
      include $path;

  }//end public static function loadClassIndex */

  /**
   *
   * @return unknown_type
   */
  public static function saveClassIndex(  )
  {

    if (!self::$indexChanged)
      return;

    // append class index
    $index = '<?php
  BuizCore::$classIndex = array('.NL;

    foreach (self::$classIndex as $class => $path)
      $index .= "    '$class' => '$path',".NL;

    $index .= NL.');'.NL.NL;

    // append template index
    $index .= '
  BuizCore::$tplIndex = array('.NL;

    foreach (self::$tplIndex as $key => $path)
      $index .= "    '$key' => '$path',".NL;

    $index .= NL.');'.NL.NL;

    $keyPath = str_replace('.' , '/' , self::$indexKey  );
    $path = PATH_GW.self::$indexCache.$keyPath.'/';

    $file = $path.self::$indexKey.'.php';

    if (!is_dir($path))
      if (!SFilesystem::mkdir($path))
        return;

    file_put_contents($file , $index);

  }//end public static function saveClassIndex */

  /**
   * Die Autoload Methode versucht anhand des Namens der Klassen den Pfad
   * zu erraten in dem sich die Datei befindet
   *
   * Dies Methode ist relativ Langsam und sollte nur beim Entwickeln genutzt
   * werden, Produktivsystemen geht das extrem auf die Performance
   *
   *
   * @param string $classname Name der Klasse
   */
  public static function pathAutoload($classname)
  {

      $length = strlen($classname);
      $requireMe = null;

      foreach (BuizCore::$autoloadPath as $path) {

        $parts = [];
        $start = 0;
        $end = 1;
        $package = '';

        if (file_exists($path.$classname.'.php')) {

          include $path.$classname.'.php' ;
          return;

        } else {

          // 3 Stufen Packages
          $level = 0;
          for ($pos = 1 ; $pos < $length  ; ++$pos) {

            if (ctype_upper($classname[$pos])) {
              $package  .= strtolower(str_replace('_','', substr($classname, $start, $end  ))).'/' ;
              $start    += $end;
              $end = 0;
              ++$level;

              $file = realpath($path.$package.$classname.'.php');
              if (file_exists($file)) {
                Debug::logFile($file);
                self::$classIndex[$classname] = $file;
                self::$indexChanged = true;
                include $file;

                return;
              }

              if ($level == self::MAX_PACKAGE_LEVEL)
                break;
            }
            ++$end;
          }
        }//end if (file_exists($path.$classname.'.php'))

      }//end foreach (BuizCore::$autoloadPath as $path)

  } //function public static function pathAutoload */

  /**
   * Diese Autoload Methode geht über einen Index
   * Ist sehr schnell muss allerdings befüllt werden
   *
   * @param string $classname Name der Klasse
   */
  public static function indexAutoload($classname)
  {

    if (isset(BuizCore::$classIndex[$classname]))
      include BuizCore::$classIndex[$classname];

  } //function public static function indexAutoload */

  /**
   * Die Autoload Methode versucht anhand des Namens der Klassen den Pfad
   * zu erraten in dem sich die Datei befindet
   *
   * Dies Methode ist relativ Langsam und sollte nur beim Entwickeln genutzt
   * werden, Produktivsystemen geht das extrem auf die Performance
   *
   *
   * @param string $classname Name der Klasse
   */
  public static function namespaceAutoload($classname)
  {

    $length = strlen($classname);
    $requireMe = null;

    $relPath = str_replace("\\", "/", $classname).".php";

    foreach (BuizCore::$autoloadPath as $path) {

      $file = $path.$relPath;

      if (file_exists($file)) {
        Debug::logFile($file);
        self::$classIndex[$classname] = $file;
        self::$indexChanged = true;
        include $file;

        return;
      }

    }//end foreach (BuizCore::$autoloadPath as $path)

  } //function public static function namespaceAutoload */

  /**
   * Fallback Autoload Methode wenn die klasse nicht gefunden wird
   * @throws ClassNotFound_Exception
   *
   * @param string $classname
   */
  public static function notfoundAutoload($classname)
  {

    $filename = PATH_GW.'tmp/cnf/'.uniqid().'.tmp';
    $errorText = "Class $classname not Found!";

    $toEval = "
    <?php

    // delete at require
    unlink('$filename');

    // throw at require
    throw new ClassNotFound_Exception('$errorText');

    /*
    class $classname
    {
      public function __construct()
        // throw everytime somebody wants to create an object from this
      {
        throw new ClassNotFound_Exception('$errorText');
      }

    }
    */
    ?>";

    file_put_contents($filename , $toEval);
    include $filename;

  } //function public static function notfoundAutoload */

/*////////////////////////////////////////////////////////////////////////////*/
// Error Handler
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Buiz Own Error Handler
   *
   * @param int $errno
   * @param string $errstr
   * @param string $errfile
   * @param string $errline
   * @param string $errDump
   */
  public static function errorHandler($errno,$errstr,$errfile,$errline,$errDump)
  {

    $errorType = array(
      E_ERROR => 'ERROR',
      E_WARNING => 'WARNING',
      E_PARSE => 'PARSING_ERROR',
      E_NOTICE => 'NOTICE',
      E_CORE_ERROR => 'CORE_ERROR',
      E_CORE_WARNING => 'CORE_WARNING',
      E_COMPILE_ERROR => 'COMPILE_ERROR',
      E_COMPILE_WARNING => 'COMPILE_WARNING',
      E_USER_ERROR => 'USER_ERROR',
      E_USER_WARNING => 'USER_WARNING',
      E_USER_NOTICE => 'USER_NOTICE',
      E_STRICT => 'STRICT',
      4096 => 'UNKNOWN ERROR'
    );

    $L[] = microtime(true);
    $L[] = $errorType[$errno];
    $L[] = $errfile;
    $L[] = $errline;
    $L[] = $errstr.': '.Debug::dumpToString($errDump);

    $_SESSION['PHPLOG'][] = $L;

  }//end public static function errorHandler */

  /**
   * Buiz Own Error Handler
   *
   * @param int $errno
   * @param string $errstr
   * @param string $errfile
   * @param string $errline
   * @param string $errDump
   */
  public static function debugErrorHandler($errno,$errstr,$errfile,$errline,$errDump)
  {

    // jaja die Hälfte der Konstanten ist überflüssig da sie hier nie
    // erreicht werden können.
    // Ist nur der Vollständigkeithalber
    $errorType = array
    (
      // Fatale Laufzeit-Fehler. Dies zeigt Fehler an, die nicht behoben werden können.
      // Beispielsweise Probleme bei der Speicherzuweisung.
      // Die Ausführung des Skripts wird abgebrochen.
      E_ERROR => 'ERROR',

      // Warnungen (keine fatalen Fehler) zur Laufzeit des Skripts.
      // Das Skript wird nicht abgebrochen.
      E_WARNING => 'WARNING',

      // Parser-Fehler während der Übersetzung.
      // Parser-Fehler können nur vom Parser erzeugt werden.
      E_PARSE => 'PARSING ERROR',

      // Benachrichtigungen während der Laufzeit. Sie zeigen an, dass im Skript
      // irgend etwas gefunden wurde, was einen Fehler verursachen könnte.
      // Es ist aber genauso möglich, dass Benachrichtigungen im ordnungsgemäßen
      // Ablauf eines Skripts ausgegeben werden.
      E_NOTICE => 'NOTICE',

      // Fatale Fehler, die beim Starten von PHP auftreten.
      // Diese sind ähnlich wie E_ERROR, nur dass diese Fehlermeldungen vom PHP-Kern erzeugt werden
      E_CORE_ERROR => 'CORE ERROR',

      // Warnungen (keine fatalen Fehler), die beim Starten von PHP auftreten.
      // Diese sind ähnlich wie E_WARNING, nur dass diese Warnungen vom PHP-Kern erzeugt werden.
      E_CORE_WARNING => 'CORE WARNING',

      // Fatale Fehler zur Übersetzungszeit. Diese sind ähnlich wie E_ERROR,
      // nur dass diese Fehlermeldungen von der Zend Scripting Engine erzeugt werden.
      E_COMPILE_ERROR => 'COMPILE ERROR',

      // Warnungen zur Übersetzungszeit. Diese sind ähnlich wie E_WARNING,
      // nur dass diese Warnungen von der Zend Scripting Engine erzeugt werden.
      E_COMPILE_WARNING => 'COMPILE WARNING',

      // Benutzerdefinierte Fehlermeldungen. Diese sind ähnlich wie E_ERROR, nur
      // dass diese Fehlermeldungen im PHP-Code mit trigger_error() erzeugt werden.
      E_USER_ERROR => 'USER ERROR',

      // Benutzerdefinierte Warnungen. Diese sind ähnlich wie E_WARNING, nur dass
      // diese Warnungen im PHP-Code mit trigger_error() erzeugt werden.
      E_USER_WARNING => 'USER WARNING',

      // Benutzerdefinierte Benachrichtigung. Diese sind ähnlich wie E_NOTICE,
      // nur dass diese Benachrichtigungen im PHP-Code mit trigger_error() erzeugt werden.
      E_USER_NOTICE => 'USER NOTICE',

      // Benachrichtigungen des Laufzeitsystems. Damit erhalten Sie von PHP Vorschläge
      // für Änderungen des Programmcodes, die eine bestmögliche Interoperabilität und
      // zukünftige Kompatibilität Ihres Codes gewährleisten.
      E_STRICT => 'STRICT',

      // Abfangbarer fataler Fehler. Dies bedeutet das ein potentiell gefährlicher
      // Fehler aufgetreten ist, die Engine aber nicht in einem instabilen Zustand hinterlassen hat.
      // Wird der Fehler nicht durch eine benutzerdefinierte Fehlerbehandlungsroutine abgefangen
      // (siehe auch set_error_handler()) so wird die Anwendung wie bei einem E_ERROR Fehler abgebrochen.
      E_RECOVERABLE_ERROR => 'RECOVERABLE ERROR',

      // Notices zur Laufzeit des Programms. Aktivieren Sie diese Einstellung,
      // um Warnungen über Codebestandteile zu erhalten, die in zukünftigen
      // PHP-Versionen nicht mehr funktionieren werden.
      E_DEPRECATED => 'DEPRECATED',

      // Benutzererzeugte Warnmeldung. Diese entspricht E_DEPRECATED mit der Ausnahme,
      // dass sie im PHP-Code durch die Verwendung der Funktion trigger_error() generiert wurde.
      E_USER_DEPRECATED => 'USER DEPRECATED',
    );

    $time = microtime(true);

    $logString = '<div>';
    $logString .= '<p>'.$errorType[$errno].': '.$errstr.'</p>';
    $logString .= '<p>File: '.$errfile.'  Line:'.$errline.'</p>';

    ob_start();
    var_dump($errDump);
    $errDumpDump = ob_get_contents();
    ob_end_clean();
    $logString .= '<p>'.$errDumpDump.'</p>';

    $backTrace = debug_backtrace();

    $logString .= Debug::backtraceToTable($backTrace);
    $logString .= '</div>';

    if (!file_exists(PATH_GW.'log')) {
      if (!class_exists('SFilesystem'))
        include PATH_FW.'src/s/SFilesystem.php';

      SFilesystem::mkdir(PATH_GW.'log');
    }

    if (defined('WGT_ERROR_LOG'))
      $logFile = WGT_ERROR_LOG;
    else
      $logFile = 'log.html';

    SFiles::write(PATH_GW.'log/'.$logFile, $logString , 'a');

    // write the first error, easier for debugging cause of the huge amount of data
    // per error
    if (!self::$numPhpErrors) {
      SFiles::write(PATH_GW.'log/'.'first_'.$logFile, $logString , 'w');
    }

    // increase the error number
    ++self::$numPhpErrors;

    return true;

  }//end public static function debugErrorHandler */

/*////////////////////////////////////////////////////////////////////////////*/
// Bootstrap
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Das Basissystem soweit initialisieren
   * @param boolean $withSession
   * @return null
   */
  public static function initLight($withSession = false)
  {

    Debug::clean();
    Conf::init();

    if ($timezone = Session::status('activ_timezone'))
      date_default_timezone_set($timezone);
    else
      date_default_timezone_set('Etc/UCT');

    if ($withSession) {
      $session = Session::getActive();

      if ($session->wakeup) {
        if (DEBUG)
          Log::debug('wakeup');

        self::$instance->wakeup();

        if (BuizCore::classExists('BuizRoleUser_Entity')) {

          // try to login user, if user has an annonymous session
          $user = User::getActive();

          if (1 == $user->getId() || !$user->getId())
            $user->singleSignOn();
        }

      } else {
        if (DEBUG)
          Log::debug('init');

        self::$instance->init();

        if (BuizCore::classExists('BuizRoleUser_Entity')) {
          // try to sign on session start
          $user = User::getActive();
          $user->singleSignOn();
        }

      }
    }

  }//end public static function initLight */

  /**
   * Das Basissystem soweit initialisieren
   * @return LibFlowApachemod
   */
  public static function init()
  {

    Debug::clean();
    Conf::init();

    $conf = Conf::getActive();

    if ($timezone = $conf->getStatus('activ_timezone'))
      date_default_timezone_set($timezone);
    else
      date_default_timezone_set('Etc/UCT');

    if (defined('BUIZ_CONTROLLER')) {
      $flowController = 'LibFlow'.ucfirst(BUIZ_CONTROLLER);
      self::$instance = new $flowController();
      self::$env = self::$instance;

      if (DEBUG)
        Log::debug('Found BUIZ_CONTROLLER: '.BUIZ_CONTROLLER);
    } else {
      // fallback auf apache mod
      self::$instance = new LibFlowApachemod();
      self::$env = self::$instance;

      if (DEBUG)
        Log::debug('Found BUIZ_CONTROLLER: LibFlowApachemod');
    }
    
    if($conf->initClasses){
       $initClasses = $conf->initClasses; 
    } else {
        $initClasses = array(
          'Log',  // the logsystem
          'Cache',  // the caching system
          'I18n',  // the i18n text provider
          'Message',  // the message system
          'Registry',  // the main registry to manage global accessable data
          'Response',  // the Response object
          'Request',  // the http request
          'Session',  // the session object
          'User',  // the active user object
          'View',  // template enginge
        );
    }

    foreach ($initClasses as $class)
      $class::init(self::$instance); // php > 5.3

    // if no controller is defined the framework FLow Handler does not start
    // and you can implement your own Flow/MVC Whatever Logicacl ApplicationFlow
    if (defined('BUIZ_CONTROLLER')) {

      if ('Cli' == BUIZ_CONTROLLER) {
        self::$instance->init();
        return self::$instance;
      }

    }

    $session = Session::getActive();

    if ($session->wakeup) {

      if (DEBUG)
        Log::debug('wakeup');

      self::$instance->wakeup();

      if (BuizCore::classExists('BuizRoleUser_Entity')) {

        // try to login user, if user has an annonymous session
        $user = User::getActive();

        if (1 == $user->getId() || !$user->getId())
          $user->singleSignOn();
      }

    } else {
      if (DEBUG)
        Log::debug('init');

      self::$instance->init();

      if (BuizCore::classExists('BuizRoleUser_Entity')) {
        // try to sign on session start
        $user = User::getActive();
        $user->singleSignOn();
      }

    }

    // some security settings:
    // prevent xee
    libxml_disable_entity_loader(true);
    
    ///TODO fetch timezone from os (check if that works in win / mac)
    // set a timezone
    if ($timezone = Session::status('activ_timezone'))
      date_default_timezone_set($timezone);
    else
      date_default_timezone_set('Etc/UCT');

    return self::$instance;

  }//end public static function init */

  /**
   * Shoutdown des Systems
   */
  public static function shutdown()
  {

    Db::shutdown();

  }//end public static function shutdown */

  /**
   * @param string $path
   * @param boolean $subPath
   * @param boolean $srcOnly
   */
  public static function announceIncludePaths($path, $subPath = false, $srcOnly = false)
  {

    ///TODO find a solution how to add a hirachie

    if (is_dir(PATH_GW.'conf/include/'.$path)  ) {
      $dModules = opendir(PATH_GW.'conf/include/'.$path);

      if ($dModules) {
         while ($mod = readdir($dModules)) {
            if ($mod[0] == '.')
              continue;

            if ($subPath) {
              $mod = str_replace('.', '/', $mod);
            }

            //syslog(LOG_WARNING, PATH_ROOT.$mod.'/module/');

            BuizCore::$autoloadPath[] = PATH_ROOT.$mod.'/src/';
            BuizCore::$autoloadPath[] = PATH_ROOT.$mod.'/module/';

            if (!$srcOnly) {
              View::$searchPathTemplate[] = PATH_ROOT.$mod.'/templates/';
              I18n::$i18nPath[] = PATH_ROOT.$mod.'/i18n/';
              Conf::$confPath[] = PATH_ROOT.$mod.'/conf/';
            }

         }

         // close the directory
         closedir($dModules);
      }
    }

  }//end public static function announceIncludePaths
  
  /**
   *
   * @param boolean $srcOnly
   */
  public static function loadModuleByPath( $type, $srcOnly = false)
  {
  
      ///TODO find a solution how to add a hirachie
  
      if (is_dir(PATH_GW.'conf/include/'.$type)  ) {
          $dModules = opendir(PATH_GW.'conf/include/'.$type);
  
          if ($dModules) {
              while ($mod = readdir($dModules)) {
                  if ($mod[0] == '.')
                      continue;
  
                  BuizCore::$autoloadPath[] = PATH_ROOT.$mod.'/src/';
                  BuizCore::$autoloadPath[] = PATH_ROOT.$mod.'/module/';
  
                  if (!$srcOnly) {
                      //View::$searchPathTemplate[] = PATH_ROOT.$mod.'/module/';
                      View::$searchPathTemplate[] = PATH_ROOT.$mod.'/templates/';
                      I18n::$i18nPath[] = PATH_ROOT.$mod.'/i18n/';
                      Conf::$confPath[] = PATH_ROOT.$mod.'/conf/';
                  }
  
              }
  
              // close the directory
              closedir($dModules);
          }
      }
  
  }//end public static function loadModuleByPath

  /**
   *
   * @param boolean $srcOnly
   */
  public static function loadModulePath( $srcOnly = false)
  {

    ///TODO find a solution how to add a hirachie

    if (is_dir(PATH_GW.'conf/include/module')  ) {
      $dModules = opendir(PATH_GW.'conf/include/module');

      if ($dModules) {
         while ($mod = readdir($dModules)) {
            if ($mod[0] == '.')
              continue;

            BuizCore::$autoloadPath[] = PATH_ROOT.$mod.'/src/';
            BuizCore::$autoloadPath[] = PATH_ROOT.$mod.'/module/';

            if (!$srcOnly) {
            	//View::$searchPathTemplate[] = PATH_ROOT.$mod.'/module/';
              View::$searchPathTemplate[] = PATH_ROOT.$mod.'/templates/';
              I18n::$i18nPath[] = PATH_ROOT.$mod.'/i18n/';
              Conf::$confPath[] = PATH_ROOT.$mod.'/conf/';
            }

         }

         // close the directory
         closedir($dModules);
      }
    }

  }//end public static function loadModulePath
  
  /**
   *
   * @param boolean $srcOnly
   */
  public static function loadGmodPath( $srcOnly = false)
  {
  
      ///TODO find a solution how to add a hirachie
  
      if (is_dir(PATH_GW.'conf/include/gmod')  )
          $dModules = opendir(PATH_GW.'conf/include/gmod');
      else
          return;
  
      if ($dModules) {
          while ($mod = readdir($dModules)) {
              if ($mod[0] == '.')
                  continue;
  
              BuizCore::$autoloadPath[] = PATH_ROOT.$mod.'/src/';
              BuizCore::$autoloadPath[] = PATH_ROOT.$mod.'/sandbox/src/';
              BuizCore::$autoloadPath[] = PATH_ROOT.$mod.'/module/';
              BuizCore::$autoloadPath[] = PATH_ROOT.$mod.'/sandbox/module/';
  
              if (!$srcOnly) {
                  View::$searchPathTemplate[] = PATH_ROOT.$mod.'/templates/';
                  View::$searchPathTemplate[] = PATH_ROOT.$mod.'/sandbox/templates/';
  
                  I18n::$i18nPath[] = PATH_ROOT.$mod.'/i18n/';
                  I18n::$i18nPath[] = PATH_ROOT.$mod.'/sandbox/i18n/';
  
                  Conf::$confPath[] = PATH_ROOT.$mod.'/conf/';
                  Conf::$confPath[] = PATH_ROOT.$mod.'/sandbox/conf/';
              }
  
          }
  
          // close the directory
          closedir($dModules);
      }
  
  }//end public static function loadGmodPath
  
  
  /**
   *
   * @param boolean $srcOnly
   */
  public static function loadPagesPath( $srcOnly = false)
  {
  
      ///TODO find a solution how to add a hirachie
  
      if (is_dir(PATH_GW.'conf/include/pages')) {
          $dModules = opendir(PATH_GW.'conf/include/pages');
  
          if ($dModules) {
              while ($mod = readdir($dModules)) {
                  if ($mod[0] == '.')
                      continue;
  
                  BuizCore::$autoloadPath[] = PATH_ROOT.$mod.'/pages/';
  
                  if (!$srcOnly) {
                      //View::$searchPathTemplate[] = PATH_ROOT.$mod.'/module/';
                      View::$searchPathTemplate[] = PATH_ROOT.$mod.'/templates/';
                      I18n::$i18nPath[] = PATH_ROOT.$mod.'/i18n/';
                      Conf::$confPath[] = PATH_ROOT.$mod.'/conf/';
                  }
  
              }
  
              // close the directory
              closedir($dModules);
          }
      }
  
  }//end public static function loadPagesPath


  /**
   *
   * @param boolean $srcOnly
   */
  public static function getIncludePaths( $key)
  {

    ///TODO find a solution how to add a hirachie
    $includePaths = [];

    if (is_dir(PATH_GW.'conf/include/'.$key)  ) {
      $dModules = opendir(PATH_GW.'conf/include/'.$key);

      if ($dModules) {
         while ($mod = readdir($dModules)) {
            if ($mod[0] == '.')
              continue;

            $includePaths[] = trim($mod);

         }

         // close the directory
         closedir($dModules);
      }
    }

    return $includePaths;

  }//end public static function loadModulePath

/*////////////////////////////////////////////////////////////////////////////*/
// Informationen zu dem Systemstatus
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Die aktive Sprache abfragen
   *
   * @return int
   */
  public static function activLang()
  {
    return self::$instance->getActivLang();
  }//end public static function activLang */

  /**
   * Das aktive Modul erfragen
   * @return Mod
   */
  public static function activMod()
  {
    return self::$instance->getActivMod();
  }//end public static function activMod */

  /**
   * Die Aktive Extension erfragen
   * @return Mex
   */
  public static function activController()
  {
    return self::$instance->getActivMod()->getActivController();
  }//end public static function activMex */
  
  
  /**
   * @return []
   */
  public static function getRouteMap($cPath=null)
  {
      
      if(!$cPath){
          if (isset($_GET['c'])) {
              $cPath = $_GET['c'];
          } else if(isset($_POST['c'])) {
              $cPath = $_POST['c'];
          } else {
              return null;
          }
      }

      $tmp = explode('.',$cPath);
      
      if (count($tmp)==2) {
          
          $modKey = SParserString::getFirstHump($tmp[0]);
          $conKey = substr($tmp[0], strlen($modKey));
          
          $map = [
              Request::MOD => $modKey,
              Request::CON => $conKey,
              Request::RUN => $tmp[1]
          ];
      } else {
          $map = [
              Request::MOD => $tmp[0],
              Request::CON => $tmp[1],
              Request::RUN => $tmp[2]
          ];
      }
      
      return $map;
      
  }//end public static function getRouteMap */
  
  /**
   * @return string
   */
  public static function getRouteKey($cPath= null)
  {
  
      if(!$cPath){
          if (isset($_GET['c'])) {
              $cPath = $_GET['c'];
          } else if(isset($_POST['c'])) {
              $cPath = $_POST['c'];
          } else {
              return null;
          }
      }

  
      $tmp = explode('.',$cPath);
  
      if (count($tmp)==3) {
        
          return $cPath;
        
      } else if(count($tmp)==2) {
  
          // punkt einfach einbauen
          $modKey = SParserString::getFirstHump($tmp[0]);
          $conKey = substr($tmp[0], strlen($modKey));
  
          return $modKey.'.'.$conKey;
      }
  
      return null;
  
  }//end public static function getRouteKey */

  /**
   * Ok irgendwas ist total schief gegangen, daher wird einfach nur
   * noch versucht das System so gut wie möglich zu beenden
   *
   * @param string $file
   * @param int $line
   * @param string $lastMessage
   */
  public static function panikShutdown($file, $line,  $lastMessage)
  {
    self::$instance->getActivMod()->panikShutdown($file, $line, $lastMessage);
  }//end public static function panikShutdown */

  /**
   * Die Anfrage auf das Loginfenster umleiten
   */
  public static function redirectToLogin()
  {
    self::$instance->redirectToLogin();
  }//end public static function redirectToLogin */

  /**
   * using a wrapper so you can write your own unique method
   *
   * @return string
   */
  public static function uniqid($seed = null)
  {
    if($seed){
        return uniqid($seed, true);
    } else {
        return uniqid(mt_rand(), true);
    }
  }//end public static function uniqid */

  /**
   * using a wrapper so you can write your own unique method
   *
   * @return string
   */
  public static function uniqKey()
  {
    return sha1(uniqid(mt_rand(), true)) ;
  }//end public static function uniqKey */

  /**
   * The timestamp to be appended on documents
   * @return string
   */
  public static function docTimestamp()
  {
    return date('YmdHis');
  }//end public static function docTimestamp */

  /**
   * @return int
   */
  public static function startMeasure()
  {
    $time = explode(' ', microtime());

    return $time[1] + $time[0];
  }//end public static function startMeasure */

  /**
   * @param int $start
   * @return int
   */
  public static function getDuration($start)
  {
    $finish = explode(' ', microtime());
    $finish = $finish[1] + $finish[0];

    return round(($finish - $start), 4);

  }//end public static function getDuration */

  /**
   * using a wrapper so you can write your own unique method
   * @param boolean $fullPath
   * @return string
   */
  public static function tmpFolder($fullPath = false)
  {

    if ($fullPath)
      return PATH_GW.'tmp/'.str_replace('.','_', uniqid(mt_rand(), true)).'/' ;
    else
      return str_replace('.','_', uniqid(mt_rand(), true)) ;

  }//end public static function tmpFolder */

  /**
   * using a wrapper so you can write your own unique method
   *
   * @return string
   */
  public static function tmpFile()
  {
    return str_replace('.','_', uniqid(mt_rand(), true)) ;
  }//end public static function tmpFile */

  /**
   * using a wrapper so you can write your own unique method
   *
   * @return string
   */
  public static function dataPath($dataKey, $repo)
  {
      $key = md5($dataKey);
      
      return PATH_GW.'app_data/'.$repo.'/'.substr($key, 0, 5).'/'.substr($key, 5, 5).'/'.substr($key, 10).'.data';
      
  }//end public static function dataPath */
  
  /**
   * @param string $prefix
   */
  public static function uuid($prefix = '')
  {

    $tmp = md5(uniqid(mt_rand(), true));

    return $prefix .substr($tmp,0,8).'-'.substr($tmp,8,4).'-'.substr($tmp,12,4)
      .'-'.substr($tmp,16,4).'-'.substr($tmp,20,12);

  }//end public static function uuid */

  /**
   * SDBM Hash Algorithmus aus der Berkley Database
   * @param string $key
   * @return string
   * /
  public static function keyHash($key)
  {

    $mul = "65599"; // (1 << 6) + (1 << 16) - 1
    $mod = "18446744073709551616"; // 1 << 64

    $hash = "0";
    $keyLength = strlen($str);

    for ($i = 0; $i < $keyLength; ++$i) {
      $hash = bcmod(bcmul($hash, $mul), $mod);
      $hash = bcmod(bcadd($hash, ord($str[$i])), $mod);
    }

    return $hash;

  }//end public static function keyHash */

  /**
   * eine neue id aus der sequence erfragen
   *
   * @return int
   */
  public static function tmpid()
  {

    // fängt halt bei 1 an
    ++ self::$sequence;

    return 'tmp_'.self::$sequence;

  }//end public static function uniqid */

  /**
   * eine neue id aus der sequence erfragen
   *
   * @return int
   */
  public static function getRunId()
  {

    if (!self::$runkey) {
      self::$runkey = time();
    }

    return self::$runkey;

  }//end public static function getRunId */

/*////////////////////////////////////////////////////////////////////////////*/
// some content loaders, for content that can be in diffrent locations
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * request a template path for a secific key
   */
  public static function templatePath( $file , $type, $codeTemplate = false)
  {

    $key = $type.'/'.$file;

    if (isset(self::$tplIndex[$key])) {

      if (DEBUG)
        Log::debug('TEMPLATE from index: '.self::$tplIndex[$key]);

      return self::$tplIndex[$key];
    }

    if ($codeTemplate) {
      $tPath = PATH_GW.'module/'.$file.'.tpl';
    } else {
      $tPath = View::$templatePath.'/'.$key.'.tpl';
    }

    // Zuerst den Standard Pfad checken
    if (file_exists($tPath)) {
      // use realpath, its faster
      $tPath = realpath($tPath);

      self::$tplIndex[$key] = $tPath;
      self::$indexChanged = true;

      if (DEBUG)
        Log::debug('TEMPLATE: '.$tPath);

      return $tPath;
    }

    if ($codeTemplate) {

      foreach (BuizCore::$autoloadPath as $path) {

        $tmpPath = $path.'/'.$file.'.tpl';

        if (file_exists($tmpPath)) {
          if (Log::$levelDebug)
            Log::debug("found Template: ". $tmpPath);

          if (DEBUG)
            Log::debug('Found: '. $tmpPath);

          // use the realpath
          $tmpPath = realpath($tmpPath);

          self::$tplIndex[$key] = $tmpPath;
          self::$indexChanged = true;

          return $tmpPath;
        } else {

          if (Log::$levelDebug)
            Log::debug('Not found: '. $tmpPath);
        }

      }
      
    } else {
        
      foreach (View::$searchPathTemplate as $path) {

        $tmpPath = $path.'/'.$type.'/'.$file.'.tpl';

        if (file_exists($tmpPath)) {
          if (Log::$levelDebug)
            Log::debug("found Template: ". $tmpPath);

          if (DEBUG)
            Log::debug('Found: '. $tmpPath);

          // use the realpath
          $tmpPath = realpath($tmpPath);

          self::$tplIndex[$key] = $tmpPath;
          self::$indexChanged = true;

          return $tmpPath;
        } else {

          if (Log::$levelDebug)
            Log::debug('Not found: '. $tmpPath);
        }

      }
    }

    return null;

  }//end public static function templatePath */

}//end class Buiz

