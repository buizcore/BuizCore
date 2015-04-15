<?php
/*******************************************************************************
*
* @author      : Enrico Hofmann <e.hofmann@buizcore.com>
* @date        :
* @copyright   : BuizCore GmbH <contact@buizcore.com>
* @project     : BuizCore, The core business application plattform
* @projectUrl  : http://buizcore.com
*
* @licence     : BuizCore.com internal only
*
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/

LibVendorAmqplib::load();

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

class BuizcoreAmqpClient
{

    /**
     * @var BuizcoreAmqpConfig
     */
    private $conf;

    /**
     * @var string
     */
    private $mode;

    /**
     * @var AMQPConnection
     */
    private $connection;

    /**
     * @var AMQPChannel
     */
    private $channel;
    private $callback_queue;
    private $response;
    private $corr_id;
    
    /**
     * @var string
     */
    protected $queueName = '';

    /**
     * @param array $config
     * @param string|null $queueName
     * @param string|null  $mode
     * @throws Exception
     */
    function __construct($config, $queueName = null, $mode = BuizcoreAmqpClientType::BACKGROUND)
    {


        if (!isset($queueName) || empty($queueName) && empty($this->queueName))
            throw new InternalError_Exception("There is no queue name defined");

        $this->conf = (object)$config;
        $this->queueName = $queueName;
        $this->mode = $mode;
        $this->connect();
        
    }//end function __construct */
    
    /**
     * 
     */
    private function connect()
    {
        $this->connection = new AMQPConnection($this->conf->host, $this->conf->port, $this->conf->user, $this->conf->passwd, $this->conf->vhost);
        $this->channel = $this->connection->channel();
        switch ($this->mode) {
            case BuizcoreAmqpClientType::RPC:
                list($this->callback_queue, ,) = $this->channel->queue_declare("", false, false, true, false);
                $this->channel->basic_consume($this->callback_queue, '', false, false, false, false, array($this, "onResponse"));
                break;
            case BuizcoreAmqpClientType::BACKGROUND:
                $this->channel->queue_declare($this->queueName, false, true, false, false);
                break;
            default:
                throw(new InternalError_Exception("Can not establish connection, client mode is not defined"));
                break;
        }
    }

    /**
     * 
     */
    public function onResponse($rep)
    {
        if ($rep->get("correlation_id") == $this->corr_id) {
            $this->response = $rep->body;
        }
    }

    /**
     * @param string $n
     * @return string | null
     */
    public function call($n)
    {
        $this->response = null;
        $this->corr_id = uniqid();

        $msg = new AMQPMessage((string)$n, array('correlation_id' => $this->corr_id, 'reply_to' => $this->callback_queue));
        $this->channel->basic_publish($msg, '', $this->queueName);

        if ($this->mode == BuizcoreAmqpClientType::RPC) {
            

            file_put_contents( PATH_GW.'/tmp/rpc-'.date('YmdHis').'.txt', date('YmdHis'));
            while (!$this->response) {
                $this->channel->wait();
            }
            return json_decode($this->response) ;
        }
    }
}