
@extends('layout.home')
@section('title','Dashboard')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Management Barang</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">Katalog</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="/category">Kategori</a>
                </li>
                <li class="breadcrumb-item active">
                    <a href="/category/list">List Kategori</a>
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
                            <div class="col md-4">
                                <button type="button" class="btn btn-primary rounded-pill btn-add" data-toggle="modal" data-target="#categoryListModal">
                                    <i class="bi bi-plus-circle"></i> Tambah
                                </button>
                            </div>
                            <div class="col-md-12">
                                <div class="">
                                    <table class="table table-striped" id="table-list-category">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">List Kategori</th>
                                                <th scope="col">Kategori</th>
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
<!-- End #main -->

<!-- Modal -->
<div class="modal fade" id="categoryListModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title .modal-title" id="exampleModalLongTitle">Tambah Kategori</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="#" id="frm-list-category">
        @csrf
      <div class="modal-body">
        <input type="hidden" name="id" id="id" class="form-control" />
        <div class="row">
          <div class="col-md-12 mt-2">
            <label> Nama List Kategori</label>
            <input type="text" class="form-control" name="list_name" id="list_name" />
          </div>
        </div>
        <div class="row">
            <div class="col-md-12 mt-2">
            <label> Kategori</label>
            <select class="form-control category_list_id" name="category_id" id="category_id" width="100%;"> 
                <option value=""> - Pilih Kategori - </option>
            </select>
          </div>
        </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-md btn-success" id="btn-save">Simpan</button>
        <button type="button" class="btn btn-md btn-secondary" data-dismiss="modal" id="btn-close">Batal</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript"> 
    var list_name
    var table
    var category_id
    $(document).ready(function () {
        
        loadListCategory()
        getCategory()
        // Open Modal
        $(".btn-add").click(function(e){
            e.preventDefault()
            $("#categoryListModal").modal("show")
            $(".modal-title").text("Tambah List Kategori")
            $("#btn-save").text("Simpan")
            $("#id").val("")
            $("#list_name").val("")
        })
        // Close Modal
        $("#btn-close").click(function(e){
            e.preventDefault()
            $("#categoryListModal").modal("hide")
        })

        // filter list category
        $("#filter_name").on("keyup", function(e){
            e.preventDefault()
            list_name = $("#filter_name").val()
            loadListCategory(list_name)
        })
        // Store data
        $("#frm-list-category").on("submit", function(e){
            e.preventDefault()

            if($("#list_name").val() == ""){
                $.alert({
                    title: 'Pesan!',
                    content: 'Nama list kategori tidak boleh kosong !',
                });
                return 
            }

            $.ajax({
                type: "POST",
                url: "/api/category/list/create",
                data: {
                    id : $("#id").val(),
                    list_name : $("#list_name").val(),
                    category_id : $("#category_id option:selected").val()
                },
                dataType: "JSON",
                success: function (response) {
                    if(response.status == 200){
                        $("#categoryListModal").modal("hide")
                        $.confirm({
                            title: 'Pesan ',
                            content: 'Data list kategori berhasil diperbarui !',
                            buttons: {
                                Ya: {
                                    btnClass: 'btn-success any-other-class',
                                    action: function(){
                                        loadListCategory()
                                    }
                                },
                            }
                        });
                    }
                }
            });
        })

    });

    function loadListCategory(name = null){
        if (table != null) {
            table.destroy();
        }

        table =  $("#table-list-category").DataTable(
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
                info: "Menampilkan _START_ dari _END_ dari _TOTAL_ List Kategori",
                aria: {
                        paginate: {
                            previous: "Previous",
                            next: "Next",
                        },
                    },
                },
                ajax:{
                    url :  '/api/category/list',
                    type: "GET",
                    data: {
                        list_name: list_name
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
                        width: "20%",
                    },
                    {
                        data: null,
                        width: "50%",
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
                            $(td).html(rowData.list_name);
                        },
                    },
                    {
                        targets: 2,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            var category = ""
                            //console.log(rowData.category)
                            if(rowData.category == null){
                                $(td).html("-");
                            }else {
                                $(td).html(rowData.category.name);
                            }
                        },
                    },
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

    // Deprecated function
    function getListCategory(name = null){
        if (table != null) {
            table.destroy();
        }
        table = $("#table-list-category").DataTable({
            "lengthChange": false,
			"searching": false,
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "bAutoWidth": true,
            "scrollX" : true,
            "scrollCollapse" : true,
            "language": {
                "emptyTable": "Data tidak tersedia",
                "zeroRecords": "Tidak ada data yang ditemukan",
                "infoFiltered": "",
                "infoEmpty": "",
                "paginate": {
                    "previous": "‹",
                    "next": "›",
                },
                "info": "Menampilkan _START_ dari _END_ dari _TOTAL_ Kategori",
                "aria": {
                    "paginate": {
                        "previous": "Previous",
                        "next": "Next",
                    },
                },
            },
            "columns": [
                {
                    data: null,
                    width: "5%",
                },
                {
                    data: null,
                    width: "20%",
                },
                {
                    data: null,
                    width: "50%",
                },
                {
                    data: null,
                },
            ],
            "columnDefs": [
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
                        $(td).html(rowData.list_name);
                    },
                },
                {
                    targets: 2,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        var category = ""
                        //console.log(rowData.category)
                        if(rowData.category == null){
                            $(td).html("-");
                        }else {
                            $(td).html(rowData.category.name);
                        }
                    },
                },
                {
                    targets: 3,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        var html = "<button type='button' class='btn btn-sm btn-warning' onclick='detail("+rowData.id+")' > Ubah </button> <button type='button' class='btn btn-sm btn-danger' onclick='confirm("+rowData.id+")'> Hapus </button>"
                        $(td).html(html);
                    },
                },
            ],
            "ajax": function(data, callback, settings) {
                let length = data.length
                let pages = (data.start / 10) + 1
                $.get('/api/category/list', {
                        _token: "{{ csrf_token() }}",
                        limit: length,
                        page: pages,
                        list_name: list_name
                    }, 
                    function(res) {
                        callback({
                            recordsTotal: res.recordsTotal,
                            recordsFiltered: res.recordsFiltered,
                            data: res.data
                    });
                });
            },
        })
    }
    // End deprecated

    function detail(id){
        $.ajax({
            type: "POST",
            url: "/api/category/list/detail",
            data: {
                id : id
            },
            dataType: "JSON",
            success: function (response) {
                var data = response.data
                console.log(data)
                getCategory(data.category_id)
                $("#categoryListModal").modal("show")
                $(".modal-title").text("Ubah List Kategori")
                $("#btn-save").text("Ubah")
                $("#id").val(data.id)
                $("#list_name").val(data.list_name)
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
            url: "/api/category/list/delete",
            data: {
                id : id,
            },
            dataType: "JSON",
            success: function (response) {
                if(response.status == 200){
                    $.confirm({
                        title: 'Pesan',
                        content: 'Data list kategori berhasil dihapus !',
                        buttons: {
                            Ya: {
                                btnClass: 'btn-success any-other-class',
                                action: function(){
                                    loadListCategory()
                                }
                            },
                        }
                    });
                }
            }
        });
    }

    function getCategory(category_id=null){
        $.ajax({
            type: "GET",
            url: "/api/category",
            data: "data",
            dataType: "JSON",
            success: function (response) {
                var data = response.data
                $("#category_id").html();
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
                            $("#category_id").append(option);
                    }
                }
            }
        });
    }
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
@endsection
@section('pagespecificscripts')
   
@stop