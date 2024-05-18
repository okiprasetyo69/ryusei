
@extends('layout.home')
@section('title','Sales Return')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.css" rel="stylesheet" />
<style> 
    .datepicker {
        z-index: 1050; /* Nilai z-index lebih tinggi dari nilai z-index modal */
        position: absolute;
    }
</style>
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Management Penjualan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item ">
                    <a href="#">Penjualan</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="#">Data Warehouse</a>
                </li>
                <li class="breadcrumb-item active">
                    <a href="#">Retur</a>
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
                            <div class="col-md-2">
                                <label> <strong><span>Pencarian : </span></strong> </label>
                            </div>
                            <div class="col-md-4 text-center">
                                <label> <strong><span> Tanggal Retur </span></strong> </label>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="text" name="filter_doc_number" class="form-control" id="filter_doc_number" placeholder="Masukkan nomor retur" autofocus/>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="text" name="filter_start_date" class="form-control" id="filter_start_date"/>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="text" name="filter_end_date" class="form-control" id="filter_end_date"/>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mt-1"> 
                                    <button type="button" class="btn btn-sm btn-success" style="border-radius:50px;" id="btn-filter"> <i class="bi bi-search"></i> Cari </button>
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
                            <div class="col-md-4 text-center">
                                <label> <strong><span> Tanggal Sync </span></strong> </label>
                            </div>
                        </div>
                        <div class="row mt-2"> 
                        <div class="col-md-2">
                                <div class="form-group">
                                    <input type="text" name="sync_start_date" class="form-control" id="sync_start_date"/>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="sync_end_date" class="form-control" id="sync_end_date"/>
                            </div>
                            <div class="col md-2">
                                <button type="button" class="btn btn-sm btn-danger rounded-pill" id="btn-sync">
                                    <i class="ri-24-hours-fill"></i> 
                                        <span class="" role="status" id="spinner-sync" aria-hidden="true"></span>
                                    <label id="lbl-sync">Sync Sales Retur</label>
                                </button>
                            </div>
                            <div class="col-md-2"> </div>
                            <div class="col-md-4">
                                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                    <i class="bi bi-star me-1"></i>
                                        Total Retur : 
                                    <label id="lbl-return">-</label> 
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="">
                                    <table class="table table-striped" id="table-sales-return">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">No Retur.</th>
                                                <th scope="col">Pelanggan</th>
                                                <th scope="col">No Ref</th>
                                                <th scope="col">Tgl Retur</th>
                                                <th scope="col">Toko</th>
                                                <th scope="col">Nilai</th>
                                                <th scope="col">Sisa</th>
                                                <th scope="col">Tgl Sync</th>
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



<script type="text/javascript"> 
    var name
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
        
        var convertOrderDate = day + '-' + month.toLocaleString('default', { month: 'long' }) + '-' + now.getFullYear()
        var convertProcessOrderDate = day + '-' + month.toLocaleString('default', { month: 'long' }) + '-' + now.getFullYear()

        // -------------- SETUP FILTER DATE ON LOAD --------------------- //
        $("#filter_start_date" ).datepicker({
            format: 'dd-mm-yyyy',
            defaultDate: new Date(),
        });
        $('#filter_start_date').val(convertOrderDate);

        $("#filter_end_date" ).datepicker({
            format: 'dd-mm-yyyy',
            defaultDate: new Date(),
        });
        $('#filter_end_date').val(convertProcessOrderDate);
        // -------------- END SETUP FILTER DATE ON LOAD --------------------- //

        // -------------- FILTER SYNC DATE ---------------------------------- //
        $("#sync_start_date" ).datepicker({
            format: 'dd-mm-yyyy',
            defaultDate: new Date(),
        });
        $("#sync_end_date" ).datepicker({
            format: 'dd-mm-yyyy',
            defaultDate: new Date(),
        });

        getTotalSalesReturn()
        loadSalesReturn()

        $("#btn-filter").on("click", function(e){
            e.preventDefault()
            doc_number =  $("#filter_doc_number").val()
            start_date = $("#filter_start_date" ).val().split("-").reverse().join("-")
            end_date = $("#filter_end_date" ).val().split("-").reverse().join("-")
          
            loadSalesReturn(doc_number, start_date, end_date)
        })

        // sync to jubelio
        $("#btn-sync").on("click", function(e){
            e.preventDefault()
            var transactionDateFrom = $("#sync_start_date" ).val().split("-").reverse().join("-")
            var transactionDateTo = $("#sync_end_date" ).val().split("-").reverse().join("-")
            $("#btn-sync").attr("disabled", true);
            $("#spinner-sync").attr("class", "spinner-grow spinner-grow-sm")
            $("#lbl-sync").text("Loading...")
            $.ajax({
                type: "GET",
                url: "/jubelio/sales/return",
                data: {
                    start_date : transactionDateFrom,
                    end_date : transactionDateTo
                },
                dataType: "JSON",
                success: function (response) {
                    if(response.status == 200){
                       
                        $.confirm({
                            title: 'Pesan',
                            content: response.message,
                            buttons: {
                                Ya: {
                                    btnClass: 'btn-success any-other-class',
                                },
                            }
                        });
                    }
                }
            });
          
        })
        
        // Inisialisasi Pusher
        Pusher.logToConsole = true;
        var pusher = new Pusher('12979774488ee33d9ff9', {
            cluster: 'ap1',
            forceTLS: true
        });

        var channel = pusher.subscribe('jobs');
        channel.bind('job.completed', function(data) {
            // Tampilkan pesan saat event diterima
            console.log(data)
                $("#btn-sync").attr("disabled", false);
                $("#spinner-sync").attr("class", "")
                $("#lbl-sync").text("Sync Sales Order")
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

    function loadSalesReturn(doc_number=null, start_date=null, end_date=null){
        if (table != null) {
            table.destroy();
        }

        table =  $("#table-sales-return").DataTable(
           {
                lengthChange: false,
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
                info: "Menampilkan _START_ dari _END_ dari _TOTAL_ Retur",
                aria: {
                        paginate: {
                            previous: "Previous",
                            next: "Next",
                        },
                    },
                },
                ajax:{
                    url :  '/api/data-warehouse/sales/return',
                    type: "GET",
                    data: {
                        doc_number: doc_number,
                        start_date : start_date,
                        end_date : end_date
                    }
                },
                columns: [
                    {
                        data: null, width: "5%"
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

                            var retur_number = ""
                            if(rowData.doc_number == null){
                                retur_number = "-"
                            } else {
                                retur_number = rowData.doc_number
                            }
                            $(td).html(retur_number);
                        },
                    },
                    {
                        targets: 2,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            var dates = rowData.date
                            var customer = ""
                            if(rowData.customer == null){
                                due_date = "-"
                            } else {
                                customer = rowData.customer.name
                            }
                            $(td).html(customer);
                        },
                    },
                    {
                        targets: 3,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            var invoice_number = ""
                            if(rowData.invoice_number == null){
                                invoice_number = "-"
                            } else {
                                invoice_number = rowData.invoice_number
                            }
                            $(td).html(invoice_number);

                          
                        },
                    },
                    {
                        targets: 4,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            var transaction_date = rowData.transaction_date
                            date = new Date(transaction_date)
                            month = date.toLocaleString('default', { month: 'long' })
                            year = date.getFullYear()
                            format = date.getDate() + "-"+ month +"-"+ year

                            $(td).html(format);
                        },
                    },
                    {
                        targets: 5,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            var store_name = ""
                            if(rowData.store_name == null){
                                store_name = "-"
                            } else {
                                store_name = rowData.store_name
                            }
                            $(td).html(store_name);
                        },
                    },
                    
                    {
                        targets: 6,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            var grand_total = ""
                            if(rowData.grand_total == null){
                                grand_total = "-"
                            } else {
                                grand_total = rowData.grand_total.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' })
                            }
                            $(td).html(grand_total);
                        },
                    },
                    
                    {
                        targets: 7,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            var due = ""
                            if(rowData.due == null){
                                due = "-"
                            } else {
                                due = rowData.due.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' })
                            }
                            $(td).html(due);
                         
                        },
                    },
                    {
                        targets: 8,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            var sync_date = rowData.sync_date
                            date = new Date(sync_date)
                            month = date.toLocaleString('default', { month: 'long' })
                            year = date.getFullYear()
                            format = date.getDate() + "-"+ month +"-"+ year

                            $(td).html(format);
                        },
                    },
                    {
                        targets: 9,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            var html = "<a href='/data-warehouse/sales-return/detail/"+rowData.id+"' class='btn btn-sm btn-warning'> Detail </a>"
                            $(td).html(html);
                        },
                    },
                ]
           }
        )
    }

    function getTotalSalesReturn(){
        $.ajax({
            type: "GET",
            url: "/api/data-warehouse/sales/return/total",
            data: "data",
            dataType: "JSON",
            success: function (response) {
                var data = response.data
                var total_return = data.total_return
                $("#lbl-return").text(total_return)
            }
        });
    }
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.js"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
@endsection
@section('pagespecificscripts')
   
@stop