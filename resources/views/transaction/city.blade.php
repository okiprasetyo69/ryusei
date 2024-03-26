
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
                    <a href="#">Kontak Pelanggan</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="/sales-channel">Sales Channel</a>
                </li>
                <li class="breadcrumb-item active">
                    <a href="/city-list">List Kota</a>
                </li>
                <li class="breadcrumb-item active">
                    <a href="/city-list/import">Tambah Masal List Kota</a>
                </li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mt-4"> 
                            <div class="col-md-3">
                                <label> <strong><span> Pilih Provinsi </span></strong> </label>
                            </div>
                            <div class="col-md-3">
                                <label> <strong><span> Pilih Kota </span></strong> </label>
                            </div>
                            <div class="col-md-3">
                                <label> <strong><span> Pilih Kecamatan </span></strong> </label>
                            </div>
                            <div class="col-md-3">
                                <label> <strong><span> Pilih Kelurahan </span></strong> </label>
                            </div>
                        </div>
                        <div class="row mt-2"> 
                            <div class="col-md-3"> 
                                <select name="filter_province" id="filter_province" class="form-control"> 
                                    <option value=""> - Pilih Provinsi - </option>
                                </select>
                            </div>
                            <div class="col-md-3"> 
                                <select name="filter_city" id="filter_city" class="form-control"> 
                                    <option value=""> - Pilih Kota - </option>
                                </select>
                            </div>
                            <div class="col-md-3"> 
                                <select name="filter_district" id="filter_district" class="form-control"> 
                                  
                                </select>
                            </div>
                            <div class="col-md-3"> 
                                <select name="filter_village" id="filter_village" class="form-control"> 
                                  
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" name="filter_name" class="form-control" id="filter_name" placeholder="Masukkan kode pos" autofocus/>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">  
                            <div class="col-md-4"> 
                                <button type="button" class="btn btn-md btn-success" style="border-radius:50px;" id="btn-search"><i class="bi bi-search"></i> Cari </button>
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
                                <button type="button" class="btn btn-primary rounded-pill btn-add" data-bs-toggle="modal" data-bs-target="#cityListModal">
                                    <i class="bi bi-plus-circle"></i> Tambah
                                </button>
                            </div>
                            <div class="col-md-12">
                                <div class="">
                                    <table class="table table-striped" id="table-city-list">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Kode Pos</th>
                                                <th scope="col">Kelurahan</th>
                                                <th scope="col">Kecamatan</th>
                                                <th scope="col">Kota</th>
                                                <th scope="col">Provinsi</th>
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
<div class="modal fade" id="cityListModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title .modal-title" id="exampleModalLongTitle">Tambah Kode Pos</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="#" id="frm-city-list">
        @csrf
      <div class="modal-body">
        <input type="hidden" name="id" id="id" class="form-control" />
        <div class="row">
          <div class="col-md-12 mt-2">
            <label> Kode POS</label>
            <input type="text" class="form-control" name="postal_code" id="postal_code" />
          </div>
          <div class="col-md-12 mt-2">
            <label> Kelurahan </label>
            <input type="text" class="form-control" name="village" id="village" />
          </div>
          <div class="col-md-12 mt-2">
            <label> Kecamatan </label>
            <input type="text" class="form-control" name="district" id="district" />
          </div>
          <div class="col-md-12 mt-2">
            <label> Kota </label>
            <input type="text" class="form-control" name="city" id="city" />
          </div>
          <div class="col-md-12 mt-2">
            <label> Provinsi </label>
            <input type="text" class="form-control" name="province" id="province" />
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
    var postal_code
    var table
    var province, district, village
    $(document).ready(function () {
        
        loadPostalCode()
        getProvince()

        // Open Modal
        $(".btn-add").click(function(e){
            e.preventDefault()
            $("#cityListModal").modal("show")
            $(".modal-title").text("Tambah Kode Pos")
            $("#btn-save").text("Simpan")
            $("#id").val("")
            $("#postal_code").val("")
            $("#village").val("")
            $("#district").val("")
            $("#city").val("")
            $("#province").val("")
        })

        // Close Modal
        $("#btn-close").click(function(e){
            e.preventDefault()
            $("#cityListModal").modal("hide")
        })

        // filter category
        $("#filter_name").on("keyup", function(e){
            e.preventDefault()
            postal_code = $("#filter_name").val()
            loadPostalCode(postal_code)
        })

        $("#filter_province").on("change", function(e){
            e.preventDefault()
            province = this.value
            getCity(province)
        })

        $("#filter_city").on("change", function(e){
            e.preventDefault()
            district = this.value
            getDistrict(province, district)
        })

        $("#filter_district").on("change", function(e){
            e.preventDefault()
            village = this.value
            getVillage(province, district, village)
        })

        // Store data
        $("#frm-city-list").on("submit", function(e){
            e.preventDefault()

            if($("#postal_code").val() == ""){
                $.alert({
                    title: 'Pesan!',
                    content: 'Kode pos channel tidak boleh kosong !',
                });
                return 
            }

            if($("#village").val() == ""){
                $.alert({
                    title: 'Pesan!',
                    content: 'Kelurahan tidak boleh kosong !',
                });
                return 
            }

            if($("#district").val() == ""){
                $.alert({
                    title: 'Pesan!',
                    content: 'Kecamatan tidak boleh kosong !',
                });
                return 
            }

            if($("#city").val() == ""){
                $.alert({
                    title: 'Pesan!',
                    content: 'Kota tidak boleh kosong !',
                });
                return 
            }

            if($("#province").val() == ""){
                $.alert({
                    title: 'Pesan!',
                    content: 'Provinsi tidak boleh kosong !',
                });
                return 
            }

            $.ajax({
                type: "POST",
                url: "/api/locality-list/create",
                data: {
                    id : $("#id").val(),
                    postal_code : $("#postal_code").val(),
                    village : $("#village").val(),
                    district : $("#district").val(),
                    city : $("#city").val(),
                    province : $("#province").val(),
                },
                dataType: "JSON",
                success: function (response) {
                    if(response.status == 200){
                        $("#cityListModal").modal("hide")
                        $.confirm({
                            title: 'Pesan ',
                            content: 'Data kota berhasil diperbarui !',
                            buttons: {
                                Ya: {
                                    btnClass: 'btn-success any-other-class',
                                    action: function(){
                                        loadPostalCode()
                                        $("#cityListModal").modal("hide")
                                    }
                                },
                            }
                        });
                    }
                }
            });
        })

        $("#btn-search").on("click", function(e){
            e.preventDefault()
            province = $("#filter_province option:selected").val()
            city = $("#filter_city option:selected").val()
            district = $("#filter_district option:selected").val()
            village = $("#filter_village option:selected").val()
            console.log(province, city, district, village)
            loadPostalCode(null, province, city, district, village)
        })
    });

    function loadPostalCode(postal_code = null, province=null, city=null, district=null, village=null){
        if (table != null) {
            table.destroy();
        }
        table = $("#table-city-list").DataTable({
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
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ List Kode Pos",
                aria: {
                        paginate: {
                            previous: "Previous",
                            next: "Next",
                        },
                    },
                },
                ajax:{
                    url :  '/api/locality-list',
                    type: "GET",
                    data: {
                        postal_code: postal_code,
                        province : province,
                        city: city,
                        district : district,
                        village : village
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
                            $(td).html(rowData.postal_code);
                        },
                    },
                    {
                        targets: 2,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            $(td).html(rowData.village);
                        },
                    },
                    {
                        targets: 3,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            $(td).html(rowData.district);
                        },
                    },
                    {
                        targets: 4,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            $(td).html(rowData.city);
                        },
                    },
                    {
                        targets: 5,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            $(td).html(rowData.province);
                        },
                    },
                    {
                        targets: 6,
                        searchable: false,
                        orderable: false,
                        createdCell: function (td, cellData, rowData, row, col) {
                            var html = "<button type='button' class='btn btn-sm btn-warning' onclick='detail("+rowData.id+")' > Ubah </button> <button type='button' class='btn btn-sm btn-danger' onclick='confirm("+rowData.id+")'> Hapus </button>"
                            $(td).html(html);
                        },
                    },
                ],
        })
    }

    function detail(id){
        $.ajax({
            type: "POST",
            url: "/api/locality-list/detail",
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
                $("#cityListModal").modal("show")
                $(".modal-title").text("Ubah Kode Pos")
                $("#btn-save").text("Ubah")
                $("#id").val(data.id)
                $("#postal_code").val(data.postal_code)
                $("#village").val(data.village)
                $("#district").val(data.district)
                $("#city").val(data.city)
                $("#province").val(data.province)
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
            url: "/api/locality-list/delete",
            data: {
                id : id,
            },
            dataType: "JSON",
            success: function (response) {
                if(response.status == 200){
                    $.confirm({
                        title: 'Pesan',
                        content: 'Data list kode pos berhasil dihapus !',
                        buttons: {
                            Ya: {
                                btnClass: 'btn-success any-other-class',
                                action: function(){
                                    loadPostalCode()
                                }
                            },
                        }
                    });
                }
            }
        });
    }

    function getProvince(){
        $.ajax({
            type: "GET",
            url: "/api/locality-list/province",
            data: "data",
            dataType: "JSON",
            success: function (response) {
                var data = response.data
                $("#filter_province").html()
                var option = ""
                var province_name = ""
                $.each(data, function (i, val) {
                    option += "<option value='"+val.province_name+"'> "+val.province+" </option>"
                });
                $("#filter_province").append(option)
            }
        });
    }

    function getCity(province=null){
        $.ajax({
            type: "GET",
            url: "/api/locality-list/city",
            data: {
                province : province
            },
            dataType: "JSON",
            success: function (response) {
                var data = response.data
                $("#filter_city").html("")
                var option = ""
                $.each(data, function (i, val) {
                    option += "<option value='"+val.city_name+"'> "+val.city+" </option>"
                });
                $("#filter_city").append(option)
            }
        });
    }

    function getDistrict(province=null, city=null){
        $.ajax({
            type: "GET",
            url: "/api/locality-list/district",
            data: {
                province : province,
                city: city,
            },
            dataType: "JSON",
            success: function (response) {
                var data = response.data
                $("#filter_district").html("")
                var option = ""
                $.each(data, function (i, val) {
                    option += "<option value='"+val.district_name+"'> "+val.district+" </option>"
                });
                $("#filter_district").append(option)
            }
        });
    }

    function getVillage(province=null, city=null, district=null){
        $.ajax({
            type: "GET",
            url: "/api/locality-list/village",
            data: {
                province : province,
                city: city,
                district: district
            },
            dataType: "JSON",
            success: function (response) {
                var data = response.data
                $("#filter_village").html("")
                var option = ""
                $.each(data, function (i, val) {
                    option += "<option value='"+val.village+"'> "+val.village+" </option>"
                });
                $("#filter_village").append(option)
            }
        });
    }
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection
@section('pagespecificscripts')
   
@stop