<?php

namespace App\Services\Subscription;

use App\Services\Subscription\Contract\SubscriptionRepositoryContract;
use App\Services\Subscription\Contract\SubscriptionServiceContract;
use App\Services\User\Contracts\UserServiceContract;

class SubscriptionService implements SubscriptionServiceContract
{
    public function __construct(
        private readonly SubscriptionRepositoryContract $subscriptionRepository,
        private readonly UserServiceContract $userService
    ) {
    }

    /**
     * @inheritDoc
     */
    public function create(int $userId, string $plan, string $paymentMethod): void
    {
        $user = $this->userService->findOneByIdAsModel($userId);

        $this->subscriptionRepository->create($user, $plan, $paymentMethod);
    }

    /**
     * @inheritDoc
     */
    public function delete(int $userId): void
    {
        $user = $this->userService->findOneByIdAsModel($userId);

        $this->subscriptionRepository->delete($user);
    }

    /**
     * @inheritDoc
     */
    public function getPlans(): array
    {
        return $this->subscriptionRepository->getPlans();
    }

    /**
     * @inheritDoc
     */
    public function isUserHasSubscription(int $userId): bool
    {
        $user = $this->userService->findOneByIdAsModel($userId);

        return $this->subscriptionRepository->isUserHasSubscription($user);
    }

    /**
     * @inheritDoc
     */
    public function getSetupIntentClientSecret(int $userId): string
    {
        $user = $this->userService->findOneByIdAsModel($userId);

        return $this->subscriptionRepository->getSetupIntentClientSecret($user);
    }
}
