<?php
/**
 * Created by PhpStorm.
 * User: mathijs
 * Date: 23-11-16
 * Time: 21:51
 */

namespace mcorten87\rabbitmq_api\test\unit\jobs;


use mcorten87\rabbitmq_api\jobs\JobBindingListAll;
use mcorten87\rabbitmq_api\mappers\JobBindingListAllMapper;
use mcorten87\rabbitmq_api\MqManagementConfig;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Password;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\objects\User;
use PHPUnit\Framework\TestCase;

class JobBindingListALlMapperTest extends TestCase
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
        $user = new User('!!@#$%^&*()-=[]\'\;/.,mM<user');
        $password = new Password('!@#$%^&*()-=[]\'\;/.,mM<password');

        $this->config = new MqManagementConfig($user, $password, $url);

        parent::__construct($name, $data, $dataName);
    }


    public function testMap() {
        $mapper = new JobBindingListAllMapper($this->config);

        $mapResult = $mapper->map(new JobBindingListAll());

        $url = 'bindings';

        $this->assertEquals(Method::METHOD_GET, $mapResult->getMethod()->getValue());
        $this->assertEquals($url, $mapResult->getUrl()->getValue());
    }
}