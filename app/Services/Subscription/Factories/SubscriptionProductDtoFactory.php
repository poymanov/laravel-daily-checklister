<?php

namespace App\Services\Subscription\Factories;

use App\Services\Subscription\Dtos\SubscriptionProductDto;
use Stripe\Product;

class SubscriptionProductDtoFactory
{
    /**
     * @param Product $product
     *
     * @return SubscriptionProductDto
     */
    public static function createFromModel(Product $product): SubscriptionProductDto
    {
        $dto       = new SubscriptionProductDto();
        $dto->id   = $product->id;
        $dto->name = $product->name;

        return $dto;
    }
}
