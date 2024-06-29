
@extends('layout.home')
@section('title','Management Produksi')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
                                <label> <strong><span>Tanggal Design</span></strong> </label>
                            </div>
                            <div class="col-md-2"> 
                                <label> <strong><span>Tanggal Sample</span></strong> </label>
                            </div>
                            <div class="col-md-2"> 
                                <label> <strong><span>Tanggal Film</span></strong> </label>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" name="filter_title_name" class="form-control" id="filter_title_name" placeholder="Masukkan kata kunci artikel" autofocus/>
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
                                    <input type="text" name="filter_film_date" class="form-control" id="filter_film_date" />
                                </div>
                            </div>
                           
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-3"> 
                                <label> <strong><span> Vendor </span></strong> </label>
                            </div>
                            <div class="col-md-3">
                                <label> <strong><span> Kategori </span></strong> </label>
                            </div>
                            <div class="col-md-3"> 
                                <label> <strong><span> Status </span></strong> </label>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-3"> 
                               <select name="filter_vendor" id="filter_vendor" class="form-control filter_vendor" width="100%;"> 

                               </select>
                            </div>
                            <div class="col-md-3">
                                <select name="filter_category" id="filter_category" class="form-control filter_category"  width="100%;"> 

                                </select>
                            </div>
                            <div class="col-md-2"> 
                                <select name="filter_status" id="filter_status" class="form-control"> 
                                    <option value=""> - Pilih Status - </option> 
                                    <option value="1"> PO </option> 
                                    <option value="2"> Film </option> 
                                    <option value="3"> Sampling </option> 
                                    <option value="4"> Produksi </option> 
                                </select>
                            </div>
                            <div class="col-md-3">
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
                                                <th scope="col">Artikel</th>
                                                <th scope="col">Tgl Terima Design</th>
                                                <th scope="col">Tgl Sample</th>
                                                <th scope="col">Tgl Film </th>
                                                <th scope="col">Kategori</th>
                                                <th scope="col">Qty</th>
                                                <th scope="col">Vendor</th>
                                                <th scope="col">Status</th>
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
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Development</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6"> 
                            <label> <strong><span>Foto Design : </span></strong> </label>
                            <img id="preview_design_image" src="#" alt="Design"  class="rounded float-left" style="height: 200px; width: 300px"/>
                        </div>
                        <div class="col-md-6"> 
                            <label> <strong><span>Foto Sample : </span></strong> </label>
                            <img id="preview_sample_image" src="#" alt="Sample"  class="rounded float-left" style="height: 200px; width: 300px"/>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12"> 
                            <table class="table table-striped table-hover mt-4" id="table-detail-qty-size"> 
                                <thead> 
                                    <tr class="text-center"> 
                                        <td colspan="5" > <strong> Qty </strong> </td>
                                    </tr>
                                    <tr id="sizeName"> 
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                     <tr id="qtySize"> 

                                     </tr>       
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12">
                            <label> <strong>  Total : <span id="totalQty">  </span></strong> </label>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12"> 
                            <label> <strong><span>Keterangan :</span></strong> </label>
                           <textarea name="description" id="description" class="form-control"></textarea>
                        </div>
                    </div>
                  
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- End #main -->

<script type="text/javascript"> 

    var table, title, received_design_date, sample_date, film_date, sample_image_url, design_image_url, vendor_id, category_id, status
    
    $(document).ready(function () {

        $(".filter_category").select2()
        $(".filter_vendor").select2()

        $("#filter_design_image_date").datepicker({
            format: 'dd-mm-yyyy',
            defaultDate: new Date(),
        });

        $("#filter_sample_image_date").datepicker({
            format: 'dd-mm-yyyy',
            defaultDate: new Date(),
        });

        $("#filter_film_date").datepicker({
            format: 'dd-mm-yyyy',
            defaultDate: new Date(),
        });

        $("#btn-add").on("click", function(e){
            e.preventDefault()
            window.location.href = "/production/development/add"
        })  

        getVendor()
        getDevelopment()
        getCategory()

        $("#btn-search").on("click", function(e){
            e.preventDefault()
            title = $("#filter_title_name").val()
            received_design_date = $("#filter_design_image_date").val().split("-").reverse().join("-")
            sample_date = $("#filter_sample_image_date").val().split("-").reverse().join("-")
            film_date = $("#filter_film_date").val().split("-").reverse().join("-")
            vendor_id = $("#filter_vendor option:selected").val()
            category_id = $("#filter_category option:selected").val()
            status = $("#filter_status option:selected").val()
            getDevelopment(title, received_design_date, sample_date, film_date, vendor_id, category_id, status)
        })
            
    });

    function getDevelopment(title=null, received_design_date=null, sample_date=null, film_date=null, vendor_id=null, category_id=null, status=null){
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
                        film_date : film_date,
                        vendor_id : vendor_id,
                        category_id : category_id,
                        status : status
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
                            $(td).html(rowData.article);
                            console.log(rowData)
                        },
                    },
                    {
                        targets: 2,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            var received_design_date = ""
                            if(rowData.received_design_date != null){
                                received_design_date = rowData.received_design_date.split("-").reverse().join("-")
                            }
                            else {
                                received_design_date = "-"
                            }
                            
                            $(td).html(received_design_date);
                        },
                    },
                    {
                        targets: 3,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            var sample_date = ""
                            if(rowData.sample_date != null){
                                sample_date = rowData.sample_date.split("-").reverse().join("-")
                            } else {
                                sample_date = "-"
                            }
                            $(td).html(sample_date);
                        },
                    },
                    {
                        targets: 4,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            var film_date = ""
                            if(rowData.film_date != null){
                                film_date = rowData.film_date.split("-").reverse().join("-")
                            } else {
                                film_date = "-"
                            }
                            $(td).html(film_date);
                        },
                    },
                    {
                        targets: 5,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            var category = ""
                            if(rowData.category_id != null){
                                category = rowData.category.name
                            }else {
                                category = "-"
                            }
                            $(td).html(category);
                        },
                    },
                    {
                        targets: 6,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            var totalQty = rowData.qty
                            $(td).html(totalQty);
                        },
                    },
                    {
                        targets: 7,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            var vendor = ""
                            if(rowData.vendor_id != null){
                                vendor = rowData.vendor.name
                            }else {
                                vendor = "-"
                            }
                            $(td).html(vendor);
                        },
                    },
                    {
                        targets: 8,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            var status = ""
                            if(rowData.status == 1){
                                status = "PO"
                            }
                            if(rowData.status == 2){
                                status = "FILM"
                            }
                            if(rowData.status == 3){
                                status = "SAMPLING"
                            }
                            if(rowData.status == 4){
                                status = "PRODUKSI"
                            }
                            $(td).html(status);
                        },
                    },
                    {
                        targets: 9,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                           
                            var html = ` <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                            <li><a class="dropdown-item" href="#" onclick='detail(`+rowData.id+`)'>Detail</a></li>
                                            <li><a class="dropdown-item" href="/production/development/`+rowData.id+`">Ubah</a></li>
                                            <li><a class="dropdown-item" href="#" onclick='confirm(`+rowData.id+`)'>Hapus</a></li>
                                        </ul>`
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
                var qty_per_size = JSON.parse(data.qty_per_size)
                var header_table = ""
                var row_table = ""
                sample_image_url = data.sample_image_url
                design_image_url = data.design_image_url
                $("#sizeName").html("")
                $("#totalQty").html("")
                $("#qtySize").html("")
                $("#description").html("")
                $.each(qty_per_size, function (i, val) { 
                    header_table += "<th>"+ val.size +"</th>"
                    row_table += "<td>"+val.qty+"</td>"
                });

                $("#sizeName").append(header_table)
                $("#qtySize").append(row_table)
                $("#totalQty").html(data.qty)
                $("#description").val(data.description).prop("readonly", true)
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

    function getVendor(){
        let vendor = $('.filter_vendor').val()
        $(".filter_vendor").select2({
            ajax: {
                url: "/api/vendors/list/select2",
                dataType: "JSON",
                type: "GET",
                data: function (params) {
                    //console.log(params)
                    return {
                        searchTerm: params.term,
                        id: vendor,
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
        });
    }

    function getCategory(){
        let category = $('.filter_category').val()
        $(".filter_category").select2({
            ajax: {
                url: "/api/category/list/select2",
                dataType: "JSON",
                type: "GET",
                data: function (params) {
                    //console.log(params)
                    return {
                        searchTerm: params.term,
                        id: category,
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
        });
    }

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection
@section('pagespecificscripts')
   
@stop