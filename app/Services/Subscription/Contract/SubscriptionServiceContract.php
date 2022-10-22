<?php

namespace App\Services\Subscription\Contract;

use App\Services\Subscription\Dtos\SubscriptionPlanDto;
use App\Services\Subscription\Exception\SetupIntentClientSecretFailed;
use App\Services\Subscription\Exception\SubscriptionNotFoundException;
use App\Services\User\Exceptions\UserNotFoundException;
use Laravel\Cashier\Exceptions\IncompletePayment;
use Stripe\Exception\ApiErrorException;

interface SubscriptionServiceContract
{
    /**
     * Добавление подписки пользователю
     *
     * @param int    $userId
     * @param string $plan
     * @param string $paymentMethod
     *
     * @return void
     * @throws UserNotFoundException
     * @throws IncompletePayment
     */
    public function create(int $userId, string $plan, string $paymentMethod): void;

    /**
     * Удаление подписки пользователя
     *
     * @param int $userId
     *
     * @return void
     * @throws SubscriptionNotFoundException
     * @throws UserNotFoundException
     */
    public function delete(int $userId): void;

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
     * @param int $userId
     *
     * @return bool
     * @throws UserNotFoundException
     */
    public function isUserHasSubscription(int $userId): bool;

    /**
     * Получение клиентского ключа для создания подписки
     *
     * @param int $userId
     *
     * @return string
     * @throws SetupIntentClientSecretFailed
     * @throws UserNotFoundException
     */
    public function getSetupIntentClientSecret(int $userId): string;
}
