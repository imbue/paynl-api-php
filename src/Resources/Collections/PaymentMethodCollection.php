<?php

namespace Imbue\Paynl\Resources\Collections;

use Imbue\Paynl\Resources\PaymentMethod;

class PaymentMethodCollection extends AbstractCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return 'paymentMethods';
    }

    /**
     * @return PaymentMethod
     */
    protected function createResourceObject(): PaymentMethod
    {
        return new PaymentMethod($this->client);
    }
}
