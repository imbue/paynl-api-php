<?php

namespace Imbue\Paynl\Endpoints;

use Imbue\Paynl\Exceptions\ApiException;
use Imbue\Paynl\Resources\Collections\PaymentMethodCollection;
use Imbue\Paynl\Resources\GenericStatus;
use Imbue\Paynl\Resources\PaymentMethod;
use Imbue\Paynl\Resources\ResourceFactory;

class PaymentMethodEndpoint extends AbstractEndpoint
{
    /** @var string */
    protected $resourcePath = 'paymentmethods';

    /**
     * @return PaymentMethod
     */
    protected function getResourceObject(): PaymentMethod
    {
        return new PaymentMethod($this->client);
    }

    /**
     * @param $previous
     * @param $next
     * @return PaymentMethodCollection
     */
    protected function getResourceCollectionObject(): PaymentMethodCollection
    {
        return new PaymentMethodCollection($this->client);
    }

    /**
     * @param $id
     * @return PaymentMethod
     * @throws ApiException
     */
    public function get($id)
    {
        return $this->restRead($id, []);
    }

    /**
     * @return PaymentMethodCollection
     * @throws ApiException
     */
    public function list()
    {
        return $this->restList();
    }

    /**
     * @param array $data
     * @return PaymentMethod
     * @throws ApiException
     */
    public function create(array $data = [])
    {
        return $this->restCreate($data);
    }

    /**
     * @param array $data
     * @return GenericStatus
     * @throws ApiException
     */
    public function cancel(string $id)
    {
        $result = $this->client->performHttpCall(
            self::REST_CREATE,
            "{$this->getResourcePath()}/{$id}/cancel",
            $this->parseRequestBody([])
        );

        return ResourceFactory::createFromApiResult($result, new GenericStatus($this->client));
    }
}
