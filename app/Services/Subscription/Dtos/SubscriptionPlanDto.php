<?php

namespace App\Services\Subscription\Dtos;

class SubscriptionPlanDto
{
    /** @var string */
    public string $id;

    /** @var int */
    public int $amount;

    /** @var string */
    public string $currency;

    /** @var string */
    public string $interval;

    /** @var SubscriptionProductDto */
    public SubscriptionProductDto $product;
}
