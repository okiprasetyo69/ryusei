
@extends('layout.home')
@section('title','Dashboard')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
    </div>
    <!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <form action="#" id="frm-add-transaction" class="row g-3">
                @csrf
                <div class="col-md-12"> 
                    <div class="card">
                        <div class="card-body">
                            <div class="row mt-2">
                                <div class="col-md-2 mt-2">
                                   <div class="col-md-12">
                                        <ul class="list-group">
                                            <li class="list-group-item active" aria-current="true">Tanggal Pesanan </li>
                                            <li class="list-group-item">
                                                <label class="text-center"> Tanggal Order  </label>
                                                <input type="text" name="order_date" id="order_date" class="form-control" placeholder="Tanggal Proses"/>
                                            </li>
                                            <li class="list-group-item">
                                                <label class="text-center"> Tanggal Proses Order  </label>
                                                <input type="text" name="process_order_date" id="process_order_date" class="form-control" placeholder="Tanggal Proses Order" />
                                            </li>
                                        </ul>
                                   </div>
                                   <div class="col-md-12 mt-4"> 
                                        <ul class="list-group">
                                            <li class="list-group-item active" aria-current="true"> Informasi Lain </li>
                                            </li>
                                            <li class="list-group-item">
                                                <label class="text-center"> Sales Channel :  </label>
                                                <select name="sales_channel_id" id="sales_channel_id" class="form-control"> 
                                                    <option value=""> - Pilih Sales Channel - </option>
                                                </select>
                                            </li>
                                            <li class="list-group-item">
                                                <label class="text-center"> Kloter :  </label>
                                                <select name="group_id" id="group_id" class="form-control"> 
                                                    <option value=""> - Pilih Keloter - </option>
                                                    <option value="1">Kloter-1 </option>
                                                    <option value="2">Kloter-2 </option>
                                                    <option value="3">Kloter-3 </option>
                                                </select>
                                            </li>
                                            <li class="list-group-item">
                                                <label class="text-center"> Metode Pembayaran :  </label>
                                                <select name="payment_method" id="payment_method_id" class="form-control"> 
                                                    <option value=""> - Pilih Metode - </option>
                                                </select>
                                            </li>
                                        </ul>
                                   </div>
                                </div>
                                <div class="col-md-10 mt-2">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="table-add-transaction" style="width:100%">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th scope="col">#</th>
                                                        <th scope="col">No Order</th>
                                                        <th scope="col">Tracking Number</th>
                                                        <th scope="col">Kode SKU</th>
                                                        <th scope="col">Quantity</th>
                                                        <th scope="col">Harga Sat</th>
                                                        <th scope="col">Kode Pos</th>
                                                        <th scope="col">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody"> 
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <button type="button" class="btn btn-md btn-outline-primary" id="btn-add" ><i class="bx bxs-cart-add"></i> Add </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success btn-save">Simpan</button>
                        <button type="reset" class="btn btn-secondary btn-reset">Reset</button>
                    </div>
                </div>

                
            </form>
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

        // Setup default date now and format date
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

        // load data
        getSalesChannel()
        getPaymentMethod()
        

        // create new element form dynamic
        $("#btn-add").on("click", function(e){
            e.preventDefault()
            let count = $('#table-add-transaction tr').length
            let row = `<tr> 
                        <td>`+count+`</td>
                        <td><input type="text" name="order_number[]" class="form-control order_number" id="order_number"/></td>    
                        <td><input type="text" name="tracking_number[]" class="form-control tracking_number" id="tracking_number"/></td>    
                        <td ><select name="sku_id[]" class="form-control sku_id" id="sku_id" style="width:100%;"><option value=""> - Pilih Kode SKU -  </option></select></td>    
                        <td><input type="number" min="1" name="qty[]" class="form-control qty" id="qty"/></td>    
                        <td><input type="number" min="1" name="unit_price[]" class="form-control unit_price" id="unit_price"/></td>    
                        <td><input type="text" name="postal_code[]" class="form-control postal_code" id="postal_code"/></td>    
                        <td><button type='button' class='btn btn-md btn-danger delete-row'><i class='bi bi-trash' aria-hidden='true'></i></button></td>    
                               
                    </tr>`
            $('#tbody').append(row);
            getSkuCode()
        })

        // remove row form table dynamic
        $("#tbody").on("click", '.delete-row',function(e){
            e.preventDefault()
            $(this).parent('td').parent('tr').remove(); 
        })

      
    });

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
                    option += "<option value="+val.id+"> "+val.name+" </option>"
                });
                $("#sales_channel_id").append(option)
            }
        });
    }

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

    function getSkuCode(){
        let sku_id = $('.sku_id').val()
        $(".sku_id").select2({
            ajax: {
                url: "/api/product/list/select2",
                dataType: "JSON",
                type: "GET",
                data: function (params) {
                    //console.log(params)
                    return {
                        searchTerm: params.term,
                        id: sku_id,
                    };
                },
                processResults: function (response) {
                    //console.log(response)
                    return {
                        results: response,
                    };
                },
                cache: true,
            },
        })
        .on("select2:select", function (e) {
            var data = e.params.data;
            //console.log(data)
        });

    }
   
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection
@section('pagespecificscripts')
   
@stop