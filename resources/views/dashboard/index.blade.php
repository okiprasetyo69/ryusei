
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

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                </ul>
                </div>

                <div class="card-body">
                <h5 class="card-title">Penjualan <span> | Rp. </span></h5>

                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-cart"></i>
                    </div>
                    <div class="ps-3">
                    <h6>145</h6>
                    <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span>

                    </div>
                </div>
                </div>

            </div>
          </div>
          <!-- End Sales Card -->

          <!-- Discount Card -->
          <div class="col-xxl-4 col-md-6">
            <div class="card info-card revenue-card">
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
                <div class="card-body">
                <h5 class="card-title">Diskon <span> | Rp. </span></h5>
                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="ps-3">
                    <h6>$3,264</h6>
                    <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span>

                    </div>
                </div>
                </div>
            </div>
          </div>
          <!-- End Discount Card -->

          <!-- Retur Card -->
          <div class="col-xxl-4 col-xl-12">
            <div class="card info-card customers-card">
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
                <div class="card-body">
                <h5 class="card-title">Retur <span> | Rp .</span></h5>

                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                    <h6>1244</h6>
                    <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span>

                    </div>
                </div>

                </div>
            </div>

          </div>
          <!-- End Retur Card -->

          <!-- Omset Card -->
          <div class="col-xxl-4 col-md-6">
            <div class="card info-card sales-card">

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

                <div class="card-body">
                <h5 class="card-title">Penjualan Bersih <span> | Rp. </span></h5>

                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-shop-window"></i>
                    </div>
                    <div class="ps-3">
                    <h6>145</h6>
                    <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span>

                    </div>
                </div>
                </div>

            </div>
          </div>
          <!-- End Omset Card -->

          <!-- Modal Card -->
          <div class="col-xxl-4 col-md-6">
            <div class="card info-card sales-card">

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

                <div class="card-body">
                <h5 class="card-title">Modal <span> | Rp. </span></h5>

                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-alexa"></i>
                    </div>
                    <div class="ps-3">
                    <h6>145</h6>
                    <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span>

                    </div>
                </div>
                </div>

            </div>
          </div>
          <!-- End Modal Card -->

          <!-- Keuntungan Card -->
          <div class="col-xxl-4 col-xl-12">
            <div class="card info-card customers-card">
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
                <div class="card-body">
                <h5 class="card-title">Keuntungan <span> | Rp .</span></h5>

                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-cash-stack"></i>
                    </div>
                    <div class="ps-3">
                    <h6>1244</h6>
                    <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span>

                    </div>
                </div>
                </div>
            </div>
          </div>
          <!-- End Retur Card -->

          <!-- Reports -->
          <div class="col-12">
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

                <div class="card-body">
                <h5 class="card-title">Reports <span>/Today</span></h5>

                <div id="reportsChart"></div>

                <script>
                    document.addEventListener("DOMContentLoaded", () => {
                    new ApexCharts(document.querySelector("#reportsChart"), {
                        series: [{
                        name: 'Sales',
                        data: [31, 40, 28, 51, 42, 82, 56],
                        }, {
                        name: 'Revenue',
                        data: [11, 32, 45, 32, 34, 52, 41]
                        }, {
                        name: 'Customers',
                        data: [15, 11, 32, 18, 9, 24, 11]
                        }],
                        chart: {
                        height: 350,
                        type: 'area',
                        toolbar: {
                            show: false
                        },
                        },
                        markers: {
                        size: 4
                        },
                        colors: ['#4154f1', '#2eca6a', '#ff771d'],
                        fill: {
                        type: "gradient",
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.3,
                            opacityTo: 0.4,
                            stops: [0, 90, 100]
                        }
                        },
                        dataLabels: {
                        enabled: false
                        },
                        stroke: {
                        curve: 'smooth',
                        width: 2
                        },
                        xaxis: {
                        type: 'datetime',
                        categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z", "2018-09-19T06:30:00.000Z"]
                        },
                        tooltip: {
                        x: {
                            format: 'dd/MM/yy HH:mm'
                        },
                        }
                    }).render();
                    });
                </script>
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

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                </ul>
                </div>

                <div class="card-body">
                <h5 class="card-title">Toko Terbaik <span>| Today</span></h5>

                <table class="table table-borderless datatable">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Sumber</th>
                        <th scope="col">Penjualan Bersih</th>
                        <th scope="col">Retur</th>
                        <th scope="col">Keuntungan</th>
                        <th scope="col">Qty Terjual</th>
                        <th scope="col">Penjualan per Hari</th>
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

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                </ul>
                </div>

                <div class="card-body pb-0">
                <h5 class="card-title">Produk Paling Laku <span>| Today</span></h5>

                <table class="table table-borderless">
                    <thead>
                    <tr>
                        <th scope="col">Rank</th>
                        <th scope="col">Product</th>
                        <th scope="col">Qty Terjual</th>
                        <th scope="col">Penjualan Per Hari</th>
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
          <h5 class="card-title">Rasio Penjualan <span>| Today</span></h5>

          <div id="trafficChart" style="min-height: 400px;" class="echart"></div>

          <script>
              document.addEventListener("DOMContentLoaded", () => {
              echarts.init(document.querySelector("#trafficChart")).setOption({
                  tooltip: {
                  trigger: 'item'
                  },
                  legend: {
                  top: '5%',
                  left: 'center'
                  },
                  series: [{
                  name: 'Access From',
                  type: 'pie',
                  radius: ['40%', '70%'],
                  avoidLabelOverlap: false,
                  label: {
                      show: false,
                      position: 'center'
                  },
                  emphasis: {
                      label: {
                      show: true,
                      fontSize: '18',
                      fontWeight: 'bold'
                      }
                  },
                  labelLine: {
                      show: false
                  },
                  data: [{
                      value: 1048,
                      name: 'Penjualan'
                      },
                      {
                      value: 735,
                      name: 'Retur'
                      },
                      {
                      value: 580,
                      name: 'All'
                      },
                      {
                      value: 484,
                      name: 'Inv'
                      },
                     
                  ]
                  }]
              });
              });
          </script>

          </div>
      </div><!-- End Website Traffic -->
    
    </div><!-- End Right side columns -->

</div>
</section>

</main><!-- End #main -->

@endsection

@section('pagespecificscripts')
   
@stop