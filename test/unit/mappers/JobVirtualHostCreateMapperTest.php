<?php
namespace mcorten87\rabbitmq_api\test\unit\jobs;

use mcorten87\rabbitmq_api\jobs\JobVirtualHostCreate;
use mcorten87\rabbitmq_api\mappers\JobVirtualHostCreateMapper;
use mcorten87\rabbitmq_api\MqManagementConfig;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Password;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\objects\User;
use mcorten87\rabbitmq_api\objects\VirtualHost;
use PHPUnit\Framework\TestCase;

class JobVirtualHostCreateMapperTest extends TestCase
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
        $user = new User('u@#$%^&*()-=[]\'\;/.,ser');
        $password = new Password('passw@#$%^&*()-=[]\'\;/.,ord');

        $this->config = new MqManagementConfig($user, $password, $url);

        parent::__construct($name, $data, $dataName);
    }


    public function testBasicJob() {
        $virtualHost = new VirtualHost('/te@#$%^&*()-=[]\'\;/.,st/');
        $job = new JobVirtualHostCreate($virtualHost);

        $mapper = new JobVirtualHostCreateMapper($this->config);
        $mapResult = $mapper->map($job);

        $this->assertEquals(Method::PUT, $mapResult->getMethod()->getValue());
        $this->assertEquals('vhosts/'.urlencode($virtualHost), $mapResult->getUrl());
    }
}
