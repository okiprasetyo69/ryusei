
@extends('layout.home')
@section('title','Transaksi')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.css" rel="stylesheet" />
<style> 
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        width: 800px;
        margin: 0 auto;
    }
</style>
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
                <li class="breadcrumb-item">
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
                        <div class="row mt-2">
                            <div class="col-md-4"> 
                                <div class="col mt-2">
                                    <label> <strong><span> Pencarian : </span></strong> </label>
                                    <div class="form-group">
                                        <select name="search_type" id="search_type" class="form-control">
                                            <option value=""> - Pilih Tipe -</option>
                                            <option value="1"> Nomor Order </option>
                                            <option value="2"> Tracking Number </option>
                                            <option value="3"> Kode SKU </option>
                                        </select>
                                    </div>
                                    <div class="form-group mt-2">
                                        <input type="text" name="filter_name" class="form-control" id="filter_name" placeholder="Masukkan kata kunci" autofocus/>
                                    </div>
                                </div>
                                <div class="col mt-2">
                                    <label> <strong><span>Sales Channel : </span></strong> </label>
                                    <div class="form-group">
                                        <select name="sales_channel_id" class="form-control" id="sales_channel_id"> 
                                            <option value=""> - Pilih Channel - </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4"> 
                                <div class="col mt-2">
                                    <label> <strong><span>Kloter : </span></strong> </label>
                                    <div class="form-group">
                                        <select name="group_id" class="form-control" id="group_id"> 
                                            <option value=""> - Pilih Kloter - </option>
                                            <option value="1">Kloter-1 </option>
                                            <option value="2">Kloter-2 </option>
                                            <option value="3">Kloter-3 </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col mt-2">
                                    <label> <strong><span>Tipe Pembayaran : </span></strong> </label>
                                    <div class="form-group">
                                        <select name="payment_method_id" class="form-control" id="payment_method_id"> 
                                            <option value=""> - Pilih Pembayaran - </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col mt-2"> 
                                    <label> <strong><span>Tanggal Order : </span></strong> </label>
                                    <div class="form-group">
                                            <input type="text" class="form-control" id="order_date">
                                        </div>
                                    </div>
                                    <label class="mt-2"> <strong><span>Tanggal Proses Order : </span></strong> </label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="process_order_date">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mt-2">
                                <button type="button" class="btn btn-sm btn-success rounded-pill float-right" id="btn-search"><i class="bi bi-search"></i> Cari </button>
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
                                <div class="table-responsive">
                                    <table class="table table-striped row-border order-column" id="table-transaction" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Sales Channel</th>
                                                <th scope="col">Nomor Order</th>
                                                <th scope="col">Tracking Number</th>
                                                <th scope="col">Kode SKU</th>
                                                <th scope="col">Qty</th>
                                                <th scope="col">Harga Sat</th>
                                                <th scope="col">Nama SKU</th>
                                                <th scope="col">Size</th>
                                                <th scope="col">Tgl Order</th>
                                                <th scope="col">Tgl Proses Order</th>
                                                <th scope="col">Keloter</th>
                                                <th scope="col">Pembayaran</th>
                                                <th scope="col">Kode Pos</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Total</th>
                                                <th scope="col">Biaya Admin %</th>
                                                <th scope="col">Biaya Admin</th>
                                                <th scope="col">Total Bersih</th>
                                                <th scope="col">SKU Ok ?</th>
                                                <th scope="col">Kategori</th>
                                                <th scope="col">Harga Barcode</th>
                                                <th scope="col">Diskon</th>
                                                <th scope="col">Kota</th>
                                                <th scope="col">Customer Name</th>
                                                <th scope="col">Customer Code</th>
                                                <th scope="col">Tgl Order</th>
                                                <th scope="col">No Order</th>
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
    var table
    var order_date
    var process_order_date
    var order_number
    var tracking_number
    var sku_code
    var sales_channel_id
    var payment_method_id
    var group_id

    $(document).ready(function () {
        var now = new Date();
        var month = (now.getMonth() + 1);               
        var day = now.getDate();

        if (month < 10) 
            month = "0" + month;
        if (day < 10) 
            day = "0" + day;
        var today = now.getFullYear() + '-' + month + '-' + day;
       

        $( "#order_date" ).datepicker({
            format: 'yyyy-mm-dd',
            defaultDate: new Date(),
        });
        $('#order_date').val(today);

        $("#process_order_date" ).datepicker({
            format: 'yyyy-mm-dd',
            defaultDate: new Date(),
        });
        $('#process_order_date').val(today);

        $("#filter_name").hide()

        // filter type
        $("#search_type").change(function (e) { 
            e.preventDefault();
            var value = this.value
            if(value == "" ){
                $("#filter_name").hide()
            }
            // Search
            if(value == 1){
                $("#filter_name").show()
                $("#filter_name").attr('placeholder','Masukkan nomor order').focus();

                $("#filter_name").on("keyup press", function(e){
                    e.preventDefault()
                    order_number = $("#filter_name").val()
                    loadTransaction(order_number)
                })
            }

            if(value == 2){
                $("#filter_name").show()
                $("#filter_name").attr('placeholder','Masukkan tracking number').focus();
                $("#filter_name").on("keyup press", function(e){
                    e.preventDefault()
                    tracking_number = $("#filter_name").val()
                    loadTransaction(null, tracking_number)
                })
            }
            if(value == 3){
                $("#filter_name").show()
                $("#filter_name").attr('placeholder','Masukkan Kode SKU').focus();
                $("#filter_name").on("keyup press", function(e){
                    e.preventDefault()
                    sku_code = $("#filter_name").val()
                    loadTransaction(null, null, sku_code)
                })
            }
        });

        $("#btn-search").on("click", function(e){
            e.preventDefault()
            order_date = $( "#order_date" ).val()
            process_order_date = $( "#process_order_date" ).val()
            sales_channel_id = $("#sales_channel_id option:selected").val()
            payment_method_id = $("#payment_method_id option:selected").val()
            group_id = $("#group_id option:selected").val()
            loadTransaction(order_number=order_number, tracking_number=tracking_number, sku_code= sku_code, order_date = order_date, process_order_date=process_order_date, sales_channel_id=sales_channel_id, payment_method_id=payment_method_id, group_id)
        })

        order_date =  $('#order_date').val()
        process_order_date = $('#process_order_date').val()
        loadTransaction(null, null, null, order_date, process_order_date, null, null, null)
        getPaymentMethod()
        getSalesChannel()
    });

    function loadTransaction(order_number=null, tracking_number=null, sku_code= null, order_date = null, process_order_date=null, sales_channel_id=null, payment_method_id=null, group_id=null){
        if (table != null) {
            table.destroy();
        }

        table = $("#table-transaction").DataTable({
            lengthChange: false,
            searching: false,
            destroy: true,
            processing: true,
            serverSide: true,
            bAutoWidth: true,
            scrollCollapse : true,
            ajax:{
                url :  '/api/transaction',
                type: "GET",
                data: {
                    // page : 1,
                    // limit : 10,
                    order_number : order_number,
                    tracking_number : tracking_number,
                    sku: sku_code,
                    order_date : order_date,
                    process_order_date : process_order_date,
                    sales_channel_id : sales_channel_id,
                    payment_method_id: payment_method_id,
                    group_id : group_id
                }
            },
            columns: [
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },

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
                        //console.log(rowData.channel.name)
                        $(td).html(rowData.channel.name);
                    },
                },
                {
                    targets: 2,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).html(rowData.order_number);
                    },
                },
                {
                    targets: 3,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).html(rowData.tracking_number);
                    },
                },
                {
                    targets: 4,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).html(rowData.product.sku);
                    },
                },
                {
                    targets: 5,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).html(rowData.qty);
                    },
                },
                {
                    targets: 6,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).html(rowData.unit_price.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }));
                    },
                },
                {
                    targets: 7,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).html(rowData.product.name);
                    },
                },
                {
                    targets: 8,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).html(rowData.product.sizes.name);
                    },
                },
                {
                    targets: 9,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).html(rowData.order_date);
                    },
                },
                {
                    targets: 10,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).html(rowData.process_order_date);
                    },
                },
                {
                    targets: 11,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        var group = ""
                        if(rowData.group_id == 1){
                            group = "Kloter - 1"
                        }

                        if(rowData.group_id == 2){
                            group = "Kloter - 2"
                        }

                        if(rowData.group_id == 3){
                            group = "Kloter - 3"
                        }

                        $(td).html(group);
                    },
                },
                {
                    targets: 12,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).html(rowData.payment.name);
                    },
                },
                {
                    targets: 13,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        var postal_code = rowData.postal_code
                        if(rowData.postal_code == ""){
                           postal_code = "-"
                        } else {
                            postal_code = rowData.postal_code
                        }
                        $(td).html(postal_code);
                    },
                },
                {
                    targets: 14,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        var status = ""
                        if(rowData.product.status == 1){
                            status = "Ready"
                        }

                        if(rowData.product.status == 0){
                            status = "Not Ready"
                        }
                        $(td).html(status);
                    },
                },
                {
                    targets: 15,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        
                        $(td).html(rowData.total.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }));
                    },
                },
                {
                    targets: 16,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                    
                        $(td).html(rowData.channel.admin_charge + "%");
                    },
                },
                {
                    targets: 17,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).html(rowData.admin_charge.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }));
                    },
                },
                {
                    targets: 18,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).html(rowData.total_net.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }))
                    },
                },
                {
                    targets: 19,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        var sku_ok = ""
                        if(rowData.product.sku != ""){
                            sku_ok = "Yes"
                        }
                        $(td).html(sku_ok);
                    },
                },
                {
                    targets: 20,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).html(rowData.product.category.name);
                    },
                },
                {
                    targets: 21,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).html(rowData.product.price.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }));
                    },
                },
                {
                    targets: 22,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).html(rowData.discount + "%");
                    },
                },
                {
                    targets: 23,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).html("Kota");
                    },
                },
                {
                    targets: 24,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        var customer_name = rowData.channel.name
                        $(td).html(customer_name);
                    },
                },
                {
                    targets: 25,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        var customer_code = rowData.channel.code
                        $(td).html(customer_code);
                    },
                },
                {
                    targets: 26,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).html(rowData.order_date);
                    },
                },
                {
                    targets: 27,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).html(rowData.order_number);
                    },
                },
                {
                    targets: 28,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        var html = "<a class='btn btn-sm btn-warning' href='/transaction/edit/"+rowData.id+" '> Ubah </a> <button type='button' class='btn btn-sm btn-danger' onclick='confirm("+rowData.id+")'> Hapus </button>"
                        $(td).html(html);
                    },
                },
            ]
        })
    }

    // Deprecated Function
    function getTransaction(order_number=null, tracking_number=null, sku_code= null, order_date = null, process_order_date=null, sales_channel_id=null, payment_method_id=null, group_id=null){
        table = $("#table-transaction").DataTable({
            "fixedColumns": true,
            "fixedColumns": {
                "start": 1,
            },
            "lengthChange": false,
			"searching": false,
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "bAutoWidth": true,
            "scrollX" : true,
            "scrollCollapse" : true,
            "language": {
                "emptyTable": "Data tidak tersedia",
                "zeroRecords": "Tidak ada data yang ditemukan",
                "infoFiltered": "",
                "infoEmpty": "",
                "paginate": {
                    "previous": "‹",
                    "next": "›",
                },
                "info": "Menampilkan _START_ dari _END_ dari _TOTAL_ Transaksi",
                "aria": {
                    "paginate": {
                        "previous": "Previous",
                        "next": "Next",
                    },
                },
            },
            "columns": [
                {
                    data: null,
                    width: "5%",
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },
                {
                    data: null,
                },

            ],
            "columnDefs": [
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
                        //console.log(rowData.channel.name)
                        $(td).html(rowData.channel.name);
                    },
                },
                {
                    targets: 2,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).html(rowData.order_number);
                    },
                },
                {
                    targets: 3,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).html(rowData.tracking_number);
                    },
                },
                {
                    targets: 4,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).html(rowData.product.sku);
                    },
                },
                {
                    targets: 5,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).html(rowData.qty);
                    },
                },
                {
                    targets: 6,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).html(rowData.unit_price.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }));
                    },
                },
                {
                    targets: 7,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).html(rowData.product.name);
                    },
                },
                {
                    targets: 8,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).html(rowData.product.sizes.name);
                    },
                },
                {
                    targets: 9,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).html(rowData.order_date);
                    },
                },
                {
                    targets: 10,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).html(rowData.process_order_date);
                    },
                },
                {
                    targets: 11,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        var group = ""
                        if(rowData.group_id == 1){
                            group = "Kloter - 1"
                        }

                        if(rowData.group_id == 2){
                            group = "Kloter - 2"
                        }

                        if(rowData.group_id == 3){
                            group = "Kloter - 3"
                        }

                        $(td).html(group);
                    },
                },
                {
                    targets: 12,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).html(rowData.payment.name);
                    },
                },
                {
                    targets: 13,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        var postal_code = rowData.postal_code
                        if(rowData.postal_code == ""){
                           postal_code = "-"
                        } else {
                            postal_code = rowData.postal_code
                        }
                        $(td).html(postal_code);
                    },
                },
                {
                    targets: 14,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        var status = ""
                        if(rowData.product.status == 1){
                            status = "Ready"
                        }

                        if(rowData.product.status == 0){
                            status = "Not Ready"
                        }
                        $(td).html(status);
                    },
                },
                {
                    targets: 15,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        
                        $(td).html(rowData.total.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }));
                    },
                },
                {
                    targets: 16,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                    
                        $(td).html(rowData.channel.admin_charge + "%");
                    },
                },
                {
                    targets: 17,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).html(rowData.admin_charge.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }));
                    },
                },
                {
                    targets: 18,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).html(rowData.total_net.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }))
                    },
                },
                {
                    targets: 19,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        var sku_ok = ""
                        if(rowData.product.sku != ""){
                            sku_ok = "Yes"
                        }
                        $(td).html(sku_ok);
                    },
                },
                {
                    targets: 20,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).html(rowData.product.category.name);
                    },
                },
                {
                    targets: 21,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).html(rowData.product.price.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }));
                    },
                },
                {
                    targets: 22,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).html(rowData.discount + "%");
                    },
                },
                {
                    targets: 23,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).html("Kota");
                    },
                },
                {
                    targets: 24,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        var customer_name = rowData.channel.name
                        $(td).html(customer_name);
                    },
                },
                {
                    targets: 25,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        var customer_code = rowData.channel.code
                        $(td).html(customer_code);
                    },
                },
                {
                    targets: 26,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).html(rowData.order_date);
                    },
                },
                {
                    targets: 27,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).html(rowData.order_number);
                    },
                },
                {
                    targets: 28,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        var html = "<a class='btn btn-sm btn-warning' href='/transaction/edit/"+rowData.id+" '> Ubah </a> <button type='button' class='btn btn-sm btn-danger' onclick='confirm("+rowData.id+")'> Hapus </button>"
                        $(td).html(html);
                    },
                },
            ],
            "ajax": function(data, callback, settings) {
                let length = data.length
                let pages = (data.start / 10) + 1
                $.get('/api/transaction', {
                        _token: "{{ csrf_token() }}",
                        limit: length,
                        page: pages,
                        order_number : order_number,
                        tracking_number : tracking_number,
                        sku: sku_code,
                        order_date : order_date,
                        process_order_date : process_order_date,
                        sales_channel_id : sales_channel_id,
                        payment_method_id: payment_method_id,
                        group_id : group_id
                    }, 
                    function(res) {
                        callback({
                            recordsTotal: res.recordsTotal,
                            recordsFiltered: res.recordsFiltered,
                            data: res.data
                    });
                });
            },
        })
    }
    // end deprecated function

    function getPaymentMethod(){
        $.ajax({
            type: "GET",
            url: "/api/payment-method",
            data: "data",
            dataType: "JSON",
            success: function (response) {
                var data = response.data
                var option = ""
                $("#payment_method_id").html()
                $.each(data, function (i, val) { 
                    option += "<option value="+val.id+"> "+val.name+" </option>"
                });
                $("#payment_method_id").append(option)
            }
        });
    }

    function getSalesChannel(){
        $.ajax({
            type: "GET",
            url: "/api/sales-channel",
            data: "data",
            dataType: "JSON",
            success: function (response) {
                var data = response.data
                var option = ""
                $("#sales_channel_id").html()
                $.each(data, function (i, val) { 
                    option += "<option value="+val.id+"> "+val.name+" - "+val.year+" </option>"
                });
                $("#sales_channel_id").append(option)
            }
        });
    }

    function confirm(id){
        $.confirm({
            title: 'Pesan ',
            content: 'Apa anda yakin akan menghapus data ini ?',
            buttons: {
                Ya: {
                    btnClass: 'btn-red any-other-class',
                    action: function(){
                        remove(id)
                    }
                },
                Batal: {
                    btnClass: 'btn-secondary',
                },
            }
        });
    }

    function remove(id){
        $.ajax({
            type: "POST",
            url: "/api/transaction/delete",
            data: {
                id : id,
            },
            dataType: "JSON",
            success: function (response) {
                if(response.status == 200){
                    $.confirm({
                        title: 'Pesan',
                        content: 'Data kategori berhasil dihapus !',
                        buttons: {
                            Ya: {
                                btnClass: 'btn-success any-other-class',
                                action: function(){
                                    getTransaction()
                                }
                            },
                        }
                    });
                }
            }
        });
    }

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.js"></script>
@endsection
@section('pagespecificscripts')
   
@stop