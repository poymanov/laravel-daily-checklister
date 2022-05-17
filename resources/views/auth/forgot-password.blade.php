<x-guest-layout>
    <div class="col-md-6">
        <div class="card mx-4">
            <div class="card-body p-4">
                <p class="text-muted">{{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}</p>

                <x-session-status class="mb-4" :status="session('status')" />

                <x-validation-errors class="mb-4" :errors="$errors"/>

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><x-svg-icon path="/assets/icons/free.svg#cil-envelope-open" class="c-icon"/></span>
                        </div>
                        <input class="form-control" type="email" placeholder="Email" name="email" value="{{ old('email') }}" required autofocus>
                    </div>
                    <button class="btn btn-block btn-success" type="submit">Email Password Reset Link</button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
