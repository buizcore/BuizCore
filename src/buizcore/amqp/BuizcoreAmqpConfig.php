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

class BuizcoreAmqpConfig
{
    /**
     * @var string
     */
    public $host;

    /**
     * @var int
     */
    public $port;

    /**
     * @var string
     */
    public $user;

    /**
     * @var string
     */
    public $passwd;

    /**
     * @var string
     */
    public $vhost;

    /**
     * @param string $host
     * @param string $user
     * @param string $pass
     * @param string $port
     * @param string $vhost
     */
    function __construct($host, $user = null, $passwd = null, $port = 5672, $vhost = null)
    {
        
        if (is_array($host)) {
            
            $this->host = $host['host'];
            $this->user = $host['user'];
            $this->passwd = $host['passwd'];
            
            if (isset($host['port']))
                $this->port = $host['port'];
            
            if (isset($host['vhost']))
                $this->vhost = $host['vhost'];
            
        } else {
            
            $this->host = $host;
            $this->user = $user;
            $this->passwd = $passwd;
            if (is_int($port))
                $this->port = $port;
            
            if (!is_null($vhost))
                $this->vhost = $vhost;
        }
        

    }


}