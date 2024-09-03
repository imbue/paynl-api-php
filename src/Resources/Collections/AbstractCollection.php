<?php

namespace Imbue\Paynl\Resources\Collections;

use ArrayObject;

abstract class AbstractCollection extends ArrayObject
{
    public int $total;
    public array $_links;

    /**
     * @return string|null
     */
    abstract public function getCollectionResourceName();
}
