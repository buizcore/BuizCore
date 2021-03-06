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
 * Basisklasse für System Nachrichten
 *
 * Diese Klasse enthält nur die nötigsten Information welche zum versenden
 * einer Nachricht benötigt werden.
 *
 * Alle andere Informationen sind direkt im Versandweg oder dem Message Provider
 * zu entnehmen
 *
 * @package net.buiz
 */
class LibMessageEnvelop
{

  /**
   * Die Person welche die Nachricht geschickt hat
   *
   * @var BuizRoleUser_Entity
   */
  public $sender = null;

  /**
   * Die Adresse für den Empfänger, abhängig vom Channel type
   * @var string
   */
  public $receiver = null;

  /**
   * Das Subjekt der Nachricht
   * @var string
   */
  public $subject = null;

  /**
   * Pfad zum Master Template der Nachricht
   * @var string
   */
  public $htmlContent = null;

  /**
   * Pfad zum Template für die Nachricht
   * @var string
   */
  public $textContent = null;

  /**
   * PGP Keyfile wenn vorhanden
   * @var int
   */
  public $keyFile = null;

  /**
   * Stack Objekt zum zusammenfassen einer Message
   * @var LibMessageStack $msgStack
   */
  public $stack = null;

/*////////////////////////////////////////////////////////////////////////////*/
// Construct
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param LibMessageStack $msgStack
   */
  public function __construct($msgStack, $receiver)
  {

    $this->stack = $msgStack;
    $this->receiver = $receiver;

  }//end public function __construct */

} // end class LibMessageEnvelop

