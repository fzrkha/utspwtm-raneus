@extends('layouts.app')
@section('title', 'Login')
@section('content')
<div class="px-4 py-5 px-md-5 text-center text-lg-start mt-3" style="background-color: hsl(0, 0%, 96%)">
    <div class="container mt-5 mb-5">
        <div class="row gx-lg-5 align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <h1 class="my-5 display-5 fw-bold ls-tight">
                    Tentang Aplikasi <br />
                    <span class="text-primary">Pelanggaran Murid</span>
                </h1>
                
                <p style="color: hsl(200, 2%, 26%)">
                    Aplikasi ini dikembangkan untuk membantu guru Bimbingan dan Konseling (BK)
                    dalam mengelola data serta mendokumentasikan berbagai pelanggaran tata tertib
                    yang terjadi di lingkungan sekolah. Dengan adanya aplikasi ini, proses pencatatan,
                    pemantauan, dan penanganan pelanggaran diharapkan menjadi lebih efektif,
                    sekaligus mendukung upaya pencegahan dan meminimalkan terjadinya pelanggaran di kemudian hari.
                </p>
            </div>
            
            <div class="col-lg-6 mb-5 mb-lg-0">
                <div class="card">
                    <div class="card-body py-5 px-md-5">
                        <h1 class="my-3 display-5 fw-bold ls-tight text-primary">
                            Login
                        </h1>
                        
                        <form action=""method="POST">
                            @csrf
                            <div class="form-outline mb-4">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" placeholder="masukkan nama pengguna" class="form-control"/>
                            </div>
                            
                            <div class="form-outline mb-4">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="masukkan kata sandi"/>
                            </div>

                            <!-- Submit button-->
                            <button type="submit" class="btn btn-primary btn-block mb-4">
                                Sign In
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection