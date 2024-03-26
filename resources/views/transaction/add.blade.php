
@extends('layout.home')
@section('title','Transaksi')
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
                                                <label class="mt-2"> 
                                                    Admin :  <span class="badge bg-success" id="admin_charge"></span>
                                                </label>
                                            </li>
                                            <li class="list-group-item">
                                                <label class="text-center"> Kloter :  </label>
                                                <select name="group_id" id="group_id" class="form-control"> 
                                                    <option value=""> - Pilih Kloter - </option>
                                                    <option value="1">Kloter-1 </option>
                                                    <option value="2">Kloter-2 </option>
                                                    <option value="3">Kloter-3 </option>
                                                </select>
                                            </li>
                                            <li class="list-group-item">
                                                <label class="text-center"> Metode Pembayaran :  </label>
                                                <select name="payment_method_id" id="payment_method_id" class="form-control"> 
                                                    <option value=""> - Pilih Metode - </option>
                                                </select>
                                            </li>
                                        </ul>
                                   </div>
                                </div>
                                <div class="col-md-10 mt-2">
                                    <div class="col-md-12">
                                        <div class="col-md-4 pull-right"> 
                                            <button type="button" class="btn btn-md btn-success" id="btn-import" data-bs-toggle="modal" data-bs-target="#basicModal">
                                                <i class="bi bi-file-earmark-excel-fill"></i> Import
                                            </button>
                                        </div>
                                        <div class="table-responsive mt-4">
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

<!-- Basic Modal -->
<div class="modal fade" id="basicModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="import-form-transaction" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import File Xlsx</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5> Pastikan File Sesuai Format </h5>
                    <input type="file" name="file_import_transaction" class="form-control mt-2">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="importBtn">Import</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div><!-- End Basic Modal-->

<script type="text/javascript"> 
    
    var convertOrderDate, convertProcessOrderDate, orderDate, processOrderDate
     
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

        // Setup default date now and format date
        $("#order_date").datepicker({
            format: 'yyyy-mm-dd',
            defaultDate: new Date(),
        });
        $('#order_date').val(convertOrderDate);

        $("#process_order_date" ).datepicker({
            format: 'yyyy-mm-dd',
            defaultDate: new Date(),
        });
        $('#process_order_date').val(convertProcessOrderDate);

        // load data
        getSalesChannel()
        getPaymentMethod()
        $(".sku_id").select2()

        // create new element form dynamic
        $("#btn-add").on("click", function(e){
            e.preventDefault()
            let count = $('#table-add-transaction tr').length
            let row = `<tr> 
                        <td>`+count+`</td>
                        <td><input type="text" name="order_number[]" class="form-control order_number" id="order_number"/></td>    
                        <td><input type="text" name="tracking_number[]" class="form-control tracking_number" id="tracking_number"/></td>    
                        <td ><select name="sku_id[]" class="form-control sku_id" id="sku_id-`+count+`" data-id="`+count+`" style="width:100%;"><option value=""> - Pilih Kode SKU -  </option></select></td>    
                        <td><input type="number" min="1" name="qty[]" class="form-control qty" id="qty"/></td>    
                        <td><input type="number" min="1" name="unit_price[]" class="form-control unit_price" id="unit_price"/></td>    
                        <td><input type="text" name="postal_code[]" class="form-control postal_code" id="postal_code"/></td>    
                        <td><button type='button' class='btn btn-md btn-danger delete-row'><i class='bi bi-trash' aria-hidden='true'></i></button></td>    
                    </tr>`
            //var dataId = $(this).attr("id")
            $('#tbody').append(row);
            getSkuCode()
        })

        // remove row form table dynamic
        $("#tbody").on("click", '.delete-row',function(e){
            e.preventDefault()
            $(this).parent('td').parent('tr').remove(); 
        })

        // filter
        $("#sales_channel_id").change(function(e){
            e.preventDefault()
            var selectedOption = $(this).find('option:selected');
            var dataId = selectedOption.data('id');
            if(dataId == null){
                dataId = 0
            }
            $("#admin_charge").text(dataId + " %")
        })
        
        // insert
        $("#frm-add-transaction").on("submit", function(e){
            e.preventDefault()

             // Validation form required
            if($("#order_date").val() == ""){
                $.alert({
                    title: 'Pesan !',
                    content: 'Tanggal Order tidak boleh kosong !',
                });
                return 
            }

            if($("#process_order_date").val() == ""){
                $.alert({
                    title: 'Pesan !',
                    content: 'Tanggal Proses Order tidak boleh kosong !',
                });
                return 
            }

            if($("#sales_channel_id option:selected").val() == ""){
                $.alert({
                    title: 'Pesan !',
                    content: 'Sales Channel tidak boleh kosong !',
                });
                return 
            }

            if($("#group_id option:selected").val() == ""){
                $.alert({
                    title: 'Pesan !',
                    content: 'Kloter tidak boleh kosong !',
                });
                return 
            }

            if($("#payment_method_id option:selected").val() == ""){
                $.alert({
                    title: 'Pesan !',
                    content: 'Metode Pembyaaran tidak boleh kosong !',
                });
                return 
            }

            var transactions = []

            $("#table-add-transaction tbody tr").each(function(index){
                order_numbers = $(this).find('.order_number').val()
                tracking_numbers = $(this).find('.tracking_number').val()
                sku_ids = $(this).find('.sku_id option:selected').val()
                qtys = $(this).find('.qty').val()
                unit_prices = $(this).find('.unit_price').val()
                postal_codes = $(this).find('.postal_code').val()

                transactions.push({order_number : order_numbers, tracking_number:tracking_numbers, sku_id:sku_ids, qty:qtys, unit_price:unit_prices, postal_code: postal_codes })
            })

            // convert to json
            var jsonTransactions = JSON.stringify(transactions);

            var formData = new FormData();

            // Set Date
            orderDate = $('#order_date').val()
            processOrderDate = $('#process_order_date').val()

            // Convert date
            convertOrderDate = orderDate.split("-").reverse().join("-")
            convertProcessOrderDate = processOrderDate.split("-").reverse().join("-")
            
            // set data
            formData.append('order_date', convertOrderDate)
            formData.append('process_order_date', convertProcessOrderDate)
            formData.append("sales_channel_id",  $('#sales_channel_id').val())
            formData.append("group_id",  $('#group_id').val())
            formData.append("payment_method_id",  $('#payment_method_id').val())
            formData.append("transactions", jsonTransactions)

            // send data to api
            $.ajax({
                type: "POST",
                url: "/api/transaction/create",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function (response) {
                    console.log(response)
                    if(response.status == 200){
                        $.confirm({
                            title: 'Pesan ',
                            content: 'Data transaksi berhasil diperbarui !',
                            buttons: {
                                Ya: {
                                    btnClass: 'btn-success any-other-class',
                                    action: function(){
                                        window.location.href = '/transaction'
                                    }
                                },
                            }
                        });
                    }
                }
            });
        })

        // import file
        $("#import-form-transaction").on("submit", function(e){
            e.preventDefault()

            if($('#sales_channel_id option:selected').val() == ""){
                $.alert({
                    title: 'Pesan !',
                    content: 'Sales Channel tidak boleh kosong !',
                });
                return 
            }

            if($('#group_id option:selected').val() == ""){
                $.alert({
                    title: 'Pesan !',
                    content: 'Kloter tidak boleh kosong !',
                });
                return 
            }

            if($('#payment_method_id option:selected').val() == ""){
                $.alert({
                    title: 'Pesan !',
                    content: 'Metode Pembayaran tidak boleh kosong !',
                });
                return 
            }

            var formData = new FormData($(this)[0]);
            
            // Set Date
            orderDate = $('#order_date').val()
            processOrderDate = $('#process_order_date').val()

            // Convert date
            convertOrderDate = orderDate.split("-").reverse().join("-")
            convertProcessOrderDate = processOrderDate.split("-").reverse().join("-")

            formData.append('order_date', convertOrderDate)
            formData.append('process_order_date', convertProcessOrderDate)
            formData.append('sales_channel_id', $('#sales_channel_id option:selected').val())
            formData.append('group_id', $('#group_id option:selected').val())
            formData.append('payment_method_id', $('#payment_method_id option:selected').val())

            $.ajax({
                type: "POST",
                url: "/api/import/transaction",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function (response) {

                    if(response.status == 200){
                        $.confirm({
                            title: 'Pesan ',
                            content: 'Data transaksi berhasil diperbarui !',
                            buttons: {
                                Ya: {
                                    btnClass: 'btn-success any-other-class',
                                    action: function(){
                                        window.location.href = '/transaction'
                                    }
                                },
                            }
                        });
                    }
                }
            });
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
                $("#admin_charge").html()
                $.each(data, function (i, val) { 
                    option += "<option value="+val.id+" data-id="+val.admin_charge+"> "+val.name+" - "+val.year+"</option>"
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

    function getSkuCode(dataId=null){
    
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