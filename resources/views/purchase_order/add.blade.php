
@extends('layout.home')
@section('title','Purchase Order')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.css" rel="stylesheet" />
<style> 
    .table-responsive {
        max-height:600px;
    }
</style>
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Management Transaksi</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item ">
                    <a href="#">Pembelian</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="/purchase/order/add">Purchase Order</a>
                </li>
                <li class="breadcrumb-item active">
                    <a href="#">Tambah</a>
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
                                <label> <strong> Vendor </strong> </label>
                            </div>
                           <div class="col-md-2"></div>
                           <div class="col-md-2"></div>
                           <div class="col-md-2"></div>
                           <div class="col-md-2"></div>
                           <div class="col-md-2">
                                <!-- <label> <b> Import File </b> </label> -->
                           </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select name="vendor_id" class="form-control" id="vendor_id"> <option value=""> - Pilih Vendor - </option> </select>
                                </div>
                            </div>
                            <div class="col-md-2"></div>
                            <div class="col-md-2"></div>
                            <div class="col-md-2"></div>
                            <div class="col-md-2"></div>
                            <div class="col-md-2">
                                <!-- <button type="button" class="btn btn-md btn-success float-right" id="btn-import" data-bs-toggle="modal" data-bs-target="#modalImportInvoice">
                                    <i class="bi bi-file-earmark-excel-fill"></i> Import
                                </button> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body"> 
                        <div class="mt-3">
                            <div class="row mb-3">
                                <label for="" class="col-sm-4 col-form-label">Vendor. Code</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="vendor_code" name="vendor_code" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="" class="col-sm-4 col-form-label">Vendor. Phone</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="vendor_phone" name="vendor_phone">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="" class="col-sm-4 col-form-label">Vendor. Ref</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="vendor_reference">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="" class="col-sm-4 col-form-label">Category</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="invoice_category_id" id="invoice_category_id"> 
                                        <option value=""> - Pilih Kategori -  </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body"> 
                        <div class="mt-3"> 
                            <div class="row mb-3">
                                <label for="" class="col-sm-4 col-form-label">Order No.</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="purchaseorder_number" name="purchaseorder_number">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="" class="col-sm-4 col-form-label">Batch No.</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="batch_number" name="batch_number">
                                </div>
                            </div>
                        </div> 
                    </div> 
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body"> 
                        <div class="mt-3"> 
                            <div class="row mb-3">
                                <label for="" class="col-sm-4 col-form-label">Date</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="date" name="date">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="" class="col-sm-4 col-form-label">Delivery Date</label>
                                <div class="col-sm-6">
                                        <input type="text" class="form-control" id="delivery_date" name="delivery_date">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="" class="col-sm-4 col-form-label">Day</label>
                                <div class="col-sm-6">
                                    <input type="number" min="0" class="form-control" id="day" name="day">
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
                            <div class="col-md-2 mt-2">
                               <label> Tipe :</label>
                               <select class="form-control mt-2" name="invoice_form_type" id="invoice_form_type"> 
                                    <option value="1"> Item </option> 
                                    <option value="2"> Summary </option> 
                                </select>
                            </div>
                            <div class="col-md-2 mt-2" id="attr_warehouse"> 
                                <label> Warehouse :</label>
                                <select class="form-control mt-2" name="warehouse_id" id="warehouse_id"> 
                                    <option value=""> - Pilih Gudang - </option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2"> 
                            <div class="col md-4 mt-2">
                                <button type="button" class="btn btn-sm btn-primary rounded-pill" id="btn-add">
                                    <i class="bi bi-plus-circle"></i> Tambah
                                </button>
                            </div>
                            <div class="col md-4 mt-2"> </div>
                            <div class="col md-4 mt-2"> 
                                <input type="text" class="form-control" name="search_text" id="search_text" placeholder="Masukkan Kode SKU" autofocus/>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="table-add-invoice-item" style="max-height:600px;">
                                        <thead>
                                            <tr class="text-center">
                                                <th scope="col">#</th>
                                                <th scope="col">Kode SKU</th>
                                                <th scope="col">Deskripsi</th>
                                                <th scope="col">Qty</th>
                                                <th scope="col">Satuan</th>
                                                <th scope="col">Harga</th>
                                                <th scope="col">Disc %</th>
                                                <th scope="col">Total</th>
                                                <th scope="col">Tax Code</th>
                                                <th scope="col">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody-invoice-item">
                                        
                                        </tbody>
                                    </table>

                                    <table class="table table-bordered table-striped" id="table-add-invoice-summary" style="max-height:600px;">
                                        <thead>
                                            <tr class="text-center">
                                                <th scope="col">#</th>
                                                <th scope="col">Item Code</th>
                                                <th scope="col">Description</th>
                                                <th scope="col">Qty</th>
                                                <th scope="col">Unit</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Disc %</th>
                                                <th scope="col">Discount</th>
                                                <th scope="col">Total</th>
                                                <th scope="col">Tax Code</th>
                                                <th scope="col">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody-invoice-summary">
                                        
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row mt-2"> 
                            <div class="col-lg-4">
                                <div class="row mb-3">
                                    <label for="" class="col-sm-4 col-form-label">Note</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" id="note" name="note"> </textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="row mb-3">
                                    <label for="" class="col-sm-4 col-form-label">Subtotal</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="subtotal" id="subtotal"/>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="" class="col-sm-4 col-form-label">Discount</label>
                                    <div class="col-sm-2">
                                        <input type="number" min="0" class="form-control" name="discount_invoice" id="discount_invoice"/>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="discount" id="discount" readonly/>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="" class="col-sm-4 col-form-label">Additional Char</label>
                                    <div class="col-sm-6">
                                        <input type="number" min="0" class="form-control" name="additional_char" id="additional_char" readonly/>
                                    </div>
                                </div>
                               
                            </div>
                            <div class="col-lg-4"> 
                                <div class="row mb-3">
                                    <label for="" class="col-sm-3 col-form-label">Tax</label>
                                    <div class="col-sm-6">
                                        <input type="number" min="0" class="form-control" name="tax" id="tax" readonly/>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="" class="col-sm-3 col-form-label">Total</label>
                                    <div class="col-sm-6">
                                        <input type="number" class="form-control grand_total" name="grand_total" id="grand_total" readonly/>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="" class="col-sm-3 col-form-label">Down Pmt.</label>
                                    <div class="col-sm-6">
                                        <input type="number" min="0" class="form-control" name="down_pmt" id="down_pmt" readonly/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row mt-2">
                    <div class="col-md-4"></div>
                    <div class="col-md-4 text-center">
                        <button type="button" class="btn btn-success btn-save">Simpan</button>
                        <a href="/purchasing" class="btn btn-secondary">Batal</a>
                    </div>
                    <div class="col-md-4"></div>
                </div>
            </div>
            
        </div>
    </section>
</main>

<div class="modal fade" id="modalImportInvoice" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="#" id="frm-import-invoice" enctype="multipart/form-data"> 
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Import File Xlsx</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12"> 
                        <h5> Pastikan File Sesuai Format </h5>
                        <input type="file" name="file_import_invoice" id="file_import_invoice" class="form-control mt-2">
                    </div>
                    <div class="col-md-12 mt-2">  
                        <button type="button" class="btn btn-md btn-dark" id="btn-download-format-import"><i class="bi bi-cloud-download-fill"></i></button>
                        <label> <b> Download Format File </b></label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btn-import-file">Import</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                  
                </div>
            </form>
        </div>
    </div>
</div>


<script type="text/javascript"> 

    var table, count, kodeSku, description , qty, price , discPercent, taxCode, orderNumber, total, unit, grandTotal, vendorId

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
       
        $("#date").datepicker({
            format: 'dd-mm-yyyy',
            defaultDate: new Date(),
        });
        $('#date').val(convertOrderDate);

        $("#due_date" ).datepicker({
            format: 'dd-mm-yyyy',
            defaultDate: new Date(),
        });
        $('#due_date').val(convertProcessOrderDate);

        getWarehouse()
        getVendor()
        getInvoiceCategory()
        $("#table-add-invoice-summary").hide()

        // select invoice type
        $("#invoice_type").on("change", function(e){
            e.preventDefault()
            value = this.value
            if(value == 1){
                $("#table-add-invoice-item").show()
                $("#table-add-invoice-summary").hide()
                $("#table-add-invoice-summary").html()
                $("#attr_warehouse").show()
            }

            if(value == 2){
                $("#table-add-invoice-summary").show()
                $("#table-add-invoice-item").hide()
                $("#table-add-invoice-item").html()
                $("#attr_warehouse").hide()
            }
        })

        // on change sales channel
        $("#vendor_id").on("change", function(e){
            e.preventDefault()
            vendorId = this.value
            getVendor(vendorId)
        })

        // assign select 2
        $(".sku_code").select2()
        $(".unit").select2()

        // search sku code on table
        $("#search_text").on("keyup press", function(e){
            e.preventDefault()
            var searchText = $(this).val().toLowerCase();
            $('#table-add-invoice-item tbody tr').each(function() {
                var rowData = $(this).text().toLowerCase();
                if (rowData.indexOf(searchText) === -1) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });
        })

        // create dynamic form
        $("#btn-add").on("click", function(e){
            e.preventDefault()
            let row = ""
            let head = ""
            var selectedType = $("#invoice_form_type option:selected").val()
           

            if(selectedType == 1){
                $("#table-add-invoice-item").show()
                $("#table-add-invoice-summary").hide()
                $("#table-add-invoice-summary").html()
                $("#attr_warehouse").show()

                count = $('#table-add-invoice-item tr').length
                row =  `<tr class="text-center"> 
                        <td>`+count+`</td>
                        <td><select name="sku_code[]" class="form-control sku_code" id="sku_code_`+ count +`" style="width:100%;" data-id="`+count+`"></select></td>    
                        <td><input type="text" name="description[]" class="form-control description" id="description_`+ count +`" data-id="`+count+`"/></td>    
                        <td><input type="number" min="0" name="qty[]" class="form-control qty" id="qty_`+ count +`" data-id="`+count+`"/></td>    
                        <td><select class="form-control unit" name="unit" id="unit_`+count+`" data-id="`+count+`" data-id="`+count+`"> </select></td>  
                        <td><input type="number" min="0 "name="price[]" class="form-control price" id="price_`+count+`" data-id="`+count+`" /></td>    
                        <td><input type="number" min="0 "name="discount[]" class="form-control discount" id="discount_`+count+`" data-id="`+count+`"/></td>    
                        <td><input type="number" min="0 "name="total[]" class="form-control total" id="total_`+count+`" data-id="`+count+`" readonly /></td>
                        <td><input type="text" name="tax_code[]" class="form-control tax_code" id="tax_code_`+ count +`" data-id="`+count+`"/></td> 
                        <td><button type='button' class='btn btn-md btn-danger delete-row' id=`+count+`><i class='bi bi-trash' aria-hidden='true'></i></button></td>    
                    </tr>`
                $('#tbody-invoice-item').append(row)

                getSkuCode(count)
                getItemUnit(count)
           
            } 

            if(selectedType == 2){
                $("#table-add-invoice-summary").show()
                $("#table-add-invoice-item").hide()
                $("#table-add-invoice-item").html()
                $("#attr_warehouse").hide()
                count = $('#table-add-invoice-summary tr').length
                row =  `<tr> 
                        <td>`+count+`</td>
                        <td><select name="item_code[]" class="form-control item_code" id="item_code_`+ count +`" style="width:100%;"></select></td>    
                        <td><input type="text" name="description[]" class="form-control description" id="description_`+ count +`"/></td>    
                        <td><input type="number" min="0" name="qty[]" class="form-control qty" id="qty_`+ count +`"/></td>    
                        <td><input type="number" min="0" name="unit[]" class="form-control unit" id="unit_`+ count +`"/></td>  
                        <td><input type="number" min="0 "name="price[]" class="form-control price" id="price_`+count+`"/></td>    
                        <td><input type="number" min="0 "name="discount[]" class="form-control discount" id="discount_`+count+`"/></td>   
                        <td><input type="number" min="0 "name="discount" class="form-control discount" id="discount_`+count+`"/></td>  
                        <td><input type="number" min="0 "name="total[]" class="form-control total" id="total_`+count+`"/></td>
                        <td><input type="text" name="tax_code[]" class="form-control tax_code" id="tax_code_`+ count +`"/></td>           
                        <td><button type='button' class='btn btn-md btn-danger delete-row' id=`+count+`><i class='bi bi-trash' aria-hidden='true'></i></button></td>    
                    </tr>`
                $('#tbody-invoice-summary').append(row);
                getSkuCode()
            }

        })

        // on change tbody
        $("#tbody-invoice-item").on("change", ".qty", function(e){
            e.preventDefault()
            var rowId =  $(this).attr('data-id')
            var discountItem =  $("#discount_"+rowId).val()

            price = $("#price_"+rowId).val()
            qty = $("#qty_"+rowId).val()
            discountItem = (discountItem / 100) * price * qty

            total = (qty * price) - discountItem

            $("#total_"+rowId).val(total)

            // assign and caclulate grand total
            var elementsTotal  =  document.getElementsByClassName('total')
            var actGrandTotal = 0
            var discountInvoice = $("#discount_invoice").val() / 100
            grandTotal = 0
            var actSubTotal= 0
            var actDiscount = 0 

            for(var i = 0; i < elementsTotal.length; i++){
                actGrandTotal = parseInt(elementsTotal[i].value)
                grandTotal = actGrandTotal + grandTotal
                actDiscount = discountInvoice * grandTotal
                actSubTotal = grandTotal - actDiscount

                $("#subtotal").val(grandTotal)
                $("#discount").val(actDiscount)
                $("#grand_total").val(actSubTotal)
                $("#balance_due").val(actSubTotal)
            }
            
        })

        $("#tbody-invoice-item").on("change", ".price", function(e){
            e.preventDefault()
            var rowId =  $(this).attr('data-id')
            var discountItem =  $("#discount_"+rowId).val()
            qty = $("#qty_"+rowId).val()
            price = $("#price_"+rowId).val()

            discountItem = (discountItem / 100) * price*qty
           
            total = (qty * price) - discountItem
            $("#total_"+rowId).val(total)

            // assign and caclulate grand total
            var elementsTotal  =  document.getElementsByClassName('total')
            var actGrandTotal = 0
            var discountInvoice = $("#discount_invoice").val() / 100
            grandTotal = 0
            var actSubTotal= 0
            var actDiscount = 0 
            
            for(var i = 0; i < elementsTotal.length; i++){
                actGrandTotal = parseInt(elementsTotal[i].value)
                grandTotal = actGrandTotal + grandTotal
                actDiscount = discountInvoice * grandTotal
                actSubTotal = grandTotal - actDiscount

                $("#subtotal").val(grandTotal)
                $("#discount").val(actDiscount)
                $("#grand_total").val(actSubTotal)
                $("#balance_due").val(actSubTotal)
            }
          
        })

        $("#tbody-invoice-item").on("change", ".discount", function(e){
            e.preventDefault()
            var rowId =  $(this).attr('data-id')
            var discountItem =  $("#discount_"+rowId).val()
            qty = $("#qty_"+rowId).val()
            price = $("#price_"+rowId).val()

            discountItem = (discountItem / 100)  * price * qty
            total = (qty * price) - discountItem

            $("#total_"+rowId).val(total)

            // initializing value into element grand total for the first time
            var elementsTotal  =  document.getElementsByClassName('total')
            var actGrandTotal = 0
            var discountInvoice = $("#discount_invoice").val() / 100
            grandTotal = 0
            var actSubTotal= 0
            var actDiscount = 0 
            // calculate grand total with discount
            for(var i = 0; i < elementsTotal.length; i++){
                actGrandTotal = parseInt(elementsTotal[i].value)
                grandTotal = actGrandTotal + grandTotal
                actDiscount = discountInvoice * grandTotal
                actSubTotal = grandTotal - actDiscount

                $("#subtotal").val(grandTotal)
                $("#discount").val(actDiscount)
                $("#grand_total").val(actSubTotal)
                $("#balance_due").val(actSubTotal)
            }
            
        })

        $("#discount_invoice").on("change", function(e){
            e.preventDefault()
            var discountPercent = this.value
            var subtotal = $("#subtotal").val()
            var discount = ((discountPercent/100) * subtotal)
            grandTotal = subtotal - ((discountPercent/100) * subtotal)
            $("#discount").val(discount)
            $("#grand_total").val(grandTotal)
            $("#balance_due").val(grandTotal)
        })

        // remove row form table invoice item
        $("#tbody-invoice-item").on("click", '.delete-row',function(e){
            e.preventDefault()
            var rowId =  $(this).attr('id')
            $("#"+rowId+"").parent('td').parent('tr').remove(); 
        })

        // remove row form table invoice summary
        $("#tbody-invoice-summary").on("click", '.delete-row',function(e){
            e.preventDefault()
            var rowId =  $(this).attr('id')
            $("#"+rowId+"").parent('td').parent('tr').remove(); 
        })

        // import from excel to view blade
        $('#btn-import-file').click(function() {
            $("#modalImportInvoice").modal('toggle')

            var file = $('#file_import_invoice').prop('files')[0];
            var reader = new FileReader();
            var arrDataSheet = []
          
            count = $('#table-add-invoice-item tr').length
            reader.onload = function (e) {
                var data = new Uint8Array(e.target.result);
                var workbook = XLSX.read(data, { type: 'array' });
                var sheet = workbook.Sheets[workbook.SheetNames[0]];
                var sheetData = XLSX.utils.sheet_to_json(sheet, { header: 1 });
                
                // start indexing loop after header has red
                sheetData = sheetData.slice(1)
                var html = '';
                count = $('#table-add-invoice-item tr').length
                var rowData =""

                $.each(sheetData, function (index, value) { 

                    if(value[0] != undefined){
                        kodeSku = value[0]
                    } else {
                        kodeSku = ""
                    }

                    if(value[1] != undefined){
                        description = value[1]
                    } else{
                        description = ""
                    }

                    if(value[2] != undefined){
                        qty = value[2]
                    } else {
                        qty = ""
                    }

                    if(value[3] != undefined){
                        unit = value[3]
                    } else {
                        unit = ""
                    }

                    if(value[4] != undefined){
                        price = value[4]
                    } else {
                        price = ""
                    }

                    if(value[5] != undefined){
                        discPercent = value[5]
                    } else {
                        discPercent = ""
                    }

                    if(value[6] != undefined){
                        taxCode = value[6]
                    } else {
                        taxCode = ""
                    }

                    if(value[7] != undefined){
                        orderNumber = value[7]
                    } else {
                        orderNumber = ""
                    }

                    total = qty * price
                    arrDataSheet.push({
                        kode_sku : kodeSku,
                        description : description,
                        qty : qty,
                        unit : unit,
                        price : price,
                        disc_percent : discPercent,
                        tax_code : taxCode,
                        order_number : orderNumber,
                        total : total
                    })
            
                });

                grandTotal = 0
                $.each(arrDataSheet, function (i, val) { 
                   
                    if(val.disc_percent != ""){
                        total =  val.total - ((val.disc_percent/100) * val.total)
                        grandTotal = total + grandTotal
                    } else{
                        total = val.total
                        grandTotal = total + grandTotal
                    }

                    rowData += `<tr class="text-center"> 
                                <td>`+ count +`</td>
                                <td><select name="sku_code[]" class="form-control sku_code" id="sku_code_`+ count +`" style="width:100%;" data-id="`+count+`" > <option value=""> `+val.kode_sku+` <option> </select></td>    
                                <td><input type="text" name="description[]" class="form-control description" id="description_`+ count +`" value="`+val.description+`" data-id="`+count+`"/></td>    
                                <td><input type="number" min="0" name="qty[]" class="form-control qty" id="qty_`+ count +`" value="`+val.qty+`" data-id="`+count+`"/></td>    
                                <td><select class="form-control unit" name="unit" id="unit_`+count+`" data-id="`+count+`"><option value=""> `+val.unit+` </option></select></td>  
                                <td><input type="number" min="0 "name="price[]" class="form-control price" id="price_`+count+`" value="`+val.price+`" data-id="`+count+`"/></td>    
                                <td><input type="number" min="0 "name="discount[]" class="form-control discount" id="discount_`+count+`" value="`+val.disc_percent+`" data-id="`+count+`"/></td>    
                                <td><input type="number" min="0 "name="total[]" class="form-control total" id="total_`+count+`" value="`+total+`" data-id="`+count+`"/></td>
                                <td><input type="text" name="tax_code[]" class="form-control tax_code" id="tax_code_`+ count +`" value="`+val.tax_code+`" data-id="`+count+`"/></td> 
                                <td><input type="text" name="order_number[]" class="form-control order_number" id="order_number_`+ count +`"  value="`+val.order_number+`" data-id="`+count+`"/></td>             
                                <td><button type='button' class='btn btn-md btn-danger delete-row' id=`+count+`><i class='bi bi-trash' aria-hidden='true'></i></button></td>    
                            </tr>`
                    count++
                });

                $('#tbody-invoice-item').append(rowData)
                getSkuCode()
                getItemUnit(count)

                $("#grand_total").val(grandTotal)
                $("#subtotal").val(grandTotal)
                $("#balance_due").val(grandTotal)
              
            };

            reader.readAsArrayBuffer(file);
            $("#file_import_invoice").val("")
        });
       
        // save data
        $(".btn-save").on("click", function(e){
            e.preventDefault()
            vendorId = $("#vendor_id option:selected").val()
            var vendorCode = $("#vendor_code").val()
            var vendorPhone = $("#vendor_phone").val()
            var vendorReference = $("#vendor_reference").val()
            var categoryInvoice = $("#invoice_category_id option:selected").val()
            var invoiceNumber = $("#invoice_number").val()
            var batchNumber = $("#batch_number").val()
            var date = $("#date").val()
            var dueDate = $("#due_date").val()
            var day = $("#day").val()
            var invoiceType = $("#invoice_form_type option:selected").val()
            var warehouseId = $("#warehouse_id option:selected").val()
            var journalMemo = $("#journal_memo").val()
            var note = $("#note").val()
            var subtotal = $("#subtotal").val()
            var discountInvoice = $("#discount_invoice").val()
            var additionalChar = $("#additional_char").val()
            var downPmt = $("#down_pmt").val()
            var tax = $("#tax").val()
            var pphPercent = $("#pph_percent").val()
            grandTotal = $("#grand_total").val()
            var balanceDue = $("#balance_due").val()

            var invoices = []
            $("#table-add-invoice-item tbody tr").each(function(index){
                sku_ids = $(this).find('.sku_code option:selected').val()

                sku_codes = $(this).find('.sku_code option:selected').text()
                sku_codes = sku_codes.split(' ').join('')

                descriptions = $(this).find('.description').val()
                qtys = $(this).find('.qty').val()
                unit_ids = $(this).find('.unit').val()

                unit_names = $(this).find('.unit').text()
                unit_names = unit_names.split(' ').join('')

                prices = $(this).find('.price').val()
                discounts = $(this).find('.discount').val()
                totals = $(this).find('.total').val()
                tax_codes = $(this).find('.tax_code').val()

                invoices.push({
                    sku_id:sku_ids, 
                    sku_code : sku_codes, 
                    description:descriptions, 
                    qty:qtys,
                    unit_id:unit_ids, 
                    unit_name:unit_names, 
                    price:prices, 
                    discount: discounts, 
                    total:totals, 
                    tax_code:tax_codes,
                })
            })


            if(vendorId == ""){
                $.alert({
                    title: 'Pesan !',
                    content: 'Vendor tidak boleh kosong. Silakan Pilih !',
                });
                return 
            }
        
            if(!invoices.length){
                $.alert({
                    title: 'Pesan !',
                    content: 'Detail invoice tidak boleh kosong. Silakan isi detail invoice !',
                });
                return 
            }
            
            // convert to json
            var jsonInvoices = JSON.stringify(invoices);
          
            // convert data
            convertDate = date.split("-").reverse().join("-")
            convertDueDate = dueDate.split("-").reverse().join("-")

            var data = {
                vendor_id : vendorId,
                vendor_code : vendorCode,
                vendor_phone : vendorPhone,
                vendor_reference : vendorReference,
                category_invoice_id : categoryInvoice,
                invoice_number : invoiceNumber,
                batch_number : batchNumber,

                date : convertDate,
                due_date : convertDueDate,
                day : day,

                invoice_type : invoiceType,
                warehouse_id : warehouseId,

                journal_memo : journalMemo,
                note : note,
                subtotal : subtotal,
                discount_invoice : discountInvoice,
                additional_char : additionalChar,
                down_pmt : downPmt,
                tax : tax,
                pph_percent : pphPercent,
                grand_total : grandTotal,
                balance_due : balanceDue,

                invoices : jsonInvoices
            }

            $.ajax({
                type: "POST",
                url: "/api/purchasing-invoice/create",
                data: data,
                dataType: "JSON",
                success: function (response) {
                    if(response.status == 200){
                        $.confirm({
                            title: 'Pesan ',
                            content: 'Data Purchase Invoice berhasil diperbarui !',
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
        })
    });

    function getSkuCode(dataId=null){
        let item_code = $('.sku_code').val()
        $(".sku_code").select2({
            ajax: {
                url: "/api/product/list/invoice/select2",
                dataType: "JSON",
                type: "GET",
                data: function (params) {
                    //console.log(params)
                    return {
                        searchTerm: params.term,
                        id: item_code,
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
            var data = e.params.data
            var rowId =  $(this).attr('data-id')
            var elementsTotal  =  document.getElementsByClassName('total')
            var actGrandTotal = 0
            grandTotal = 0

            getItemUnit(rowId)

            $("#description_"+rowId).val(data.article)
            $("#qty_"+rowId).val(1)
            $("#price_"+rowId).val(data.price)

            qty =  $("#qty_"+rowId).val()
            price =  parseInt(data.price)
            dicountItem = $("#discount_"+rowId).val()
            dicountItem = (dicountItem / 100) * (qty * price)

            total = (qty * price) - dicountItem

            $("#total_"+rowId).val(total)

            for(var i = 0; i < elementsTotal.length; i++){

                if(elementsTotal[i].value == ""){
                    elementsTotal[i].value = 0
                }
                actGrandTotal = parseInt(elementsTotal[i].value)
                grandTotal = actGrandTotal + grandTotal
                //console.log(elementsTotal[i].value)
                $("#grand_total").val(grandTotal)
                $("#subtotal").val(grandTotal)
                $("#balance_due").val(grandTotal)
            }
        });

    }

    function getWarehouse(){
            $.ajax({
                type: "GET",
                url: "/api/warehouse",
                data: "data",
                dataType: "JSON",
                success: function (response) {
                    //console.log(response.data)
                    var data = response.data
                    var option = ""
                    $("#warehouse_id").html()
                    $.each(data, function (i, val) { 
                        option += "<option value="+val.id+"> "+val.name+" </option>"
                    })
                    $("#warehouse_id").append(option)
                
                }   
            });
    }

    function getItemUnit(count=null){
        $.ajax({
            type: "GET",
            url: "/api/product/item-unit",
            data: "data",
            dataType: "JSON",
            success: function (response) {
                var data = response.data
                $("#unit_"+count+"").html("");
                var len = 0;
                if(response['data'] != null) {
                    len = response['data'].length
                    for(i = 0; i < len; i++) {
                        var selected = ""
                        var id = response['data'][i].id
                        var name = response['data'][i].name
                        // if(id == category_id){
                        //     selected = "selected"
                        // }
                        var option = "<option value='"+id+"' "+selected+">"+name+"</option>";
                        $("#unit_"+count+"").append(option);
                    }
                }
            }
        });
    }

    function getVendor(vendorId = null){
        $.ajax({
            type: "GET",
            url: "/api/vendors",
            data: {
                id : vendorId
            },
            dataType: "JSON",
            success: function (response) {
                var data = response.data
                var option = ""
                var selected = ""
                $("#vendor_id").html()
                $("#vendor_code").val("")

                if(vendorId != null){
                    $("#vendor_code").val(data[0].vendor_code)
                }

                $.each(data, function (i, val) { 
                    
                    option += "<option value="+val.id+" "+selected+">"+val.name+" </option>"
                });

                $("#vendor_id").append(option)

            }
        });
    }

    function getInvoiceCategory(name = null){
        $.ajax({
            type: "GET",
            url: "/api/invoice/category",
            data: "data",
            dataType: "JSON",
            success: function (response) {
                var data = response.data
                $("#invoice_category_id").html();
                var len = 0;
                if(response['data'] != null) {
                    len = response['data'].length
                    for(i = 0; i < len; i++) {
                        var selected = ""
                        var id = response['data'][i].id
                        var name = response['data'][i].name
                        // if(id == category_id){
                        //     selected = "selected"
                        // }
                        var option = "<option value='"+id+"' "+selected+">"+name+"</option>";
                        $("#invoice_category_id").append(option);
                    }
                }
            }
        });
    }
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.4/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.js"></script>
@endsection
@section('pagespecificscripts')
   
@stop