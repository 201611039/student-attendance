@extends('layouts.app')

@section('content')
    <form method="post" id="register-form">


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
@endpush