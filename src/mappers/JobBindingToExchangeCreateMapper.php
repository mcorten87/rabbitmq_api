<?php
declare(strict_types=1);
namespace mcorten87\rabbitmq_api\mappers;

use mcorten87\rabbitmq_api\exceptions\WrongArgumentException;
use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobBindingToExchangeCreate;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;

class JobBindingToExchangeCreateMapper extends BaseMapper
{
    protected function mapMethod() : Method
    {
        return new Method(Method::POST);
    }

    /**
     * @param JobBase $job
     * @return Url
     * @throws WrongArgumentException
     */
    protected function mapUrl(JobBase $job) : Url
    {
        if (!$job instanceof JobBindingToExchangeCreate) {
            throw new WrongArgumentException($job, JobBindingToExchangeCreate::class);
        }

        return new Url('bindings/'
            .urlencode((string)$job->getVirtualHost()).'/'
            .'e/'
            .urlencode((string)$job->getExchangeName()).'/'
            .$job->getDestinationType().'/'
            .urlencode((string)$job->getToExchange()));
    }

    /**
     * @param JobBase $job
     * @return array
     * @throws WrongArgumentException
     */
    protected function mapConfig(JobBase $job) : array
    {
        if (!$job instanceof JobBindingToExchangeCreate) {
            throw new WrongArgumentException($job, JobBindingToExchangeCreate::class);
        }

        $body = [
            'arguments'         => [],
            'destination'       => (string)$job->getToExchange(),
            'destination_type'  => $job->getDestinationType(),
            'routing_key'       => (string)$job->getRoutingKey(),
            'source'            => (string)$job->getExchangeName(),
            'vhost'             => $job->getVirtualHost(),
        ];

        return array_merge(parent::mapConfig($job), [
            'json'      =>  $body,
        ]);
    }
}
