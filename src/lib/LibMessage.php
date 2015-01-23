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
 * @package net.webfrap
 */
class LibMessage extends PBase
{

  /**
   * Die Person welche die Nachricht geschickt hat
   *
   * @var WbfsysRoleUser_Entity
   */
  public $sender = null;

  /**
   * Array mit Empfängern
   * @var array<WbfsysRoleUser_Entity>
   */
  public $receivers = [];

  /**
   * Das Subjekt der Nachricht
   * @var string
   */
  public $subject = null;

  /**
   * Inhalt der Nachricht
   * @var string
   */
  public $content = null;

  /**
   * Dateien die der Nachricht angehängt werden sollen
   * @var array<name:WbfsysFile_Entity>
   */
  public $attachments = [];

  /**
   * Nachrichten Kanäle über welche die Nachricht versandt wird
   * @var array<string>
   */
  public $channels = [];

  /**
   * Template für die Nachricht
   * @var string
   */
  public $template = null;

} // end class LibMessage

