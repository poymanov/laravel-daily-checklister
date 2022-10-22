<x-app-layout>
    <div class="card">
        <div class="card-header">Subscription</div>
        <div class="card-body">
            @if($hasSubscription)
                @include('subscription._info')
            @else
                @include('subscription._create', compact('plans', 'setupIntentClientSecret'))
            @endif
        </div>
    </div>
</x-app-layout>
