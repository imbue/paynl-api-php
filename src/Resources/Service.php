<?php

namespace Imbue\Paynl\Resources;

class Service extends AbstractResource
{
    /** @var string */
    public $name;
    /** @var string */
    public $code;
    /** @var string */
    public $status;
    /** @var bool */
    public $testMode;
    /** @var array */
    public $translations;
    /** @var array */
    public $merchant;
    /** @var array */
    public $category;
    /** @var int */
    public $mcc;
    /** @var array */
    public $turnoverGroup;
    /** @var array */
    public $layout;
    /** @var array */
    public $tradeName;
    /** @var array */
    public $checkoutOptions;
    /** @var array */
    public $checkoutSequence;
    /** @var array */
    public $checkoutTests;

    public function getPaymentMethods(): array
    {
        $paymentMethods = [];

        foreach ($this->checkoutOptions as $checkoutOption) {
            foreach ($checkoutOption->paymentMethods as $paymentMethod) {
                $options = [];

                if (!empty($paymentMethod->options)) {
                    foreach ($paymentMethod->options as $option) {
                        $image = '';
                        if (isset($option->image)) {
                            $image = $option->image;
                        }
                        $options[] = [
                            'id' => $option->id,
                            'name' => $option->name,
                            'image' => $image,
                        ];
                    }
                }

                $paymentMethods[$paymentMethod->id] = [
                    'id' => $paymentMethod->id,
                    'name' => $paymentMethod->name,
                    'description' => $paymentMethod->description ?? '',
                    'translations' => $paymentMethod->translations,
                    'image' => $paymentMethod->image,
                    'minAmount' => $paymentMethod->minAmount,
                    'maxAmount' => $paymentMethod->maxAmount,
                    'options' => $options,
                ];
            }
        }

        return json_decode(json_encode($paymentMethods), true);
    }
}
