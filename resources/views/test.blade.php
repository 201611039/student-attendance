@extends('layouts.app')

@section('content')
    <form method="post" id="register-form">
        @csrf

        <button type="submit">Submit</button>
    </form>

    <form method="post" id="login-form">
        @csrf

        <input id="email" name="email" type="text" value="{{ auth()->user()->email }}">
        <button type="submit">Submit</button>
    </form>
@endsection

@push('script')
<script src="{{ asset('vendor/larapass/js/larapass.js') }}"></script>

<!-- Registering credentials -->
<script>
    const register = (event) => {
        event.preventDefault()
        new Larapass({
            register: 'webauthn/register',
            registerOptions: 'webauthn/register/options'
        }).register()
          .then(response => alert('Registration successful!'))
          .catch(response => alert('Something went wrong, try again!'))
    }

    document.getElementById('register-form').addEventListener('submit', register)
</script>

<!-- Login users -->
<script>
    const login = (event) => {
        event.preventDefault()
        new Larapass({
            login: 'webauthn/login',
            loginOptions: 'webauthn/login/options'
        }).login({
            email: document.getElementById('email').value
        }).then(response => alert('Authentication successful!'))
          .catch(error => alert('Something went wrong, try again!'))
    }

    document.getElementById('login-form').addEventListener('submit', login)
</script>
@endpush