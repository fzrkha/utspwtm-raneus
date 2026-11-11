<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{asset('img/logo/PMlogo.png')}}">
    <title>Pelanggaran Murid | @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-B/GM4XqrwHnWXNOWMbloTmrYXZg10cakYGmpfsR/bbzQ6JAJI4ihuyADKLnBgrCe" crossorigin="anonymous">
    <script type="module" src="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-1a/pXj49ZQ1aHEmrJ+gMw1otqoVsYwlEnlD8mIfY2TV03r20Y0CN7uqx1tQogjPL" crossorigin="anonymous"></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <script src="{{asset('js/jquery-3.7.1.min.js')}}"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/select2_cus.css')}}">
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="{{asset('css/modal_cus.css')}}">
    <script src="{{asset('js/modal_cus.js')}}"></script>
</head>
<body>
    <nav class="navbar sm:navbar-expand bg-black sticky-top" data-bs-theme="dark">
        <div class="container-fluid ms-5 d-flex">
            <a class="navbar-brand fg-primary text-lg" href="/">Pelanggaran Murid</a>

            <button class="btn-icon navbar-toggler" type="button" data-bs-toggle="drawer" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="bi bi-three-dots" aria-hidden="true"></span>
            </button>

            <dialog class="drawer drawer-end" tabindex="-1" id="navbarNavAltMarkup" aria-labelledby="navbarNavAltMarkupLabel">
                <div class="drawer-header">
                    <h5 class="drawer-title" id="navbarNavAltMarkupLabel">Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="drawer" aria-label="Close"></button>
                </div>
                
                <div class="drawer-body">
                    <div class="nav nav-pills navbar-nav bg-black custom-nav">
                        @auth
                            @if (Auth::user()->level == 'administrasi')
                                <a class="nav-link {{ request()->is('admin') ? 'active' : '' }}" href="/admin">
                                    <i class="fa-solid fa-home"></i>
                                    Dashboard
                                </a>
                                
                                <a class="nav-link {{ request()->is('admin/pengguna*') ? 'active' : '' }}" href="/admin/pengguna">
                                    <i class="fa-solid fa-users"></i>
                                    Pengguna
                                </a>
                    
                                <a class="nav-link {{ request()->is('admin/murid*') ? 'active' : '' }}" href="/admin/murid">
                                    <i class="fa-solid fa-user-graduate"></i>
                                    Murid
                                </a>
                    
                                <a class="nav-link {{ request()->is('admin/pelanggaran*') ? 'active' : '' }}" href="/admin/pelanggaran">
                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                    Pelanggaran
                                </a>
                    
                                <a class="nav-link {{ request()->is('admin/tanggapan*') ? 'active' : '' }}" href="/admin/tanggapan">
                                    <i class="fa-solid fa-comments"></i>
                                    Tanggapan
                                </a>
                            @elseif (Auth::user()->level == 'gurubk')
                                <a class="nav-link {{ request()->is('guru') ? 'active' : '' }}" href="/guru">
                                    <i class="fa-solid fa-home"></i>
                                    Dashboard
                                </a>
                    
                                <a class="nav-link {{ request()->is('guru/murid*') ? 'active' : '' }}" href="/guru/murid">
                                    <i class="fa-solid fa-user-graduate"></i>
                                    Murid
                                </a>
                    
                                <a class="nav-link {{ request()->is('guru/pelanggaran*') ? 'active' : '' }}" href="/guru/pelanggaran">
                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                    Pelanggaran
                                </a>
                    
                                <a class="nav-link {{ request()->is('guru/tanggapan*') ? 'active' : '' }}" href="/guru/tanggapan">
                                    <i class="fa-solid fa-comments"></i>
                                    Tanggapan
                                </a>
                            @endif

                            <button type="button" class="btn-outline theme-danger" data-bs-toggle="dialog" data-bs-target="#modalLogout">
                                <i class="fa-solid fa-right-from-bracket me-1"></i>
                                Logout
                            </button>
            
                        @endauth
                        
                        <!-- <a class="nav-link disabled" aria-disabled="true">Disabled</a> -->
                    </div>
                </div>
            </dialog>
        </div>
    </nav>

    <dialog class="dialog dialog-sm" id="modalLogout">
        <div class="dialog-header">
            <h5 class="dialog-title fw-bold">
                Konfirmasi Logout
            </h5>

            <button type="button" class="btn-close"
                data-bs-dismiss="dialog" aria-label="Close"></button>
        </div>

        <div class="dialog-body text-center">
            <i class="fa-solid fa-right-from-bracket text-danger fa-3x mb-3"></i>

            <p class="mb-0">
                Yakin ingin keluar dari aplikasi?
            </p>
        </div>

        <div class="dialog-footer justify-content-center">
            <button type="button" class="btn-solid theme-inverse"
                data-bs-dismiss="dialog">
                Batal
            </button>

            <a href="/logout" class="btn-solid theme-danger">
                Logout
            </a>
        </div>
    </dialog>

    <section class="container mt-5">
        @yield('content')
    </section>
</body>
</html>