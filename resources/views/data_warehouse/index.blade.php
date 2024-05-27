
@extends('layout.home')
@section('title','Gudang Data')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/fixedcolumns/5.0.0/css/fixedColumns.dataTables.css" rel="stylesheet" />
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Management Penjualan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="#">Gudang Data</a></li>
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
                            <div class="col-md-2">
                                <label> <strong><span> Tanggal Faktur Awal </span></strong> </label>
                            </div>
                            <div class="col-md-2">
                                <label> <strong><span> Tanggal Faktur Akhir </span></strong> </label>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="text" name="filter_invoice_number" class="form-control" id="filter_invoice_number" placeholder="Masukkan nomor faktur" autofocus/>
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
                                    <button type="button" class="btn btn-sm btn-success" style="border-radius:50px;" id="btn-search"> <i class="bi bi-search"></i> Cari </button>
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
                            <div class="col-md-2">
                                <label> <strong><span> Tanggal Awal Sync </span></strong> </label>
                            </div>
                            <div class="col-md-2">
                                <label> <strong><span> Tanggal Akhir Sync </span></strong> </label>
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
                                    <label id="lbl-sync">Sync Faktur</label>
                                </button>
                            </div>
                            <div class="col-md-2"> </div>
                            <div class="col-md-4">
                                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                    <i class="bi bi-star me-1"></i>
                                    Total Faktur : 
                                    <label id="lbl-total">-</label> 

                                </div>
                            </div>
                            <div class="table-responsive mt-4">
                                <table class="table table-striped" id="table-data-warehouse-invoice">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">No Faktur</th>
                                            <th scope="col">Pelanggan</th>
                                            <th scope="col">No Ref</th>
                                            <th scope="col">Tgl Faktur</th>
                                            <th scope="col">Jatuh Tempo</th>
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
    </section>
</main>
<!-- End #main -->

<script type="text/javascript"> 
    
    var table, invoice_number, start_date, end_date

      $(document).ready(function(){
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

        // -------------- END FILTER SYNC DATE --------------------- //

        // filter button
        $("#btn-search").on("click", function(e){
            e.preventDefault()
            invoice_number = $("#filter_invoice_number").val()
            start_date = $("#filter_start_date" ).val().split("-").reverse().join("-")
            end_date = $("#filter_end_date" ).val().split("-").reverse().join("-")
            loadInvoiceWarehouseData(invoice_number, start_date, end_date)
        })
        
        // sync data
        $("#btn-sync").on("click", function(e){
            e.preventDefault()
            var transactionDateFrom = $("#sync_start_date" ).val().split("-").reverse().join("-")
            var transactionDateTo = $("#sync_end_date" ).val().split("-").reverse().join("-")

            if(transactionDateFrom == ""){
                $.alert({
                    title: 'Pesan !',
                    content: 'Tanggal Awal Sync tidak boleh kosong !',
                });
                return 
            }

            if(transactionDateTo == ""){
                $.alert({
                    title: 'Pesan !',
                    content: 'Tanggal Akhir Sync tidak boleh kosong !',
                });
                return 
            }

            $("#btn-sync").attr("disabled", true);
            $("#spinner-sync").attr("class", "spinner-grow spinner-grow-sm")
            $("#lbl-sync").text("Loading...")
            $.ajax({
                type: "GET",
                url: "/jubelio/transaction/invoice",
                data: {
                    start_date : transactionDateFrom,
                    end_date : transactionDateTo
                },
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
                                        loadInvoiceWarehouseData()
                                    }
                                },
                            }
                        });
                    }

                }
            });
        })

        start_date = $("#filter_start_date" ).val().split("-").reverse().join("-")
        end_date = $("#filter_end_date" ).val().split("-").reverse().join("-")
        loadInvoiceWarehouseData(invoice_number, start_date, end_date)
        getTotalInvoice()

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
            $("#lbl-sync").text("Sync Faktur")
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


      })

      function getTotalInvoice(){
        $.ajax({
            type: "GET",
            url: "/api/data-warehouse/invoice/total",
            data: "data",
            dataType: "JSON",
            success: function (response) {
                var data = response.data
                var total_invoice = data.total_invoice.toLocaleString('id', { style: 'decimal', useGrouping: true, minimumFractionDigits: 0 })
                $("#lbl-total").text(total_invoice)
            }
        });
      }

      function loadInvoiceWarehouseData(invoice_number=null, start_date=null, end_date=null){
            if (table != null) {
                table.destroy();
            }

            table =  $("#table-data-warehouse-invoice").DataTable({
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
                info: "Menampilkan _START_ dari _END_ dari _TOTAL_ Invoice",
                aria: {
                        paginate: {
                            previous: "Previous",
                            next: "Next",
                        },
                    },
                },
                ajax:{
                    url : '/api/data-warehouse/invoice',
                    type: "GET",
                    data: {
                        invoice_number: invoice_number,
                        start_date: start_date,
                        end_date: end_date,
                        // page : 1,
                        // limit : 10
                    }
                },
                columns: [
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
                            $(td).html(rowData.invoice_number);
                        },
                    },
                    {
                        targets: 2,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            $(td).html(rowData.customer_name);
                        },
                    },
                    {
                        targets: 3,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            $(td).html(rowData.customer_reference);
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
                            var due_date = rowData.due_date
                            date = new Date(due_date)
                            month = date.toLocaleString('default', { month: 'long' })
                            year = date.getFullYear()
                            format = date.getDate() + "-"+ month +"-"+ year

                            $(td).html(format);
                        },
                    },
                    {
                        targets: 6,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            
                            $(td).html(rowData.grand_total.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }));
                        },
                    },
                    {
                        targets: 7,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            $(td).html(rowData.due.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }));
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
                            var html = ""
                            html = "<a href='/data-warehouse/invoice/detail/"+ rowData.id +"' class='btn btn-sm btn-warning'> Detail </button>"
                            $(td).html(html);
                        },
                    },
                ],
            })
      }

      function detail(id=null){
        $.ajax({
            type: "POST",
            url: "/api/user/detail",
            data: {
                id : id
            },
            dataType: "JSON",
            success: function (response) {
                var data = response.data
                $("#id").val(data.id)
                $("#name").val(data.name)
                $("#email").val(data.email)
                $("#phone").val(data.phone)
                getRole(data.role_id)
                $(".title-modal").text("Ubah pengguna")
                $("#userModal").modal("show")
            }
        });
      }

      function confirm(id=null){
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

      function getRole(role_id=null){
        $.ajax({
            type: "GET",
            url: "/api/role",
            data: "data",
            dataType: "JSON",
            success: function (response) {
                var data = response.data
                $("#role_id").html("");
                    var len = 0;
                    if(response['data'] != null) {
                        len = response['data'].length
                        for(i = 0; i < len; i++) {
                            var selected = ""
                            var id = response['data'][i].id
                            var name = response['data'][i].name
                            if(id == role_id){
                                selected = "selected"
                            }
                            var option = "<option value='"+id+"' "+selected+">"+name+"</option>";
                            $("#role_id").append(option);
                    }
                }
            }
        });
      }

      function remove(id){ 
            $.ajax({
                type: "POST",
                url: "/api/user/delete",
                data: {
                    id : id,
                },
                dataType: "JSON",
                success: function (response) {
                    if(response.status == 200){
                        $.confirm({
                            title: 'Pesan',
                            content: 'Data pengguna berhasil dihapus !',
                            buttons: {
                                Ya: {
                                    btnClass: 'btn-success any-other-class',
                                    action: function(){
                                        loadUserData()
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
<script src="https://cdn.datatables.net/fixedcolumns/5.0.0/js/fixedColumns.dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
@endsection
@section('pagespecificscripts')
   
@stop