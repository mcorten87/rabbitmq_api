<?php
namespace mcorten87\rabbitmq_api\test\unit\jobs;

use mcorten87\rabbitmq_api\jobs\JobExchangeList;
use mcorten87\rabbitmq_api\jobs\JobExchangeListVirtualHost;
use mcorten87\rabbitmq_api\jobs\JobExchangePublish;
use mcorten87\rabbitmq_api\mappers\JobExchangeListMapper;
use mcorten87\rabbitmq_api\mappers\JobExchangeListVirtualHostMapper;
use mcorten87\rabbitmq_api\mappers\JobExchangePublishMapper;
use mcorten87\rabbitmq_api\MqManagementConfig;
use mcorten87\rabbitmq_api\objects\DeliveryMode;
use mcorten87\rabbitmq_api\objects\ExchangeName;
use mcorten87\rabbitmq_api\objects\Message;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Password;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\objects\User;
use mcorten87\rabbitmq_api\objects\VirtualHost;
use PHPUnit\Framework\TestCase;

class JobExchangePublishMapperTest extends TestCase
{

    /** @var  MqManagementConfig */
    private $config;

    /**
     * MqManagementFactoryTest constructor.
     * setUp gets called after the datapProvicers, in this case it is not good enough
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        $url = new Url('http://localhost:15672/api/');
        $user = new User('user');
        $password = new Password('password');

        $this->config = new MqManagementConfig($user, $password, $url);

        parent::__construct($name, $data, $dataName);
    }


    public function testBasicJob() {
        $virtualHost = new VirtualHost('/t!@#$%^&*()-=[]\'\;/.,mest/');
        $exchangeName = new ExchangeName('t!@#$%^&*()-=[]\'\;/.,mest');
        $message = new Message('test @#$!#!@#*("^t7u575434ter(&*){{;/./.');
        $deliveryMethod = new DeliveryMode(DeliveryMode::PERSISTENT);
        $job = new JobExchangePublish($virtualHost, $exchangeName, $message, $deliveryMethod);

        $mapper = new JobExchangePublishMapper($this->config);
        $mapResult = $mapper->map($job);

        $this->assertEquals(Method::POST, $mapResult->getMethod()->getValue());
        $this->assertEquals('exchanges/'.urlencode($virtualHost).'/'.urlencode($exchangeName).'/publish', $mapResult->getUrl());

        $body = $mapResult->getConfig()['json'];
        $this->assertEquals((string)$message, $body['payload']);
    }
}