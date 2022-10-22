<?php

namespace App\Services\Subscription\Repositories;

use App\Enums\SubscriptionEnum;
use App\Models\User;
use App\Services\Subscription\Contract\SubscriptionRepositoryContract;
use App\Services\Subscription\Exception\SetupIntentClientSecretFailed;
use App\Services\Subscription\Exception\SubscriptionNotFoundException;
use App\Services\Subscription\Factories\SubscriptionPlanDtoFactory;
use Laravel\Cashier\Cashier;

class SubscriptionRepository implements SubscriptionRepositoryContract
{
    /**
     * @inheritDoc
     */
    public function create(User $user, string $plan, string $paymentMethod): void
    {
        $user->createOrGetStripeCustomer();
        $user->addPaymentMethod($paymentMethod);

        $user->newSubscription(SubscriptionEnum::PRO->value, $plan)->create($paymentMethod, [
            'email' => $user->email,
        ]);
    }

    /**
     * Удаление подписки пользователя
     *
     * @param User $user
     *
     * @return void
     * @throws SubscriptionNotFoundException
     */
    public function delete(User $user): void
    {
        $subscription = $user->subscription(SubscriptionEnum::PRO->value);

        if (is_null($subscription)) {
            throw new SubscriptionNotFoundException();
        }

        $subscription->cancelNow();
    }

    /**
     * @inheritDoc
     */
    public function getPlans(): array
    {
        $stripe = Cashier::stripe();
        $plans  = $stripe->plans->all()->data;

        foreach ($plans as $plan) {
            $productDetails = $stripe->products->retrieve((string)$plan->product, []);
            $plan->product  = $productDetails;
        }

        return SubscriptionPlanDtoFactory::createFromModelsList($plans);
    }

    /**
     * @inheritDoc
     */
    public function isUserHasSubscription(User $user): bool
    {
        return $user->subscribed(SubscriptionEnum::PRO->value);
    }

    /**
     * @inheritDoc
     */
    public function getSetupIntentClientSecret(User $user): string
    {
        $setupIntent = $user->createSetupIntent();

        if (is_null($setupIntent->client_secret)) {
            throw new SetupIntentClientSecretFailed();
        }

        return $setupIntent->client_secret;
    }
}
