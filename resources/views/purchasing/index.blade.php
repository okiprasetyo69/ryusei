
@extends('layout.home')
@section('title','Sales Invoice')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.css" rel="stylesheet" />
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Management Transaksi</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item ">
                    <a href="#">Pembelian</a>
                </li>
                <li class="breadcrumb-item active">
                    <a href="#">Purchase Invoice</a>
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
                                <label> <strong><span>Pencarian</span></strong> </label>
                            </div>
                            <div class="col-md-2">  
                                <label> <strong><span>Start Date </span></strong> </label>
                            </div>
                            <div class="col-md-2">  
                                <label> <strong><span>End Date </span></strong> </label>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="text" name="filter_name" class="form-control" id="filter_name" placeholder="Masukkan nomor invoice" autofocus/>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group"> 
                                    <input type="text" name="start_date" class="form-control" id="start_date"/>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group"> 
                                    <input type="text" name="end_date" class="form-control" id="end_date" />
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row mt-4"> 
                            <div class="col-md-4">   
                                <label> <strong><span>Status : </span></strong> </label>
                                <input class="form-check-input" name="filter[]" type="checkbox" value="0" id="stateOpen"> Open
                                <input class="form-check-input" name="filter[]" type="checkbox" value="1" id="stateClosed"> Closed
                                <input class="form-check-input" name="filter[]" type="checkbox" value="2" id="stateDraft"> Draft
                                <input class="form-check-input" name="filter[]" type="checkbox" value="3" id="stateVoid"> Void
                            </div>
                        </div> -->
                        <div class="row mt-4">
                            <div class="col-md-2">   
                                <div class="form-group"> 
                                    <button type="button" class="btn btn-sm btn-success" style="border-radius:50px;" id="btn-fiter"> <i class="bi bi-search"></i> Cari </button>
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
                            <div class="col md-4">
                                <button type="button" class="btn btn-primary rounded-pill" id="btn-add">
                                    <i class="bi bi-plus-circle"></i> Tambah
                                </button>
                                <button type="button" class="btn btn-sm btn-danger rounded-pill" id="btn-sync">
                                    <i class="ri-24-hours-fill"></i> 
                                    <span class="" role="status" id="spinner-sync" aria-hidden="true"></span>
                                    <label id="lbl-sync">Sync Purchase Invoice</label>
                                </button>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <div class="">
                                    <table class="table table-striped" id="table-invoice">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Doc No.</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Due Date</th>
                                                <th scope="col">Vendor</th>
                                                <th scope="col">Amount</th>
                                                <th scope="col">Amt Due</th>
                                                <th scope="col">State</th>
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
    var invoice_number, start_date, end_date, openState, closeState, draftState, voidState
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
        
        var convertDate = day + '-' + month.toLocaleString('default', { month: 'long' }) + '-' + now.getFullYear()
        var convertEndDate = day + '-' + month.toLocaleString('default', { month: 'long' }) + '-' + now.getFullYear()
        
        $("#start_date").datepicker({
            format: 'dd-mm-yyyy',
            defaultDate: new Date(),
        });
        $('#start_date').val(convertDate);

        $("#end_date").datepicker({
            format: 'dd-mm-yyyy',
            defaultDate: new Date(),
        });
        $('#end_date').val(convertEndDate);


        $("#btn-add").on("click", function(e){
            e.preventDefault()
            window.location.href = "/purchasing/invoice/add"
        })

        // filter invoice
        $("#btn-fiter").on("click", function(e){
            e.preventDefault()
            invoice_number =  $("#filter_name").val()
            start_date = $("#start_date").val()
            start_date = start_date.split("-").reverse().join("-")
            end_date = $("#end_date").val()
            end_date = end_date.split("-").reverse().join("-")
            openState = $("#stateOpen").val()
            closeState = $("#stateClosed").val()
            draftState = $("#stateDraft").val()
            voidState = $("#stateVoid").val()
          
            loadPurchaseInvoice(invoice_number, start_date, end_date, openState, closeState, draftState, voidState)
        })

        start_date = $("#start_date").val()
        start_date = start_date.split("-").reverse().join("-")
        end_date = $("#end_date").val()
        end_date = end_date.split("-").reverse().join("-")
        loadPurchaseInvoice(invoice_number, start_date, end_date, openState, closeState, draftState, voidState)

         // sync supplier
         $("#btn-sync").on("click", function(e){
            e.preventDefault()
            $("#btn-sync").attr("disabled", true);
            $("#spinner-sync").attr("class", "spinner-grow spinner-grow-sm")
            $("#lbl-sync").text("Loading...")

            $.ajax({
                type: "GET",
                url: "/jubelio/purchase/invoice",
                data: "data",
                dataType: "JSON",
                success: function (response) {

                    if(response.status == 200){
                        $("#btn-sync").attr("disabled", false);
                        $("#spinner-sync").attr("class", "")
                        $("#lbl-sync").text("Sync Product")
                        $.confirm({
                            title: 'Pesan ',
                            content: response.message,
                            buttons: {
                                Ya: {
                                    btnClass: 'btn-success any-other-class',
                                    action: function(){
                                        window.location.href = '/purchasing'
                                    }
                                },
                            }
                        });
                    }

                    if(response.status == 401){
                        $("#btn-sync").attr("disabled", false);
                        $("#spinner-sync").attr("class", "")
                        $("#lbl-sync").text("Sync Product")
                        $.confirm({
                            title: 'Pesan ',
                            content: response.message,
                            buttons: {
                                "Update Token": {
                                    btnClass: 'btn-success any-other-class',
                                    action: function(){
                                        updateUserToken()
                                    }
                                },
                            }
                        });
                    }
                }   
            });

        })


    });

    function loadPurchaseInvoice(invoice_number = null, start_date=null, end_date = null, openState=null, closeState=null, draftState= null, voidState= null){
        if (table != null) {
            table.destroy();
        }

        table =  $("#table-invoice").DataTable(
           {
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
                info: "Menampilkan _START_ dari _END_ dari _TOTAL_ Purchase Invoice",
                aria: {
                        paginate: {
                            previous: "Previous",
                            next: "Next",
                        },
                    },
                },
                ajax:{
                    url :  '/api/purchasing-invoice',
                    type: "GET",
                    data: {
                        invoice_number: invoice_number,
                        start_date : start_date,
                        end_date : end_date,
                        open_state : openState,
                        close_state : closeState,
                        draft_state : draftState,
                        void_state : voidState
                        // page : 1,
                        // limit : 10
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
                        targets: 2,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            var dates = rowData.date
                            date = new Date(dates)
                            month = date.toLocaleString('default', { month: 'long' })
                            year = date.getFullYear()
                            format = date.getDate() + "-"+ month +"-"+ year

                            $(td).html(format);
                        },
                    },
                    {
                        targets: 3,
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
                        targets: 4,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            var vendorName = ""
                            if(rowData.vendor == null){
                                vendorName = "-"
                            } else {
                                vendorName = rowData.vendor.name
                            }
                            $(td).html(vendorName);
                        },
                    },
                    
                    {
                        targets: 5,
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
                            var state = ""
                            if( (rowData.state == 0) && (rowData.is_deleted == 0) ){
                                state = "Open"
                                // $("#stateOpen").prop("checked", true)
                                // $("#stateClosed").prop("checked", true)
                            }

                            if((rowData.state == 1) && (rowData.is_deleted == 0)){
                                state = "Close"
                                // $("#stateClosed").prop("checked", true)
                            }

                            if((rowData.state == 2) && (rowData.is_deleted == 0)){
                                state = "Draft"
                                // $("#stateDraft").prop("checked", true)
                            }

                            if((rowData.state == 3) && (rowData.is_deleted == 1)){
                                state = "Void"
                                // $("#stateVoid").prop("checked", true)
                                // $("#stateOpen").prop("checked", false)
                                // $("#stateClosed").prop("checked", false)
                            }

                            $(td).html(state);
                        },
                    },
                    {
                        targets: 8,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
           
                            var html = "<a href='/purchasing/invoice/"+rowData.id+"' class='btn btn-sm btn-warning'> Detail </a> <button type='button' class='btn btn-sm btn-danger' onclick='confirm("+rowData.id+")'> Hapus </button>"
                            $(td).html(html);
                        },
                    },
                ]
           }
        )
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
            url: "/api/purchasing-invoice/delete",
            data: {
                id : id,
            },
            dataType: "JSON",
            success: function (response) {
                if(response.status == 200){
                    $.confirm({
                        title: 'Pesan',
                        content: 'Data Purchase Invoice berhasil dihapus !',
                        buttons: {
                            Ya: {
                                btnClass: 'btn-success any-other-class',
                                action: function(){
                                    loadPurchaseInvoice()
                                }
                            },
                        }
                    });
                }
            }
        });
    }

    function updateUserToken(){
        $.ajax({
            type: "GET",
            url: "/jubelio/update-token",
            data: "data",
            dataType: "JSON",
            success: function (response) {
                console.log(response)
                if(response.status == 200){
                    $.confirm({
                            title: 'Pesan ',
                            content: response.message,
                            buttons: {
                                Ya: {
                                    btnClass: 'btn-success any-other-class',
                                    action: function(){
                                        window.location.href = '/purchasing'
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.js"></script>
@endsection
@section('pagespecificscripts')
   
@stop