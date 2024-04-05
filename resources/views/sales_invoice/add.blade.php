
@extends('layout.home')
@section('title','Dashboard')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
                    <a href="#">Penjualan</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="/sales-invoice">Invoice</a>
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
                                <label> <strong> Customer </strong> </label>
                            </div>
                           <div class="col-md-2"></div>
                           <div class="col-md-2"></div>
                           <div class="col-md-2"></div>
                           <div class="col-md-2"></div>
                           <div class="col-md-2">
                                <label> <b> Import File </b> </label>
                           </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select name="sales_channel_id" class="form-control" id="sales_channel_id"> <option value=""> - Pilih Customer - </option> </select>
                                </div>
                            </div>
                            <div class="col-md-2"></div>
                            <div class="col-md-2"></div>
                            <div class="col-md-2"></div>
                            <div class="col-md-2"></div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-md btn-success float-right" id="btn-import" data-bs-toggle="modal" data-bs-target="#modalImportInvoice">
                                    <i class="bi bi-file-earmark-excel-fill"></i> Import
                                </button>
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
                                <label for="" class="col-sm-4 col-form-label">Cust. Code</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="customer_code" name="customer_code" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="" class="col-sm-4 col-form-label">Cust. Phone</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="customer_phone" name="customer_phone">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="" class="col-sm-4 col-form-label">Cust. Ref</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="customer_reference">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="" class="col-sm-4 col-form-label">Category</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="category_id" id="category_id"> </select>
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
                                <label for="" class="col-sm-4 col-form-label">Invoice No.</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="invoice_number" name="invoice_number">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="" class="col-sm-4 col-form-label">Batch No.</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="batch_number" name="batch_number">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="" class="col-sm-4 col-form-label">Type</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="type" id="type"> 
                                        <option value=""> - Pilih Tipe -  </option>
                                        <option value="1"> Standard </option>
                                        <option value="2"> Service </option>
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
                                <label for="" class="col-sm-4 col-form-label">Date</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="date" name="date">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="" class="col-sm-4 col-form-label">Due Date</label>
                                <div class="col-sm-6">
                                        <input type="text" class="form-control" id="due_date" name="due_date">
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
                               <select class="form-control mt-2" name="invoice_type" id="invoice_type"> 
                                    <option value="1"> Item </option> 
                                    <option value="2"> Summary </option> 
                                </select>
                            </div>
                            <div class="col-md-2 mt-2" id="attr_warehouse"> 
                                <label> Warehouse :</label>
                                <select class="form-control mt-2" name="warehouse_id" id="warehouse_id"> 
                                     
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2"> 
                            <div class="col md-4 mt-2">
                                <button type="button" class="btn btn-sm btn-primary rounded-pill" id="btn-add">
                                    <i class="bi bi-plus-circle"></i> Tambah
                                </button>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-add-invoice-item" style="max-height:600px;">
                                        <thead>
                                            <tr class="text-center">
                                                <th scope="col">#</th>
                                                <th scope="col">Item Code</th>
                                                <th scope="col">Description</th>
                                                <th scope="col">Qty</th>
                                                <th scope="col">Unit</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Disc %</th>
                                                <th scope="col">Total</th>
                                                <th scope="col">Tax Code</th>
                                                <th scope="col">No Order</th>
                                                <th scope="col">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody-invoice-item">
                                        
                                        </tbody>
                                    </table>

                                    <table class="table table-striped" id="table-add-invoice-summary" style="max-height:600px;">
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
                                    <label for="" class="col-sm-4 col-form-label">Sales Person</label>
                                    <div class="col-sm-6">
                                        <select class="form-control" name="sales_person" id="sales_person"> 
                                           
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="" class="col-sm-4 col-form-label">Journal Memo</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="journal_memo" name="journal_memo">
                                    </div>
                                </div>
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
                                        <input type="number" min="0" class="form-control" name="discount_percent" id="discount_percent"/>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="number" min="0" class="form-control" name="discount" id="discount"/>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="" class="col-sm-4 col-form-label">Additional Char</label>
                                    <div class="col-sm-6">
                                        <input type="number" min="0" class="form-control" name="subtotal" id="subtotal"/>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="" class="col-sm-4 col-form-label">Down Pmt.</label>
                                    <div class="col-sm-6">
                                        <input type="number" min="0" class="form-control" name="subtotal" id="subtotal"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4"> 
                                <div class="row mb-3">
                                    <label for="" class="col-sm-3 col-form-label">Tax</label>
                                    <div class="col-sm-6">
                                        <input type="number" class="form-control" name="tax" id="tax"/>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="" class="col-sm-3 col-form-label">PPh 23</label>
                                    <div class="col-sm-4">
                                        <input type="number" min="0" class="form-control" name="pph_percent" id="pph_percent"/>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="number" min="0" class="form-control" name="pph" id="pph"/>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="" class="col-sm-3 col-form-label">Total</label>
                                    <div class="col-sm-6">
                                        <input type="number" class="form-control" name="total" id="total"/>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="" class="col-sm-3 col-form-label">Balance Due</label>
                                    <div class="col-sm-6">
                                        <input type="number" class="form-control" name="balance_due" id="balance_due"/>
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
                        <button type="submit" class="btn btn-success btn-save">Simpan</button>
                        <button type="button" class="btn btn-secondary btn-reset">Batal</button>
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
                        <input type="file" name="file_import_invoice" class="form-control mt-2">
                    </div>
                    <div class="col-md-12 mt-2">  
                        <button type="button" class="btn btn-md btn-dark" id="btn-download-format-import"><i class="bi bi-cloud-download-fill"></i></button>
                        <label> <b> Download Format File </b></label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="btn-save">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                  
                </div>
            </form>
        </div>
    </div>
</div>


<script type="text/javascript"> 

    var table

    $(document).ready(function () {

        $("#table-add-invoice-summary").hide()

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

        // create dynamic form
        $("#btn-add").on("click", function(e){
            e.preventDefault()
            console.log("Masuk sini")
            let row = ""
            let head = ""
            var selectedType = $("#invoice_type option:selected").val()
            let count = 0

            if(selectedType == 1){
                $("#table-add-invoice-item").show()
                $("#table-add-invoice-summary").hide()
                $("#table-add-invoice-summary").html()
                $("#attr_warehouse").show()

                count = $('#table-add-invoice-item tr').length
                row =  `<tr> 
                        <td>`+count+`</td>
                        <td><select name="item_code[]" class="form-control item_code" id="item_code_`+ count +`" style="width:100%;"></select></td>    
                        <td><input type="text" name="description[]" class="form-control description" id="description_`+ count +`"/></td>    
                        <td><input type="number" min="0" name="qty[]" class="form-control qty" id="qty_`+ count +`"/></td>    
                        <td><input type="number" min="0" name="unit[]" class="form-control unit" id="unit_`+ count +`"/></td>  
                        <td><input type="number" min="0 "name="price[]" class="form-control price" id="price_`+count+`"/></td>    
                        <td><input type="number" min="0 "name="discount[]" class="form-control discount" id="discount_`+count+`"/></td>    
                        <td><input type="number" min="0 "name="total[]" class="form-control total" id="total_`+count+`"/></td>
                        <td><input type="text" name="tax_code[]" class="form-control tax_code" id="tax_code_`+ count +`"/></td> 
                        <td><input type="text" name="order_number[]" class="form-control order_number" id="order_number_`+ count +`"/></td>             
                        <td><button type='button' class='btn btn-md btn-danger delete-row' id=`+count+`><i class='bi bi-trash' aria-hidden='true'></i></button></td>    
                    </tr>`
                $('#tbody-invoice-item').append(row);
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
                        <td><input type="number" min="0 "name="discount_percent[]" class="form-control discount" id="discount_percent`+count+`"/></td>   
                        <td><input type="number" min="0 "name="discount" class="form-control discount" id="discount_`+count+`"/></td>  
                        <td><input type="number" min="0 "name="total[]" class="form-control total" id="total_`+count+`"/></td>
                        <td><input type="text" name="tax_code[]" class="form-control tax_code" id="tax_code_`+ count +`"/></td>           
                        <td><button type='button' class='btn btn-md btn-danger delete-row' id=`+count+`><i class='bi bi-trash' aria-hidden='true'></i></button></td>    
                    </tr>`
                $('#tbody-invoice-summary').append(row);
            }

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
    });


   

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection
@section('pagespecificscripts')
   
@stop