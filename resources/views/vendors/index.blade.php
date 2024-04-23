
@extends('layout.home')
@section('title','Vendor')
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
                    <a href="#">Pemasok - Vendor</a>
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
                                <label> <strong><span>Pencarian</span></strong> </label>
                            </div>
                        </div>
                        <div class="row mt-2"> 
                            <div class="col-md-4">
                                <div class="form-group"> 
                                    <select class="form-control" name="filter_type" id="filter_type"> 
                                        <option value="1"> Nama </option>
                                        <option value="2"> Kode </option>
                                        <option value="3"> Kategori </option>
                                        <option value="4"> Phone </option>
                                        <option value="5"> Mobile </option>
                                        <option value="6"> Email </option>
                                    </select>
                                </div>
                            </div>
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
                            <div class="col md-4">
                                <button type="button" class="btn btn-sm btn-primary rounded-pill" id="btn-add">
                                    <i class="bi bi-plus-circle"></i> Tambah
                                </button>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <div class="">
                                    <table class="table table-striped" id="table-vendor">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Kode</th>
                                                <th scope="col">Nama</th>
                                                <th scope="col">Kategori</th>
                                                <th scope="col">Telephone</th>
                                                <th scope="col">Mobile Phone</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Tax</th>
                                                <th scope="col">Balance</th>
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
    var name, vendor_code, category, phone, mobile, email
    var table
    $(document).ready(function () {

        loadVendor()

        $("#btn-add").on("click", function(e){
            e.preventDefault()
            window.location.href = "/vendors/add"
        })

        // filter invoice
        $("#filter_name").on("keyup", function(e){
            e.preventDefault()
            var type = $("#filter_type").val()

            if(type == 1){
                name = $("#filter_name").val()
            }
            if(type == 2){
                vendor_code = $("#filter_name").val()
            }

            if(type == 3){
                category = $("#filter_name").val()
            }

            if(type == 4){
                phone = $("#filter_name").val()
            }

            if(type == 5){
                mobile = $("#filter_name").val()
            }
            
            if(type == 6){
                email = $("#filter_name").val()
            }

            loadVendor(name, vendor_code, category, phone, mobile, email)
        })

    });

    function loadVendor(name = null, vendor_code=null, category=null, phone=null, mobile=null, email=null){
        if (table != null) {
            table.destroy();
        }

        table =  $("#table-vendor").DataTable(
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
                info: "Menampilkan _START_ dari _END_ dari _TOTAL_ Vendor",
                aria: {
                        paginate: {
                            previous: "Previous",
                            next: "Next",
                        },
                    },
                },
                ajax:{
                    url :  '/api/vendor',
                    type: "GET",
                    data: {
                        name: name,
                        vendor_code: vendor_code, 
                        category : category,
                        phone : phone,
                        mobile : mobile,
                        email : email
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
                            $(td).html(rowData.vendor_code);
                        },
                    },
                    {
                        targets: 2,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            $(td).html(rowData.name);
                        },
                    },
                    {
                        targets: 3,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            $(td).html(rowData.category);
                        },
                    },
                    {
                        targets: 4,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            $(td).html(rowData.phone);
                        },
                    },
                    {
                        targets: 5,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            $(td).html(rowData.mobile);
                        },
                    },
                    {
                        targets: 6,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            $(td).html(rowData.email);
                        },
                    },
                    {
                        targets: 7,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            var checked = ""
                            var html = ""
                            if(rowData.is_tax_on_purchase == 1){
                                checked = "checked"
                                html = "<input class='form-check-input tax' type='checkbox' id='is_tax_on_purchase' value="+rowData.is_tax_on_purchase+" "+checked+">"
                            } else {
                                html = "<input class='form-check-input tax' type='checkbox' id='is_tax_on_purchase' value="+rowData.is_tax_on_purchase+" >"
                            }
                            $(td).html(html);
                          
                        },
                    },
                    {
                        targets: 8,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            $(td).html(rowData.balance);
                        },
                    },
                    {
                        targets: 9,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            var html = "<a href='/vendors/"+rowData.id+"' class='btn btn-sm btn-warning'> Detail </a> <button type='button' class='btn btn-sm btn-danger' onclick='confirm("+rowData.id+")'> Hapus </button>"
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
            url: "/api/vendor/delete",
            data: {
                id : id,
            },
            dataType: "JSON",
            success: function (response) {

                if(response.status == 200){
                    $.confirm({
                        title: 'Pesan',
                        content: 'Data Vendor berhasil dihapus !',
                        buttons: {
                            Ya: {
                                btnClass: 'btn-success any-other-class',
                                action: function(){
                                    loadVendor()
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