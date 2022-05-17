<x-guest-layout>
    <div class="col-md-6">
        <div class="card mx-4">
            <div class="card-body p-4">
                <x-validation-errors class="mb-4" :errors="$errors"/>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><x-svg-icon path="/assets/icons/free.svg#cil-envelope-open" class="c-icon"/></span>
                        </div>
                        <input class="form-control" type="email" placeholder="Email" name="email" value="{{ old('email', $request->email)}}" required autofocus>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><x-svg-icon path="/assets/icons/free.svg#cil-lock-locked" class="c-icon"/></span>
                        </div>
                        <input class="form-control" type="password" placeholder="Password" name="password">
                    </div>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><x-svg-icon path="/assets/icons/free.svg#cil-lock-locked" class="c-icon"/></span>
                        </div>
                        <input class="form-control" type="password" name="password_confirmation" placeholder="{{ __('Confirm Password') }}">
                    </div>
                    <button class="btn btn-block btn-success" type="submit">{{ __('Reset Password') }}</button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
