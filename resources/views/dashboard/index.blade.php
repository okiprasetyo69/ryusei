
@extends('layout.home')
@section('title','Dashboard')
<link href="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
@section('content')

<main id="main" class="main">

<div class="pagetitle">
<h1>Dashboard</h1>
<nav>
    <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
    <li class="breadcrumb-item active">Dashboard</li>
    </ol>
</nav>
</div><!-- End Page Title -->

<section class="section dashboard">
    
    <div class="card"> 
        <div class="card-body "> 
            <div class="row">
                <div class="col-md-10 text-center"> 
                    <label class="card-title text-center"> Range Tanggal Order</label>
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
                <!-- Sales Card -->
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
                            <h5 class="card-title">Penjualan <span id="total_sold">  </span></h5>

                        <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cart"></i>
                                </div>
                                <div class="ps-3">
                                    <h6 id="qty">-</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Sales Card -->

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
                            <h5 class="card-title">Performance Marketplace</h5>
                            <div>
                                <canvas id="performanceStoreChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 445px;" width="445" height="250" class="chartjs-render-monitor"></canvas>
                            </div>
                            <!-- <div class="col-md-12 mt-2">
                                <div id="actualData"> </div>
                            </div> -->

                        </div>
                    </div>
                </div>
                <!-- End Reports -->

                <!-- Recent Sales -->
                <div class="col-12">
                    <div class="card recent-sales overflow-auto">

                        <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                                <h6>Filter</h6>
                            </li>
                            <li><a class="dropdown-item" href="#" id="filter-today-best-channel">Today</a></li>
                            <li><a class="dropdown-item" href="#" id="filter-month-best-channel">This Month</a></li>
                            <li><a class="dropdown-item" href="#" id="filter-year-best-channel">This Year</a></li>
                           
                        </ul>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title">Toko Terbaik</h5>

                            <table class="table table-striped" id="table-best-store">
                                <thead>
                                <tr class="text-center">
                                    <th scope="col">#</th>
                                    <th scope="col">Sumber</th>
                                    <th scope="col">Nama Toko</th>
                                    <th scope="col">Omset</th>
                                    <th scope="col">%</th>
                                </tr>
                                </thead>
                                <tbody>
                                
                                </tbody>
                            </table>

                        </div>

                    </div>
                </div><!-- End Recent Sales -->

                <!-- Top Selling -->
                <div class="col-12">
                    <div class="card top-selling overflow-auto">
                        <div class="filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-header text-start">
                                <h6>Filter</h6>
                                </li>

                                <li><a class="dropdown-item" href="#" id="filter-today-most-product">Today</a></li>
                                <li><a class="dropdown-item" href="#" id="filter-month-most-product">This Month</a></li>
                                <li><a class="dropdown-item" href="#" id="filter-year-most-product">This Year</a></li>
                            </ul>
                        </div>

                        <div class="card-body pb-0">
                            <h5 class="card-title">Produk Paling Laku</h5>
                            <table class="table table-striped" id="table-most-product">
                                <thead>
                                <tr class="text-center">
                                    <th scope="col">Rank</th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Qty Terjual</th>
                                    <th scope="col">Total Penjualan</th>
                                </tr>
                                </thead>
                                <tbody>
                                
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
                <!-- End Top Selling -->

                <!-- Report Sales Turnover Market Place -->
                <div class="col-12"> 
                    <div class="card top-selling overflow-auto"> 
                        <div class="filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-header text-start">
                                <h6>Filter</h6>
                                </li>

                                <li><a class="dropdown-item" href="#" id="filter-today-omset-marketplace">Today</a></li>
                                <li><a class="dropdown-item" href="#" id="filter-month-omset-marketplace">This Month</a></li>
                                <li><a class="dropdown-item" href="#" id="filter-year-omset-marketplace">This Year</a></li>
                                <li><a class="dropdown-item" href="#" id="sync-market-place">Sync</a></li>
                            </ul>
                        </div>
                        <div class="card-body pb-0">
                            <h5 class="card-title">Omset Marketplace & Toko</h5>
                            <table class="table table-striped" id="table-sales-turn-over">
                                <thead>
                                <tr class="text-center">
                                    <th scope="col">#</th>
                                    <th scope="col">Market Place</th>
                                    <th scope="col">Nama Toko</th>
                                    <th scope="col">Omset</th>
                                    <th scope="col">Tgl Transaksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Start Report Basket Size -->
                <div class="col-12"> 
                    <div class="card top-selling overflow-auto"> 
                        <div class="filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-header text-start">
                                <h6>Filter</h6>
                                </li>

                                <li><a class="dropdown-item" href="#" id="filter-today-basket-size">Today</a></li>
                                <li><a class="dropdown-item" href="#" id="filter-month-basket-size">This Month</a></li>
                                <li><a class="dropdown-item" href="#" id="filter-year-basket-size">This Year</a></li>
                                <li><a class="dropdown-item" href="#" id="sync-basket-size">Sync</a></li>
                            </ul>
                        </div>
                        <div class="card-body pb-0">
                            <h5 class="card-title">Basket Size</h5>
                            <table class="table table-striped" id="table-basket-size">
                                <thead class="text-center">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Total Pesanan</th>
                                        <th scope="col">Total Transaksi</th>
                                        <th scope="col">AOV</th>
                                        <th scope="col">Tgl Transaksi</th>
                                    </tr>
                                </thead>
                            <tbody>
                                        
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
                <!-- End TReport Basket Size -->

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
                    <h5 class="card-title"> Monitoring Stock </h5>
                    <div class="col-md-4"> 
                        <label> <strong><span> Cari Kategori : </span></strong> </label>
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
                                    <th scope="col">SKU</th>
                                    <th scope="col">Nama Produk</th>
                                    <th scope="col">Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                        
                            </tbody>
                        </table>
                    </div>

                </div>
          </div>
          <!-- End Monitoring Stock -->

          <!-- Sale Stock Ratio Report -->
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
                    <h5 class="card-title">Sale Stock Ratio</h5>
                    <div class="table-responsinve mt-4">
                        <table class="table table-striped" id="table-ssr">
                            <thead class="text-center">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Bulan</th>
                                    <th scope="col">Omset</th>
                                    <th scope="col">Nilai Inventory</th>
                                    <th scope="col">Rp</th>
                                </tr>
                            </thead>
                            <tbody>
                                        
                            </tbody>
                        </table>
                    </div>
                </div>
          </div>
          <!-- Sale Stock Ratio Report -->

          <!-- Sell Through  -->
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
                    <h5 class="card-title">Sell Through</h5>
                    <div class="table-responsinve mt-4">
                        <table class="table table-striped" id="table-sell-through">
                            <thead class="text-center">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Bulan</th>
                                    <th scope="col">Qty Barang Masuk</th>
                                    <th scope="col">Qty Barang Terjual</th>
                                    <th scope="col">%</th>
                                </tr>
                            </thead>
                            <tbody>
                                        
                            </tbody>
                        </table>
                    </div>
                </div>
          </div>
          <!-- End Sell Through Report -->

          <!-- AOV Report -->
          <!-- <div class="card">
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
                    <h5 class="card-title">AOV</h5>
                    <div class="table-responsinve mt-4">
                        <table class="table table-striped" id="table-aov">
                            <thead class="text-center">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tgl Transaksi</th>
                                    <th scope="col">Total Pesanan</th>
                                    <th scope="col">Total Transaksi</th>
                                    <th scope="col">Rata-Rata</th>
                                </tr>
                            </thead>
                            <tbody>
                                        
                            </tbody>
                        </table>
                    </div>
                </div>
          </div> -->
          <!-- End AOV Report -->
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

    var now, currentMonth, this_year, myChart, start_date, end_date , convertStartDate, convertEndDate, table, table_sales_turnover, category_name, table_basket_size
    $(document).ready(function () {
      
        totalSoldWithQty()
        bestStoreChannelSeller()
        bestProductSeller()
        loadChart()
        monitoringStock()
       
        var startOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);

        $("#start_date").datepicker({
            format: 'dd-mm-yyyy',
            defaultDate: new Date(),
        }).datepicker("setDate", startOfMonth);

        $("#end_date").datepicker({
            format: 'dd-mm-yyyy',
            defaultDate: new Date(),
        }).datepicker("setDate", today);

        start_date = $("#start_date" ).val().split("-").reverse().join("-")
        end_date = $("#end_date" ).val().split("-").reverse().join("-")
        reportSalesTurnoverMarketplace(start_date, end_date)
        reportBasketSize(start_date, end_date)
       
        // -------------------- START FILTER BUTTON ------------------------ //
        $("#btn-search").on("click", function(e){
            e.preventDefault()
            start_date =  $("#start_date").val()
            end_date = $("#end_date").val()
            convertStartDate = start_date.split("-").reverse().join("-")
            convertEndDate = end_date.split("-").reverse().join("-")

            totalSoldWithQty(convertStartDate, convertEndDate, null, null, null)
            bestStoreChannelSeller(convertStartDate, convertEndDate, null, null, null)
            bestProductSeller(convertStartDate, convertEndDate, null, null, null)
            filterChart(convertStartDate, convertEndDate, null, null, null)
            reportBasketSize(convertStartDate, convertEndDate, null, null)
            reportSalesTurnoverMarketplace(convertStartDate, convertEndDate, null, null)
            var description = "Periode " + start_date + " sampai dengan " + end_date
            $("#description").html(description)
        })
        $("#btn-search-stock").on("click", function(e){
            e.preventDefault()
            category_name = $("#search_category").val()
            monitoringStock(category_name)
        })
        // -------------------- END FILTER BUTTON ------------------------ //

        // --------------------------------------------------------------- //
        $("#filter-today").on("click", function(e){
            e.preventDefault()
            now = formattedDate
            totalSoldWithQty(null, null,now,null,null)
        })
        $("#filter-month").on("click", function(e){
            e.preventDefault()
            currentMonth = today.getMonth() + 1
            totalSoldWithQty(null, null,null,currentMonth,null)
        })
        $("#filter-year").on("click", function(e){
            e.preventDefault()
            this_year = year
            totalSoldWithQty(null, null,null,null,this_year)
        })
        // --------------------------------------------------------------- //
        // --------------------------------------------------------------- //
        $("#filter-today-best-channel").on("click", function(e){
            e.preventDefault()
            now = formattedDate
            bestStoreChannelSeller(null, null,now,null,null)
        })
        $("#filter-month-best-channel").on("click", function(e){
            e.preventDefault()
            currentMonth = today.getMonth() + 1
            this_year = year
            bestStoreChannelSeller(null, null,null,currentMonth,this_year)
        })
        $("#filter-year-best-channel").on("click", function(e){
            e.preventDefault()
            this_year = year
            bestStoreChannelSeller(null, null,null,null,this_year)
        })
        // --------------------------------------------------------------- //
        // --------------------------------------------------------------- //
        $("#filter-today-most-product").on("click", function(e){
            e.preventDefault()
            now = formattedDate
            bestProductSeller(null, null,now,null,null)
        })
        $("#filter-month-most-product").on("click", function(e){
            e.preventDefault()
            currentMonth = today.getMonth() + 1
            bestProductSeller(null, null,null,currentMonth,null)
        })
        $("#filter-year-most-product").on("click", function(e){
            e.preventDefault()
            this_year = year
            bestProductSeller(null, null,null,null,this_year)
        })
        // --------------------------------------------------------------- //
        // --------------------------------------------------------------- //
        $("#filter-today-chart").on("click", function(e){
            e.preventDefault()
            now = formattedDate
            filterChart(null, null,now,null,null)
        })
        $("#filter-month-chart").on("click", function(e){
            e.preventDefault()
            currentMonth = today.getMonth() + 1
            this_year = year
            filterChart(null, null,null,currentMonth,this_year)
        })
        $("#filter-year-chart").on("click", function(e){
            e.preventDefault()
            this_year = year
            filterChart(null, null,null,null,this_year)
        })
        // --------------------------------------------------------------- //
        // --------------------------------------------------------------- //
        $("#filter-today-omset-marketplace").on("click", function(e){
            e.preventDefault()
            now = formattedDate
            reportSalesTurnoverMarketplace(null, null, now, null, null)
        })
        $("#filter-month-omset-marketplace").on("click", function(e){
            e.preventDefault()
            currentMonth = today.getMonth() + 1
            this_year = year
            reportSalesTurnoverMarketplace(null, null, null, currentMonth, this_year)
        })
        $("#filter-year-omset-marketplace").on("click", function(e){
            e.preventDefault()
            this_year = year
            reportSalesTurnoverMarketplace(null, null, null, null, this_year)
        })
        // --------------------------------------------------------------- //
        // --------------------------------------------------------------- //
        $("#filter-today-basket-size").on("click", function(e){
            e.preventDefault()
            now = formattedDate
            reportBasketSize(null, null, now, null, null)
        })
        $("#filter-month-basket-size").on("click", function(e){
            e.preventDefault()
            currentMonth = today.getMonth() + 1
            this_year = year
            reportBasketSize(null, null, null, currentMonth, this_year)
        })
        $("#filter-year-basket-size").on("click", function(e){
            e.preventDefault()
            this_year = year
            reportBasketSize(null, null, null, null, this_year)
        })
        // --------------------------------------------------------------- //

        // ------------------------START SYNC------------------------------- //
        $("#sync-market-place").on("click", function(e){
            e.preventDefault()
            syncMarketPlace()
        })

        $("#sync-basket-size").on("click", function(e){
            e.preventDefault()
            syncBasketSize()
        })
        // -----------------------END SYNC----------------------------------- //

        // Inisialisasi Pusher
        Pusher.logToConsole = true;
        var pusher = new Pusher('12979774488ee33d9ff9', {
            cluster: 'ap1',
            forceTLS: true
        });

        var channel = pusher.subscribe('jobs');
        channel.bind('job.completed', function(data) {
            // Tampilkan pesan saat event diterima
                $.confirm({
                    title: 'Pesan !',
                    content: data.message,
                    type: 'orange',
                    typeAnimated: true,
                    buttons: {
                        close: function () {
                        }
                    }
                });
        });
    });

    function totalSoldWithQty(start_date = null, end_date = null, today=null, this_month=null, this_year=null){
        $.ajax({
            type: "GET",
            url: "/api/analytics/total-qty",
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
                let formatter = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' });
                var total_sold = 0
                var qty = 0
                if(data.total_sold != null){
                    total_sold =  formatter.format(data.total_sold)
                }
                if(data.qty != null){
                    qty = data.qty
                }

                if(data != null){
                    $("#total_sold").text("| " + total_sold)
                    $("#qty").text(qty + " item")
                }

            }
        });
    }

    function bestStoreChannelSeller(start_date = null, end_date = null, today=null, this_month=null, this_year=null){
        $.ajax({
            type: "GET",
            url: "/api/analytics/report/best-store",
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
                var row = ""
                var number = 1
                var grand_total = 0
                var total = 0
                var arrTotal = [];
                var percentage = 0
                $("#table-best-store").find("tr:gt(0)").remove();
                $.each(data, function (i, val) {
                    total = parseInt(val.total)
                    grand_total = total + grand_total
                    total = total.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' })
                    arrTotal.push(val.total)
                    row += "<tr class='text-center'><td>"+ (number++) +"</td> <td>"+val.channel_name+"</td><td> "+val.store_name+" </td><td>"+total+"</td><td data-id="+ i +"></td></tr>"
                });
                $("#table-best-store > tbody:last-child").append(row); 

                $.each(arrTotal, function (i, val) { 
                    percentage = parseFloat((val / grand_total) * 100)
                    percentage = percentage.toFixed(3)
                    $('#table-best-store tr').find('td[data-id="' + i + '"]').text(percentage)
                });
            }
        });
    }

    function bestProductSeller(start_date = null, end_date = null, today=null, this_month=null, this_year=null){
        $.ajax({
            type: "GET",
            url: "/api/analytics/best-product",
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
                var row = ""
                var number = 1
                let formatter = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' });
                var total_sell =  0
                $("#table-most-product").find("tr:gt(0)").remove();
                $.each(data, function (i, val) {
                    total_sell = formatter.format(val.total_sell)
                    row += "<tr class='text-center'><td>"+ (number++) +"</td> <td>"+val.article+"</td><td>"+val.total_qty+"</td><td> "+total_sell+" </td></tr>"
                });
                $("#table-most-product > tbody:last-child").append(row); 
            }
        });
    }

    function loadChart(start_date = null, end_date = null, today=null, this_month=null, this_year=null){
        $.ajax({
            type: "GET",
            url: "/api/analytics/chart/sales-turnover-marketplace",
            data: {
                start_date : start_date,
                end_date : end_date,
                today : today,
                this_month : this_month,
                this_year : this_year,
            },
            dataType: "JSON",
            success: function (response) {
                var data = response.data.data
                var labels = response.data.labels
                let formatter = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' })
                var htmlTags = ""
                $("#actualData").html("")
                if(data.length === labels.length){
                   for(var i = 0; i < data.length; i++){
                        htmlTags = "<div class='col-md-2 d-inline text-success'>| "+labels[i]+" : "+ formatter.format(data[i])+" | </div>"
                        $("#actualData").append(htmlTags)
                   }
                }else{
                    console.log("array length not same")
                }

                data = {
                    labels: labels,
                    datasets: [{
                        label: 'Performance Channel',
                        backgroundColor: 'rgb(255, 99, 132)',
                        borderColor: 'rgb(255, 99, 132)',
                        data: data,
                    }]
                }
                config = {
                    type: 'bar',
                    data: data,
                    options: {}
                }

                var ctx =  document.getElementById('performanceStoreChart').getContext('2d')
                myChart = new Chart(
                    ctx,
                    config
                );
            }
        });
    }

    function filterChart(start_date = null, end_date = null, today=null, this_month=null, this_year=null){
        $.ajax({
            type: "GET",
            url: "/api/analytics/chart/sales-turnover-marketplace",
            data: {
                start_date : start_date,
                end_date : end_date,
                today : today,
                this_month : this_month,
                this_year : this_year,
            },
            dataType: "JSON",
            success: function (response) {
                var data = response.data.data
                var labels = response.data.labels
                let formatter = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' })
                var htmlTags = ""
                $("#actualData").html("")
                if(data.length === labels.length){
                   for(var i = 0; i < data.length; i++){
                        htmlTags = "<div class='col-md-2 d-inline text-success'>| "+labels[i]+" : "+ formatter.format(data[i])+" | </div>"
                        $("#actualData").append(htmlTags)
                   }
                }else{
                    console.log("array length not same")
                }

                data = {
                    labels: labels,
                    datasets: [{
                        label: 'Performance Channel',
                        backgroundColor: 'rgb(255, 99, 132)',
                        borderColor: 'rgb(255, 99, 132)',
                        data: data,
                    }]
                }
                config = {
                    type: 'bar',
                    data: data,
                    options: {}
                }

                var newContext = document.getElementById('performanceStoreChart').getContext('2d')
                if(myChart) myChart.destroy();

                myChart = new Chart(
                    newContext,
                    config
                );
            }
        });
    }

    function monitoringStock(category_name = null){
        if (table != null) {
            table.destroy();
        }
        table =  $("#table-stock-items").DataTable({
            // lengthChange: false,
            searching: false,
            destroy: true,
            processing: true,
            serverSide: true,
            bAutoWidth: true,
            scrollCollapse : true,
            ordering: false,
            language: {
                emptyTable: "Data tidak tersedia",
                zeroRecords: "Tidak ada data yang ditemukan",
                infoFiltered: "",
                infoEmpty: "",
                paginate: {
                    previous: "‹",
                    next: "›",
                },
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ Stock",
                aria: {
                    paginate: {
                        previous: "Previous",
                        next: "Next",
                    },
                },
            },
            columns: [
                { data: null, width: "2%" },
                { data: null, width: "5%"},
                { data: null },
                { data: null, width: "5%" },
            ],
            columnDefs: [
                {
                    targets: 0,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).addClass("text-center");
                        $(td).html(table.page.info().start + row + 1);
                    },
                },
                {
                    targets: 1,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).html(rowData.sku_code);
                    },
                },
                {
                    targets: 2,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                      
                        $(td).html(rowData.product.name);
                    },
                },
                {
                    targets: 3,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).html(rowData.qty);
                    },
                },
            ],
            ajax:{
                url :  '/api/analytics/monitoring-stock',
                type: "GET",
                data: {
                    category_name: category_name,
                }
            },
        })
    }

    function syncMarketPlace(){
        $.ajax({
            type: "GET",
            url: "/api/analytics/sync-sales-turnover-marketplace",
            data: "data",
            dataType: "JSON",
            success: function (response) {
                if(response.status == 200){
                    $.confirm({
                        title: 'Pesan ',
                        content: response.message,
                        buttons: {
                            Ya: {
                                btnClass: 'btn-success any-other-class',
                                action: function(){
                                    // loadSalesOrderCompleted()
                                }
                            },
                        }
                    });
                }
            }
        });
    }

    function syncBasketSize(){
        $.ajax({
            type: "GET",
            url: "/api/analytics/sync-basket-size",
            data: "data",
            dataType: "JSON",
            success: function (response) {
                if(response.status == 200){
                    $.confirm({
                        title: 'Pesan ',
                        content: response.message,
                        buttons: {
                            Ya: {
                                btnClass: 'btn-success any-other-class',
                                action: function(){
                                    // loadSalesOrderCompleted()
                                }
                            },
                        }
                    });
                }
            }
        });
    }

    function reportSalesTurnoverMarketplace(start_date=null, end_date=null, today=null, this_month=null, this_year=null){
        if (table_sales_turnover != null) {
            table_sales_turnover.destroy();
        }
        table_sales_turnover =  $("#table-sales-turn-over").DataTable({
            // lengthChange: false,
            searching: false,
            destroy: true,
            processing: true,
            serverSide: true,
            bAutoWidth: true,
            scrollCollapse : true,
            ordering: false,
            language: {
                emptyTable: "Data tidak tersedia",
                zeroRecords: "Tidak ada data yang ditemukan",
                infoFiltered: "",
                infoEmpty: "",
                paginate: {
                    previous: "‹",
                    next: "›",
                },
                info: "Menampilkan _START_ s/d _END_ dari _TOTAL_ Omset Marketplace",
                aria: {
                    paginate: {
                        previous: "Previous",
                        next: "Next",
                    },
                },
            },
            columns: [
                { data: null, width: "2%" },
                { data: null},
                { data: null },
                { data: null },
                { data: null },
            ],
            columnDefs: [
                {
                    targets: 0,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).addClass("text-center");
                        $(td).html(table.page.info().start + row + 1);
                    },
                },
                {
                    targets: 1,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).html(rowData.channel_name);
                    },
                },
                {
                    targets: 2,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                      
                        $(td).html(rowData.store_name);
                    },
                },
                {
                    targets: 3,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).html(rowData.grand_total.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }));
                    },
                },
                {
                    targets: 4,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        var transaction_date = rowData.transaction_date
                        var currDate = new Date(transaction_date)
                        var currMonth = currDate.toLocaleString('default', { month: 'long' })
                        var currYear = currDate.getFullYear()
                        var format = currDate.getDate() + "-"+ currMonth +"-"+ currYear
                        $(td).html(format);
                    },
                },
            ],
            ajax:{
                url :  '/api/analytics/report/sales-turnover-marketplace',
                type: "GET",
                data: {
                    start_date:start_date, 
                    end_date : end_date,
                    today : today,
                    this_month : this_month,
                    this_year : this_year
                }
            },
        })
    }

    function reportBasketSize(start_date=null, end_date=null, today=null, this_month=null, this_year=null){
        if (table_basket_size != null) {
            table_basket_size.destroy();
        }
        table_basket_size =  $("#table-basket-size").DataTable({
            // lengthChange: false,
            searching: false,
            destroy: true,
            processing: true,
            serverSide: true,
            bAutoWidth: true,
            scrollCollapse : true,
            ordering: false,
            language: {
                emptyTable: "Data tidak tersedia",
                zeroRecords: "Tidak ada data yang ditemukan",
                infoFiltered: "",
                infoEmpty: "",
                paginate: {
                    previous: "‹",
                    next: "›",
                },
                info: "Menampilkan _START_ s/d _END_ dari _TOTAL_ Basket Size",
                aria: {
                    paginate: {
                        previous: "Previous",
                        next: "Next",
                    },
                },
            },
            columns: [
                { data: null, width: "2%" },
                { data: null},
                { data: null },
                { data: null },
                { data: null },
            ],
            columnDefs: [
                {
                    targets: 0,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).addClass("text-center");
                        $(td).html(table.page.info().start + row + 1);
                    },
                },
                {
                    targets: 1,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).html(rowData.total_order_number);
                    },
                },
                {
                    targets: 2,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).html(rowData.grand_total.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }));
                    },
                },
                {
                    targets: 3,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        var result = parseFloat(rowData.result_divide)
                        result = result.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' })
                        $(td).html(result);
                    },
                },
                {
                    targets: 4,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        var transaction_date = rowData.transaction_date
                        var currDate = new Date(transaction_date)
                        var currMonth = currDate.toLocaleString('default', { month: 'long' })
                        var currYear = currDate.getFullYear()
                        var format = currDate.getDate() + "-"+ currMonth +"-"+ currYear
                        $(td).html(format);
                    },
                },
            ],
            ajax:{
                url :  '/api/analytics/report/basket-size',
                type: "GET",
                data: {
                    start_date:start_date, 
                    end_date : end_date,
                    today : today,
                    this_month : this_month,
                    this_year : this_year
                }
            },
        })
    }
             
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
@endsection

@section('pagespecificscripts')
   
@stop