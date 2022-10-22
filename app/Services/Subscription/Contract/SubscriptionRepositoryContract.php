<?php

namespace App\Services\Subscription\Contract;

use App\Models\User;
use App\Services\Subscription\Dtos\SubscriptionPlanDto;
use App\Services\Subscription\Exception\SetupIntentClientSecretFailed;
use App\Services\Subscription\Exception\SubscriptionNotFoundException;
use Laravel\Cashier\Exceptions\IncompletePayment;
use Stripe\Exception\ApiErrorException;

interface SubscriptionRepositoryContract
{
    /**
     * Добавление подписки пользователю
     *
     * @param User   $user
     * @param string $plan
     * @param string $paymentMethod
     *
     * @return void
     * @throws IncompletePayment
     */
    public function create(User $user, string $plan, string $paymentMethod): void;

    /**
     * Удаление подписки пользователя
     *
     * @param User $user
     *
     * @return void
     * @throws SubscriptionNotFoundException
     */
    public function delete(User $user): void;

    /**
     * Получение списка планов для подписки
     *
     * @return SubscriptionPlanDto[]
     * @throws ApiErrorException
     */
    public function getPlans(): array;

    /**
     * Подписан ли пользователь
     *
     * @param User $user
     *
     * @return bool
     */
    public function isUserHasSubscription(User $user): bool;

    /**
     * Получение клиентского ключа для создания подписки
     *
     * @param User $user
     *
     * @return string
     * @throws SetupIntentClientSecretFailed
     */
    public function getSetupIntentClientSecret(User $user): string;
}
