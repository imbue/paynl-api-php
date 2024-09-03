<?php

namespace Imbue\Paynl\Endpoints;

use Imbue\Paynl\Exceptions\ApiException;
use Imbue\Paynl\Resources\Collections\PaymentMethodCollection;
use Imbue\Paynl\Resources\GenericStatus;
use Imbue\Paynl\Resources\PaymentMethod;
use Imbue\Paynl\Resources\ResourceFactory;
use Imbue\Paynl\Resources\Service;

class ServiceConfigEndpoint extends AbstractEndpoint
{
    /** @var string */
    protected $resourcePath = 'services/config';

    /**
     * @return PaymentMethod
     */
    protected function getResourceObject(): Service
    {
        return new Service($this->client);
    }

    /**
     * @param $id
     * @return Service
     * @throws ApiException
     */
    public function get()
    {
        $result = $this->client->performHttpCall(
            self::REST_READ,
            "{$this->getResourcePath()}/{$this->getSlCode()}"
        );

        return ResourceFactory::createFromApiResult($result, $this->getResourceObject(), $this->getSingleResourceKey());
    }
}
