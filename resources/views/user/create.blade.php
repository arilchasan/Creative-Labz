<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@extends('layouts.app')
@section('container')
{{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" rel="stylesheet" /> --}}

<section class="p-5 mx-2 mt-2 shadow rounded">
    <h2 class="text-lg font-semibold capitalize">Tambah Customers</h2>

    <form action="/dashboard/user/store" method="POST">
        @csrf
        <div class="row g-3 mt-2">
            <div class="col-md-12">
                <label class="form-label" for="name">Username</label>
                <input id="name" type="text" name="name"
                    class="form-control" required>
            </div>
            <div class="col-md-12">
                <label class="form-label" for="email">Email</label>
                <input id="email" type="text" name="email"
                    class="form-control" required>
            </div>
            <div class="col-md-12">
                <label class="form-label" for="password">Password</label>
                <div class="input-group">
                    <input id="password" type="password" name="password"
                        class="form-control" required>

                        <span class="input-group-text" id="password-addon" onclick="togglePasswordVisibility()">
                            <i id="password-icon" class="far fa-eye"></i>
                        </span>

                </div>
            </div>
        </div>

        <div class="text-end mt-4">
            <a href="/dashboard/user/all" class="btn btn-secondary ml-2">Kembali</a>
            <button type="submit" class="btn btn-primary ml-2" style="background-color: blue">Simpan</button>
        </div>
    </form>
</section>

@endsection
<script>
    function togglePasswordVisibility() {
        const passwordField = document.getElementById("password");
        const passwordIcon = document.getElementById("password-icon");

        if (passwordField.type === "password") {
            passwordField.type = "text";
            passwordIcon.className = "far fa-eye-slash"; // Change to the eye-slash icon
        } else {
            passwordField.type = "password";
            passwordIcon.className = "far fa-eye"; // Change back to the eye icon
        }
    }

    function closeAlert(alertId) {
        var alert = document.getElementById(alertId);
        if (alert) {
            alert.style.display = 'none';
        }
    }
</script>
