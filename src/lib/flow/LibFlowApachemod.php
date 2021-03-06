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

// Sicher stellen, dass nur Cms Controller aufgerufen werden können
if (!defined('BUIZ_CONTROLLER_PREFIX'))
  define('BUIZ_CONTROLLER_PREFIX', '');

if (!defined('BUIZ_CONTROLLER_TYPE'))
    define('BUIZ_CONTROLLER_TYPE', '_Controller');

/**
 * @lang de:
 *
 * Der Supercontroller der alle anderen Controller verwaltet, den Status den
 * Kompletten Systems speichert und die Benutzereingaben verarbeite.
 * Weiter liest der Supercontroller bei Systemstart die Systemkonfiguration aus.
 *
 * @author Dominik Bonsch <dominik.bonsch@buiz.net>
 * @package net.buiz
 */
class LibFlowApachemod extends Base
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * the active module object
   * @var Module
   */
  protected $module = null;

  /**
   * name of the active module
   * @var string
   */
  protected $moduleName = null;

  /**
   * the activ controller object
   * @var Controller
   */
  protected $controller = null;

  /**
   * name of the activ controller
   * @var string
   */
  protected $controllerName = null;

  /**
   * mappertabelle for url short links
   *
   * @var array
   */
  protected $redirectMap = [];

  /**
   * List of callbacks to be executed on shutdown
   *
   * @example $flow->registerShutdownFunction( $key, $closure );
   *
   * @var array
   */
  protected $shutDownFunctions = [];

/*////////////////////////////////////////////////////////////////////////////*/
// Logic
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * check for hidden redirects in the url
   * @return void
   */
  protected function checkRedirect()
  {

    $conf = $this->getConf();

    foreach ($conf->redirect as $name => $data) {
      if (isset($_GET[$name])) {
        $_GET['c'] = $data[0];
        $_GET[$data[1]] = $_GET[$name];
        break;
      }
    }

  }//end protected function checkRedirect */

  /**
   * @param string $key
   * @param Closure $func
   */
  public function registerShutdownFunction($key, $func)
  {
    $this->shutDownFunctions[$key] = $func;
  }//end public function registerShutdownFunction */

    /**
    *
    * @return void
    */
    public function init()
    {
    
        $request = $this->getRequest();
        $response = $this->getResponse();
        $this->getSession();
        $this->getUser();
        
        $response->tpl = $this->getTplEngine();
    
        //make shure the system has language information
        if ($lang = $request->param('lang', Validator::CNAME)) {
            Conf::setStatus('lang',$lang);
            I18n::changeLang($lang  );
        }
        
        if (defined('MODE_MAINTENANCE')) {
            $map = array(
                Request::MOD => 'Maintenance',
                Request::CON => 'Base',
                Request::RUN => 'message'
            );
            $request->addParam($map);
            
            return;
        }
    
        $this->checkRedirect();
    
        
        if ($map = Buizcore::getRouteMap()) {
            $request->addParam($map);
        }
        
        
    
    }//end  public function init */

 /**
  *
  * @return void
  */
  public function wakeup()
  {

    $request = $this->getRequest();
    $response = $this->getResponse();
    $session = $this->getSession();
    $this->getUser();

    $response->tpl = $this->getTplEngine();

    //make shure the system has language information
    if ($lang = $request->param('lang', Validator::CNAME  )) {
      $session->setStatus('activ_lang' , $lang);
      I18n::changeLang($session->getStatus['activ_lang']);
    }

    /*
    if (defined('MODE_MAINTENANCE')) {
      $map = array(
        Request::MOD => 'Maintenance',
        Request::CON => 'Base',
        Request::RUN => 'message'
      );
      $request->addParam($map);

      return;
    }*/

    $this->checkRedirect();

    if ($command = $request->param('c', Validator::TEXT  )) {
        $map = Buizcore::getRouteMap($command);
        
        if ($map) {
            $request->addParam($map);
        }
    } elseif ($command = $request->data('c', Validator::TEXT)) {
        $map = Buizcore::getRouteMap($command);
        
        if ($map) {
            $request->addParam($map);
        }
    }

    Log::trace('$_GET' , $_GET);

  }//end  public function wakeup */

  /**
  * the main method
  * @param LibRequestPhp $httpRequest
  * @param LibSessionPhp $session
  * @param Transaction $transaction
  * @return boolean
  */
  public function main($httpRequest = null, $session = null, $transaction = null)
  {

    // get the info from where main was called
    if (DEBUG)
      Debug::console('Called MAIN flow', null, true);

    // Startseiten Eintrag ins Navmenu
    $view = $this->getView();

    if (!$session)
      $session = $this->session;

    if (!$httpRequest)
      $httpRequest = $this->request;

    if (!$transaction)
      $transaction = $this->transaction;

    $user = $this->getUser();

    if (!$sysClass = $httpRequest->param(Request::MOD, Validator::CNAME)) {

      if (!$user->getLogedIn()) {
        $tmp = explode('.',$session->getStatus('tripple_annon'));
        $map = array(
          Request::MOD => $tmp[0],
          Request::CON => $tmp[1],
          Request::RUN => $tmp[2]
        );
        $httpRequest->addParam($map);

        $sysClass = $tmp[0];

      } else {
        $tmp = explode('.',$session->getStatus('tripple_user'));
        $map = array(
          Request::MOD => $tmp[0],
          Request::CON => $tmp[1],
          Request::RUN => $tmp[2]
        );
        $httpRequest->addParam($map);

        $sysClass = $tmp[0];
      }
    }//end if (!$sysClass = $httpRequest->param(Request::MOD,'Cname'))

    $modName = ucfirst($sysClass);
    $className = $modName.'_Module';


    if (BuizCore::classExists($className)) {
        
      Log::debug('$module',$className);
      
      $this->module = new $className($this);
      $this->module->init();
      $this->module->main();

    } else {
        
      $this->runController(
        $modName,
        ucfirst($httpRequest->param(Request::CON , Validator::CNAME))
      );
      
    }


  } // end public function main */

  /**
   *
   * @param Module $module
   * @param Controller $controller
   */
  public function runController($module , $controller  )
  {

    $request = $this->getRequest();

    try {

      $classname = $module.$controller.BUIZ_CONTROLLER_PREFIX.BUIZ_CONTROLLER_TYPE;

      if (BuizCore::classExists($classname)) {
        $this->controller = new $classname($this);
        if (method_exists($this->controller, 'setDefaultModel'))
          $this->controller->setDefaultModel($module.$controller);
        $this->controllerName = $classname;

        $action = $request->param(Request::RUN, Validator::CNAME);

        // Initialisieren der Extention
        if (!$this->controller->initController())
          throw new BuizSys_Exception('Failed to initialize Controller');

        // Run the mainpart
        $this->controller->run($action  );

        // shout down the extension iff the controller was not reset by a failed redirect
        if ($this->controller)
          $this->controller->shutdownController();

      } else {

        throw new BuizUser_Exception('Resource '.$classname.' not exists!');
      }

    } catch (Exception $exc) {

      Error::report(
        I18n::s(
          'Module Error: {@message@}',
          'wbf.message' ,
          array('message' => $exc->getMessage())
        ),
        $exc
      );

      // if the controller ist not loadable set an error controller
      $classname = 'Error'.BUIZ_CONTROLLER_PREFIX.BUIZ_CONTROLLER_TYPE;
      $this->controller = new $classname($this);
      $this->controllerName = $classname;
      //\Reset The Extention

      if (Log::$levelDebug) {
        $this->controller->displayError('displayException' , array($exc));
      } else {
        $this->controller->displayError('displayEnduserError' , array($exc));
      }//end else

    }//end catch(Exception $exc)

  }//end public function runController */

  /**
   * Write the content in the output stream
   */
  public function out()
  {

    if (View::$published)
      throw new Buiz_Exception("Allready published!!");

    View::$published = true;

    //$this->response->compile();

    if (BUFFER_OUTPUT) {
        
        $errors = ob_get_contents();
        ob_end_clean();
        $this->response->publish(); //tell the view to publish the data
        ob_start();
        return $errors;
      
    } else {

        $this->response->publish(); //tell the view to publish the data
        return null;
    }

  }//end public function out */

  /**
   * @param string $errorKey
   * @param string $data
   */
  public function httpError($errorKey , $data = null)
  {

    $tplEngine = $this->getTpl();

    $errorClass = 'LibHttpError'.$errorKey;

    if (!BuizCore::classExists($errorClass))
      $errorClass = 'LibHttpError500';

    $error = new $errorClass($data);
    $error->publish($tplEngine);

    $tplEngine->compile();

    if (BUFFER_OUTPUT) {
      $errors = ob_get_contents();

      ob_end_clean();
      $tplEngine->publish(); //tell the view to publish the data
      ob_start();

      return $errors;
    }

    $tplEngine->publish(); //tell the view to publish the data

  }//end public function out */

  /**
   * Sauberes beenden des Requests
   */
  public function shutdown()
  {

    if (Log::$levelDebug)
      Debug::publishDebugdata();

    if (Session::$session->getStatus('logout')) {
      Log::info(
        'User logged of from system'
      );

      Session::destroy();
    }

    if ($this->shutDownFunctions) {
      foreach ($this->shutDownFunctions as $shutFunc) {
        // execute the shutdown function
        $shutFunc($this);
      }
    }

    Session::close();
    Db::shutdown();
    BuizCore::saveClassIndex();
    I18n::writeCache();

  }//end public function shutdown */

 /**
  * Funktion zum beenden von Buiz falls ein Fataler Fehler auftritt der das
  * Ausführen von Buiz verhindert
  *
  * @param string $file
  * @param int $line
  * @param string $lastMessage
  * @return array
  */
  public function panikShutdown($file, $line,  $lastMessage)
  {

    Log::fatal(
      'System got killed: '.$file.' Linie: '.$line .' reason: '.$lastMessage
    );

    $messages = ob_get_contents();
      ob_end_clean();

    echo '<h1>Fatal Error, System died :-((</h1>';

    if (Log::$levelDebug)
      echo $messages;

    echo '<p>'.$lastMessage.'</p>';
    session_destroy();
    exit();

  } // end public function panikShutdown */

/*////////////////////////////////////////////////////////////////////////////*/
// System Status
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * methode for an intern redirect throw chaching the states an recall the main
   * function
   *
   * @var array|string $target
   * @var LibRequestHttp $request
   * @var boolean $forceLogedin
   * @return void
   */
  public function redirect($target, $request = null, $forceLogedin = true  )
  {

    if ($request) {
      $this->request = $request;
      BuizCore::$env->setRequest($request);
    } else {
      $request = $this->getRequest();
    }

    if ($this->controller)
      $this->controller->shutdownController();

    $this->module = null;
    $this->moduleName = null;
    $this->controller = null;
    $this->controllerName = null;

    if (is_array($target)) {

      // wenn login benötigt, aber nicht vorhanden umleiten auf die loginseite
      if (!$forceLogedin || $this->user->getLogedin()  ) {
        $map = $target;
      } else {
        $tmp = explode('.', $this->session->getStatus('tripple_login'));

        $map = array(
          Request::MOD => $tmp[0],
          Request::CON => $tmp[1],
          Request::RUN => $tmp[2]
        );
      }

    } else {

      if (!$forceLogedin || $this->user->getLogedin()  )
        $tmp = explode('.', $target);
      else
        $tmp = explode('.', $this->session->getStatus('tripple_login'));

      $map = array
      (
        Request::MOD => $tmp[0],
        Request::CON => $tmp[1],
        Request::RUN => $tmp[2]
      );

    }

    $request->addParam($map);

    $this->main();

  }//end public function redirect */

  /**
   * methode for an intern redirect throw chaching the states an recall the main
   * function
   *
   * @var LibRequestHttp $request
   * @var boolean $forceLogedin
   * @return void
   */
  public function redirectByRequest($request, $viewType, $forceLogedin = true  )
  {

    // erneuern des environments
    $this->request = $request;
    BuizCore::$env->setRequest($request);

    // shutdown actual controller
    $this->controller->shutdownController();

    $this->module = null;
    $this->moduleName = null;
    $this->controller = null;
    $this->controllerName = null;

    View::rebase(SFormatStrings::subToCamelCase($viewType));

    if ($forceLogedin && !$this->user->getLogedin()  ) {
      $loginTripple = $this->session->getStatus('tripple_login');
      $tmp = explode('.', $loginTripple);
      $map = array(
        'c' => $loginTripple,
        Request::MOD => $tmp[0],
        Request::CON => $tmp[1],
        Request::RUN => $tmp[2]
      );
      $request->addParam($map);
    }

    $this->main();

  }//end public function redirectByRequest */

  /**
   * methode for an intern redirect to the start page
   *
   * @return void
   */
  public function redirectToDefault()
  {

    $conf = $this->getConf();
    $user = $this->getUser();

    if ($user->getLogedin()  ) {

      $profile = $user->getProfileName();

      if ($status = $conf->getStatus('default.action.profile_'.$profile)  ) {
        $tmp = explode('.',$status);
      } elseif ($status = $conf->getStatus('tripple_user')) {
        $status = $conf->getStatus('tripple_user');
        $tmp = explode('.',$status);
      } else {
        $status = 'Buiz.Desktop.display';
        $tmp = explode('.',$status);
      }

    } else {

      if ($status = $conf->getStatus('tripple_annon')) {
        $tmp = explode('.', $conf->getStatus('tripple_annon'));
      } else {
        $status = 'Buiz.Auth.form';
        $tmp = explode('.',$status);
      }

    }

    if (3 != count($tmp)) {
      Debug::console('tried to forward to an invalid status '.$status);

      return;
    }

    $map = array(
      Request::MOD => $tmp[0],
      Request::CON => $tmp[1],
      Request::RUN => $tmp[2]
    );
    $this->redirect($map);

  }//end public function redirectToDefault */

  /**
   * methode for an intern redirect to the start page
   *
   * @return void
   */
  public function redirectByKey($key , $forceLogedin = true)
  {

    if (!$forceLogedin || $this->user->getLogedin()  )
      $tmp = explode('.',$this->session->getStatus($key));
    else
      $tmp = explode('.',$this->session->getStatus('tripple_login'));

    $map = array
    (
      Request::MOD => $tmp[0],
      Request::CON => $tmp[1],
      Request::RUN => $tmp[2]
    );
    $this->redirect($map);

  }//end public function redirectByKey */

  /**
   * methode for an intern redirect to the start page
   *
   * @return void
   */
  public function redirectByTripple($key , $forceLogedin = true)
  {

    if (!$forceLogedin || $this->user->getLogedin()  )
      $tmp = explode('.',$key);
    else
      $tmp = explode('.',$this->session->getStatus('tripple_login'));

    $map = array
    (
      Request::MOD => $tmp[0],
      Request::CON => $tmp[1],
      Request::RUN => $tmp[2]
    );
    $this->redirect($map);

  }//end public function redirectByTripple */

  /**
   * method for intern redirect to the loginpage
   * @return void
   */
  public function redirectToLogin()
  {

    $tmp = explode('.', $this->session->getStatus('tripple_login'));
    $map = array
    (
      Request::MOD=> $tmp[0],
      Request::CON => $tmp[1],
      Request::RUN => $tmp[2]
    );
    $this->request->addParam($map);

    if ('ajax' == $this->request->param('rqt', Validator::CNAME)) {
      $tmp = explode('.', $this->session->getStatus('tripple_login'));
      //$this->tplEngine->setStatus(401);
      $this->tpl->redirectUrl = 'index.php?mod='.$tmp[0].'&amp;mex='.$tmp[1].'&amp;do='.$tmp[2];
    }

    $this->main();

  }//end public function redirectToLogin */

  /**
   * @lang de:
   * Das aktuive module objekt anfragen
   *
   * @return Module
   */
  public function getActivMod()
  {
    return $this->module;
  }//end public function getActivMod */

}//end class LibFlowApachemod

