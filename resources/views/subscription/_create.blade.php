<x-validation-errors class="mb-4" :errors="$errors"/>
<div class="stripe-errors"></div>
<form action="{{ route('subscription.store') }}" method="post" id="subscribe-form">
    @csrf

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                @foreach($plans as $plan)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="plan-{{$plan->product->id}}" name="plan" value='{{$plan->id}}'>
                        <label class="form-check-label" for="plan-{{$plan->product->id}}">
                            <span class="plan-name">{{$plan->product->name}} ({{$plan->amount/100}} {{ Str::upper($plan->currency) }} / {{$plan->interval}}) </span>
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-2">
                <label for="card-holder-name">Card Holder Name</label>
                <input id="card-holder-name" class="form-control" type="text" name="name" value="{{ old('name') }}" required>
            </div>
            <div class="form-group">
                <label for="card-element">Credit or debit card</label>
                <div id="card-element" class="form-control">
                </div>
                <div id="card-errors" role="alert"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group text-center">
                <button type="submit" id="card-button" data-secret="{{ $setupIntentClientSecret }}" class="btn btn-lg btn-success btn-block">Submit</button>
            </div>
        </div>
    </div>
</form>
