<?php

namespace mcorten87\rabbitmq_api\mappers;


use mcorten87\rabbitmq_api\jobs\JobBase;
use mcorten87\rabbitmq_api\jobs\JobVirtualHostDelete;
use mcorten87\rabbitmq_api\objects\Method;
use mcorten87\rabbitmq_api\objects\Url;
use mcorten87\rabbitmq_api\services\MqManagementConfig;

class JobVirtualHostDeleteMapper extends BaseMapper
{

    /**
     * @param JobVirtualHostDelete $job
     * @return Method
     */
    protected function mapMethod() : Method {
        return new Method(Method::DELETE);
    }

    /**
     * @param JobVirtualHostDelete $job
     * @return Url
     */
    protected function mapUrl(JobBase $job) : Url {
        return new Url('vhosts/'.urlencode($job->getVirtualHost()));
    }
}
