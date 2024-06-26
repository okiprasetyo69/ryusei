
@extends('layout.home')
@section('title','Gudang Data')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/fixedcolumns/5.0.0/css/fixedColumns.dataTables.css" rel="stylesheet" />
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Management Gudang</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Data Warehouse</a></li>
                <li class="breadcrumb-item"><a href="/data-warehouse/sales/order/completed">Pesanan Selesai</a></li>
                <li class="breadcrumb-item active"><a href="#">Detail</a></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body info-card sales-card"> 
                         <h5 class="card-title"> Faktur</span> <h6 id="lbl-invoice"> - </h6> </h5>
                    </div> 
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body info-card sales-card"> 
                        <h5 class="card-title">  No Pesanan </span> <h6 id="lbl-order-number"> - </h6> </h5>
                    </div> 
                </div>
            </div>
            <div class="col-md-2">
                <div class="card">
                    <div class="card-body info-card sales-card"> 
                        <h5 class="card-title">  Tanggal  </span> <h6 id="lbl-trx-date"> - </h6> </h5>
                    </div> 
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body info-card sales-card"> 
                        <h5 class="card-title">  No Ref  </span> <h6 id="lbl-no-ref"> - </h6> </h5>
                    </div> 
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <div class="card">
                    <div class="card-body info-card sales-card"> 
                        <h5 class="card-title">  Pelanggan  </span> <h6 id="lbl-cust-name"> - </h6> </h5>
                    </div> 
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body info-card sales-card"> 
                        <h5 class="card-title">  Total  </span> <h6 id="lbl-total"> - </h6> </h5>
                    </div> 
                </div>
            </div>
        </div>
 
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mt-2"> 
                        <div class="table-responsive mt-4">
                            <table class="table table-striped" id="table-data-warehouse-detail-sales-order">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">SKU</th>
                                        <th scope="col">Deskripsi</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">Qty</th>
                                        <th scope="col">Diskon %</th>
                                        <th scope="col">Nilai Diskon</th>
                                        <th scope="col">Total</th>
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
    
    </section>
</main>
<!-- End #main -->

<script type="text/javascript"> 
    var salesOrder = '<?php echo $salesOrder ;?>'
    var table, dwh_order_id, invoice_number

      $(document).ready(function(){

        salesOrder = $.parseJSON(salesOrder)

        dwh_order_id = salesOrder.id
        loadDetailSalesOrder(dwh_order_id)
        var transaction_date = salesOrder.transaction_date
        var date = new Date(transaction_date)
        var month = date.toLocaleString('default', { month: 'long' })
        var year = date.getFullYear()
        var format = date.getDate() + "-"+ month +"-"+ year
        invoice_number = salesOrder.invoice_number ? salesOrder.invoice_number : "-"

        $("#lbl-invoice").text(invoice_number)
        $("#lbl-order-number").text(salesOrder.salesorder_no)
        $("#lbl-cust-name").text(salesOrder.customer_name)
        $("#lbl-trx-date").text(format)
        $("#lbl-no-ref").text(salesOrder.ref_no)
        $("#lbl-total").text(salesOrder.grand_total.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }))

      })

      function getTotalInvoice(){
        $.ajax({
            type: "GET",
            url: "/api/data-warehouse/sales/order/total",
            data: "data",
            dataType: "JSON",
            success: function (response) {
                var data = response.data
                var total_sales_order = data.total_invoice.toLocaleString('id', { style: 'decimal', useGrouping: true, minimumFractionDigits: 0 })
                $("#lbl-total").text(total_sales_order)
            }
        });
      }

    function loadDetailSalesOrder(dwh_order_id){
        if (table != null) {
            table.destroy();
        }

        table =  $("#table-data-warehouse-detail-sales-order").DataTable({
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
            info: "Menampilkan _START_ dari _END_ dari _TOTAL_ Detail Pesanan",
            aria: {
                    paginate: {
                        previous: "Previous",
                        next: "Next",
                    },
                },
            },
            ajax:{
                url : '/api/data-warehouse/sales/order/detail',
                type: "GET",
                data: {
                    dwh_order_id : dwh_order_id
                }
            },
            columns: [
                {
                    data: null,
                    width: "5%",
                },
                {
                    data: null,
                    width: "5%",
                },
                {
                    data: null,
                    width: "35%",
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
                        $(td).html(rowData.sku_code);
                    },
                },
                {
                    targets: 2,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        var description = ""
                        if(rowData.description != "" ){
                            description = rowData.description
                        } else {
                            description = rowData.name
                        }
                        $(td).html(description);
                    },
                },
                {
                    targets: 3,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).html(rowData.price.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }));
                    },
                },
                {
                    targets: 4,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).html(rowData.qty);
                    },
                },
                {
                    targets: 5,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).html(rowData.discount);
                    },
                },
                {
                    targets: 6,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).html(rowData.disc_amount.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }));
                    },
                },
                {
                    targets: 7,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).html(rowData.amount.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }));
                    },
                },
                  
            ],
        })
    }
    
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/5.0.0/js/fixedColumns.dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
@endsection
@section('pagespecificscripts')
   
@stop