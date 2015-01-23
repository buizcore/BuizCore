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
 * Sammlet Nachrichten aus verschiedenen Quellen. Mögliche Typen sind allgemeine Nachrichten,
 * Warnungen, Fehler und ein Protokoll mit dem Nachrichten in einen Kontext, bzw. mit einer Entität
 * in Verbindung gebracht werden können.
 * 
 * @package net.webfrap
 */
class LibResponseCollector extends LibResponse
{

  /**
   * Puffer für ankommende Nachrichten
   * @var array
   */
  public $message = [];

  /**
   * Puffer für ankommende Warnungen
   * @var array
   */
  public $warning = [];

  /**
   * Puffer für ankommende Fehler
   * @var array
   */
  public $error = [];

  /**
   * Puffer für alle Ereignisse die protokolliert werden
   * @var array
   */
  public $protocol = [];
  
  public $counter = 0;

  /**
   * Fügt eine neue Nachricht zu den Nachrichten hinzu
   * @param string $message
   */
  public function addMessage ($message)
  {
    $this->counter ++;
    $this->message[] = "Action " . $this->counter . " " . $message;
  }

  /**
   * Fügt eine neue Warnung zu den Warnungen hinzu
   * @param string $warning
   */
  public function addWarning ($warning)
  {
    $this->counter ++;
    $this->warning[] = "Action " . $this->counter . " " . $warning;
  }

  /**
   * Fügt einen neuen Fehler zu den Fehlern hinzu
   * @param string $error
   */
  public function addError ($error)
  {
    $this->counter ++;
    $this->error[] = "Action " . $this->counter . " " . $error;
  }

  /**
   * Globale Protokollierung der Nachrichten.
   * 
   * @param string $message
   * @param string $context
   * @param Entity $entity
   * @param string $mask
   */
  public function protocol ($message, $context, $entity = null, $mask = null)
  {

    $protocol = array(
        $message, 
        $context,
        $entity,
        $mask
    );
    
    $this->protocol[] = $protocol;
  }
}