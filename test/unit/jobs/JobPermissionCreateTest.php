<?php
namespace mcorten87\rabbitmq_api\test\unit\jobs;

use mcorten87\rabbitmq_api\jobs\JobPermissionCreate;
use mcorten87\rabbitmq_api\objects\User;
use mcorten87\rabbitmq_api\objects\VirtualHost;
use PHPUnit\Framework\TestCase;

class JobPermissionCreateTest extends TestCase
{
    /**
     * Tests if the dependency injection in the constructor works
     */
    public function testDependencyInjection()
    {
        $user = new User('test');
        $virtualHost = new VirtualHost('/test/');

        $job = new JobPermissionCreate($virtualHost, $user);

        $this->assertEquals($user, $job->getUser());
        $this->assertEquals($virtualHost, $job->getVirtualHost());
    }
}
