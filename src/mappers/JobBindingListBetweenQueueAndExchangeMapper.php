<?php

namespace mcorten87\rabbitmq_api\mappers;

use mcorten87\rabbitmq_api\exceptions\WrongArgumentException;
use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobBindingListBetweenQueueAndExchange;
use mcorten87\rabbitmq_api\jobs\JobBindingListExchange;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\services\MqManagementConfig;

class JobBindingListBetweenQueueAndExchangeMapper  extends BaseMapper
{

    /**
     * @return Method
     */
    protected function mapMethod() : Method {
        return new Method(Method::METHOD_GET);
    }

    /**
     * @param JobBindingListBetweenQueueAndExchange $job
     * @return Url
     */
    protected function mapUrl(JobBase $job) : Url {
        if (!$job instanceof JobBindingListBetweenQueueAndExchange) {
            throw new WrongArgumentException($job, JobBindingListBetweenQueueAndExchange::class);
        }

        $url = 'bindings';
        $url .= sprintf('/%1$s', urlencode($job->getVirtualHost()));
        $url .= sprintf('/%1$s', urlencode($job->getQueueName()));
        $url .= sprintf('/%1$s', urlencode($job->getExchangeName()));
        return new Url($url);
    }
}