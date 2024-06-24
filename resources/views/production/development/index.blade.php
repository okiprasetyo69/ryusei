
@extends('layout.home')
@section('title','Management Produksi')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Management Produksi</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <a href="/production/development">Development</a>
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
                        <div class="col md-4 mt-4">
                            <button type="button" class="btn btn-sm btn-primary rounded-pill" id="btn-add">
                                <i class="bi bi-plus-circle"></i> Tambah
                            </button>
                        </div>
                        <div class="row mt-2"> 
                            <div class="col-md-12 mt-4">
                                <div class="">
                                    <table class="table table-striped" id="table-development">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Tanggal Terima Design</th>
                                                <th scope="col">Tanggal Jadi Sample</th>
                                                <th scope="col">Photo Sample</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                        </tbody>
                                    </table>
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

        $("#btn-add").on("click", function(e){
            e.preventDefault()
            window.location.href = "/production/development/add"
        })  
        
   });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection
@section('pagespecificscripts')
   
@stop