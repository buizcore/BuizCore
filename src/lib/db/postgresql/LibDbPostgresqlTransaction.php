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
 * @author dominik alexander bonsch <dominik.bonsch@buiz.net>
 */
class LibDbPostgresqlTransaction extends LibDbTransactions
{

    ////////////////////////////////////////////////////////////////////////////////
    //
    ////////////////////////////////////////////////////////////////////////////////
    
    /**
     * Senden einer Datenbankabfrage zum erstellen eines Ausführplans
     *
     * @param
     *            string Name Name der Abfrage
     * @param
     *            string Der Fertige SQL Code
     * @return void
     * @throws LibDb_Exception
     */
    public function prepareSelect($name, $sqlstring)
    {
        ++ $this->counter;
    
        if (trim($name) == '' || trim($sqlstring) == '') {
            // Fehlermeldung raus und gleich mal nen Trace laufen lassen
            $args = func_get_args();
            Error::addError('Wrong Parameters', 'LibDb_Exception', $args);
        }
    
        if (Log::$levelDebug)
            Log::debug(__FILE__, __LINE__, 'PREPARE SELECT: '.$name.' SQL: '.$sqlstring);
    
        if (! $this->result = pg_prepare($this->connectionRead, $name, $sqlstring)) {
            throw new LibDb_Exception('Die Afrage hat kein Result geliefert: '.pg_last_error());
        }
    } // end public function prepareSelect */
    
    /**
     * Ein Insert Statement an die Datenbank schicken
     *
     * @param
     *            res Sql Ein Aktion Object
     * @throws LibDb_Exception
     * @return int
     */
    public function prepareInsert($name, $sqlstring)
    {
        ++ $this->counter;
    
        if (trim($name) == '' || trim($sqlstring) == '') {
            // Fehlermeldung raus und gleich mal nen Trace laufen lassen
            $args = func_get_args();
            throw new LibDb_Exception('Datenbank prepareInsert() hat inkompatible Parameter bekommen');
        }
    
        if (Log::$levelDebug)
            Log::debug(__FILE__, __LINE__, 'PREPARE INSERT: '.$name.' SQL: '.$sqlstring);
    
        if (! $this->result = pg_prepare($this->connectionWrite, $name, $sqlstring)) {
            throw new LibDb_Exception('Die Afrage hat kein Result geliefert: '.pg_last_error());
        }
    } // end public function prepareInsert */
    
    /**
     * Ein Updatestatement an die Datenbank schicken
     *
     * @param string $name
     * @param string $sqlstring
     * @throws LibDb_Exception
     * @return int
     */
    public function prepareUpdate($name, $sqlstring)
    {
        ++ $this->counter;
    
        if (trim($name) == '' || trim($sqlstring) == '') {
            // Fehlermeldung raus und gleich mal nen Trace laufen lassen
            $args = func_get_args();
            throw new LibDb_Exception('Datenbank prepareUpdate hat inkompatible Parameter bekommen');
        }
    
        if (Log::$levelDebug)
            Log::debug(__FILE__, __LINE__, 'Name: '.$name.' SQL: '.$sqlstring);
    
        if (! $this->result = pg_prepare($this->connectionWrite, $name, $sqlstring)) {
            throw new LibDb_Exception('Die Afrage hat kein Result geliefert: '.pg_last_error());
        }
    } // end public function prepareUpdate */
    
    /**
     * Ein Deletestatement and die Datenbank schicken
     *
     * @param
     *            res Sql Ein Aktion Object
     * @return
     *
     */
    public function prepareDelete($name, $sqlstring)
    {
        ++ $this->counter;
    
        if (trim($name) == '' || trim($sqlstring) == '') {
            // Fehlermeldung raus und gleich mal nen Trace laufen lassen
            $args = func_get_args();
            throw new LibDb_Exception('Datenbank prepareInsert() hat inkompatible Parameter bekommen');
        }
    
        if (Log::$levelDebug)
            Log::debug(__FILE__, __LINE__, 'Name: '.$name.' SQL: '.$sqlstring);
    
        if (! $this->result = pg_prepare($this->connectionWrite, $name, $sqlstring)) {
            throw new LibDb_Exception('Die Afrage hat kein Result geliefert: '.pg_last_error());
        }
    } // end public function prepareDelete */
    
    ////////////////////////////////////////////////////////////////////////////////
    // Statement Methodes
    ////////////////////////////////////////////////////////////////////////////////
    
    /**
     * Löschen eines Ausführplans in der Datenbank
     *
     * @param
     *            string Name Name der Abfrage die gelöscht werden soll
     * @return void
     * @throws LibDb_Exception
     */
    public function deallocate($name)
    {
        if (! $this->result = pg_query($this->connectionWrite, 'DEALLOCATE '.$name)) {
            throw new LibDb_Exception('Konnte deallocate nicht ausführen');
        }
    } // end public function deallocate */
    
    /**
     * Ausführen einer Vorbereiteten Datenbankabfrage
     *
     * @param
     *            string Name Name der Query in der Datenbank
     * @param
     *            array Values Ein Array mit den Daten
     * @throws LibDb_Exception
     */
    public function executeQuery($name, $values = null, $returnIt = true, $single = false)
    {
        if (is_object($name)) {
            $obj = $name;
            $name = $obj->getName();
            $values = $obj->getPrepareValues();
            $single = $obj->getSingelRow();
        }
    
        if (! $this->result = pg_execute($this->connectionRead, $name, $values)) {
            throw new LibDb_Exception('Konnte Execute nicht ausführen: '.pg_last_error());
        }
    
        if ($returnIt) {
    
            if (! $ergebnis = pg_fetch_all($this->result)) {
                return [];
            }
    
            if ($single) {
                return $ergebnis[0];
            } else {
                return $ergebnis;
            }
        } else {
            return true;
        }
    } // end public function executeQuery */
    
    /**
     * Ausführen einer Vorbereiteten Datenbankabfrage
     *
     * @param
     *            string Name Name der Query in der Datenbank
     * @param
     *            array Values Ein Array mit den Daten
     * @throws LibDb_Exception
     */
    public function executeAction($name, $values = null, $getNewId = false)
    {
        if (is_object($name)) {
            $obj = $name;
            $name = $obj->getName();
            $values = $obj->getPrepareValues();
        }
    
        if (! $this->result = pg_execute($this->connectionWrite, $name, $values)) {
    
            throw new LibDb_Exception('Konnte Execute nicht ausführen: '.pg_last_error());
        }
    
        if ($getNewId or $this->activObject->getNewid()) {
    
            $table = $this->activObject->getTable();
    
            if (! $this->result = pg_query($this->connection, $sqlstring = 'select currval(\''.strtolower($table).'_'.strtolower($getNewId).'_seq\')')) {
    
                Error::addError('Konnte die neue Id nicht abfragen', 'LibDb_Exception');
            }
    
            if (! $row = pg_fetch_assoc($this->result)) {
                Error::addError('Konnte die neue Id nicht lesen', 'LibDb_Exception');
            }
    
            return $row['currval'];
        } else {
            return pg_affected_rows($this->result);
        }
    } // end public function executeAction */
    
} //end class LibDbPostgresqlTransaction

