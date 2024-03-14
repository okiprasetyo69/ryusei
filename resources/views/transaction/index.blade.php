
@extends('layout.home')
@section('title','Transaksi')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.css" rel="stylesheet" />
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Management Transaksi</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">Penjualan</a>
                </li>
                <li class="breadcrumb-item active">
                    <a href="/transaction">Transaksi Penjualan</a>
                </li>
                <li class="breadcrumb-item active">
                    <a href="/transaction/add">Tambah</a>
                </li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mt-4">
                            <div class="col-md-2">
                                <label> <strong><span>Tipe Pencarian : </span></strong> </label>
                            </div>
                            <div class="col-md-2">
                                <label> <strong><span>Tanggal Awal : </span></strong> </label>
                            </div>
                            <div class="col-md-2">
                                <label> <strong><span>Tanggal Akhir : </span></strong> </label>
                            </div>
                            <div class="col-md-2">
                                <label> <strong><span>Channel : </span></strong> </label>
                            </div>
                            <div class="col-md-2">
                                <label> <strong><span>Kloter : </span></strong> </label>
                            </div>
                            <div class="col-md-2">
                                <label> <strong><span>Tipe Bayar : </span></strong> </label>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select name="search_type" id="search_type" class="form-control">
                                        <option value=""> - Pilih Tipe -</option>
                                        <option value="1"> Nomor Order </option>
                                        <option value="2"> Tracking Number </option>
                                        <option value="3"> Kode SKU </option>
                                    </select>
                                </div>
                                <div class="form-group mt-4">
                                <input type="text" name="filter_name" class="form-control" id="filter_name" placeholder="Masukkan kata kunci" autofocus/>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="start_date">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="end_date">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select name="sales_channel" class="form-control" id="sales_channel"> 
                                        <option value=""> - Pilih Channel - </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select name="kloter" class="form-control" id="kloter"> 
                                        <option value=""> - Pilih Kloter - </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select name="payment_type" class="form-control" id="payment_type"> 
                                        <option value=""> - Pilih Pembayaran - </option>
                                    </select>
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
                            <div class="col-md-12">
                                <div class="">
                                    <table class="table table-striped" id="table-transaction">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Sales Channel</th>
                                                <th scope="col">Nomor Order</th>
                                                <th scope="col">Tracking Number</th>
                                                <th scope="col">Kode SKU</th>
                                                <th scope="col">Qty</th>
                                                <th scope="col">Harga Sat</th>
                                                <th scope="col">Tgl Order</th>
                                                <th scope="col">Tgl Proses Order</th>
                                                <th scope="col">Total</th>
                                                <th scope="col">Aksi</th>
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
        var now = new Date();
        var month = (now.getMonth() + 1);               
        var day = now.getDate();
        if (month < 10) 
            month = "0" + month;
        if (day < 10) 
            day = "0" + day;
        var today = now.getFullYear() + '-' + month + '-' + day;
       

        $( "#start_date" ).datepicker({
            format: 'yyyy-mm-dd',
            defaultDate: new Date(),
        });
        $('#start_date').val(today);

        $("#end_date" ).datepicker({
            format: 'yyyy-mm-dd',
            defaultDate: new Date(),
        });
        $('#end_date').val(today);

        $("#filter_name").hide()

        $("#search_type").change(function (e) { 
            e.preventDefault();
            var value = this.value
            if(value == "" ){
                $("#filter_name").hide()
            }

            if(value == 1){
                $("#filter_name").show()
                $("#filter_name").attr('placeholder','Masukkan nomor order').focus();
            }
            if(value == 2){
                $("#filter_name").show()
                $("#filter_name").attr('placeholder','Masukkan tracking number').focus();
            }
            if(value == 3){
                $("#filter_name").show()
                $("#filter_name").attr('placeholder','Masukkan Kode SKU').focus();
            }
          
        });
    });


</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.js"></script>
@endsection
@section('pagespecificscripts')
   
@stop