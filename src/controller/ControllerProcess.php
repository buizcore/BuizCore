<?php

/*******************************************************************************
 *
 * @author      : Dominik Bonsch <dominik.bonsch@buiz.net>
 * @date        :
 * @copyright   : Buiz Developer Network <contact@buiz.net>
 * @project     : Buiz Web Frame Application
 * @projectUrl  : http://buiz.net
 *
 * @licence     : BSD License see: LICENCE/BSD Licence.txt
 *
 * @version: @package_version@  Revision: @package_revision@
 *
 * Changes:
 *
 *******************************************************************************/

/**
 *
 * @package net.buiz
 * @author dominik alexander bonsch <dominik.bonsch@buiz.net>
 *
 */
class ControllerProcess extends Controller
{

  /**
   * Eine Modelklasse laden
   *
   * @return Model
   * @throws Controller_Exception wenn das angefragt Modell nicht existiert
   */
  public function loadModel ($modelKey, $key = null, $injectKeys = [])
  {

    if (is_array($key))
      $injectKeys = $key;

    if (! $key || is_array($key))
      $key = $modelKey;

    $modelName = $modelKey . '_Model';

    if (! isset($this->models[$key])) {
      if (BuizCore::classExists($modelName)) {

        $model = new $modelName($this);

        foreach ($injectKeys as $injectKey) {
          $model->{"set" . $injectKey}($this->{"get" . $injectKey}());
        }

        $this->models[$key] = $model;
      } else {
        throw new Controller_Exception('Internal Error', 'Failed to load Submodul: ' . $modelName);
      }
    }

    return $this->models[$key];

  } //end public function loadModel */

 

  /**
   * @param TFlag $params
   * @return TFlag
   */
  protected function getCrudFlags ($request)
  {

    $request = $this->getRequest();

    // create named parameters object
    $params = new TFlag();

    // the publish type, like selectbox, tree, table..
    if ($publish = $request->param('publish', Validator::CNAME))
      $params->publish = $publish;

   // listing type
    if ($ltype = $request->param('ltype', Validator::CNAME))
      $params->ltype = $ltype;

   // context
    if ($context = $request->param('context', Validator::CNAME))
      $params->context = $context;

   // if of the target element, can be a table, a tree or whatever
    if ($targetId = $request->param('target_id', Validator::CKEY))
      $params->targetId = $targetId;

   // callback for a target function in thr browser
    if ($target = $request->param('target', Validator::CNAME))
      $params->target = $target;

   // mask key
    if ($mask = $request->param('target_mask', Validator::CNAME))
      $params->targetMask = $mask;

   // mask key
    if ($viewType = $request->param('view', Validator::CNAME))
      $params->viewType = $viewType;

   // mask key
    if ($viewId = $request->param('view_id', Validator::CKEY))
      $params->viewId = $viewId;

   // soll die maske neu geladen werden?
    if ($reload = $request->param('reload', Validator::BOOLEAN))
      $params->reload = $reload;

   // refid
    if ($refid = $request->param('refid', Validator::INT))
      $params->refId = $refid;

   // startpunkt des pfades für die acls
    if ($aclRoot = $request->param('a_root', Validator::CKEY))
      $params->aclRoot = $aclRoot;

   // die maske des root startpunktes
    if ($maskRoot = $request->param('m_root', Validator::TEXT))
      $params->maskRoot = $maskRoot;

   // die id des Datensatzes von dem aus der Pfad gestartet wurde
    if ($aclRootId = $request->param('a_root_id', Validator::INT))
      $params->aclRootId = $aclRootId;

   // der key des knotens auf dem wir uns im pfad gerade befinden
    if ($aclKey = $request->param('a_key', Validator::CKEY))
      $params->aclKey = $aclKey;

   // an welchem punkt des pfades befinden wir uns?
    if ($aclLevel = $request->param('a_level', Validator::INT))
      $params->aclLevel = $aclLevel;

   // der neue knoten
    if ($aclNode = $request->param('a_node', Validator::CKEY))
      $params->aclNode = $aclNode;

   // per default
    $params->categories = [];

    return $params;

  } //end protected function getCrudFlags */

 


} // end class ControllerProcess
