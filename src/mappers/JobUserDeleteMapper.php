<?php
declare(strict_types=1);
namespace mcorten87\rabbitmq_api\mappers;


use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobUserDelete;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;

class JobUserDeleteMapper extends BaseMapper
{
    protected function mapMethod() : Method
    {
        return new Method(Method::DELETE);
    }


    /**
     * @param JobUserDelete $job
     * @return Url
     */
    protected function mapUrl(JobBase $job) : Url {
        $url = 'users';
        $url .= '/'.urlencode((string)$job->getUser());

        return new Url($url);
    }
}
