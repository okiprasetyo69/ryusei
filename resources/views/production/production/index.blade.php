

@extends('layout.home')
@section('title','Management Produksi')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.css" rel="stylesheet" />
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Management Produksi</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <a href="/production">Produksi</a>
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
                            <div class="col-md-4"> 
                                <label> <strong><span>Pencarian</span></strong> </label>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" name="filter_title_name" class="form-control" id="filter_title_name" placeholder="Masukkan kata kunci judul" autofocus/>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group"> 
                                    <button type="button" class="btn btn-md btn-success" style="border-radius:50px;" id="btn-search"> <i class="bi bi-search"></i> Cari </button>
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
                                    <table class="table table-striped" id="table-production">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Column</th>
                                                <th scope="col">Column</th>
                                                <th scope="col">Column</th>
                                                <th scope="col">Column</th>
                                                <th scope="col">Column</th>
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

    var table
    
    $(document).ready(function () {

        var now = new Date();
        var month = (now.getMonth() + 1);               
        var day = now.getDate();

        if (month < 10) 
            month = "0" + month;
        if (day < 10) 
            day = "0" + day;
        var today = now.getFullYear() + '-' + month + '-' + day;

        var convertDesignImageDate = day + '-' + month.toLocaleString('default', { month: 'long' }) + '-' + now.getFullYear()
        var convertSampleImageDate = day + '-' + month.toLocaleString('default', { month: 'long' }) + '-' + now.getFullYear()

   
            
    });

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.js"></script>

@endsection
@section('pagespecificscripts')
   
@stop