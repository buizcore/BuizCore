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
 * @package net.buiz
 * @author Dominik Donsch <dominik.bonsch@buiz.net>
 *
 */
class LibPeriodManager extends BaseChild
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  protected $actPeriod = [];

/*////////////////////////////////////////////////////////////////////////////*/
// Methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param PBase
   */
  public function __construct($env = null)
  {

    if (!$env)
      $env = BuizCore::$env;

    $this->env = $env;

  }//end public function __construct */

/*////////////////////////////////////////////////////////////////////////////*/
// Methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Initialisieren eines neuen Periodentypes
   * @param string $key
   */
  public function initNewPeriodType($key)
  {

    $orm = $this->getOrm();

    $period = $orm->getByKey('BuizPeriodType', $key);

    if (!$period)
      throw new LibPeriod_Exception('period type not exists','wbf.period',array('type',$key));

    // prüfen ob nicht schon initialisiert
    if ($period->status > 1) {
      throw new LibPeriod_Exception('period type allready initialized','wbf.period',array('type',$key));
    }

  }//end public function initNewPeriodType */

  /**
   * Initialisieren eines neuen Periodentypes
   * @param string $key
   *
   * @return
   */
  public function getPeriodType($key)
  {

    $orm = $this->getOrm();

    if (ctype_digit($key)) {

      $pType = $orm->get('BuizPeriodType', $key);
    } else {

      $pType = $orm->getByKey('BuizPeriodType', $key);
    }

    if (!$pType)
      throw new LibPeriod_Exception('period_type_not_exists', 'wbf.period', array('type',$key));

    return $pType;

  }//end public function getPeriodType */

  /**
   * Id der aktiven Period für eine bestimmten Type erfragen
   *
   * @param string|int $key id des types oder der access_key
   * @param int|array $status liste der status
   *
   * @return int die id der periode
   *
   * @throws LibPeriod_Exception
   */
  public function getActivePeriod($key, $status = null)
  {

    if (is_object($key))
      $key = $key->getId();

    if (isset($this->actPeriod[$key]))
      return $this->actPeriod[$key]['rowid'];

    if (!$status)
      $status = array(EBuizPeriodStatus::FROZEN, EBuizPeriodStatus::ACTIVE) ;

    if ( is_array($status) ) {
      $whereStatus = " IN(".implode(', ',$status).") ";
    } else {
      $whereStatus = " = ".$status;
    }

    if (ctype_digit($key)) {

      $sql = <<<SQL
SELECT
  period.rowid
FROM buiz_period period
WHERE
  period.id_type = {$key}
    and period.status {$whereStatus};
SQL;

    } else {

      $sql = <<<SQL
SELECT
  period.rowid,
  period.status,
  period.planned_end
FROM buiz_period period
  JOIN buiz_period_type type
    ON type.rowid = period.id_type
WHERE
  type.access_key = '{$key}'
  and period.status {$whereStatus};
SQL;

    }

    $this->actPeriod[$key] = $this->getDb()->select($sql)->get();

    if (!$this->actPeriod[$key]){
      throw new LibPeriod_Exception('no active period', 'wbf.period', array('type',$key));
    }

    return $this->actPeriod[$key]['rowid'];

  }//end public function getActivePeriod */

  /**
   * Die Actions für einen bestimmten Periodenübergang auslesen
   *
   * @param string $key
   * @param int EBuizPeriodStatus $type
   *
   * @return array
   */
  public function getPeriodActions($key, $type)
  {

    if ( is_object($key) || ctype_digit($key) ){

      $sql = <<<SQL
SELECT
  task.actions
FROM buiz_period_task task
WHERE
  task.id_type = {$key}
  AND task.event_type = {$type};
SQL;

    } else {

      $sql = <<<SQL
SELECT
  task.actions
FROM buiz_period_task task
  JOIN buiz_period_type type
    ON type.rowid = task.id_type
WHERE
  type.access_key = '{$key}'
  AND task.event_type = {$type};
SQL;

    }

    return $this->getDb()->select($sql)->getColumn('actions');

  }//end public function getPeriodActions */

  /**
   *
   *
   * @constraint Kann erst nach getActivePeriod aufgerufen werden
   *
   * @param string $key
   * @param int EBuizPeriodStatus $type
   *
   * @return array
   */
  public function getActivePeriodStatus($key)
  {

    return isset($this->actPeriod[$key]['status'])
      ? $this->actPeriod[$key]['status']
      : null;

  }//end public function getActivePeriodStatus */

  /**
   *
   * @constraint Kann erst nach getActivePeriod aufgerufen werden
   *
   * @param string $key
   * @param int EBuizPeriodStatus $type
   *
   * @return array
   *
   */
  public function getActivePeriodDeadline($key)
  {

    return isset($this->actPeriod[$key]['planned_end'])
      ? $this->actPeriod[$key]['planned_end']
      : null;

  }//end public function getActivePeriodDeadline */


  /**
   * Die nächste Periode eines Types erfragen
   * @param string $key
   *
   * @return int
   */
  public function getNext($pType)
  {

    // valide Perionden sind entweder in Planung oder in Preparation
    $prep = EBuizPeriodStatus::PREPARATION;
    $planned = EBuizPeriodStatus::PLANNED;

    $sql = <<<SQL
SELECT
  rowid
FROM
  buiz_period
WHERE
  date_start IN(
    SELECT min(date_start)
    FROM buiz_period
    WHERE
      status IN({$prep}, {$planned})
        AND id_type = {$pType}
  )
  AND status IN({$prep}, {$planned})
  AND id_type = {$pType}
SQL;

    return $this->getDb()->select($sql)->getField('rowid');

  }//end public function getNext */

  /**
   * Die lezte Periode erfragen
   * @param string $key
   *
   * @return int
   */
  public function getLast($key)
  {

    // valide Perionden sind entweder in Planung oder in Preparation
    $status = EBuizPeriodStatus::CLOSED;

    $sql = <<<SQL
SELECT
  period.rowid
FROM
  buiz_period
WHERE
  status = {$status}
HAVING
  date_end = max(date_end);
SQL;

    return $this->getDb()->select($sql)->getField('rowid');

  }//end public function getLast */

  /**
   *
   */
  public function getBetween($key, $start, $end)
  {

    $orm = $this->getOrm();

    $period = $orm->getByKey('BuizPeriodType', $key);

    if (!$period)
      throw new LibPeriod_Exception('Got key '.$key.' to initialize, however this period type does not exist.' );

    // prüfen ob nicht schon initialisiert
    if ($period->status > 1) {
      throw new LibPeriod_Exception('The period type '.$key.' is allready initialized');
    }

  }//end public function getBetween */

  /**
   * Eine neue Periode zum angegeben Type hinzufügen
   *
   * @param string $key
   * @param int $status
   */
  public function createNext($pType, $status = null)
  {

    $orm = $this->getOrm();

    $period = new BuizPeriod_Entity();
    $period->title = $pType->name.' '.date('Y-m-d');
    $period->access_key = $pType->access_key.'_'.date('Y_m_d');
    $period->date_start = date('Y-m-d');
    $period->status = $status;
    $period->id_type = $pType;

    $orm->save($period);

    return $period;

  }//end public function createNext */
  
  /**
   * Checken ob die Periode aktuell in frozen Status ist
   *
   * @param int $pTypeId ID der Periode
   */
  public function isInitialized($pTypeId)
  {
  
    $orm = $this->getOrm();
    return (boolean)$orm->countRows('BuizPeriod', 'id_type = '.$pTypeId);
  
  }//end public function isFrozen */
  
  /**
   * Checken ob die Periode aktuell in frozen Status ist
   * 
   * @param int $pTypeId ID der Periode
   */
  public function isFrozen($pTypeId)
  {
    
    $orm = $this->getOrm();
    return (boolean)$orm->countRows('BuizPeriod', 'id_type = '.$pTypeId.' and status = '.EBuizPeriodStatus::FROZEN);
    
  }//end public function isFrozen */
  
  /**
   * Checken ob die Periode aktuell in frozen Status ist
   *
   * @param int $pTypeId ID der Periode
   */
  public function isActive($pTypeId)
  {
  
    $orm = $this->getOrm();
    return !(boolean)$orm->countRows('BuizPeriod', 'id_type = '.$pTypeId.' and status = '.EBuizPeriodStatus::FROZEN);
  
  }//end public function isFrozen */
  

  /**
   * @param string $key
   * @throws LibPeriod_Exception im Fehlerfall
   */
  public function initialize($key)
  {

    $orm = $this->getOrm();

    $pType = $this->getPeriodType($key);

    if ($pType->status >= EBuizPeriodTypeStatus::ACTIVE){
      throw new LibPeriod_Exception('period type allready initialized', 'wbf.period');
    }

    $activePeriod = $this->createNext(
      $pType,
      EBuizPeriodStatus::ACTIVE
    );


    $this->triggerAction($pType, $activePeriod, EBuizPeriodEventType::INITIALIZE );

  }//end public function initialize */

  /**
   * @param string $key
   * @throws LibPeriod_Exception im Fehlerfall
   */
  public function freeze($key)
  {

    /// @throws LibPeriod_Exception wenn inkonsistent
    $this->checkConsistency($key);

    /// @throws LibPeriod_Exception  wenn keine aktive periode vorhanden ist
    $activePeriod = $this->getActivePeriod($key);
    $pType = $this->getPeriodType($key);

    $this->createNext($pType, EBuizPeriodStatus::PREPARATION);

    $this->updatePeriodStatus($activePeriod, EBuizPeriodStatus::FROZEN);

    $this->triggerAction(
      $pType,
      $activePeriod,
      EBuizPeriodEventType::FREEZE,
      true
    );

  }//end public function freeze */

  /**
   * @param string $key
   * @throws LibPeriod_Exception im Fehlerfall
   */
  public function next($key)
  {

    /// @throws LibPeriod_Exception wenn inkonsistent
    $this->checkConsistency($key);

    $pType = $this->getPeriodType($key);

    // die aktive periode finden
    $activePeriod = $this->getActivePeriod($pType, array(EBuizPeriodStatus::ACTIVE, EBuizPeriodStatus::FROZEN));
    $this->closePeriod($activePeriod, EBuizPeriodStatus::CLOSED);


    // die nächste Periode laden
    $nextPeriod = $this->getNext($pType);

    // wenn keine vorhanden ist eine erstellen
    if (!$nextPeriod) {

      $this->createNext($pType, EBuizPeriodStatus::ACTIVE);
    } else {

      // die nächste periode aktiv setzen
      $this->updatePeriodStatus($nextPeriod, EBuizPeriodStatus::ACTIVE);
    }

    $this->triggerAction(
      $pType,
      array($activePeriod,$nextPeriod),
      EBuizPeriodEventType::SWITCH_NEXT,
      true
    );

  }//end public function next */


  /**
   * @param string $pType
   * @param int $activePeriod
   * @param int $actionType
   * @throws LibPeriod_Exception im Fehlerfall
   */
  public function triggerAction($pType, $activePeriod, $actionType)
  {


    // alle Actions die am Überfang hängen ausführen
    $actions = $this->getPeriodActions($pType, $actionType);

    if ($actions) {
      $executor = new LibAction_Runner($this->env);
      foreach ($actions as $action) {
        $executor->executeByString($action, array($activePeriod));
      }
    }


  }//end public function triggerAction */

  /**
   * @param string $key
   * @param int $activePeriod
   * @param int $status
   * @param int $actionType
   * @param boolean $createNext
   * @throws LibPeriod_Exception im Fehlerfall
   */
  public function updatePeriodStatus($activePeriod, $status)
  {

    $db = $this->getDb();

    // periode auf freeze setzen
    $sql = <<<SQL
UPDATE buiz_period set status = {$status} where rowid = {$activePeriod};
SQL;

    $db->update($sql);


  }//end public function updatePeriodStatus */

  /**
   * @param string $key
   * @param int $activePeriod
   * @param int $status
   * @param int $actionType
   * @param boolean $createNext
   * @throws LibPeriod_Exception im Fehlerfall
   */
  public function closePeriod($activePeriod, $status)
  {

    $db = $this->getDb();

    $today = date('Y-m-d');

    // periode auf freeze setzen
    $sql = <<<SQL
UPDATE buiz_period set status = {$status}, date_end = '{$today}' where rowid = {$activePeriod};
SQL;

    $db->update($sql);

  }//end public function closePeriod */


  /**
   * @param string $key
   * Check auf Consistency
   */
  public function checkConsistency( $key )
  {

    $db = $this->getDb();

    $status = EBuizPeriodStatus::PREPARATION;
    $startDate = date('Y-m-d');

    if (ctype_digit($key)) {

      // periode auf freeze setzen
      $sql = <<<SQL
SELECT
  COUNT(period.rowid) as num
FROM
   buiz_period period
WHERE
  period.id_type = {$key}
    AND period.status <= {$status}
    AND period.date_start < '{$startDate}';

SQL;

    } else {

      // periode auf freeze setzen
      $sql = <<<SQL
SELECT
  COUNT(period.rowid) as num
FROM
   buiz_period period
JOIN
    buiz_period_type type ON type.rowid = period.id_type
WHERE
  buiz_period_type.access_key = '{$key}'
    AND status <= {$status}
    AND date_start < '{$startDate}';

SQL;
    }

    $num = $db->select($sql)->getField('num');

    if ($num > 2) {
      throw new LibPeriod_Exception('wbf.period.multiple_periods_in_past');
    }

  }//end public function checkConsistency */

}//end class LibPeriodManager

