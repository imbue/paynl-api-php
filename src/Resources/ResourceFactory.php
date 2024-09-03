<?php

namespace Imbue\Paynl\Resources;

class ResourceFactory
{
    /**
     * @param                  $apiResult
     * @param AbstractResource $resource
     * @param string|null      $resourceKey
     * @return AbstractResource
     */
    public static function createFromApiResult(
        $apiResult,
        AbstractResource $resource,
        ?string $resourceKey = null
    ): AbstractResource {
        if ($resourceKey) {
            $apiResult = $apiResult->{$resourceKey};
        }

        foreach ($apiResult as $property => $value) {
            if (!property_exists($resource, $property)) {
                continue;
            }

            $resource->{$property} = $value;
        }

        return $resource;
    }
}
