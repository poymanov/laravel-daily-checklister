<?php

namespace App\Http\Controllers;

use App\Http\Requests\Subscription\StoreRequest;
use App\Services\Subscription\Contract\SubscriptionServiceContract;
use Illuminate\Support\Facades\Log;
use Throwable;

class SubscriptionController extends Controller
{
    public function __construct(private readonly SubscriptionServiceContract $subscriptionService)
    {
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \App\Services\Subscription\Exception\SetupIntentClientSecretFailed
     * @throws \App\Services\User\Exceptions\UserNotFoundException
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function index()
    {
        $userId = (int)auth()->id();

        $plans                   = $this->subscriptionService->getPlans();
        $hasSubscription         = $this->subscriptionService->isUserHasSubscription($userId);
        $setupIntentClientSecret = $this->subscriptionService->getSetupIntentClientSecret($userId);

        return view('subscription.index', compact('plans', 'setupIntentClientSecret', 'hasSubscription'));
    }

    /**
     * @param StoreRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRequest $request)
    {
        try {
            $this->subscriptionService->create((int)auth()->id(), $request->get('plan'), $request->get('payment_method'));

            return redirect()->route('page.welcome')->with('alert.success', 'Subscription created');
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return back()->with('alert.error', 'Failed to create subscription');
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy()
    {
        try {
            $this->subscriptionService->delete((int)auth()->id());

            return redirect()->route('page.welcome')->with('alert.success', 'Subscription was canceled');
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return back()->with('alert.error', 'Failed to cancel subscription');
        }
    }
}
