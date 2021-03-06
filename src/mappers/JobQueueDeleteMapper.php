<?php
declare(strict_types=1);
namespace mcorten87\rabbitmq_api\mappers;

use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobQueueDelete;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;

class JobQueueDeleteMapper extends BaseMapper
{
    protected function mapMethod() : Method
    {
        return new Method(Method::DELETE);
    }

    /**
     * @param JobQueueDelete $job
     * @return Url
     */
    protected function mapUrl(JobBase $job) : Url
    {
        return new Url('queues/'
            .urlencode((string)$job->getVirtualhost())
            .'/'.urlencode((string)$job->getQueueName()));
    }
}
