<?php
declare(strict_types=1);
namespace mcorten87\rabbitmq_api\mappers;


use mcorten87\rabbitmq_api\exceptions\WrongArgumentException;
use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobBindingToExchangeDelete;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\services\MqManagementConfig;

class JobBindingToExchangeDeleteMapper extends BaseMapper
{
    protected function mapMethod() : Method
    {
        return new Method(Method::DELETE);
    }

    /**
     * @param JobBindingToExchangeDelete $job
     * @return Url
     */
    protected function mapUrl(JobBase $job) : Url
    {
        if (!$job instanceof JobBindingToExchangeDelete) {
            throw new WrongArgumentException($job, JobBindingToExchangeDelete::class);
        }

        return new Url('bindings/'
            .urlencode((string)$job->getVirtualHost()).'/'
            .'e/'
            .urlencode((string)$job->getExchangeName()).'/'
            .$job->getDestinationType().'/'
            .urlencode((string)$job->getToExchange())
            .'/'.(!empty((string) $job->getRoutingKey()) ? (string) $job->getRoutingKey() : '~')
        );
    }

    /**
     * @param JobBindingToExchangeDelete $job
     * @return array
     */
    protected function mapConfig(JobBase $job) : array {
        if (!$job instanceof JobBindingToExchangeDelete) {
            throw new WrongArgumentException($job, JobBindingToExchangeDelete::class);
        }

        $body = [
            'destination'       => (string)$job->getToExchange(),
            'destination_type'  => $job->getDestinationType(),
            'properties_key'       => (string)$job->getRoutingKey(),
            'source'            => (string)$job->getExchangeName(),
            'vhost'             => $job->getVirtualHost(),
        ];

        return array_merge(parent::mapConfig($job), [
            'json'      =>  $body,
        ]);
    }
}
