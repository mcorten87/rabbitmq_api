<?php

namespace mcorten87\rabbitmq_api\jobs;

use mcorten87\rabbitmq_api\objects\ExchangeName;
use mcorten87\rabbitmq_api\objects\VirtualHost;

/**
 * Lists the details of a specific exchange
 */
class JobBindingListExchange extends JobBase
{
    /**
     * @var VirtualHost
     */
    private $virtualHost;

    /**
     * @var ExchangeName
     */
    private $exchangeName;


    /** @return VirtualHost */
    public function getVirtualHost() : VirtualHost
    {
        return $this->virtualHost;
    }

    /**
     * @return ExchangeName
     */
    public function getExchangeName(): ExchangeName
    {
        return $this->exchangeName;
    }

    public function __construct(VirtualHost $virtualHost, ExchangeName $exchangeName)
    {
        $this->virtualHost = $virtualHost;
        $this->exchangeName = $exchangeName;
    }
}
