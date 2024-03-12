
@extends('layout.home')
@section('title','Dashboard')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Management Barang</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">Katalog</a>
                </li>
                <li class="breadcrumb-item active">
                    <a href="/product">Product</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="/product/add">Tambah</a>
                </li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mt-2">
                            <label> <strong><span>Pencarian : </span></strong> </label>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" name="filter_name" class="form-control" id="filter_name" placeholder="Masukkan kata kunci" autofocus/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                            <div class="row mt-4">
                                <div class="col-lg-3">
                                    <div class="card">
                                        <div class="filter">
                                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                <li class="dropdown-header text-start">
                                                    <h6>Aksi</h6>
                                                </li>
                                                <li><a class="dropdown-item" href="#">Ubah</a></li>
                                                <li><a class="dropdown-item" href="#">Hapus</a></li>
                                            </ul>
                                        </div>
                                        <img class="card-img-top" src="{{ asset('') }}img/ryusei_logo.png">
                                        <div class="card-body">
                                            <h5 class="card-title text-center">Artikel</h5>
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item"> Nama SKU : </li>
                                            <li class="list-group-item"> Size : </li>
                                            <li class="list-group-item"> Harga : </li>
                                            <li class="list-group-item"> Ready : </li>
                                            <li class="list-group-item"> Kategori : </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="card">
                                        <div class="filter">
                                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                <li class="dropdown-header text-start">
                                                    <h6>Aksi</h6>
                                                </li>
                                                <li><a class="dropdown-item" href="#">Ubah</a></li>
                                                <li><a class="dropdown-item" href="#">Hapus</a></li>
                                            </ul>
                                        </div>
                                        <img class="card-img-top" src="{{ asset('') }}img/ryusei_logo.png">
                                        <div class="card-body">
                                            <h5 class="card-title text-center"> Artikel : </h5>
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">Nama SKU : </li>
                                            <li class="list-group-item">Size : </li>
                                            <li class="list-group-item">Harga : </li>
                                            <li class="list-group-item"> Ready : </li>
                                            <li class="list-group-item"> Kategori : </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="card">
                                        <div class="filter">
                                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                <li class="dropdown-header text-start">
                                                    <h6>Aksi</h6>
                                                </li>
                                                <li><a class="dropdown-item" href="#">Ubah</a></li>
                                                <li><a class="dropdown-item" href="#">Hapus</a></li>
                                            </ul>
                                        </div>
                                        <img class="card-img-top" src="{{ asset('') }}img/ryusei_logo.png">
                                        <div class="card-body">
                                            <h5 class="card-title text-center"> Artikel : </h5>
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">Nama SKU : </li>
                                            <li class="list-group-item">Size : </li>
                                            <li class="list-group-item">Harga : </li>
                                            <li class="list-group-item"> Ready : </li>
                                            <li class="list-group-item"> Kategori : </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="card">
                                        <div class="filter">
                                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                <li class="dropdown-header text-start">
                                                    <h6>Aksi</h6>
                                                </li>
                                                <li><a class="dropdown-item" href="#">Ubah</a></li>
                                                <li><a class="dropdown-item" href="#">Hapus</a></li>
                                            </ul>
                                        </div>
                                        <img class="card-img-top" src="{{ asset('') }}img/ryusei_logo.png">
                                        <div class="card-body">
                                            <h5 class="card-title text-center"> Artikel : </h5>
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">Nama SKU : </li>
                                            <li class="list-group-item">Size : </li>
                                            <li class="list-group-item">Harga : </li>
                                            <li class="list-group-item"> Ready : </li>
                                            <li class="list-group-item"> Kategori : </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<!-- End #main -->

<script type="text/javascript"> 

    $(document).ready(function () {
       
    });


</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
@endsection
@section('pagespecificscripts')
   
@stop