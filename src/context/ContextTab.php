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
 *
 *
 * @author dominik alexander bonsch <dominik.bonsch@buiz.net>
 * @package net.buiz
 *
 */
class ContextTab extends Context
{

  /**
   * @var array
   */
  public $order = [];

  /**
   * Interpret the Userinput Flags
   *
   * @param LibRequestHttp $request
   */
  public function interpretRequest($request)
  {

    // per default
    $this->categories = [];

    // listing type
    if ($ltype = $request->param('ltype', Validator::CNAME))
      $this->ltype = $ltype;

    // context type
    if ($context = $request->param('context', Validator::CNAME))
      $this->context = $context;

      // start position of the query and size of the table
    $this->offset = $request->param('offset', Validator::INT);

    // start position of the query and size of the table
    $this->start = $request->param('start', Validator::INT);

    if ($this->offset) {
      if (!$this->start)
        $this->start = $this->offset;
    }

    // stepsite for query (limit) and the table
    if (!$this->qsize = $request->param('qsize', Validator::INT))
      $this->qsize = Wgt::$defListSize;

    // order for the multi display element
    $this->order = $request->param('order', Validator::CNAME);

    // target for a callback function
    $this->target = $request->param('target', Validator::CKEY  );

    // target for some ui element
    $this->targetId = $request->param('target_id', Validator::CKEY  );

    // target for some ui element
    $this->tabId = $request->param('tabid', Validator::CKEY  );

    // flag for beginning seach filter
    if ($text = $request->param('begin', Validator::TEXT  )) {
      // whatever is comming... take the first char
      $this->begin = $text[0];
    }

    $this->refIds = $request->paramList('refids', Validator::INT  );

    $this->dynFilters = $request->param('dynfilter', Validator::TEXT);

    // exclude whatever
    $this->exclude = $request->param('exclude', Validator::CKEY  );

    // the activ id, mostly needed in exlude calls
    $this->objid = $request->param('objid', Validator::EID  );

     // mask key
    if ($viewId = $request->param('view_id', Validator::CKEY))
      $this->viewId = $viewId;

    // parent mask
    if ($parentMask = $request->param('pmsk', Validator::TEXT))
      $this->parentMask = $parentMask;

    // startpunkt des pfades für die acls
    if ($aclRoot = $request->param('a_root', Validator::CKEY))
      $this->aclRoot = $aclRoot;

    // die maske des root startpunktes
    if ($maskRoot = $request->param('m_root', Validator::TEXT))
      $this->maskRoot = $maskRoot;

    // die id des Datensatzes von dem aus der Pfad gestartet wurde
    if ($aclRootId = $request->param('a_root_id', Validator::INT))
      $this->aclRootId = $aclRootId;

    // der key des knotens auf dem wir uns im pfad gerade befinden
    if ($aclKey = $request->param('a_key', Validator::CKEY))
      $this->aclKey = $aclKey;

    // an welchem punkt des pfades befinden wir uns?
    if ($aclLevel = $request->param('a_level', Validator::INT))
      $this->aclLevel = $aclLevel;

    // der neue knoten
    if ($aclNode = $request->param('a_node', Validator::CKEY))
      $this->aclNode = $aclNode;

  }//end public function interpretRequest */

} // end class TFlagTab

