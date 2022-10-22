<?php

namespace App\Services\Subscription\Factories;

use App\Services\Subscription\Dtos\SubscriptionPlanDto;
use Stripe\Plan;

class SubscriptionPlanDtoFactory
{
    /**
     * @param Plan $plan
     *
     * @return SubscriptionPlanDto|null
     */
    public static function createFromModel(Plan $plan): ?SubscriptionPlanDto
    {
        if (is_null($plan->amount) || is_null($plan->product) || is_string($plan->product)) {
            return null;
        }

        $dto           = new SubscriptionPlanDto();
        $dto->id       = $plan->id;
        $dto->amount   = $plan->amount;
        $dto->currency = $plan->currency;
        $dto->interval = $plan->interval;
        $dto->product  = SubscriptionProductDtoFactory::createFromModel($plan->product);

        return $dto;
    }

    /**
     * @param array $models
     *
     * @return array
     */
    public static function createFromModelsList(array $models): array
    {
        $dtos = [];

        foreach ($models as $model) {
            $dto = self::createFromModel($model);

            if (is_null($dto)) {
                continue;
            }

            $dtos[] = $dto;
        }

        return $dtos;
    }
}
