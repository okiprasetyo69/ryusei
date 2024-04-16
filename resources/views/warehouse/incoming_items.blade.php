
@extends('layout.home')
@section('title','Gudang')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.css" rel="stylesheet" />
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Management Barang</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">Gudang</a>
                </li>
                <li class="breadcrumb-item active">
                    <a href="#">Barang Masuk</a>
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
                                <label> <strong><span>Tipe Pencarian: </span></strong> </label>
                                <select class="form-control mt-2" name="type_search" id="type_search"> 
                                    <option value=""> - Pilih Tipe - </option>
                                    <option value="1"> Kode SKU </option>
                                    <option value="2"> Nama Artikel </option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4"> 
                                <label> <strong><span>Pencarian : </span></strong> </label>
                            </div>
                            <div class="col-md-2"> 
                                <label> <strong><span>Kategori : </span></strong> </label>
                            </div>
                            <div class="col-md-2"> 
                                <label> <strong><span>Tanggal Awal : </span></strong> </label>
                            </div>
                            <div class="col-md-2"> 
                                <label> <strong><span>Tanggal Akhir : </span></strong> </label>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" name="filter_name" class="form-control" id="filter_name" placeholder="Masukkan kata kunci tipe pencarian" autofocus/>
                                </div>
                            </div>
                            <div class="col-md-2"> 
                                <div class="form-group">
                                    <select class="form-control" name="filter_category" id="filter_category"> 
                                        <option value="">  - Filter Kategori -  </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2"> 
                                <div class="form-group">
                                    <input type="text" name="start_date" class="form-control" id="start_date"/>
                                </div>
                            </div>
                            <div class="col-md-2"> 
                                <div class="form-group">
                                    <input type="text" name="end_date" class="form-control" id="end_date"/>
                                </div>
                            </div>
                            <div class="col-md-2"> 
                                <button type="button" class="btn btn-sm btn-success mt-1" style="border-radius:50px;" id="btn-search"> <i class="bi bi-search"></i> Cari</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mt-2"> 
                            <div class="col md-4 mt-2">
                                <button type="button" class="btn btn-sm btn-primary rounded-pill" id="btn-add-new-stock-item">
                                    <i class="bi bi-file-earmark-plus-fill"></i> Tambah Baru
                                </button>
                                <button type="button" class="btn btn-sm btn-dark rounded-pill btn-add" data-bs-toggle="modal" data-bs-target="#modalStockItems">
                                    <i class="bi bi-plus-circle"></i> Tambah
                                </button>
                                <button type="button" class="btn btn-sm btn-success rounded-pill" id="btn-import" data-bs-toggle="modal" data-bs-target="#basicModal">
                                    <i class="bi bi-file-earmark-excel-fill"></i> Import
                                </button>
                            </div>
                            <div class="col-md-12">
                                <div class="mt-4">
                                    <table class="table table-striped" id="table-stock-items">
                                        <thead class="text-center">
                                            <tr >
                                                <th scope="col">#</th>
                                                <th scope="col">Kode SKU</th>
                                                <th scope="col">Nama Item</th>
                                                <th scope="col">Kategori</th>
                                                <th scope="col">Qty</th>
                                                <th scope="col">Satuan</th>
                                                <th scope="col">Avg. Value</th>
                                                <th scope="col">Total. Value</th>
                                                <th scope="col">Price (PL)</th>
                                                <th scope="col">Tgl Masuk</th>
                                                <th scope="col">Aksi </th>
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

<div class="modal fade" id="modalStockItems" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="#" id="frm-stock-items"> 
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Barang Masuk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="">
                    <input type="hidden" name="id" id="id" class="form-control" />
                    <div class="row">
                        <div class="col-md-12">
                            <label>  Kategori </label>
                            <select class="form-control mt-2"  name="category" id="category" style="width:100%;">
                                <option value="">  - Cari Kategori -  </option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <label> Kode SKU </label>
                            <select class="form-control mt-2 sku_id"  name="sku_id" id="sku_id" style="width: 100%;">
                              
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <label> Nama Item </label>
                            <input type="text" class="form-control" name="article" id="article" readonly />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <label> Qty </label>
                            <input type="number" min="0" class="form-control" name="qty" id="qty" />
                        </div>
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

<!-- Basic Modal -->
<div class="modal fade" id="basicModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="import-form-item-stock" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                      <h5 class="modal-title">Import File Xlsx</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">  
                        <h5> Pastikan File Sesuai Format </h5>
                        <input type="file" name="file_import_item_stock" id="file_import_product" class="form-control">
                    </div>
                    <div class="col-md-12 mt-2">  
                        <button type="button" class="btn btn-md btn-dark" id="btn-download-format-import"><i class="bi bi-cloud-download-fill"></i></button>
                        <label> <b> Download Format File </b></label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="importBtn">Import</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- End Basic Modal-->

<script type="text/javascript"> 
    var table
    var category_id, start_date, end_date, article, sku_code, convertStartDate, convertEndDate
    
    $(document).ready(function () {

        // Set Date
        var now = new Date();
        var month = (now.getMonth() + 1);               
        var day = now.getDate();

        if (month < 10) 
            month = "0" + month;
        if (day < 10) 
            day = "0" + day;
        var today = now.getFullYear() + '-' + month + '-' + day;

        $("#start_date" ).datepicker({
            format: 'dd-mm-yyyy',
            defaultDate: new Date(),
        });
        $("#end_date" ).datepicker({
            format: 'dd-mm-yyyy',
            defaultDate: new Date(),
        });
        
        // Filter
        $("#btn-search").on("click", function(e){
            e.preventDefault()
            start_date = $("#start_date").val()
            end_date = $("#end_date").val()
            convertStartDate = ""
            convertEndDate = ""

            var typeSearch = $("#type_search option:selected").val()
            var filterCategory = $("#filter_category option:selected").val()

            if(typeSearch == 1){
                $("#filter_name").attr("placeholder", "Masukkan Kode SKU")
                sku_code = $("#filter_name").val()
            }

            if(typeSearch == 2){
                $("#filter_name").attr("placeholder", "Masukkan Nama Artikel")
                article = $("#filter_name").val()
            }

            if(start_date != ""){
                convertStartDate = start_date.split("-").reverse().join("-")
            }

            if(end_date != ""){
                convertEndDate = end_date.split("-").reverse().join("-")
            }

            loadStockItems(sku_code, convertStartDate, convertEndDate, article, filterCategory)
        })
        
        // Load Data
        loadStockItems()
        getCategory()
        // getSkuCode()
        $(".sku_id").select2()

        $(".btn-add").on("click", function(e){
            e.preventDefault()
            getCategory()
            $("#sku_id").val(null).trigger('change')
            $("#article").val("")
            $("#qty").val("")
        })

        $("#btn-add-new-stock-item").on("click", function(e){
            e.preventDefault()
            window.location.href = '/product/add'
        })

        $("#category").on("change", function(e){
            e.preventDefault()
            $("#sku_id").val(null).trigger('change')
            $("#article").val("")
            $("#qty").val("")
            category_id = this.value
            getSkuCode(category_id)
        })

        // Close Modal
        $("#btn-close").click(function(e){
            e.preventDefault()
            $("#modalStockItems").modal("hide")
        })

        // Store data
        $("#frm-stock-items").on("submit", function(e){
            e.preventDefault()

            if($("#sku_id").val() == ""){
                $.alert({
                    title: 'Pesan !',
                    content: 'Kode Item tidak boleh kosong !',
                });
                return 
            }

            if($("#category").val() == ""){
                $.alert({
                    title: 'Pesan !',
                    content: 'Kategori tidak boleh kosong !',
                });
                return 
            }

            if($("#qty").val() == ""){
                $.alert({
                    title: 'Pesan !',
                    content: 'Qty tidak boleh kosong !',
                });
                return 
            }

            $.ajax({
                type: "POST",
                url: "/api/item-stock/create",
                data: {
                    id : $("#id").val(),
                    category_id : $("#category").val(),
                    sku_id : $("#sku_id option:selected").val(),
                    qty : $("#qty").val(),
                },
                dataType: "JSON",
                success: function (response) {
                    if(response.status == 200){
                        $("#modalStockItems").modal("hide")
                        $.confirm({
                            title: 'Pesan ',
                            content: 'Data Gudang berhasil diperbarui !',
                            buttons: {
                                Ya: {
                                    btnClass: 'btn-success any-other-class',
                                    action: function(){
                                        loadStockItems()
                                    }
                                },
                            }
                        });
                    }
                }
            });
        })

        // Import data by xlxs
        $("#import-form-item-stock").on("submit", function(e){
            e.preventDefault()
            var formData = new FormData($(this)[0]);
            $.ajax({
                type: "POST",
                url: "/api/item-stock/import",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function (response) {
                    if(response.status == 200){
                        $.confirm({
                            title: 'Pesan ',
                            content: 'Data barang masuk berhasil diperbarui !',
                            buttons: {
                                Ya: {
                                    btnClass: 'btn-success any-other-class',
                                    action: function(){
                                        window.location.href = '/items-incoming'
                                    }
                                },
                            }
                        });
                    }
                }
            });
        })

        // download format file
        $("#btn-download-format-import").on("click", function(e){
            e.preventDefault()
            window.location.href = '/items-incoming/download/import'
        })
    });

    function loadStockItems(sku_code = null, start_date=null, end_date=null, article=null, filter_category){
        if (table != null) {
            table.destroy();
        }

        table =  $("#table-stock-items").DataTable(
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
                    info: "Menampilkan _START_ dari _END_ dari _TOTAL_ Barang Masuk",
                    aria: {
                            paginate: {
                                previous: "Previous",
                                next: "Next",
                            },
                    },
                },
                ajax:{
                    url :  '/api/item-stock',
                    type: "GET",
                    data: {
                        sku_code: sku_code,
                        start_date: start_date,
                        end_date : end_date,
                        article : article,
                        filter_category : filter_category
                        // page : 1,
                        // limit : 10
                    }
                },
                columns: [
                    { data: null,  width: "5%"},
                    { data: null},
                    { data: null, width: "20%" },
                    { data: null },
                    { data: null },
                    { data: null },
                    { data: null },
                    { data: null },
                    { data: null },
                    { data: null },
                    { data: null, width: "10%"},
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
                            var sku_code = ""
                            if(rowData.sku_id == null){
                                sku_code = ""
                            } else {
                                sku_code = rowData.product.sku
                            }
                            $(td).html(sku_code);
                        },
                    },
                    {
                        targets: 2,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            var item_name = ""
                            if(rowData.sku_id == null){
                                item_name = ""
                            } else {
                                item_name = rowData.product.name
                            }
                            $(td).html(item_name);
                        },
                    },
                    {
                        targets: 3,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            var category_name = ""
                            if(rowData.sku_id == null){
                                category_name = ""
                            } else {
                                category_name = rowData.product.category.name
                            }
                            $(td).html(category_name);
                        },
                    },
                    {
                        targets: 4,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            var qty = 0

                            if(rowData.qty != null){
                                qty = rowData.qty
                            } 

                            $(td).html(qty);
                        },
                    },
                    {
                        targets: 5,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            var unit_name = "-"

                            if(rowData.sku_id != null){
                                if( rowData.product.unit != null ){
                                    unit_name = rowData.product.unit.name
                                }
                            } 

                            $(td).html(unit_name);
                        },
                    },
                    {
                        targets: 6,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            var avg_value = "-"
                         
                            $(td).html(avg_value);
                        },
                    },
                    {
                        targets: 7,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            var total_value = "-"
                         
                            $(td).html(total_value);
                        },
                    },
                    {
                        targets: 8,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            var price = 0
                            if(rowData.sku_id != null){
                                price = rowData.product.price.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' })
                            }
                            $(td).html(price);
                        },
                    },
                    {
                        targets: 9,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            check_in_date = rowData.check_in_date
                            date = new Date(check_in_date)
                            month = date.toLocaleString('default', { month: 'long' })
                            year = date.getFullYear()
                            format = date.getDate() + "-"+ month +"-"+ year

                            $(td).html(format);
                        },
                    },
                    {
                        targets: 10,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            var html = "<button type='button' class='btn btn-sm btn-warning' onclick='detail("+rowData.id+")' > Ubah </button> <button type='button' class='btn btn-sm btn-danger' onclick='confirm("+rowData.id+")'> Hapus </button>"
                            $(td).html(html);
                        },
                    },
                ]
           }
        )
    }

    function getCategory(category_id=null){
        $.ajax({
            type: "GET",
            url: "/api/category",
            data: "data",
            dataType: "JSON",
            success: function (response) {

                $("#category").html();
                    var len = 0;
                    if(response['data'] != null) {
                        len = response['data'].length
                        for(i = 0; i < len; i++) {
                            var selected = ""
                            var id = response['data'][i].id
                            var name = response['data'][i].name
                            if(id == category_id){
                                selected = "selected"
                            }
                            var option = "<option value='"+id+"' "+selected+">"+name+"</option>";
                            $("#category").append(option);
                    }
                }

                $("#filter_category").html();
                    var len = 0;
                    if(response['data'] != null) {
                        len = response['data'].length
                        for(i = 0; i < len; i++) {
                            var selected = ""
                            var id = response['data'][i].id
                            var name = response['data'][i].name
                            if(id == category_id){
                                selected = "selected"
                            }
                            var option = "<option value='"+id+"' "+selected+">"+name+"</option>";
                            $("#filter_category").append(option);
                    }
                }
            }
        });
    }

    function getSkuCode(categoryId=null, skuId = null){
        // $.ajax({
        //     type: "GET",
        //     url: "/api/product",
        //     data: {
        //         category_id : categoryId
        //     },
        //     dataType: "JSON",
        //     success: function (response) {
        //         var data = response.data
        //         var option = ""
        //         $("#sku_id").html("")
        //         $.each(data, function (i, val) { 
        //             option += "<option value="+val.id+"> "+val.sku+" </option>"
        //         });
        //         $("#sku_id").append(option)
        //     }
        // });

        let item_code = $('.sku_id').val()

        $(".sku_id").select2({
            dropdownParent: $("#modalStockItems"),
            ajax: {
                url: "/api/product/list/invoice/select2",
                dataType: "JSON",
                type: "GET",
                data: function (params) {
                    //console.log(params)
                    return {
                        searchTerm: params.term,
                        id: item_code,
                        category_id : categoryId,
                        sku_id : skuId
                    };
                },
                processResults: function (response) {
                    // console.log(response)
                    return {
                        results: response,
                       
                    };
                  
                },
                cache: true,
            },
        })
        .on("select2:select", function (e) {
            var data = e.params.data;
            var article = data.article
            $("#article").val(data.article)
            // $("#sku_id").val(data.sku).trigger('change')
            //console.log(data)
        });
       
    }

    function getArticle(sku = null){
        $.ajax({
            type: "GET",
            url: "/api/product",
            data: {
                sku : sku
            },
            dataType: "JSON",
            success: function (response) {
                var data = response.data[0].article
                $("#article").val(data)
            }
        });
    }

    function detail(id){
        $.ajax({
            type: "POST",
            url: "/api/item-stock/detail",
            data: {
                id : id
            },
            dataType: "JSON",
            success: function (response) {
                var data = response.data
                var sku_id = data.sku_id
                category_id = data.category_id
               
                getCategory(category_id)
                getSkuCode(category_id, sku_id)
                getProduct(sku_id)
            
                $("#modalStockItems").modal("show")
                $(".modal-title").text("Ubah Barang Masuk")
                $("#btn-save").text("Ubah")
                $("#id").val(data.id)
                $("#qty").val(data.qty)

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
            url: "/api/item-stock/delete",
            data: {
                id : id,
            },
            dataType: "JSON",
            success: function (response) {
                if(response.status == 200){
                    $.confirm({
                        title: 'Pesan',
                        content: 'Data barang masuk berhasil dihapus !',
                        buttons: {
                            Ya: {
                                btnClass: 'btn-success any-other-class',
                                action: function(){
                                    loadStockItems()
                                }
                            },
                        }
                    });
                }
            }
        });
    }

    function getProduct(sku_id=null){
         $.ajax({
            type: "POST",
            url: "/api/product/detail",
            data: {
                id : sku_id
            },
            dataType: "JSON",
            success: function (response) {
                var data = response.data
                //console.log(data)
                var option = "<option value="+data.id+"  selected> "+data.article+" </option>"
                $("#sku_id").html(option)
                $("#article").val(data.article)
                //$(".sku_id").select2('data',{id:data.id, text:data.article});
                
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