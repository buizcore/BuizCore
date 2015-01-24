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
 * Basisklasse für einen Nachrichten Channel
 *
 * Der Channel legt den Versandweg fest über den Nachrichten an Personen oder
 * sonstige Empfänger weiter geleitet werden.
 *
 * @package net.buiz
 */
abstract class LibMessageChannel
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Der Type des Message Channels
   * @var string
   */
  public $type = null;

  /**
   * Das Renderobjekt für den message Channel
   * @var LibMessageRenderer
   */
  protected $renderer = null;

  /**
   * Der Absender
   * @var LibMessageSender
   */
  protected $sender = null;

/*////////////////////////////////////////////////////////////////////////////*/
// Methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param User $user
   */
  public function setSender($user)
  {

    $this->sender = new LibMessageSender($user);

  }//end public function setSender */

  /**
   * @return LibMessageSender
   */
  public function getSender()
  {

    if (!$this->sender) {
      $this->sender = new LibMessageSender(BuizCore::$env->getUser());
    }

    return $this->sender;

  }//end public function getSender */

/*////////////////////////////////////////////////////////////////////////////*/
// Abstract Methodes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param LibMessageStack $message
   * @param array<rowid:<user,address>> $receivers Liste mit den Empfängern
   *
   * @return LibMessageStatistic Objekt mit den Informationen wieviele Nachrichten
   *  ausgeliefert werden konnten. Da wird Benutzer Objekte und keine Addressen übergeben
   *  kann es passieren das nicht für alle Benutzer Addressen vorhanden sind
   *  Diese Information kann den Statistic Objekt entnommen werden
   */
  abstract public function send($message, $receivers);

  /**
   * Das Renderobjekt für den aktuellen Channel laden / anfragen
   * Mit diesem Objekt wird der Inhalt der Nachricht in eine "Humanreadable" Form
   * gebracht.
   *
   * @return LibMessageRenderer
   */
  abstract public function getRenderer();

}// end LibMessageChannel

