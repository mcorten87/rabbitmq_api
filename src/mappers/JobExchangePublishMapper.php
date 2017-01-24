<?php

namespace mcorten87\rabbitmq_api\mappers;

use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobExchangeDelete;
use mcorten87\rabbitmq_api\jobs\JobExchangeList;
use mcorten87\rabbitmq_api\jobs\JobExchangePublish;
use mcorten87\rabbitmq_api\jobs\JobUserList;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\services\MqManagementConfig;

class JobExchangePublishMapper  extends BaseMapper
{

    protected function mapMethod() : Method {
        return new Method(Method::METHOD_POST);
    }

    /**
     * @param JobExchangeDelete $job
     * @return Url
     */
    protected function mapUrl(JobBase $job) : Url {
        if (!$job instanceof JobExchangePublish) {
            throw new WrongArgumentException($job, JobExchangePublish::class);
        }

        $url = 'exchanges';
        $url .= '/'.urlencode($job->getVirtualHost());
        $url .= '/'.urlencode($job->getExchangeName());
        $url .= '/publish';
        return new Url($url);
    }

    /**
     * @param JobExchangePublish $job
     * @return array
     */
    protected function mapConfig(JobBase $job) : array {
        $body = [
            'payload' => (string)$job->getMessage(),
            'payload_encoding' => 'string', // TODO
            'routing_key' => (string)$job->getRoutingKey(),
            'properties' => [
                'delivery_mode' =>  (int)$job->getDeliveryMode(),
                'headers' => []         // TODO
            ]
        ];

        return array_merge(parent::mapConfig($job), [
            'json'      =>  $body,
        ]);
    }
}