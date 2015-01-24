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

/*
* Mail Header:
*
* To                                      (X)
* Subject                                 (X)
* User-Agent                              (X)
* MIME-Version                            (X)
* Content-Type                            (X)
* From                                    (X)
* Cc
* Bcc
* X-Priority                              (X)
* Importance                              (X)
* Content-Class
* Content-Transfer-Encoding               (X)
* Content-Disposition                     (X)
* Content-Description (bei Anhaengen)     (X)
* Reply-To                                (X)
* Return-Path                             (X)
*
* Received
* Delivered-To
* Message-ID
*
*/

/**
 * @package net.buiz
 *
 * @todo Festlegen was passiert wenn sowohl mehrere Empfänger als auch
 * BBC und CC angegeben werden
 *
 */
class LibMessageInternalMessage extends LibMessageAdapter
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Das New Line Format das in den Messages verwendet wird   *
   */
  const NL = "\n";


/*////////////////////////////////////////////////////////////////////////////*/
// Getter and Setter
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param String $address
   * @param String $sender
   */
  public function __construct($address = null, $sender = null)
  {

    if ($address) {
      $this->address = $address;
    }

    if ($sender) {

      $this->sender = $sender;

    } else {

      $db = $this->getDb();
      $orm = $db->getOrm();

      $this->sender = $orm->get('BuizRoleUser', BuizCore::$env->getUser()->getid());
    }

  }//end public function __construct */


/*////////////////////////////////////////////////////////////////////////////*/
// Logic
/*////////////////////////////////////////////////////////////////////////////*/

  /**
   * Senden der Nachricht
   * @param LibMessageEnvelop $envelop
   * @return boolean
   */
  public function send($envelop)
  {

    $db = $this->getDb();
    $orm = $db->getOrm();

    // Variables
    if (!$envelop) {
      throw new LibMessage_Exception('Missing User Message ID');
    }

    if (!$envelop->receiver) {
      throw new LibMessage_Exception('Missing a receiver!');
    }

    $messageObj = $orm->newEntity('BuizMessage');
    $msgReceiver = $orm->newEntity('BuizMessageReceiver');

    $messageObj->title = $envelop->subject;

    if ($envelop->htmlContent)
      $messageObj->message = $envelop->htmlContent;

    if ($envelop->textContent)
      $messageObj->text_message = $envelop->htmlContent;

    // Header
    $messageObj->id_sender = $envelop->stack->sender->userId;
    $messageObj->flag_sender_deleted = 0;
    $messageObj->id_sender_status = EMessageStatus::IS_NEW;
    $messageObj->confidential = $envelop->stack->confidential;

    $messageObj->priority = $envelop->stack->priority
      ? $envelop->stack->priority
      : EPriority::MEDIUM;

    if ($messageObj->priority && 10 > $messageObj->priority)
      $messageObj->priority = $messageObj->priority * 10;


    $messageObj->stack_id = $envelop->stack->stackId;

    $messageObj->message_id = BuizCore::uuid();

    $db->begin();

    // speichern der Nachricht, und damit verschicken
    $orm->save($messageObj);


    $msgReceiver->id_message = $messageObj;
    $msgReceiver->status = EMessageStatus::IS_NEW;
    $msgReceiver->vid = $envelop->receiver->id;
    $msgReceiver->flag_hidden = false;
    $orm->save($msgReceiver);
  
    /* Auswerten der Aspekte */
    foreach ($envelop->stack->aspects as $aspect) {
      
      $msgAspect = $orm->newEntity('BuizMessageAspect');
      $msgAspect->id_receiver = $envelop->receiver->id;
      $msgAspect->id_message = $messageObj;
      $msgAspect->aspect = $aspect;
      $orm->save($msgAspect);
      
      // dem versender die gleichen aspekte zuweisen
      $msgAspect = $orm->newEntity('BuizMessageAspect');
      $msgAspect->id_receiver = $envelop->stack->sender->userId;
      $msgAspect->id_message = $messageObj;
      $msgAspect->aspect = $aspect;
      $orm->save($msgAspect);
    }

    if ($this->attachment || $this->embedded) {
      $entityObj = $orm->getByKey('BuizEntity', 'buiz_message');
    }

    foreach ($this->attachment as $attachment) {
      
      $attachmentObj = $orm->newEntity('BuizEntityAttachment');

      $attachmentObj->vid = $messageObj;
      $attachmentObj->id_file = $attachment;
      $attachmentObj->id_entity = $entityObj;
      $orm->save($attachmentObj);
      
    }
    
    // common copy
    foreach ($this->cc as $sendAlsoCC) {
      
      $receiverAlso = $orm->copy($msgReceiver);
      $receiverAlso->vid = $sendAlsoCC;
      $orm->save($receiverAlso);
      
      foreach ($envelop->stack->aspects as $aspect) {
      
        $msgAspect = $orm->newEntity('BuizMessageAspect');
        $msgAspect->id_message = $messageObj;
        $msgAspect->id_receiver = $sendAlsoCC;
        $msgAspect->aspect = $aspect;
        $orm->save($msgAspect);
      }
    }
    
    // blind copy
    foreach ($this->bbc as $sendAlsoBBC) {
      
      $receiverAlso = $orm->copy($msgReceiver);
      $receiverAlso->flag_hidden = true;
      $receiverAlso->vid = $sendAlsoCC;
      $orm->save($receiverAlso);
      
      foreach ($envelop->stack->aspects as $aspect) {
      
        $msgAspect = $orm->newEntity('BuizMessageAspect');
        $msgAspect->id_message = $messageObj;
        $msgAspect->id_receiver = $sendAlsoBBC;
        $msgAspect->aspect = $aspect;
        $orm->save($msgAspect);
      }
    }

    $db->commit();

  }//end protected function send */


} // end class LibMessageInternalMessage

