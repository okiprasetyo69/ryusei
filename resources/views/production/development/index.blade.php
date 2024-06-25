
@extends('layout.home')
@section('title','Management Produksi')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.css" rel="stylesheet" />
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Management Produksi</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <a href="/production/development">Development</a>
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
                            <div class="col-md-2">
                                <label> <strong><span>Tanggal Terima Design</span></strong> </label>
                            </div>
                            <div class="col-md-2"> 
                                <label> <strong><span>Tanggal Terima Sample</span></strong> </label>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" name="filter_title_name" class="form-control" id="filter_title_name" placeholder="Masukkan kata kunci judul" autofocus/>
                                </div>
                            </div>
                            <div class="col-md-2"> 
                                <div class="form-group"> 
                                    <input type="text" name="filter_design_image_date" class="form-control" id="filter_design_image_date" />
                                </div>
                            </div>
                            <div class="col-md-2"> 
                                <div class="form-group"> 
                                    <input type="text" name="filter_sample_image_date" class="form-control" id="filter_sample_image_date" />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group"> 
                                    <button type="button" class="btn btn-md btn-success" style="border-radius:50px;" id="btn-search"> <i class="bi bi-search"></i> Cari </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="col md-4 mt-4">
                            <button type="button" class="btn btn-sm btn-primary rounded-pill" id="btn-add">
                                <i class="bi bi-plus-circle"></i> Tambah
                            </button>
                        </div>
                        <div class="row mt-2"> 
                            <div class="col-md-12 mt-4">
                                <div class="">
                                    <table class="table table-striped" id="table-development">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Judul</th>
                                                <th scope="col">Tanggal Terima Design</th>
                                                <th scope="col">Tanggal Jadi Sample</th>
                                                <th scope="col">Deskripsi</th>
                                                <th scope="col">Action</th>
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

<div class="modal fade" id="modalDetailDevelopment" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Development</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12"> 
                        <label> <strong><span>Foto Design : </span></strong> </label>
                        <img id="preview_design_image" src="#" alt="Design"  class="rounded float-left" style="height: 200px; width: 300px"/>
                    </div>
                    <div class="col-md-12 mt-2"> 
                        <label> <strong><span>Foto Sample : </span></strong> </label>
                        <img id="preview_sample_image" src="#" alt="Sample"  class="rounded float-left" style="height: 200px; width: 300px"/>
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

<!-- End #main -->

<script type="text/javascript"> 

    var table, title, received_design_date, sample_date, sample_image_url, design_image_url
    
    $(document).ready(function () {

        var now = new Date();
        var month = (now.getMonth() + 1);               
        var day = now.getDate();

        if (month < 10) 
            month = "0" + month;
        if (day < 10) 
            day = "0" + day;
        var today = now.getFullYear() + '-' + month + '-' + day;

        var convertDesignImageDate = day + '-' + month.toLocaleString('default', { month: 'long' }) + '-' + now.getFullYear()
        var convertSampleImageDate = day + '-' + month.toLocaleString('default', { month: 'long' }) + '-' + now.getFullYear()

        $("#filter_design_image_date").datepicker({
            format: 'dd-mm-yyyy',
            defaultDate: new Date(),
        });

        $("#filter_sample_image_date").datepicker({
            format: 'dd-mm-yyyy',
            defaultDate: new Date(),
        });

        $("#btn-add").on("click", function(e){
            e.preventDefault()
            window.location.href = "/production/development/add"
        })  

        getDevelopment()

        $("#btn-search").on("click", function(e){
            e.preventDefault()
            title = $("#filter_title_name").val()
            received_design_date = $("#filter_design_image_date").val().split("-").reverse().join("-")
            sample_date = $("#filter_sample_image_date").val().split("-").reverse().join("-")
            getDevelopment(title, received_design_date, sample_date)
        })
            
    });

    function getDevelopment(title=null, received_design_date=null, sample_date=null){
        if (table != null) {
            table.destroy();
        }

        table =  $("#table-development").DataTable(
           {
                // lengthChange: false,
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
                info: "Menampilkan _START_ dari _END_ dari _TOTAL_ Development",
                aria: {
                        paginate: {
                            previous: "Previous",
                            next: "Next",
                        },
                    },
                },
                ajax:{
                    url :  '/api/development',
                    type: "GET",
                    data: {
                        title: title,
                        received_design_date : received_design_date,
                        sample_date : sample_date,
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
                            $(td).html(rowData.title);
                        },
                    },
                    {
                        targets: 2,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            var received_design_date = rowData.received_design_date
                            date = new Date(received_design_date)
                            month = date.toLocaleString('default', { month: 'long' })
                            year = date.getFullYear()
                            format = date.getDate() + "-"+ month +"-"+ year
                            $(td).html(format);
                        },
                    },
                    {
                        targets: 3,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            var sample_date = rowData.sample_date
                            date = new Date(sample_date)
                            month = date.toLocaleString('default', { month: 'long' })
                            year = date.getFullYear()
                            format = date.getDate() + "-"+ month +"-"+ year
                            $(td).html(format);
                        },
                    },
                    {
                        targets: 4,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            $(td).html(rowData.description);
                        },
                    },
                    {
                        targets: 5,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            var html = "<button type='button' class='btn btn-sm btn-secondary' onclick='detail("+rowData.id+")'> Detail </button> <a href='/production/development/"+rowData.id+"' class='btn btn-sm btn-warning'> Ubah </a> <button type='button' class='btn btn-sm btn-danger' onclick='confirm("+rowData.id+")'> Hapus </button>"
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
            url: "/api/development/detail",
            data: {
                id : id,
            },
            dataType: "JSON",
            success: function (response) {
                var data = response.data
                sample_image_url = data.sample_image_url
                design_image_url = data.design_image_url
                $("#modalDetailDevelopment").modal('toggle')
                $("#preview_design_image").attr("src", design_image_url)
                $("#preview_sample_image").attr("src", sample_image_url)
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
            type: "delete",
            url: "/api/development",
            data: {
                id : id,
            },
            dataType: "JSON",
            success: function (response) {
                if(response.status == 200){
                    $.confirm({
                        title: 'Pesan',
                        content: 'Data kategori berhasil dihapus !',
                        buttons: {
                            Ya: {
                                btnClass: 'btn-success any-other-class',
                                action: function(){
                                    getDevelopment()
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.js"></script>

@endsection
@section('pagespecificscripts')
   
@stop