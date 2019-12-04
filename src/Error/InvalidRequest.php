<?php
declare(strict_types=1);

namespace Vms\Error;

class InvalidRequest extends Base
{
    public function __construct(
        $message,
        $vmsParam,
        $httpStatus = null,
        $httpBody = null,
        $jsonBody = null,
        $httpHeaders = null
    ) {
        parent::__construct($message, $httpStatus, $httpBody, $jsonBody, $httpHeaders);
        $this->vmsParam = $vmsParam;
    }

    public function getVmsParam()
    {
        return $this->vmsParam;
    }
}
