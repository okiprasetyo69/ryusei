
@extends('layout.home')
@section('title','Managment Transaksi')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
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
                    <a href="/sales-channel">Sales Channel</a>
                </li>
                <!-- <li class="breadcrumb-item">
                    <a href="#">List Kategori</a>
                </li> -->
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mt-2">
                            <label> <strong><span>Pencarian Nama Channel: </span></strong> </label>
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
                                <button type="button" class="btn btn-primary rounded-pill btn-add" data-bs-toggle="modal" data-target="#salesChannelModal">
                                    <i class="bi bi-plus-circle"></i> Tambah
                                </button>
                            </div>
                            <div class="col-md-12">
                                <div class="">
                                    <table class="table table-striped" id="table-sales-channel">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Kode</th>
                                                <th scope="col">Nama Sales Channel</th>
                                                <th scope="col">Biaya Admin %</th>
                                                <th scope="col">Tahun</th>
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
<div class="modal fade" id="salesChannelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title .modal-title" id="exampleModalLongTitle">Tambah Kategori</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="#" id="frm-sales-channel">
        @csrf
      <div class="modal-body">
        <input type="hidden" name="id" id="id" class="form-control" />
        <div class="row">
          <div class="col-md-12 mt-2">
            <label> Kode </label>
            <input type="text" class="form-control" name="code" id="code" />
          </div>
          <div class="col-md-12 mt-2">
            <label> Nama Sales Channel</label>
            <input type="text" class="form-control" name="name" id="name" />
          </div>
          <div class="col-md-12 mt-2">
            <div class="row">
                <label> Biaya Admin</label>
                <div class="col-md-10">
                    <input type="number" min="0" class="form-control" name="admin_charge" id="admin_charge" />
                </div>
                <div class="col-md-2">
                    <span class="input-group-text" id="basic-addon2">%</span>
                </div>
            </div>
          </div>
          <div class="col-md-12 mt-2">
            <label> Tahun </label>
            <input type="number" min="0" class="form-control" name="year" id="year" />
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
    var name
    var table
    var category_list_id
    $(document).ready(function () {
        
        getSalesChannel()

        // Open Modal
        $(".btn-add").click(function(e){
            e.preventDefault()
            $("#salesChannelModal").modal("show")
            $(".modal-title").text("Tambah Sales Channel")
            $("#btn-save").text("Simpan")
            $("#id").val("")
            $("#code").val("")
            $("#name").val("")
            $("#year").val("")
            $("#admin_charge").val("")
        })
        // Close Modal
        $("#btn-close").click(function(e){
            e.preventDefault()
            $("#salesChannelModal").modal("hide")
        })

        // filter category
        $("#filter_name").on("keyup", function(e){
            e.preventDefault()
            name = $("#filter_name").val()
            getSalesChannel(name)
        })

        // Store data
        $("#frm-sales-channel").on("submit", function(e){
            e.preventDefault()

            if($("#code").val() == ""){
                $.alert({
                    title: 'Pesan!',
                    content: 'Kode sales channel tidak boleh kosong !',
                });
                return 
            }

            if($("#name").val() == ""){
                $.alert({
                    title: 'Pesan!',
                    content: 'Nama sales channel tidak boleh kosong !',
                });
                return 
            }

            if($("#admin_charge").val() == ""){
                $.alert({
                    title: 'Pesan!',
                    content: 'Admin charge tidak boleh kosong !',
                });
                return 
            }

            if($("#year").val() == ""){
                $.alert({
                    title: 'Pesan!',
                    content: 'Tahun sales channel tidak boleh kosong !',
                });
                return 
            }

            $.ajax({
                type: "POST",
                url: "/api/sales-channel/create",
                data: {
                    id : $("#id").val(),
                    code : $("#code").val(),
                    name : $("#name").val(),
                    admin_charge : $("#admin_charge").val(),
                    year : $("#year").val(),
                },
                dataType: "JSON",
                success: function (response) {
                    if(response.status == 200){
                        $("#categoryModal").modal("hide")
                        $.confirm({
                            title: 'Pesan ',
                            content: 'Data kategori berhasil diperbarui !',
                            buttons: {
                                Ya: {
                                    btnClass: 'btn-success any-other-class',
                                    action: function(){
                                        getSalesChannel()
                                        $("#salesChannelModal").modal("hide")
                                    }
                                },
                            }
                        });
                    }
                }
            });
        })

    });

    function getSalesChannel(name = null){
        if (table != null) {
            table.destroy();
        }
        table = $("#table-sales-channel").DataTable({
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
                "info": "Menampilkan _START_ dari _END_ dari _TOTAL_ Sales Channel",
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
                        $(td).html(rowData.code);
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
                        var admin_charge = 0
                        if(rowData.admin_charge != null){
                            admin_charge = rowData.admin_charge
                        }
                        $(td).html(admin_charge);
                    },
                },
                {
                    targets: 4,
                    searchable: false,
                    orderable: false,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).html(rowData.year);
                    },
                },
                {
                    targets: 5,
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
                $.get('/api/sales-channel/datatable', {
                        _token: "{{ csrf_token() }}",
                        limit: length,
                        page: pages,
                        name: name
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

    function detail(id){
        $.ajax({
            type: "POST",
            url: "/api/sales-channel/detail",
            data: {
                id : id
            },
            dataType: "JSON",
            success: function (response) {
                var data = response.data
                var admin_charge = 0
                if(data.admin_charge != null){
                    admin_charge = data.admin_charge
                }
                $("#salesChannelModal").modal("show")
                $(".modal-title").text("Ubah Sales Channel")
                $("#btn-save").text("Ubah")
                $("#id").val(data.id)
                $("#code").val(data.code)
                $("#name").val(data.name)
                $("#admin_charge").val(admin_charge)
                $("#year").val(data.year)
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
            url: "/api/sales-channel/delete",
            data: {
                id : id,
            },
            dataType: "JSON",
            success: function (response) {
                if(response.status == 200){
                    $.confirm({
                        title: 'Pesan',
                        content: 'Data sales channel berhasil dihapus !',
                        buttons: {
                            Ya: {
                                btnClass: 'btn-success any-other-class',
                                action: function(){
                                    getSalesChannel()
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
@endsection
@section('pagespecificscripts')
   
@stop