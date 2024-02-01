<link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.3/components/logins/login-10/assets/css/login-10.css" />
<style>
    body {
        font-family: 'poppins', sans-serif;
        font-weight: 400
    }

    .btn-primary {
        background-color: #17acb0;
        border-color: #17acb0;
    }

    .btn-primary:hover {
        background-color: transparent;
        color: white;
        /* Change text color on hover */
        border: 1px solid #17acb0;
    }
</style>
<title>Login</title>
<body>
<div class="d-flex align-items-center justify-content-center h-100 bg-dark">
    <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
        <div class="text-center mb-3">
            <img src="assets/logo.png" alt="" width="" height="120">
        </div>
        <h4 class="text-center text-white">Login Dashboard Creativ Labz</h4>
        <div class="card border-0 rounded-0 bg-dark">
            <div class="card-body">
                <form action="/login-admin" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row gy-1 overflow-hidden">
                        <div class="col-12">
                            <div class="form-floating mb-3">
                                <input type="name" class="form-control bg- border-0" name="name" id="name"
                                    placeholder="name@example.com" required>
                                <label for="name" class="form-label">Username</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" name="password" id="password"
                                    value="" placeholder="Password" required>
                                <label for="password" class="form-label">Password</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-grid">
                                <button class="btn btn-primary btn-lg" type="submit">Log in</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
