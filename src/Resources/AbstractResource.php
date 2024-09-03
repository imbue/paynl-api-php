<?php

namespace Imbue\Paynl\Resources;

use Imbue\Paynl\PaynlClient;

abstract class AbstractResource
{
    /** @var PaynlClient */
    protected $client;

    /**
     * @param PaynlClient $client
     */
    public function __construct(PaynlClient $client)
    {
        $this->client = $client;
    }
}
