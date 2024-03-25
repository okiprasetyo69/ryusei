
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
                <li class="breadcrumb-item">
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
                        <div class="row mt-2"> 
                            <div class="col-md-4">
                                <form action="#" enctype="multipart/form-data" id="frm-import-postal-code">
                                    <div class="form-group">
                                        <label for="">File (.xls, .xlsx)</label>
                                        <input type="file" class="form-control mt-2" name="file_import_postal_code" id="file_import_postal_code">
                                    </div>
                                    <div class="form-group mt-2">
                                        <button type="submit" class="btn btn-primary btn-sm">Import</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<!-- End #main -->

<script type="text/javascript"> 
    var name
    var table

    $(document).ready(function () {

        // Store data
        $("#frm-import-postal-code").on("submit", function(e){
            e.preventDefault()
            var formData = new FormData($(this)[0]);

            $.ajax({
                type: "POST",
                url: "/api/locality-list/import-postalcode",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function (response) {
                    if(response.status == 200){
                        $.confirm({
                            title: 'Pesan ',
                            content: 'Data kota berhasil diperbarui !',
                            buttons: {
                                Ya: {
                                    btnClass: 'btn-success any-other-class',
                                    action: function(){
                                        window.location.href = '/city-list'
                                    }
                                },
                            }
                        });
                    }
                }
            });
        })

    });


   


</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection
@section('pagespecificscripts')
   
@stop