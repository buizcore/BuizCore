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
 * @package net.buiz
 */
class LibDbPostgresql extends LibDbConnection
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////
    
    /**
     * Der Standard Fetch Mode
     */
    protected $fetchMode = PGSQL_ASSOC;

    /**
     * Holen der Daten als Assoziativer Array
     */
    const fetchAssoc = PGSQL_ASSOC;

    /**
     * Holen der Daten als Numerischer Array
     */
    const fetchNum = PGSQL_NUM;

    /**
     * Holen der Daten als Doppelter Assoziativer und Numerischer Array
     */
    const fetchBoth = PGSQL_BOTH;

    /**
     * the type of the sql sqlBuilder for this database class
     *
     * @var string
     */
    protected $builderType = 'Postgresql';

    /**
     *
     * @return string
     */
    public function __toString()
    {
        return 'Database Connection: '.$this->databaseName.'.'.$this->schema.' Type: '.$this->getParserType();
    } // end public function __toString */
    
////////////////////////////////////////////////////////////////////////////////
// 
////////////////////////////////////////////////////////////////////////////////
    
    /**
     *
     * @param string $sql            
     */
    public function roubstSelect($sql)
    {
        try {
            if (DEBUG) {
                $start = BuizCore::startMeasure();
            }
            
            $res = $this->select($sql);
            
            if (DEBUG) {
                $duration = BuizCore::getDuration($start);
                $this->queryTime += $duration;
                Log::debug('ROBUST SELECT SQL dur:'.$duration.' num:'.$this->counter.':  '.$sql);
            }
            
            return $res;
        } catch (Exception $e) {
            return null;
        }
    } // end public function roubstSelect */
    
    /**
     * de:
     * eine einfach select abfrage an die datenbank
     * select wird immer auf der lesende connection ausgeführt
     *
     * @param string $sql
     *            ein SQL String
     * @return LibDbPostgresqlResult
     * @throws LibDb_Exception - bei inkompatiblen parametern
     */
    public function select($sql)
    {
        ++ $this->counter;
        $duration = - 1;
        
        if (! is_string($sql)) {
            // Fehlermeldung raus und gleich mal nen Trace laufen lassen
            throw new LibDb_Exception('incompatible parameters');
        }
        
        // Query protokolieren bei bedarf
        if ($this->protocol)
            $this->protocol->write($sql);
        
        if (Log::$levelDebug)
            Log::debug('SELECT SQL '.$this->counter.':  '.$sql);
        
        if (DEBUG) {
            $start = BuizCore::startMeasure();
        }
        
        if (! is_resource($this->connectionRead)) {
            Log::error('Lost Connection to the Database!!! Try to reconnect');
            $this->connect();
        }
        
        if (! $this->result = pg_query($this->connectionRead, $sql)) {
            
            $trace = Debug::backtrace();
            
            // Fehlermeldung raus und gleich mal nen Trace laufen lassen
            throw new LibDb_Exception(
                'Failed to read from the database. Seems we have a broken query here. '.$sql, 
                'DB Response: '.pg_last_error($this->connectionRead).' '.$trace, 
                Response::INTERNAL_ERROR, 
                $sql, 
                $this->counter
            );
        }
        
        if (DEBUG) {
            $duration = BuizCore::getDuration($start);
            $this->queryTime += $duration;
            Log::debug('SELECT SQL num:'.$this->counter.' dur:'.$duration.' :  '.$sql, null, true);
        }
        
        return new LibDbPostgresqlResult($this->result, $this, $sql, $this->counter, $duration);
    } // end public function select */
    
    /**
     * de:
     * ausführen einer insert query
     *
     * @param mixed $sql            
     * @param string $tableName            
     * @param string $tablePk            
     * @return int
     * @throws LibDb_Exception im fehlerfall
     */
    public function insert($sql, $tableName, $tablePk)
    {
        ++ $this->counter;
        $duration = - 1;
        
        if (! is_string($sql)) {
            throw new LibDb_Exception('incompatible parameters');
        }
        
        if (Log::$levelDebug)
            Log::debug('INSERT SQL: '.$sql);
        
        if (DEBUG) {
            $start = BuizCore::startMeasure();
        }
        
        if ($this->protocol)
            $this->protocol->write($sql);
        
        if (! is_resource($this->connectionWrite)) {
            Log::error('Lost Connection to the Database!!! Try to reconnect');
            $this->connect();
        }
        
        if (! $this->result = pg_query($this->connectionWrite, $sql)) {
            throw new LibDb_Exception('Insert failed DB Response: '.pg_last_error($this->connectionWrite).' '.$sql , 'DB Response: '.pg_last_error($this->connectionWrite), Response::INTERNAL_ERROR, $sql, $this->counter);
        }
        
        // das kann passieren, wenn eine insert if not exists query läuft
        // dann kann es dazu kommen, dass kein datensatz angelegt wird, also
        // wollen wir in dem kontext dann auch keine id zurückgeben
        if (! pg_affected_rows($this->result))
            return null;
            
            // $sqlstring = 'select currval(\''.strtolower($tableName).'_'.strtolower($tablePk).'_seq\')';
        $sqlstring = "select currval('".Db::SEQUENCE."');";
        
        if (! $this->result = pg_query($this->connectionWrite, $sqlstring)) {
            throw new LibDb_Exception('Failed to receive a new id', 'No Db Result: '.pg_last_error($this->connectionWrite), Response::INTERNAL_ERROR, $sqlstring, $this->counter);
        }
        
        if (!$row = pg_fetch_row($this->result)) {
            throw new LibDb_Exception(I18n::s('wbf.error.DBFailedToGetNewId'));
        }
        
        if (DEBUG) {
            $duration = BuizCore::getDuration($start);
            $this->queryTime += $duration;
            Log::debug('INSERT SQL dur:'.$duration.' num:'.$this->counter.':  '.$sql);
        }
        
        return $row[0];
        
    } // end public function insert */
    
    /**
     * de:
     * ausführen einer insert query
     *
     * @param string $seqName            
     * @return int
     * @throws LibDb_Exception im fehlerfall
     */
    public function nextVal($seqName)
    {
        ++ $this->counter;
        
        $sqlstring = "select nextval('".$seqName."');";
        
        if (! $this->result = pg_query($this->connectionWrite, $sqlstring)) {
            throw new LibDb_Exception(
                'Failed to receive a new id', 
                'No Db Result: '.pg_last_error($this->connectionWrite).' '.$this->schema , 
                Response::INTERNAL_ERROR, 
                $sqlstring
            );
        }
        
        $row = pg_fetch_row($this->result);
        
        return $row[0];
        
    } // end public function nextVal */
    
    /**
     * de:
     * ausführen einer insert query
     *
     * @param string $seqName            
     * @return int
     * @throws LibDb_Exception im fehlerfall
     */
    public function currVal($seqName)
    {
        ++ $this->counter;
        
        $sqlstring = "select currval('".$seqName."');";
        
        if (! $this->result = pg_query($this->connectionRead, $sqlstring)) {
            throw new LibDb_Exception(
                'Failed to receive a new id', 
                'No Db Result: '.pg_last_error($this->connectionRead), Response::INTERNAL_ERROR, $sqlstring);
        }
        
        $row = pg_fetch_row($this->result);
        
        return $row[0];
    } // end public function currVal */
    
    /**
     * Den aktuellen Wert einer Sequence auslesen
     *
     * @param string $seqName            
     * @return int
     * @throws LibDb_Exception im fehlerfall
     */
    public function sequenceValue($seqName)
    {
        ++ $this->counter;
        
        $sqlstring = "select last_value from {$seqName};";
        
        if (! $this->result = pg_query($this->connectionRead, $sqlstring)) {
            throw new LibDb_Exception('Failed to receive a new id', 'No Db Result: '.pg_last_error($this->connectionRead), Response::INTERNAL_ERROR, $sqlstring);
        }
        
        $row = pg_fetch_row($this->result);
        
        return $row[0];
    } // end public function sequenceValue */
    
    /**
     * de:
     * ausführen einer insert query
     *
     * @param string $seqName            
     * @return int
     * @throws LibDb_Exception im fehlerfall
     */
    public function lastVal($seqName)
    {
        ++ $this->counter;
        
        $sqlstring = "select lastval('".$seqName."');";
        
        if (! $this->result = pg_query($this->connectionRead, $sqlstring)) {
            throw new LibDb_Exception('Failed to receive a new id', 'No Db Result: '.pg_last_error($this->connectionRead), Response::INTERNAL_ERROR, $sqlstring);
        }
        
        $row = pg_fetch_row($this->result);
        
        return $row[0];
    } // end public function lastVal */
    
    /**
     *
     * @param string $sql            
     * @param string $tableName            
     *
     * @throws LibDb_Exception
     * @return LibDbPostgresqlResult
     */
    public function create($sql, $tableName = null)
    {
        ++ $this->counter;
        
        /*
         * if (is_object($sql) || $tableName) { $sqlstring = $this->sqlBuilder->buildInsert($sql , $tableName); } elseif (is_string($sql)) { $sqlstring = $sql; } elseif (is_array($sql) ) { $sqlstring = $this->sqlBuilder->buildInsert($sql , $tableName); } else { throw new LibDb_Exception ('incompatible parameters'); }
         */
        
        if (! is_string($sql)) {
            throw new LibDb_Exception('incompatible parameters');
        }
        
        $sqlstring = $sql;
        
        if (Log::$levelDebug)
            Log::debug('CREATE SQL: '.$sqlstring);
        
        if ($this->protocol)
            $this->protocol->write($sqlstring);
        
        if (! is_resource($this->connectionWrite)) {
            Log::error('Lost Connection to the Database!!! Try to reconnect');
            $this->connect();
        }
        
        if (! $this->result = pg_query($this->connectionWrite, $sqlstring)) {
            throw new LibDb_Exception('Create Failed', 'DB Response: '.pg_last_error($this->connectionWrite), Response::INTERNAL_ERROR, $sqlstring);
        }
        
        if (Log::$levelDebug)
            Log::debug('CREATE: '.$sqlstring);
        
        return new LibDbPostgresqlResult($this->result, $this);
    } // end public function create */
    
    /**
     * Ein Updatestatement an die Datenbank schicken
     *
     * @param string $sql
     *            Ein Aktion Object
     * @throws LibDb_Exception
     * @return int
     */
    public function update($sql)
    {
        ++ $this->counter;
        
        if (! is_string($sql)) {
            throw new LibDb_Exception('incompatible parameters');
        }
        
        if (Log::$levelDebug)
            Log::debug('UPDATE SQL '.$this->counter.':  '.$sql);
        
        if ($this->protocol)
            $this->protocol->write($sql);
        
        if (! is_resource($this->connectionWrite)) {
            Log::error('Lost Connection to the Database!!! Try to reconnect');
            $this->connect();
        }
        
        if (! $this->result = pg_query($this->connectionWrite, $sql)) {
            // Fehlermeldung raus und gleich mal nen Trace laufen lassen
            throw new LibDb_Exception(
                'Update Failed', 
                'DB Response: '.pg_last_error($this->connectionWrite), Response::INTERNAL_ERROR, $sql);
        }
        
        return new LibDbPostgresqlResult($this->result, $this);
        
    } // end public function update */
    
    /**
     *
     * @todo add some error handling and a response
     */
    public function multiDelete(array $sqls)
    {
        foreach ($sqls as $sql)
            $this->delete($sql);
    } // end public function multiDelete */
    
    /**
     * Ein Deletestatement and die Datenbank schicken
     *
     * @param
     *            res Sql Ein Aktion Object
     * @throws LibDb_Exception
     * @return int Anzahl der gelöschten Datensätze
     */
    public function delete($sql)
    {
        ++ $this->counter;
        
        if (! is_string($sql)) {
            $args = func_get_args();
            
            throw new LibDb_Exception('Datenbank delete() hat inkompatible Parameter bekommen');
        }
        
        if (Log::$levelDebug)
            Log::debug('DELETE SQL '.$this->counter.':  '.$sql);
        
        if ($this->protocol)
            $this->protocol->write($sql);
        
        if (! is_resource($this->connectionWrite)) {
            Log::error('Lost Connection to the Database!!! Try to reconnect');
            $this->connect();
        }
        
        if (! $this->result = pg_query($this->connectionWrite, $sql)) {
            // Fehlermeldung raus und gleich mal nen Trace laufen lassen
            throw new LibDb_Exception('Delete failed', 'DB Response: '.pg_last_error($this->connectionWrite), Response::INTERNAL_ERROR, $sql);
        }
        
        return pg_affected_rows($this->result);
        
    } // end public function delete */
    

    
////////////////////////////////////////////////////////////////////////////////
// Simple Queries
////////////////////////////////////////////////////////////////////////////////
    
    /**
     * a raw sql query
     *
     * @param string $sql
     *            sql als string oder criteria
     * @param boolean $returnit
     *            Should be returned?
     * @param boolean $single
     *            Is a single Row Query
     * @throws LibDb_Exception
     * @return array
     */
    public function query($sql)
    {
        if (Log::$levelDebug)
            Log::debug('QUERY SQL: '.$sql);
        
        if ($this->protocol)
            $this->protocol->write($sql);
        
        if (! is_resource($this->connectionRead)) {
            Log::error('Lost Connection to the Database!!! Try to reconnect');
            $this->connect();
        }
        
        if (! $this->result = pg_query($this->connectionRead, (string) $sql)) {
            throw new LibDb_Exception('Query Failed: '.pg_last_error($this->connectionRead));
        }
        
        $anz = pg_num_rows($this->result);
        
        return $anz;
    } // end public function query */
    
    /**
     * Einfaches ausführen einer nicht select query
     * 
     * @param string $sql            
     * @throws LibDb_Exception
     * @return boolean
     */
    public function exec($sql)
    {
        if (Log::$levelDebug)
            Log::debug('EXEC SQL: '.$sql);
        
        if ($this->protocol)
            $this->protocol->write($sql);
        
        if (! is_resource($this->connectionWrite)) {
            Log::error('Lost Connection to the Database!!! Try to reconnect');
            $this->connect();
        }
        
        if (! $this->result = pg_query($this->connectionWrite, (string)$sql)) {
            // false alarm?!
            if (! $error = pg_last_error($this->connectionWrite)) {
                throw new LibDb_Exception('Query Failed, but Postgres returned no error! query: '.$sql );
            }
            
            throw new LibDb_Exception('Query Failed: '.$error.' '.$sql. implode(' : ', $this->conf));
        }
        
        return true;
    } // end public function exec */
    
    /**
     * execute a sql
     *
     * @param string $sql
     *            sql als string
     * @throws LibDb_Exception
     * @return mixed
     */
    public function crud($sql, $insertId = null, $table = null)
    {
        if ($this->protocol)
            $this->protocol->write($sql);
        
        if (! $this->result = pg_query($this->connectionWrite, $sql)) {
            Error::addError('Query Failed: '.pg_last_error($this->connectionWrite), 'LibDb_Exception');
        }
        
        if (! $insertId) {
            return pg_affected_rows($this->result);
        } else {
            
            if (! $this->result = pg_query($this->connection, 'select currval(\''.strtolower($table).'_'.strtolower($insertId).'_seq\')')) {
                
                Error::addError(I18n::s('failed to get the new id from the sequence'), 'LibDb_Exception');
            }
            
            if (! $row = pg_fetch_assoc($this->result)) {
                Error::addError(I18n::s('failed to get the new id from the sequence'), 'LibDb_Exception');
            }
            
            return $row['currval'];
        }
    } // end public function crud */
    
    /**
     * eine ddl query ausführen
     *
     * @param string $sql            
     * @return null oder fehlermeldung
     */
    public function ddlQuery($sql)
    {
        if ($this->protocol)
            $this->protocol->write($sql);
        
        if (! is_resource($this->connectionWrite)) {
            Log::error('Lost Connection to the Database!!! Try to reconnect');
            $this->connect();
        }
        
        if (! $this->result = pg_query($this->connectionWrite, $sql))
            return pg_last_error($this->connectionWrite);
        
        else
            return null;
    } // end public function ddlQuery */
    
    /**
     * Funktion zum einfachen durchleiten einer logquery in die Datenbank
     * 
     * @param string $sql            
     */
    public function logQuery($sql)
    {
        pg_send_query($this->connectionWrite, $sql);
    } // end public function logQuery */
    
////////////////////////////////////////////////////////////////////////////////
// getter for meta data
////////////////////////////////////////////////////////////////////////////////
    
    /**
     * Meldungen des Datenbanksystems abfragen
     * 
     * @param boolean $write            
     * @return string
     */
    public function getNotice($write = true)
    {
        if ($write)
            return pg_last_notice($this->connectionWrite);
        else
            return pg_last_notice($this->connectionRead);
    } // end public function getNotice */
    
    /**
     * Fehlermeldungen des Datenbanksystems abfragen
     * 
     * @param boolean $write            
     * @return string
     */
    public function getError($write = true)
    {
        if ($write)
            return pg_last_error($this->connectionWrite);
        else
            return pg_last_error($this->connectionRead);
    } // end public function getError */
    
    /**
     * Die Affected Rows der letzen Query erfragen
     *
     * @return int
     */
    public function getAffectedRows()
    {
        return pg_affected_rows($this->result);
    } // end public function getAffectedRows */
    
////////////////////////////////////////////////////////////////////////////////
// transactions
////////////////////////////////////////////////////////////////////////////////
    
    /**
     * Starten einer Transaktion
     * 
     * @param boolean $write            
     * @return
     *
     */
    public function begin($write = true)
    {
        Log::debug('DB Begin');
        
        if ($write) {
            if (! $this->result = pg_query($this->connectionWrite, 'BEGIN')) {
                Error::addError('Fehler beim ausführen von Begin: '.pg_last_error($this->connectionWrite), 'LibDb_Exception');
            }
        } else {
            if (! $this->result = pg_query($this->connectionRead, 'BEGIN')) {
                Error::addError('Fehler beim ausführen von Begin: '.pg_last_error($this->connectionRead), 'LibDb_Exception');
            }
        }
    } // end public function begin */
    
    /**
     * Transaktion wegen Fehler abbrechen
     * @return
     *
     */
    public function rollback($write = true)
    {
        Log::debug('DB Rollback');
        
        if ($write) {
            if (! $this->result = pg_query($this->connectionWrite, 'ROLLBACK')) {
                Error::addError('Fehler beim ausführen von Rollback: '.pg_last_error($this->connectionWrite), 'LibDb_Exception');
            }
        } else {
            if (! $this->result = pg_query($this->connectionRead, 'ROLLBACK')) {
                Error::addError('Fehler beim ausführen von Rollback: '.pg_last_error($this->connectionRead), 'LibDb_Exception');
            }
        }
    } // end public function rollback */
    
    /**
     * Transaktion erfolgreich Abschliesen
     *
     * @return
     *
     */
    public function commit($write = true)
    {
        Log::debug('DB Commit');
        
        if ($write) {
            if (! $this->result = pg_query($this->connectionWrite, 'COMMIT')) {
                Error::addError('Fehler beim ausführen von Commit: '.pg_last_error($this->connectionWrite), 'LibDb_Exception');
            }
        } else {
            if (! $this->result = pg_query($this->connectionRead, 'COMMIT')) {
                Error::addError('Fehler beim ausführen von Commit: '.pg_last_error($this->connectionRead), 'LibDb_Exception');
            }
        }
    } // end public function commit */
    
////////////////////////////////////////////////////////////////////////////////
// connection status
////////////////////////////////////////////////////////////////////////////////
    
    /**
     * Setzten des Aktiven Schemas
     *
     * @param
     *            string Schema Das aktive Schema
     * @return bool
     */
    public function setSearchPath($schema)
    {
        
        // Falsche Daten übergeben
        if (! is_string($schema))
            throw new LibDb_Exception('got wrong db type');
        
        if (Log::$levelDebug)
            Log::debug("Set Search_path $schema ");
        
        if (DEBUG) {
            Log::debug("PG: set search_path $schema ");
        }
        
        $sqlstring = 'SET search_path = "'.$schema.'", pg_catalog;';
        
        /*
         * if ($this->protocol) $this->protocol->write($sqlstring);
         */
        
        if ($this->clusterMode) {
            if (! $this->result = pg_query($this->connectionWrite, $sqlstring)) {
                // Fehlermeldung raus und gleich mal nen Trace laufen lassen
                Error::addError('got an error from the database: '.pg_last_error($this->connectionWrite), 'LibDb_Exception');
            }
        }
        
        if (! $this->result = pg_query($this->connectionRead, $sqlstring)) {
            
            Log::error('Failed to change schema');
            
            // Fehlermeldung raus und gleich mal nen Trace laufen lassen
            Error::addError('got an error from the database: '.pg_last_error($this->connectionRead), 'LibDb_Exception');
        }
        
        Log::debug('New schema is '.$schema);
        
        $this->schema = $schema;
        
        return true;
    } // end public function setSearchPath */
    
    /**
     * Den Status des Results Checken
     *
     * @return
     *
     */
    public function checkStatus()
    {
        $status = pg_result_status($this->result, PGSQL_STATUS_LONG);
        switch ($status) {
            case 'PGSQL_COMMAND_OK':
                {}
            case 'PGSQL_TUPLES_OK':
                {}
            case 'PGSQL_COPY_OUT':
                {}
            case 'PGSQL_COPY_IN':
                {
                    return false;
                    break;
                } // ENDE CASE
            
            case 'PGSQL_EMPTY_QUERY':
                {
                    return 'PG1';
                    break;
                } // ENDE CASE
            case 'PGSQL_BAD_RESPONSE':
                {
                    return 'PG2';
                    break;
                } // ENDE CASE
            case 'PGSQL_NONFATAL_ERROR':
                {
                    return 'PG3';
                    break;
                } // ENDE CASE
            case 'PGSQL_FATAL_ERROR':
                {
                    return 'PG4';
                    break;
                } // ENDE CASE
            
            default:
                {
                    return 'PG5';
                    break;
                } // ENDE DEFAULT
        } // ENDE SWITCH
    } // end public function checkStatus */
    
    /**
     * Erstellen einer Datenbankverbindung
     *
     * @param
     *            res Sql Ein Select Object
     * @return
     *
     */
    protected function connect()
    {
        if (isset($this->conf['quote']) && $this->conf['quote'] == 'multi')
            $this->quoteMulti = true;
        
        $pgsql_con_string = 'host='.$this->conf['dbhost'].' port='.$this->conf['dbport'].' dbname='.$this->conf['dbname'].' user='.$this->conf['dbuser'].' password='.$this->conf['dbpwd'];
        
        $this->dbUrl = $this->conf['dbhost'];
        $this->dbPort = $this->conf['dbport'];
        $this->databaseName = $this->conf['dbname'];
        $this->dbUser = $this->conf['dbuser'];
        $this->dbPwd = $this->conf['dbpwd'];
        
        if (Log::$levelConfig) {
            $pgsql_con_debug = 'host='.$this->conf['dbhost'].' port='.$this->conf['dbport'].' dbname='.$this->conf['dbname'].' user='.$this->conf['dbuser'].' password=******************';
            
            Log::config('DbVerbindungsparameter:'.$pgsql_con_debug);
        }
        
        if (! $this->connectionRead = pg_connect($pgsql_con_string)) {
            
            if (DEBUG) {
                throw new LibDb_Exception('Konnte Die Datenbank Verbindung nicht herstellen :'.pg_last_error().' '. $pgsql_con_string);
            } else {
                throw new LibDb_Exception('Konnte Die Datenbank Verbindung nicht herstellen.');
            }
            
        }
        
        $this->connectionWrite = $this->connectionRead;
        
        if ($this->schema) {
            $this->setSearchPath($this->schema);
        } elseif (isset($this->conf['dbschema'])) {
            $this->schema = $this->conf['dbschema'];
            $this->setSearchPath($this->conf['dbschema']);
        }
    } // end function connect */
    
    
    /**
     * Clonen der aktuellen Verbindung aber connection auf ein anderes schema
     * @return $newCon;
     *
     */
    public function cloneConnection($dbName, $schema)
    {

        $conf = $this->conf;
        $conf['dbname'] = $dbName;
        $conf['dbschema'] = $schema;
        
        $newCon = new LibDbPostgresql($conf);
        
        return $newCon;

    } // end function cloneConnection */

    /**
     * Schliesen der Datenbankverbindung
     *
     * @return void
     *
     */
    protected function dissconnect()
    {
        if (is_resource($this->connectionRead))
            pg_close($this->connectionRead);
        
        if (is_resource($this->connectionWrite))
            pg_close($this->connectionWrite);
    } // end protected function dissconnect */
    
    /**
     *
     * @return LibDbAdminPostgresql
     */
    public function getManager()
    {
        return new LibDbAdminPostgresql($this);
    } // end public function getManager */
    
    /**
     * @param string $schema            
     */
    public function reconnect($schema = null)
    {
        $this->dissconnect();
        
        if (isset($this->conf['quote']) && $this->conf['quote'] == 'multi')
            $this->quoteMulti = true;
        
        $pgsql_con_string = 'host='.$this->conf['dbhost'].' port='.$this->conf['dbport'].' dbname='.$this->conf['dbname'].' user='.$this->conf['dbuser'].' password='.$this->conf['dbpwd'];
        
        $this->databaseName = $this->conf['dbname'];
        
        
        if (DEBUG) {
            $pgsql_con_debug = 'host='.$this->conf['dbhost'].' port='.$this->conf['dbport'].' dbname=****************** user=****************** password=******************';
            
            Log::debug('PG: Constring '.$pgsql_con_debug);
        }
        
        if (! $this->connectionRead = pg_connect($pgsql_con_string)) {
            throw new LibDb_Exception('Konnte Die Datenbank Verbindung nicht herstellen :'.pg_last_error());
        }
        
        $this->connectionWrite = $this->connectionRead;
        
        if ($schema) {
            $this->setSearchPath($schema);
        } elseif ($this->schema) {
            $this->setSearchPath($this->schema);
        } elseif (isset($this->conf['dbschema'])) {
            $this->schema = $this->conf['dbschema'];
            $this->setSearchPath($this->conf['dbschema']);
        }
    }

    /**
     * Ändern des Schemas
     * @param string $schema            
     */
    public function switchSchema($schema = null)
    {
        if ($schema) {
            $this->setSearchPath($schema);
        } elseif ($this->schema) {
            $this->setSearchPath($this->schema);
        } else {
            $this->setSearchPath('public');
        }
    } // end public function switchSchema */
    
    /**
     * @param string $value
     * @return string
     * @deprecated use escape
     */
    public function addSlashes($value)
    {
        if (get_magic_quotes_gpc()) {
            $this->firstStripThenAddSlashes($value);
        } else {
            if (is_array($value)) {
                $tmp = [];
                
                foreach ($value as $key => $data)
                    $tmp[$key] = $this->escape($data);
                
                $value = $tmp;
            } else {
                $value = pg_escape_string($this->connectionWrite, $value);
            }
        }
        
        return $value;
    } // end public function addSlashes */
    
    /**
     * Sanititzen eines strings für die Datenbank
     *
     * @param string $value
     * @return
     *
     */
    public function escape($value)
    {
        if (get_magic_quotes_gpc()) {
            $this->firstStripThenAddSlashes($value);
        } else {
            if (is_array($value)) {
                $tmp = [];
                
                foreach ($value as $key => $data)
                    $tmp[$key] = $this->escape($data);
                
                $value = $tmp;
            } else {
                $value = pg_escape_string($this->connectionWrite, $value);
            }
        }
        
        return $value;
    } // end public function escape */
    
    /**
     * 
     * @param string $value
     * @return
     *
     */
    protected function firstStripThenAddSlashes($value)
    {
        if (is_array($value)) {
            
            $tmp = [];
            
            foreach ($value as $key => $data)
                $tmp[$key] = $this->firstStripThenAddSlashes($data);
            
            $value = $tmp;
        } else {
            
            $value = pg_escape_string($this->connectionWrite, stripslashes($value));
        }
        
        return $value;
    } // end protected function firstStripThenAddSlashes */
    
} //end class LibDbPostgresql

