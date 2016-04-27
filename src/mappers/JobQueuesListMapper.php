<?php

namespace mcorten87\messagequeue_management\mappers;


use mcorten87\messagequeue_management\jobs\JobBase;
use mcorten87\messagequeue_management\jobs\JobVirtualHostCreate;
use mcorten87\messagequeue_management\objects\MapResult;
use mcorten87\messagequeue_management\objects\Method;
use mcorten87\messagequeue_management\objects\Url;
use mcorten87\messagequeue_management\services\MqManagementConfig;

class JobQueuesListMapper  extends BaseMapper
{

    protected function mapMethod(JobBase $job) : Method {
    return new Method(Method::METHOD_GET);
}

    protected function mapUrl(JobBase $job) : Url {
        $url = 'queues';
        if ($job->getVirtualhost() !== null) {
            $url .= '/'.urlencode($job->getVirtualhost());
        }
        return new Url($url);
    }

    protected function mapConfig(JobBase $job) : array {
        return $config = [
            'auth'    => array($this->config->getUser(), $this->config->getPassword()),
        ];
    }
}
