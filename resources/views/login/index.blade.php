@extends("templates.base")

@section("content")

<div class="d-flex justify-content-center align-items-center" style="height: calc(100vh - 50px);">
    <form class="w-25" method="POST" action="{{ route('login.store') }}">
        @csrf
        <h1 class="text-primary">Admin</h1>
        <div class="text-start">
            <label for="emailInput" class="form-label">Email address</label>
            <input value="{{ old('email') }}" type="email" class="form-control" id="emailInput" name="email">
        </div>
        <div class="text-start mb-2">
            <label for="passwordInput" class="form-label">Password</label>
            <div class="input-group">
                <input value="{{ old('password') }}" type="password" class="form-control" id="passwordInput" name="password">
                <button type="button" class="btn btn-outline-secondary" onclick="togglePasswordVisibility()">
                    <i id="passwordToggleIcon" class="bi bi-eye"></i>
                </button>
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-4">Log in</button>
    </form>
</div>

<script>
    function togglePasswordVisibility() {
        var passwordInput = document.getElementById("passwordInput");
        var passwordToggleIcon = document.getElementById("passwordToggleIcon");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            passwordToggleIcon.classList.remove("bi-eye");
            passwordToggleIcon.classList.add("bi-eye-slash");
        } else {
            passwordInput.type = "password";
            passwordToggleIcon.classList.remove("bi-eye-slash");
            passwordToggleIcon.classList.add("bi-eye");
        }
    }
</script>

@endsection
