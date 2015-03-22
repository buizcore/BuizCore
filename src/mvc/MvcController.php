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

/**
 * class Controller
 * Extention zum verwalten und erstellen von neuen Menus in der Applikation
 * @package net.buiz
 *
 * @statefull
 */
abstract class MvcController extends BaseChild
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var string the default Action
   */
  protected $activAction = null;

  /**
   * sub Modul Extention
   * @var array
   */
  protected $models = [];

  /**
   * Flag ob der Controller schon initialisiert wurde, und damit einsatzbereit
   * ist zum handeln von requests
   *
   * @var boolean
   */
  protected $initialized = false;

  /**
   * Liste der Services welche über diesen Controller angeboten werden.
   *
   * Listet für jeden Service die HTTP Methoden die Valide sind, sowie
   * die Attribute und Datenfelder welcher akzeptiert werden
   *
   * Kann zu XML oder Json Serialisiert werden
   *
   * Klappt nicht?
   * Häufige Fehler / Fehlerquellen:
   *  - eintrag nicht lowercase
   *  - Buchstabendreher
   *  - methode ist nicht public und kann deshalb nicht aufgerufen werden
   *  - call tripple enthält weniger als genau 3 werte
   *  - beim aufruf das c= vor dem tripple vergessen
   *  - ? anstelle von & als url trenner
   *
   * @example
   * protected $options = array
   * (
   *   'helloworld' => array
   *   (
   *     'method' => array('GET', 'POST'),
   *     'interface' => array
   *     (
   *        'GET' => array
   *       (
   *         'param' => array
   *          (
   *           'name' => array('type' => 'string', 'semantic' => 'The Name of the Whatever', 'required' => true, 'default' => 'true'),
   *          ),
   *       )
   *       'POST' => array
   *       (
   *          'param' => array
   *          (
   *
   *          ),
   *          'data' => array
   *          (
   *
   *         )
   *       )
   *     ),
   *     'views' => array
   *     (
   *       'maintab',
   *       'window'
   *     ),
   *     'access' => 'auth_required',
   *     'description' => 'Hello World Method'
   *     'docref' => 'some_link',
   *     'author' => 'author <author@mail.addr>'
   *   )
   *);
   *
   * @var array
   */
  protected $options = [];

  /**
   * makte the public Access whitelist to a blacklist
   * de:
   * {
   *   Wenn flipPublicAccess auf true gesetzt wird, wird der array in
   *   Controller::$publicAccess als Blacklist anstelle als Whitelist verwendet
   *   Methoden die gelistet werde können dann nur von Authentifizierten Benutzer
   *   gecalled werden
   * }
   * @var boolean
   */
  protected $flipPublicAccess = false;

  /**
   * ignore accesslist everything is free accessable
   * de:
   * {
   *   Wird fullAccess auf true gesetzt werden alle alle einträge in publicAccess
   *   komplett ignoriert, alle Methoden sind dann ohne Authentifizierung callbar
   *   gecalled werden
   * }
   * @var boolean
   */
  protected $fullAccess = false;

/*////////////////////////////////////////////////////////////////////////////*/
// deprecated attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @var string
   * @deprecated
   * @todo prüfen ob das ding problemlos gelöscht werden kann
   */
  public $listMethod = null;

/*////////////////////////////////////////////////////////////////////////////*/
// Constructor and other Magics
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param Base $env
   */
  public function __construct($env = null)
  {

    if (!$env)
      $env = BuizCore::getActive();

    $this->env = $env;

    if (DEBUG)
      Debug::console('Load Controller '.get_class($this));

  }//end public function __construct */

  /**
   * default constructor
   */
  public function __destruct()
  {
    $this->initialized = false;
  } // end public function __destruct */

/*////////////////////////////////////////////////////////////////////////////*/
// Getter, Setter and Adder Methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /** request the actually activ Action
   * @return string
   */
  public function getActivAction()
  {
    return $this->activAction ;
  }//end public function getActivAction */

/*////////////////////////////////////////////////////////////////////////////*/
// load methodes for loading resources
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Eine Modelklasse laden
   *
   * @param string $modelKey
   * @param string $key
   * @param array $injectKeys
   *
   * @return Model
   * @throws Controller_Exception wenn das angefragt Modell nicht existiert
   */
  public function loadModel($modelKey, $key = null, $injectKeys = [])
  {

    if (is_array($key))
      $injectKeys = $key;

    if (!$key || is_array($key))
      $key = $modelKey;

    $modelName = $modelKey.'_Model';

    if (!isset($this->models[$key]  )) {
      if (BuizCore::classExists($modelName)) {
        $model = new $modelName($this);
        
        foreach ($injectKeys as $injectKey) {
            $model->{"set".$injectKey}($this->{"get".$injectKey}());
        }
        
        $this->models[$key] = $model;
      } else {
        throw new Mvc_Exception(
          'Internal Error',
          'Failed to load Submodul: '.$modelName
        );
      }
    }

    return $this->models[$key];

  }//end public function loadModel */

  /**
   * de:
   * {
   *  @getter Model
   * }
   * @param $key
   * @return Model
   */
  public function getModel($key)
  {

    if (isset($this->models[$key]))
      return $this->models[$key];
    else
      return null;

  }//public function getModel */

  /**
   *
   * @return LibFlow
   */
  public function getFlowController()
  {
    return BuizCore::getActive();

  }//public function getFlowController */

/*////////////////////////////////////////////////////////////////////////////*/
// Logic
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Den Aufruf an einen Subcontroller weiterrouten
   *
   * @param string $conKey
   * @param string do
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   *
   * @throws Buiz_Exception
   */
  public function routeToSubcontroller($conKey, $do, $request, $response)
  {

    try {

      $className = $conKey.'_Controller';

      if (!BuizCore::classExists($className)) {
        throw new InvalidRoute_Exception($className);
      }

      $controller = new $className();

      // Initialisieren der Extention
      if (!$controller->initController())
        throw new Buiz_Exception('Failed to initialize Controller');

      // Run the mainpart
      $controller->run($do);

      // shout down the extension
      $controller->shutdownController();

    } catch (Exception $exc) {

      Error::report(
        $response->i18n->l(
          'Module Error: {@message@}',
          'wbf.message' ,
          array(
            'message' => $exc->getMessage()
          )
        ),
        $exc
      );

      $type = get_class($exc);

      if (Log::$levelDebug) {
        // Create a Error Page
        $this->errorPage(
          $exc->getMessage(),
          Response::INTERNAL_ERROR,
          '<pre>'.Debug::dumpToString($exc).'</pre>'
        );

      } else {
        switch ($type) {
          case 'Security_Exception': {
            $this->errorPage(
              $response->i18n->l('Access Denied', 'wbf.message'  ),
              Response::FORBIDDEN
            );
            break;
          }
          default: {

            if (Log::$levelDebug) {
              $this->errorPage(
                'Exception '.$type.' not catched ',
                Response::INTERNAL_ERROR,
                Debug::dumpToString($exc)
              );
            } else {
              $this->errorPage(
                $response->i18n->l( 'Sorry Internal Error', 'wbf.message'  ),
                Response::INTERNAL_ERROR
              );
            }

            break;

          }//end efault:

        }//end switch($type)

      }//end else

    }//end catch

  }//end public function routeToSubcontroller */

  /**
   * die vom request angeforderte methode auf rufen
   * @param string $action
   */
  public function run($action = null)
  {

    if (!$this->checkAction($action))
      return;

    $this->runIfCallable($action);

  }//end public function run */

  /**
   * @param string $methodeName
   */
  public function runIfCallable($methodeKey  )
  {

    $request = $this->getRequest();
    $response = $this->getResponse();

    $methodeKey = strtolower($methodeKey);
    $methodeName = 'service_'.$methodeKey;

     if (method_exists($this, $methodeName)) {

       try {

         // prüfen der options soweit vorhanden
         if (isset($this->options[$methodeKey])) {

           // prüfen ob die HTTP Methode überhaupt zulässig ist
           if (
             isset($this->options[$methodeKey]['method'])
               && !$request->method($this->options[$methodeKey]['method'])
           ) {
            throw new InvalidRequest_Exception(
              $response->i18n->l(
                'The request method {@method@} is not allowed for this action! Use {@use@}.',
                'wbf.message',
                array(
                  'method' => $request->method(),
                  'use' => implode(' or ', $this->options[$methodeKey]['method'])
                )
              ),
              Request::METHOD_NOT_ALLOWED
            );

           }

           if(
             isset($this->options[$methodeKey]['views'])
               && !$response->tpl->isType($this->options[$methodeKey]['views'])
           ) {

             throw new InvalidRequest_Exception(
               $response->i18n->l(
                 'Invalid format type {@type@}, valid types are: {@use@}',
                 'wbf.message',
                 array(
                   'type' => $response->tpl->getType(),
                   'use' => implode(' or ', $this->options[$methodeKey]['views'])
                 )
               ),
               Request::NOT_ACCEPTABLE
             );

           }

         }

         $error = $this->$methodeName($request, $response  );

         if ($error && is_object($error)) {
           $this->errorPage($error);
         }

       } catch (Buiz_Exception $error) {
           
         $this->errorPage($error);
       } catch (Exception $error) {
         
         $this->errorPage(
           $error->getMessage(),
           Response::INTERNAL_ERROR
         );
       }

       return;

     } else {
         
       if (DEBUG) {
         Debug::console($methodeName.' is not callable!' ,  array_keys($this->options));

        $tmpMethodes = get_class_methods($this);
        $methodes = [];
        
        foreach ($tmpMethodes as $method) {
            if('service_'== substr($method, 0, 8)){
                $methodes[] = $method;
            }
        }
         
         
         $methodes = implode(', ', $methodes);
         $response->addError(
           'The action :'.$methodeName .' is not callable on service: '.get_class($this).' methode: '.$methodes.'!'
         );

         $this->errorPage(
            'The action :'.$methodeName .' is not callable on service: '.get_class($this).' methode: '.$methodes.'!',
            Response::NOT_FOUND
         );
         
       } else {
         
         $response->addError('The action :'.$methodeName .' is not callable on service: '.get_class($this).' !');
         $this->errorPage(
            'The action :'.$methodeName .' is not callable on service: '.get_class($this).' !',
            Response::NOT_FOUND
         );
       }

       return;
     }

  }//end public function runIfCallable */

  /**
   * run a method if it exists
   *
   * @param string $methodeName
   * @param LibTemplateView $view
   *
   * @return void
   */
  public function runIfExists($methodeName , $view = null)
  {

    if (method_exists($this , $methodeName  )) {
      if ($view)
        $this->$methodeName($view);

      else
        $this->$methodeName();

      return true;
    } else {
      return false;
    }

  } // end public function runIfExists */

  /**
   * @param string $action
   * @return void
   */
  protected function checkAction($action)
  {

    $action = strtolower($action);
    $this->activAction = $action;

    if ($this->fullAccess)
      return true;

    $user = $this->getUser();
    if ($user->getLogedIn())
      return true;

    // prüfen mit den options
    if (isset($this->options[$action]['public'])  ) {

      if ($this->options[$action]['public']) {
        return true;
      } elseif ($this->login()  ) {
        return true;
      }

      // wenn false fällt der code direkt zum login redirect
    } elseif ($this->login()  ) {
      return true;
    }

    BuizCore::getActive()->redirectToLogin();

    return false;

  }//end protected function checkAction */

  /**
   * Function for reinitializing after wakeup. Is Neccesary caus we can't use
   * the normal __wakeup function without getting race conditions
   * @param array $data
   * @return boolean
   */
  public function initController($data = [])
  {

    if ($this->initialized)
      return true;

    $this->initialized = true;

    foreach ($data as $name => $value)
      $this->$name = $value;

    // View und Request und User werden immer benötigt
    // alle anderen sind optional

    $this->getRequest();

    $response = $this->getResponse();
    $response->setMessage($this->getMessage());
    $response->setI18n($this->getI18n());

    if (!defined('WBF_NO_VIEW')) {
        $tpl =  $this->getTplEngine();
        $response->setTplEngine($tpl);
        
        $tpl->setI18n($this->getI18n());
        $tpl->setUser($this->getUser());
        $tpl->setMessage($this->getMessage());
        $tpl->setAcl($this->getAcl());
        
        $this->setView($tpl);
    }


    $this->init();

    return true;

  } // end public function initController */

  /**
   * methode for shutting down extention, we use this instead of __sleep
   *
   * @return void
   */
  public function shutdownController()
  {
    $this->shutDown();
  } // end public function shutdownController */

/*////////////////////////////////////////////////////////////////////////////*/
// Controler Logic
/*////////////////////////////////////////////////////////////////////////////*/


/*////////////////////////////////////////////////////////////////////////////*/
// Methodes to overwrite
/*////////////////////////////////////////////////////////////////////////////*/
  
  
  /**
   * Trigger the custom init method of this controller
   */
  public function init() { return true; }

  /**
   * Overwrite if needed
   * use this instead of destructor
   */
  public function shutDown() {}


/*////////////////////////////////////////////////////////////////////////////*/
// error page and messages
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * de:
   * {
   *   Standard
   * }
   *
   * @param string $message
   * @param string $errorCode
   * @param mixed $dump
   *
   * @return void
   */
  public function errorPage($message, $errorCode = Response::INTERNAL_ERROR, $dump = null)
  {

    if (is_string($message)) {
      $error = new Error($message, $message, $errorCode, $dump );
    } else {
      $error = $message;
    }
    
    $errorHandler = new LibFlowErrorHandler($this);
    $errorHandler->handleError($this->getRequest(), $this->getResponse(), $error);

  }//end public function errorPage */


  /**
   * @todo auslagern in eine eigene klasse
   */
  public function login()
  {

    $request = $this->getRequest();
    $orm = $this->getOrm();
    
    if(!$orm){
        throw new InternalError_Exception("It's not possible to login when no default database connection is defined.");
    }

    $loggedIn = false;
    if ($request->serverExists('PHP_AUTH_USER')) {

        $auth = new LibAuth($this, 'Httpauth');
        $response = $this->getResponse();
        $loggedIn = $auth->login();
    }
    
    if(!$loggedIn){
        
        if (!$request->method(Request::POST))
          return false;
        
        $auth = new LibAuth($this, 'Httppost');
        $loggedIn = $auth->login();
    }

    if ($loggedIn) {

      $user = $this->getUser();
      $user->setDb($this->getDb());

      $userName = $auth->getUsername();

      try {

        $authRole = $orm->get('BuizRoleUser', "lower(name) = lower('{$userName}')");
        
        if (!$authRole) {
          $response->addError('User '.$userName.' not exists ');
          return false;
        }
      } catch (LibDb_Exception $exc) {

        $response->addError('Error in the query to fetch the data for user: '.$userName);
        return false;
      }

      if (
        defined('WBF_AUTH_TYPE')
          && 2 == WBF_AUTH_TYPE && ($userName != 'admin')
          && !$authRole->non_cert_login
      ) {
        $response->addError(
          'Login Via Password is not permitted, you need a valid X509 SSO Certificate'
        );

        return false;
      }

      if ($user->login($authRole)) {

        return true;
      } else {

        $response->addError('Failed to autologin User: '.$auth->getUsername());
        return false;
      }

    } else {
      return false;
    }

  }//end public function login */
  
  
  /**
   * get the form flags for this management
   * de:
   * {
   *   prüfen ob die standard steuer flags vorhanden sind
   * }
   * @param LibRequestHttp $request
   * @return TFlag
   */
  protected function interpretDefRqt($request)
  {
  
    return new ContextDefault($request);
  
  }//end protected function interpretDefRqt */

  /**
   * get the form flags for this management
   * de:
   * {
   *   prüfen ob die standard steuer flags vorhanden sind
   * }
   * @param LibRequestHttp $request
   * @return TFlag
   */
  protected function getFlags($request)
  {

    return new ContextDefault($request);

  }//end protected function getFlags */

  /**
   * @param LibRequest $request
   * @return ContextCrud
   */
  protected function getCrudFlags($request)
  {

    return new ContextCrud($request);

  } //end protected function getCrudFlags */


} // end abstract class MvcController

