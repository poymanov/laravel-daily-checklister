<x-guest-layout>
    <div class="col-md-8">
        <div class="card-group">
            <div class="card p-4">
                <div class="card-body">
                    <h1>Login</h1>

                    <p class="text-muted">Sign In to your account</p>

                    <x-session-status class="mb-4" :status="session('status')" />

                    <x-validation-errors class="mb-4" :errors="$errors"/>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text">
                                <x-svg-icon path="/assets/icons/free.svg#cil-envelope-open" class="c-icon"/>
                            </span>
                            </div>
                            <input class="form-control" type="email" name="email" placeholder="Email" required>
                        </div>
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text">
                                <x-svg-icon path="/assets/icons/free.svg#cil-lock-locked" class="c-icon"/>
                            </span>
                            </div>
                            <input class="form-control" type="password" name="password" placeholder="Password" required>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <button class="btn btn-primary px-4" type="submit">Login</button>
                            </div>
                            @if (Route::has('password.request'))
                                <div class="col-6 text-right">
                                    <a href="{{ route('password.request') }}" class="btn btn-link px-0" type="button">Forgot password?</a>
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
            <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
                <div class="card-body text-center">
                    <div>
                        <h2>Sign up</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        <a href="{{ route('register') }}" class="btn btn-lg btn-outline-light mt-3" type="button">Register Now!</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
