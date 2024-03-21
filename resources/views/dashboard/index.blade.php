
@extends('layout.home')
@section('title','Dashboard')

@section('content')

<main id="main" class="main">

<div class="pagetitle">
<h1>Dashboard</h1>
<nav>
    <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
    <li class="breadcrumb-item active">Dashboard</li>
    </ol>
</nav>
</div><!-- End Page Title -->

<section class="section dashboard">
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
                    <h5 class="card-title">Performance</h5>
                    <div>
                        <canvas id="performanceStoreChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 445px;" width="445" height="250" class="chartjs-render-monitor"></canvas>
                    </div>
                    <div class="col-md-12 mt-2">
                        <div id="actualData"> </div>
                    </div>

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
                <h5 class="card-title">Toko Terbaik <span>| Today</span></h5>

                <table class="table table-striped" id="table-best-store">
                    <thead>
                    <tr class="text-center">
                        <th scope="col">#</th>
                        <th scope="col">Sumber</th>
                        <th scope="col">Penjualan Bersih</th>
                        <th scope="col">Qty Terjual</th>
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
          </div><!-- End Top Selling -->

      </div>
    </div><!-- End Left side columns -->

    <!-- Right side columns -->
    <div class="col-lg-4">
      <!-- Ratio Selling -->
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
            <h5 class="card-title">Apapun <span>| Today</span></h5>
            <div id="trafficChart" style="min-height: 400px;" class=""></div>

          </div>
      </div><!-- End Website Traffic -->
    
    </div><!-- End Right side columns -->

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
    var currentMonth
    var this_year
    var myChart
    $(document).ready(function () {
      
        totalSoldWithQty()
        bestStoreChannelSeller()
        bestProductSeller()
        loadChart()
       
        // filter
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
        $("#filter-today-best-channel").on("click", function(e){
            e.preventDefault()
            now = formattedDate
            bestStoreChannelSeller(null, null,now,null,null)
        })
        
        $("#filter-month-best-channel").on("click", function(e){
            e.preventDefault()
            currentMonth = today.getMonth() + 1
            bestStoreChannelSeller(null, null,null,currentMonth,null)
        })

        $("#filter-year-best-channel").on("click", function(e){
            e.preventDefault()
            this_year = year
            bestStoreChannelSeller(null, null,null,null,this_year)
        })

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
        $("#filter-today-chart").on("click", function(e){
            e.preventDefault()
            now = formattedDate
            filterChart(null, null,now,null,null)
        })
        $("#filter-month-chart").on("click", function(e){
            e.preventDefault()
            currentMonth = today.getMonth() + 1
            filterChart(null, null,null,currentMonth,null)
        })
        $("#filter-year-chart").on("click", function(e){
            e.preventDefault()
            this_year = year
            filterChart(null, null,null,null,this_year)
        })
        // --------------------------------------------------------------- //
        
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
                var total_sold =  formatter.format(data.total_sold);
                if(data != null){
                    $("#total_sold").text("| " + total_sold)
                    $("#qty").text(data.qty + " item")
                }

            }
        });
    }

    function bestStoreChannelSeller(start_date = null, end_date = null, today=null, this_month=null, this_year=null){
        $.ajax({
            type: "GET",
            url: "/api/analytics/best-store",
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
                $("#table-best-store").find("tr:gt(0)").remove();
                $.each(data, function (i, val) {
                    total_sell = formatter.format(val.total_sell)
                    row += "<tr class='text-center'><td>"+ (number++) +"</td> <td>"+val.name+"</td><td> "+total_sell+" </td><td>"+val.total_qty+"</td></tr>"
                });
                $("#table-best-store > tbody:last-child").append(row); 
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
            url: "/api/analytics/chart-performance",
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
                        label: 'Performnace Channel',
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
            url: "/api/analytics/chart-performance",
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
                        label: 'Performnace Channel',
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
             
</script>
@endsection

@section('pagespecificscripts')
   
@stop