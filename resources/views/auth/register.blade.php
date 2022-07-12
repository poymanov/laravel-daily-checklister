<x-guest-layout>
    <div class="col-md-6">
        <div class="card mx-4">
            <div class="card-body p-4">
                <h1>Register</h1>
                <p class="text-muted">Create your account</p>

                <x-validation-errors class="mb-4" :errors="$errors"/>

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><x-svg-icon path="/assets/icons/free.svg#cil-user" class="c-icon"/></span>
                        </div>
                        <input class="form-control" type="text" placeholder="Name" name="name" value="{{ old('name') }}" required>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><x-svg-icon path="/assets/icons/free.svg#cil-envelope-open" class="c-icon"/></span>
                        </div>
                        <input class="form-control" type="email" placeholder="Email" name="email" value="{{ old('email') }}" required>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><x-svg-icon path="/assets/icons/free.svg#cil-lock-locked" class="c-icon"/></span>
                        </div>
                        <input class="form-control" type="password" placeholder="Password" name="password">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><x-svg-icon path="/assets/icons/free.svg#cil-lock-locked" class="c-icon"/></span>
                        </div>
                        <input class="form-control" type="password" name="password_confirmation" placeholder="Repeat password">
                    </div>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><x-svg-icon path="/assets/icons/free.svg#cil-external-link" class="c-icon"/></span>
                        </div>
                        <input class="form-control" type="text" placeholder="Website" name="website" value="{{ old('website') }}" required>
                    </div>
                    <button class="btn btn-block btn-success" type="submit">Create Account</button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
