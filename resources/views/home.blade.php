
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/png" href="{{ asset('img/logo/PMlogo.png') }}">
    <title>Pelanggaran Murid</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-B/GM4XqrwHnWXNOWMbloTmrYXZg10cakYGmpfsR/bbzQ6JAJI4ihuyADKLnBgrCe"
          crossorigin="anonymous">

    <script type="module"
            src="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-1a/pXj49ZQ1aHEmrJ+gMw1otqoVsYwlEnlD8mIfY2TV03r20Y0CN7uqx1tQogjPL"
            crossorigin="anonymous">
    </script>
</head>

<body class="bg-2">
    <div class="min-vh-100 d-flex align-items-center justify-content-center">
        <div class="card border-0 shadow-sm rounded-4 w-100" style="max-width: 400px;">
            <div class="card-body p-4">
                <div class="text-center">
                    <img src="{{ asset('img/logo/PMlogo.png') }}"
                         alt="Logo Pelanggaran Murid"
                         class="img-fluid"
                         style="width: 85px; height: 85px; object-fit: contain;">
                </div>

                {{-- Judul --}}
                <h2 class="text-center fw-bold mb-4">
                    <span class="fg-primary">Pelanggaran</span>
                    <span class="fg-black">Murid</span>
                </h2>

                <form action="" method="POST">
                    @csrf
                    <div class="form-field mb-3">
                        <label for="username" class="form-label fw-semibold">
                            Username
                        </label>

                        <input type="text"
                               name="username"
                               id="username"
                               class="form-control"
                               placeholder="Masukkan nama pengguna"
                               required>
                    </div>

                    <div class="form-field mb-4">
                        <label for="password" class="form-label fw-semibold">
                            Password
                        </label>

                        <input type="password"
                               name="password"
                               id="password"
                               class="form-control"
                               placeholder="Masukkan kata sandi"
                               required>
                    </div>

                    <button type="submit"
                            class="btn-solid theme-inverse w-100 fw-semibold">
                        Sign In
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
