
@extends('layout.home')
@section('title','Dashboard')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Management Barang</h1>
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Katalog</a></li>
            <li class="breadcrumb-item active">Product</li>
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
                        <div class="row mt-2"> 
                           <!-- Pills Tabs -->
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-product-tab" data-bs-toggle="pill" data-bs-target="#pills-product" type="button" role="tab" aria-controls="pills-product" aria-selected="true">Product</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-tambah-product-tab" data-bs-toggle="pill" data-bs-target="#pills-tambah-product" type="button" role="tab" aria-controls="pills-tambah-product" aria-selected="false">Tambah</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Contact</button>
                                </li>
                            </ul>
                            <div class="tab-content pt-2" id="myTabContent">
                                <div class="tab-pane fade show active" id="pills-product" role="tabpanel" aria-labelledby="product-tab">
                                    @include('product.data')
                                </div>
                                <div class="tab-pane fade" id="pills-tambah-product" role="tabpanel" aria-labelledby="tambah-product-tab">
                                    @include('product.form')
                                </div>
                                <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="contact-tab">
                                    Saepe animi et soluta ad odit soluta sunt. Nihil quos omnis animi debitis cumque. Accusantium quibusdam perspiciatis qui qui omnis magnam. Officiis accusamus impedit molestias nostrum veniam. Qui amet ipsum iure. Dignissimos fuga tempore dolor.
                                </div>
                            </div>
                            <!-- End Pills Tabs -->
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