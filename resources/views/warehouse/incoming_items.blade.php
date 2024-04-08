
@extends('layout.home')
@section('title','Gudang')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
                            <label> <strong><span>Pencarian : </span></strong> </label>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" name="filter_name" class="form-control" id="filter_name" placeholder="Masukkan kata kunci" autofocus/>
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
                            <div class="col md-4 mt-2">
                                <button type="button" class="btn btn-sm btn-success rounded-pill" id="btn-add-new-stock-item">
                                    <i class="bi bi-file-earmark-plus-fill"></i> Tambah Baru
                                </button>
                                <button type="button" class="btn btn-sm btn-dark rounded-pill btn-add" data-bs-toggle="modal" data-bs-target="#modalStockItems">
                                    <i class="bi bi-plus-circle"></i> Tambah
                                </button>
                            </div>
                            <div class="col-md-12">
                                <div class="mt-4">
                                    <table class="table table-striped" id="table-stock-items">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Item Code</th>
                                                <th scope="col">Item Name</th>
                                                <th scope="col">Category</th>
                                                <th scope="col">Qty</th>
                                                <th scope="col">Unit</th>
                                                <th scope="col">Avg. Value</th>
                                                <th scope="col">Total. Value</th>
                                                <th scope="col">Price (PL)</th>
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
                <div class="modal-body">
                    <input type="hidden" name="id" id="id" class="form-control" />
                    <div class="row">
                        <div class="col-md-12">
                            <label>  Category </label>
                            <select class="form-control mt-2"  name="category" id="category" style="width:100%;">
                                <option value="">  - Search Category -  </option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <label> Item Code </label>
                            <select class="form-control mt-2 sku_id"  name="sku_id" id="sku_id" style="width: 100%;">
                              
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <label> Item Name </label>
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

<script type="text/javascript"> 
    var name
    var table
    var category_id
    $(document).ready(function () {
        
        getCategory()
        // getSkuCode()
        //$(".sku_id").select2()

        $("#btn-add-new-stock-item").on("click", function(e){
            e.preventDefault()
            window.location.href = '/product/add'
        })

        $("#category").on("change", function(e){
            e.preventDefault()
            category_id = this.value
            getSkuCode(category_id)
        })

        $("#sku_id").on("change", function(e){
            e.preventDefault()
            sku = $("#sku_id option:selected").text()
            getArticle(sku)
        })

        // loadStockItems()

        // Close Modal
        $("#btn-close").click(function(e){
            e.preventDefault()
            $("#modalStockItems").modal("hide")
        })

        // filter category
        $("#filter_name").on("keyup", function(e){
            e.preventDefault()
            name = $("#filter_name").val()
            loadStockItems(name)
        })

        // Store data
        $("#frm-stock-items").on("submit", function(e){
            e.preventDefault()

            if($("#sku_code").val() == ""){
                $.alert({
                    title: 'Pesan !',
                    content: 'Kode Item tidak boleh kosong !',
                });
                return 
            }

            $.ajax({
                type: "POST",
                url: "",
                data: {
                    id : $("#id").val(),
                    name : $("#name").val(),
                    address : $("#address").val(),
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

    });

    function loadStockItems(name = null){
        if (table != null) {
            table.destroy();
        }

        table =  $("#table-warehouse").DataTable(
           {
                lengthChange: false,
                searching: false,
                destroy: true,
                processing: true,
                serverSide: true,
                bAutoWidth: true,
                scrollCollapse : true,
                language: {
                emptyTable: "Data tidak tersedia",
                zeroRecords: "Tidak ada data yang ditemukan",
                infoFiltered: "",
                infoEmpty: "",
                paginate: {
                    previous: "‹",
                    next: "›",
                },
                info: "Menampilkan _START_ dari _END_ dari _TOTAL_ Kategori",
                aria: {
                        paginate: {
                            previous: "Previous",
                            next: "Next",
                        },
                    },
                },
                ajax:{
                    url :  '/api/warehouse',
                    type: "GET",
                    data: {
                        name: name,
                        // page : 1,
                        // limit : 10
                    }
                },
                columns: [
                    { data: 'id', name: 'id',  width: "10%",},
                    { data: 'name', name: 'name', width: "30%", },
                    { data: 'address', name: 'address', width: "30%", },
                    { data: null },
                ],
                columnDefs: [
                    {
                        targets: 3,
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

    function detail(id){
        $.ajax({
            type: "POST",
            url: "",
            data: {
                id : id
            },
            dataType: "JSON",
            success: function (response) {
                var data = response.data
                $("#modalWarehouse").modal("show")
                $(".modal-title").text("Ubah Gudang")
                $("#btn-save").text("Ubah")
                $("#id").val(data.id)
                $("#name").val(data.name)
                $("#address").val(data.address)
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
            url: "",
            data: {
                id : id,
            },
            dataType: "JSON",
            success: function (response) {
                if(response.status == 200){
                    $.confirm({
                        title: 'Pesan',
                        content: 'Data Stock Barang berhasil dihapus !',
                        buttons: {
                            Ya: {
                                btnClass: 'btn-success any-other-class',
                                action: function(){
                                    // loadStockItems()
                                }
                            },
                        }
                    });
                }
            }
        });
    }

    function getCategory(){
        $.ajax({
            type: "GET",
            url: "/api/category",
            data: "data",
            dataType: "JSON",
            success: function (response) {
                var data = response.data
                var option = ""
                $("#category").html("")
                $.each(data, function (i, val) { 
                    option += "<option value="+val.id+"> "+val.name+" </option>"
                });
                $("#category").append(option)
            }
        });
    }

    function getSkuCode(categoryId=null){
        $.ajax({
            type: "GET",
            url: "/api/product",
            data: {
                category_id : categoryId
            },
            dataType: "JSON",
            success: function (response) {
                var data = response.data
                var option = ""
                $("#sku_id").html("")
                $.each(data, function (i, val) { 
                    option += "<option value="+val.id+"> "+val.sku+" </option>"
                });
                $("#sku_id").append(option)
            }
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

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection
@section('pagespecificscripts')
   
@stop