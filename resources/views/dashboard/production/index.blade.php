
@extends('layout.home')
@section('title','Dashboard Produksi')
<link href="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
@section('content')

<main id="main" class="main">

<div class="pagetitle">
<h1>Dashboard Produksi</h1>
<nav>
    <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/dashboard/production">Home</a></li>
    <li class="breadcrumb-item active">Dashboard Produksi</li>
    </ol>
</nav>
</div><!-- End Page Title -->

<section class="section dashboard">
    
    <div class="card"> 
        <div class="card-body "> 
            <div class="row">
                <div class="col-md-10 text-center"> 
                    <label class="card-title text-center"> Range Tanggal</label>
                </div>
                <div class="col-md-2"> </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <input type="text" class="form-control" name="start_date" id="start_date" placeholder="Klik tanggal"/>
                </div>
                <div class="col-md-5">
                    <input type="text" class="form-control" name="end_date" id="end_date" placeholder="Klik tanggal"/>
                </div>
                <div class="col-md-2"> 
                    <button type="button" class="btn btn-md btn-success rounded-pill" id="btn-search"><i class="bi bi-search"></i> Cari </button>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-4">
                    <h5 class="card-title" id="description"> </h5>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Left side columns -->
        <div class="col-lg-8">
            <div class="row">

                <!-- Total Sample -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">
                        <div class="filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-header text-start">
                                    <h6>Filter</h6>
                                </li>
                                <li><a class="dropdown-item" href="#" id="filter-today">Today</a></li>
                                <li><a class="dropdown-item" href="#" id="filter-month">This Month</a></li>
                                <li><a class="dropdown-item" href="#" id="filter-year">This Year</a></li>
                            </ul>
                        </div>
                            <div class="card-body">
                            <h5 class="card-title">Total Sample <span id="total_sample">  </span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bx bxs-checkbox"></i>
                                </div>
                                <div class="ps-3">
                                    <h6 id="total-sample">-</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Total Sample -->

                 <!-- Total Design -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">
                        <div class="filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-header text-start">
                                    <h6>Filter</h6>
                                </li>
                                <li><a class="dropdown-item" href="#" id="filter-today">Today</a></li>
                                <li><a class="dropdown-item" href="#" id="filter-month">This Month</a></li>
                                <li><a class="dropdown-item" href="#" id="filter-year">This Year</a></li>
                            </ul>
                        </div>
                            <div class="card-body">
                            <h5 class="card-title">Total Design <span id="total_design">  </span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bx bxs-card"></i>
                                </div>
                                <div class="ps-3">
                                    <h6 id="total-design">-</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Total Sample -->

                <!-- Reports -->
                <div class="col-12">
                    <div class="card">
                        <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                            <h6>Filter</h6>
                            </li>
                            <li><a class="dropdown-item" href="#" id="filter-today-chart">Today</a></li>
                            <li><a class="dropdown-item" href="#" id="filter-month-chart">This Month</a></li>
                            <li><a class="dropdown-item" href="#" id="filter-year-chart">This Year</a></li>
                        </ul>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title">Development</h5>
                            <div>
                                
                            </div>

                        </div>
                    </div>
                </div>
                <!-- End Reports -->

            </div>
        </div>
        <!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">
            <!-- Monitoring Stock -->
            <div class="card">
                    <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                                <h6>Filter</h6>
                            </li>
                            <li><a class="dropdown-item" href="#">Today</a></li>
                            <li><a class="dropdown-item" href="#">This Month</a></li>
                            <li><a class="dropdown-item" href="#">This Year</a></li>
                        </ul>
                    </div>

                    <div class="card-body pb-0">
                        <h5 class="card-title"> Anythings </h5>
                        <div class="col-md-4"> 
                            <label> <strong><span>Find Something : </span></strong> </label>
                        </div>
                        <div class="row">
                            <div class="col-md-8 mt-1">
                                <input type="text" class="form-control" name="search_category" id="search_category" placeholder="TShirt" autofocus/>
                            </div>
                            <div class="col-md-4"> 
                                <button type="button" class="btn btn-sm btn-success mt-1" style="border-radius:50px;" id="btn-search-stock"> <i class="bi bi-search"></i> Cari</button>
                            </div>
                        </div>
                        
                        <div class="table-responsinve mt-4">
                            <table class="table table-striped" id="table-stock-items">
                                <thead class="text-center">
                                    <tr>
                                        <th scope="col">#</th>
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
            <!-- End Monitoring Stock -->
        </div>
    </div>
</section>

</main><!-- End #main -->

<script type="text/javascript">

    var today = new Date();
    var day = String(today.getDate()).padStart(2, '0'); // Hari
    var month = String(today.getMonth() + 1).padStart(2, '0'); // Bulan (ingat bahwa bulan dimulai dari 0)
    var year = today.getFullYear(); // Tahun
    // Format tanggal dalam bentuk string YYYY-MM-DD
    var formattedDate = year + '-' + month + '-' + day;

    var now
    
    $(document).ready(function () {
        var startOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);

        totalDesign()
        totalSample()
        $("#start_date").datepicker({
            format: 'dd-mm-yyyy',
            defaultDate: new Date(),
        }).datepicker("setDate", startOfMonth);

        $("#end_date").datepicker({
            format: 'dd-mm-yyyy',
            defaultDate: new Date(),
        }).datepicker("setDate", today);
            
    });

    function totalDesign(start_date=null, end_date=null, today=null, this_month=null, this_year=null){
        $.ajax({
            type: "GET",
            url: "/api/analytics/development/total-design",
            data: {
                start_date : start_date,
                end_date : end_date,
                today : today,
                this_month : this_month,
                this_year : this_year,
            },
            dataType: "JSON",
            success: function (response) {
                var data = response.data
                var total_design = 0
                if(data.total_design != null){
                    total_design = data.total_design.toLocaleString('id-ID')
                    $("#total-design").text(total_design)
                }
            }
        });
    }

    function totalSample(start_date=null, end_date=null, today=null, this_month=null, this_year=null){
        $.ajax({
            type: "GET",
            url: "/api/analytics/development/total-sample",
            data: {
                start_date : start_date,
                end_date : end_date,
                today : today,
                this_month : this_month,
                this_year : this_year,
            },
            dataType: "JSON",
            success: function (response) {
                var data = response.data
                var total_sample = 0
                if(data.total_sample != null){
                    total_sample = data.total_sample.toLocaleString('id-ID')
                    $("#total-sample").text(total_sample)
                }
            }
        });
    }
    
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
@endsection

@section('pagespecificscripts')
   
@stop