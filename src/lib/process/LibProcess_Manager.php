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
class LibProcess_Manager extends Manager
{
/*////////////////////////////////////////////////////////////////////////////*/
// Attributes
/*////////////////////////////////////////////////////////////////////////////*/
  

    /**
     * Status eines Prozess Nodes setzen
     * 
     * @param Process $process
     * @param Entity $entity
     * @param string $keyNewPos
     */
    public function switchStatus($process, $entity, $keyNewPos)
    {
        
    }

    /**
     * Den aktuellen Status Key des Prozesses erfragen
     * 
     * @param Process $process
     * @param Entity $entity
     */
    public function getStatusKey($process, $entity)
    {
    
    }//end public function getStatusKey */
    
    
    /**
     * @var Process $process
     * @var string $startNodeName
     */
    public function initProcess($process, $startNodeName, $params = null)
    {
        
        $orm = $this->getOrm();

        // prüfen dass die entity vorhanden ist
        if (!$process->entity || !$process->entity->getId()) {
            throw new LibProcess_Exception('It\'s not possible to initialize a Process without a valid Entity');
        }
    
        $activStatus = new BuizProcessStatus_Entiy(true);
    
        // orm laden
        $activStatus->id_process = $process->processId;
        $activStatus->vid = $process->entity;
    
        $startNode = $this->getNodeByName($startNodeName);
    
        $activStatus->id_start_node = $startNode;
        $activStatus->id_last_node = $startNode;
        $activStatus->id_actual_node = $startNode;
        $activStatus->actual_node_key = $startNode->access_key;
        $activStatus->value_highest_node = $startNode->m_order;
        $activStatus->running_state = Process::STATE_RUNNING;
        $activStatus->state = '{}';
  
        $process->activStatus = $activStatus;
        $process->activKey = $startNodeName;
        $process->oldKey = $startNodeName;
        $process->statesData = new stdClass();
    
        $orm->insert($activStatus);
    
        if ($process->statusAttribute) {
            
            $process->entity->{$process->statusAttribute} = $startNode;
            $orm->save($process->entity);
            
        } else {
            Debug::console("GOT NO STATUS ATTRIBUTE?!");
        }
    
        $step = new BuizProcessStep_Entity(true);
        $step->id_to = $activStatus->id_actual_node;
        $step->id_process_instance = $activStatus;
        $step->comment = 'Process was initialized';
    
        $orm->insert($step);
    
    }//end public function initProcess */
    
    
    /**
     * Erfragen eines ProzessKnotens über den Namen
     *
     * @param string $name
     * @param Process $process
     * @return BuizProcessNode_Entity
     */
    public function getNodeByName($name, $process )
    {
        
        $orm = $this->getOrm();
    
        $node = $orm->get(
            'BuizProcessNode',
            "access_key='{$name}' and id_process={$process->processId}"
        );
    
        if (!$node)
            $node = $this->createProcessNode($name, $process);
    
        return $node;
    
    }//end protected function getNodeByName */
    
    /**    
     * Fehlende Nodes automatisch in der Datenbank anlegen
     * 
     * @param string $name
     * @param Process $process
     * @return BuizProcessNode_Entity
     */
    protected function createProcessNode($key, $process)
    {
    
        $orm = $this->getOrm();
        $node = $process->nodes[$key];
    
        $processNode = $orm->newEntity('BuizProcessNode');
        $processNode->access_key = $key;
        $processNode->label = $node['label'];
        $processNode->description = isset($node['description'])?$node['description']:'';
        $processNode->m_order = $node['order'];
        $processNode->id_process = $process->processId;
    
        $orm->insert($processNode);
    
        return $processNode;
    
    }//end protected function createProcessNode */
    
}//end class LibProcess_Manager

