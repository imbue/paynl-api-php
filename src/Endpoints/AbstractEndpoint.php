<?php

namespace Imbue\Paynl\Endpoints;

use Imbue\Paynl\Exceptions\ApiException;
use Imbue\Paynl\Resources\AbstractResource;
use Imbue\Paynl\Resources\Collections\AbstractCollection;
use Imbue\Paynl\Resources\ResourceFactory;
use Imbue\Paynl\PaynlClient;
use InvalidArgumentException;

abstract class AbstractEndpoint
{
    protected const REST_READ = PaynlClient::HTTP_GET;
    protected const REST_LIST = PaynlClient::HTTP_GET;
    protected const REST_CREATE = PaynlClient::HTTP_POST;
    protected const REST_UPDATE = PaynlClient::HTTP_PATCH;
    protected const REST_DELETE = PaynlClient::HTTP_DELETE;

    /** @var PaynlClient */
    protected $client;
    /** @var string */
    protected $resourcePath;
    /** @var string */
    protected $singleResourceKey;
    /** @var string */
    protected $listResourceKey;
    /** @var string */
    protected $parentId;

    /**
     * AbstractEndpoint constructor.
     * @param PaynlClient $client
     */
    public function __construct(PaynlClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param array $filters
     * @return string
     */
    protected function buildQueryString(array $parameters)
    {
        if (empty($parameters)) {
            return '';
        }

        return '?' . http_build_query($parameters, '', '&');
    }

    /**
     * @param array $body
     * @return AbstractResource
     * @throws ApiException
     */
    protected function restCreate(array $body)
    {
        $result = $this->client->performHttpCall(
            self::REST_CREATE,
            $this->getResourcePath(),
            $this->parseRequestBody($body)
        );

        return ResourceFactory::createFromApiResult($result, $this->getResourceObject(), $this->getSingleResourceKey());
    }

    /**
     * @param array $body
     * @return AbstractCollection
     * @throws ApiException
     */
    protected function restCreateCollection(array $body)
    {
        $result = $this->client->performHttpCall(
            self::REST_CREATE,
            $this->getResourcePath(),
            $this->parseRequestBody($body)
        );

        /** @var AbstractCollection $collection */
        $collection = $this->getResourceCollectionObject();

        if (is_object($result)) {
            $result = $result->{$collection->getCollectionResourceName()};
        }

        foreach ($result as $dataResult) {
            $collection[] = ResourceFactory::createFromApiResult($dataResult, $this->getResourceObject());
        }

        return $collection;
    }

    /**
     * @param       $id
     * @param array $filters
     * @return AbstractResource
     * @throws ApiException
     */
    protected function restRead($id, array $parameters): AbstractResource
    {
        if (empty($id)) {
            throw new ApiException('Invalid resource id.');
        }

        $id = urlencode($id);

        $result = $this->client->performHttpCall(
            self::REST_READ,
            "{$this->getResourcePath()}/{$id}" . $this->buildQueryString($parameters)
        );

        return ResourceFactory::createFromApiResult($result, $this->getResourceObject(), $this->getSingleResourceKey());
    }

    /**
     * @param       $id
     * @param array $body
     * @return AbstractResource|null
     * @throws ApiException
     */
    protected function restDelete($id, array $body = []): ?AbstractResource
    {
        if (empty($id)) {
            throw new ApiException('Invalid resource id.');
        }

        $id = urlencode($id);

        $result = $this->client->performHttpCall(
            self::REST_DELETE,
            "{$this->getResourcePath()}/{$id}",
            $this->parseRequestBody($body)
        );

        if ($result === null) {
            return null;
        }

        return ResourceFactory::createFromApiResult($result, $this->getResourceObject());
    }

    /**
     * @param array $filters
     * @return AbstractCollection
     * @throws ApiException
     */
    protected function restList(array $parameters = []): AbstractCollection
    {
        $apiPath = $this->getResourcePath();

        if (count($parameters)) {
            $apiPath .= $this->buildQueryString($parameters);
        }

        $result = $this->client->performHttpCall(self::REST_LIST, $apiPath);

        /** @var AbstractCollection $collection */
        $collection = $this->getResourceCollectionObject();

        if (is_object($result)) {
            $result = $result->{$collection->getCollectionResourceName()};
        }

        foreach ($result as $dataResult) {
            $collection[] = ResourceFactory::createFromApiResult($dataResult, $this->getResourceObject());
        }

        return $collection;
    }

    /**
     * @return mixed
     */
    abstract protected function getResourceObject();

    /**
     * @return string
     * @throws ApiException
     */
    public function getResourcePath()
    {
        if (strpos($this->resourcePath, '/{}/') !== false) {
            list($parentResource, $childResource) = explode('/{}/', $this->resourcePath, 2);
            if (empty($this->parentId)) {
                throw new ApiException("Subresource '{$this->resourcePath}' used without parent '$parentResource' ID.");
            }
            return "$parentResource/{$this->parentId}/$childResource";
        }
        return $this->resourcePath;
    }

    /**
     * @return string
     */
    protected function getSingleResourceKey()
    {
        return $this->singleResourceKey;
    }

    /**
     * @return string
     */
    protected function getListResourceKey()
    {
        return $this->listResourceKey;
    }

    /**
     * @param array $body
     * @return null|string
     * @throws ApiException
     */
    protected function parseRequestBody(array $body)
    {
        if (empty($body)) {
            return null;
        }

        try {
            $encoded = \GuzzleHttp\json_encode($body);
        } catch (InvalidArgumentException $e) {
            throw new ApiException("Error encoding parameters into JSON: '" . $e->getMessage() . "'");
        }

        return $encoded;
    }

    protected function getSlCode(): string
    {
        $code = $this->client->getSlCode();

        if (!$code) {
            throw new ApiException('You have not set a SL code.');
        }

        return urlencode($code);
    }
}
