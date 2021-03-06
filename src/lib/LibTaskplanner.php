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
 * Taskplanner
 *
 * @package net.buiz
 */
class LibTaskplanner extends BaseChild {
   
   /**
    * Aktueller Unix Timestamp
    *
    * @var int
    */
   public $currentTimestamp = null;
   
   /**
    * Aktuelles Datum als Array
    *
    * @var array
    */
   public $currentDate = null;
   
   /**
    * Die Typen der Tasks welche zu laden sind.
    * Siehe ETaskType
    *
    * @var array
    */
   public $taskTypes = array ();
   
   /**
    * Liste der auszuführenden Tasks.
    *
    * @var array
    */
   public $tasks = null;
   
   /**
    * Das Environment Objekt
    *
    * @var LibFlowApachemod
    */
   public $env = null;

   /**
    * Konstruktor.
    *
    * @param LibFlowApachemod $env           
    * @param int $currentTimestamp
    *           Timestamp
    */
   public function __construct($currentTimestamp = null, $env = null) {

      if ($env) {
         $this->env = $env;
      } else {
         $this->env = BuizCore::$env;
      }
      
      if ($currentTimestamp) {
         $this->currentTimestamp = $currentTimestamp;
      } else {
         $this->currentTimestamp = time();
      }
      
      $this->load();
   
   }

   /**
    * Initialisiert den Taskplanner und ermittelt welche Typen von Tasks laufen sollen.
    *
    * @param int $currentTimestamp
    *           Timestamp
    */
   public function load() {

      $this->currentDate = getdate( $this->currentTimestamp );
      
      $this->taskTypes = $this->setupRequiredTasktypes( $this->currentDate );
      
      $this->tasks = $this->loadTypedTasks( $this->taskTypes, date( 'Y-m-d H:i:00', $this->currentTimestamp ) );
   
   }

   /**
    * Bestimmt in Abhängigkeit von <code>$currentDate</code> welche Typen von Tasks gestartet werden müssen.
    * Tasks die zu den selben Zeitpunkten starten können, werden zeitversetzt gestartet.
    *
    * @param int $currentDate
    *           Timestamp
    * @return array $types
    */
   public function setupRequiredTasktypes($currentDate) {

      $minutes = $currentDate ['minutes'];
      $hours = $currentDate ['hours'];
      $weekDay = $currentDate ['wday'];
      $monthDay = $currentDate ['mday'];
      $yearDay = $currentDate ['yday'];
      $year = $currentDate ['year'];
      $month = $currentDate ['mon'];
      
      $types = array ();
      
      // Die Tasks im Bereich von Minuten können zu jeder Sekunde laufen.
      // Damit können verzögerungen besser ausgeglichen werden und $types ist niemals leer.
      
      // ETaskType: Every minute
      $types [] = ETaskType::MINUTE;
      
      // ETaskType: Every 5 minutes
      if ($minutes % 5 == 0) {
         $types [] = ETaskType::MINUTE_5;
      }
      
      // ETaskType: Every 15 minutes
      if ($minutes % 15 == 0) {
         $types [] = ETaskType::MINUTE_15;
      }
      
      // ETaskType: Every 30 minutes
      if ($minutes % 30 == 0) {
         $types [] = ETaskType::MINUTE_30;
      }
      
      // **:11:**, Jeden Tag
      if ($minutes == 11) {
         
         // ETaskType: Every hour
         $types [] = ETaskType::HOUR;
         
         // ETaskType: Every 6 hours
         if ($hours % 6 == 0) {
            $types [] = ETaskType::HOUR_6;
         }
         
         // ETaskType: Every 12 hours
         if ($hours % 12 == 0) {
            $types [] = ETaskType::HOUR_12;
         }
      }
      
      // 02:22:**, Jeden Tag
      if ($hours == 2 && $minutes == 22) {
         
         // ETaskType: Every day
         $types [] = ETaskType::DAY;
         
         // ETaskType: Every working day
         if ($weekDay > 0 && $weekDay < 6) {
            $types [] = ETaskType::WORK_DAY;
         }
         
         // ETaskType: Every weekend
         if ($weekDay == 0 || $weekDay == 6) {
            $types [] = ETaskType::WEEK_END;
         }
         
         // Mo alle 2 Wochen
         // ETaskType: Every second week
         if ($weekDay == 1 && (($yearDay / 7) % 2) == 0) {
            $types [] = ETaskType::WEEK_2;
         }
         
         // Mi jede Woche
         // ETaskType: Every week
         if ($weekDay == 3) {
            $types [] = ETaskType::WEEKLY;
         }
      }
      
      // 05:33:**
      if ($hours == 5 && $minutes == 33) {
         $lastDayOfMonth = SDate::getMonthDays( $year, $month );
         
         // Welches ist der letzte Wochentag des Monats?
         $lastWeekdayOfMonth = date( 'N', strtotime( date( $year . '-' . $month . '-' . $lastDayOfMonth ) ) );
         
         // Wann ist Ostersonntag?
         $easter = getdate( easter_date() );
         
         // Wann ist Karfreitag?
         $karfreitag = $easter ['mday'] - 2;
         
         if ($lastWeekdayOfMonth == 6) {
            // Wenn der letzte Tag des Monats ein Samstag ist, ist der letzte Arbeitstag der Freitag davor
            $lastWorkingDay = $lastDayOfMonth - 1;
         } elseif ($lastWeekdayOfMonth == 7) {
            // Wenn der letzte Tag des Monats ein Sonntag ist, ist der letzte Arbeitstag der Freitag davor
            $lastWorkingDay = $lastDayOfMonth - 2;
            if ($lastWorkingDay == $karfreitag && $month == $easter ['mon']) {
               // Ist der lezte Arbeitstag der Karfreitag, ziehen wir noch einen Tag ab.
               $lastWorkingDay --;
            }
         } else {
            // In jedem anderen Fall ist der letzte Tag des Monats auch der letzte Arbeitstag
            $lastWorkingDay = $lastDayOfMonth;
         }
         
         // Letzter Tag im Monat
         if ($monthDay == $lastWorkingDay) {
            $types [] = ETaskType::MONTH_END_WORKDAY;
         }
         
         // Monatlich am 20.
         if ($monthDay == 20) {
            $types [] = ETaskType::MONTHLY;
         }
         
         // Jedes Quartal
         if ($monthDay == 1) {
            // ETaskType: Every month start
            $types [] = ETaskType::MONTH_START;
         } elseif ($monthDay == $lastDayOfMonth) {
            // ETaskType: Every month end
            $types [] = ETaskType::MONTH_END;
         }
         
         // 1. Tag des Monats, alle 3 Monate
         if ($monthDay == 1 && $month % 3 == 0) {
            // ETaskType: Every quater start
            $types [] = ETaskType::MONTH_3_START;
         } elseif ($monthDay == $lastDayOfMonth && $month % 3 == 0) {
            // ETaskType: Every quater end
            $types [] = ETaskType::MONTH_3_END;
         }
         
         // Jedes Halbjahr, erster Tag des Monats
         if ($monthDay == 1 && $month % 6 == 0) {
            // ETaskType: Every half year start
            $types [] = ETaskType::MONTH_6_START;
         } elseif ($monthDay == $lastDayOfMonth && $month % 6 == 0) {
            // ETaskType: Every half year end
            $types [] = ETaskType::MONTH_6_END;
         }
         
         // Jahresbeginn
         
         if ($monthDay == 1 && $month == 1) {
            // ETaskType: Every year start
            $types [] = ETaskType::YEAR_START;
         }
         
         // Jahredende
         if ($monthDay == $lastDayOfMonth && $month == 12) {
            // ETaskType: Every year end
            $types [] = ETaskType::YEAR_END;
         }
      }
      
      return $types;
   
   }

   /**
    * Ermittelt die zum Zeitpunkt <code>$currentDate</code> zu startenden Tasks.
    *
    * @param array $taskTypes
    *           ETaskType
    * @param array $currentDate           
    * @return array
    */
   public function loadTypedTasks($taskTypes, $currentDate) {

      $whereType = implode( ', ', $taskTypes );
      
      $customType = ETaskType::CUSTOM;
      
      $statusOpen = ETaskStatus::OPEN;
      
      $statusDisabled = ETaskStatus::DISABLED;
      
      $db = $this->getDb();
      
      $sql = <<<SQL
SELECT
  plan.rowid as plan_id,
  plan.actions as plan_actions,
  task.rowid as task_id,
  task.actions as task_actions

FROM
  buiz_task_plan as plan

JOIN
  buiz_planned_task task
    ON plan.rowid = task.vid

WHERE
	(
		task.type IN({$whereType})
		AND task.task_time = '{$currentDate}'
		AND task.status = {$statusOpen}
	)
	OR
	(
		task.type IN({$whereType})
		AND '{$currentDate}' BETWEEN plan.timestamp_start AND plan.timestamp_end
		AND task.status <> {$statusDisabled}
	)
	OR
	(
		task.type IN({$customType})
		AND task.task_time = '{$currentDate}'
		AND task.status <> {$statusDisabled}
     )
SQL;
      
      return $db->select( $sql )->getAll();
   
   }

   public function getTasklist() {

      $taskList = array ();
      
      if (! is_null( $this->tasks )) {
         foreach ( $this->tasks as $task ) {
            
            $taskList [] = new LibTask( $task );
         }
      }
      
      return $taskList;
   
   }

}