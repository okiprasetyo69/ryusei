
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
                <li class="breadcrumb-item">
                    <a href="#">Management Produksi</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="/production/development">Development</a>
                </li>
                <li class="breadcrumb-item active">
                    <a href="/production/development/{{$development->id}}">Detail</a>
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
                            <div class="col-md-12">
                                <!-- Floating Labels Form -->
                                <form action="#" id="frm-add-development" class="row g-3">
                                    @csrf
                                    <input type="hidden" name="id" id="id" class="form-control" />
                                    <div class="row mt-4">
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="title" id="title"/>
                                                <label for="">Judul</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="received_design_date" id="received_design_date"/>
                                                <label for="">Tanggal Terima Design</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="sample_date" id="sample_date"/>
                                                <label for="">Tanggal Jadi Sample</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <textarea class="form-control" name="description" id="description"></textarea>
                                                <label for="">Keterangan</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-md-4">
                                            <img id="preview_design_image" src="#" alt="Design"  class="rounded float-left" style="height: 200px; width: 300px"/>
                                            <div class="col-md-12">
                                                <label for="">Upload Foto Design</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="file" id="design_image">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <img id="preview_sample_image" src="#" alt="Sample"  class="rounded float-left" style="height: 200px; width: 300px"/>
                                            <div class="col-md-12">
                                                <label for="">Upload Foto Sample</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="file" id="sample_image">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center mt-4">
                                        <button type="submit" class="btn btn-success btn-save">Simpan</button>
                                        <button type="reset" class="btn btn-secondary btn-reset">Reset</button>
                                    </div>
                                </form>
                                <!-- End floating Labels Form -->
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
   
    var design_image, sample_image, received_design_date, sample_date, description
    var development = '<?php echo $development ;?>'
    var now = new Date();
    var month = (now.getMonth() + 1);               
    var day = now.getDate();
    if (month < 10) 
        month = "0" + month;
    if (day < 10) 
        day = "0" + day;
    var today = now.getFullYear() + '-' + month + '-' + day;

    $(document).ready(function () {

        // convert string to json
        development = JSON.parse(development)

        // assign values
        if(development.received_design_date != null){
            received_design_date = development.received_design_date.split("-").reverse().join("-")
        } else {
            received_design_date = null
        }
        
        if(development.sample_date != null){
            sample_date = development.sample_date.split("-").reverse().join("-")
        } else {
            sample_date = null
        }
       
        description = development.description
        $("#id").val(development.id)
        $("#title").val(development.title)
        $("#received_design_date").val(received_design_date)
        $("#sample_date").val(sample_date)
        $("#description").val(description)
        $("#preview_design_image").attr("src", development.design_image_url)
        $("#preview_sample_image").attr("src", development.sample_image_url)

        var convertReceivedDesignDate = day + '-' + month.toLocaleString('default', { month: 'long' }) + '-' + now.getFullYear()
        var convertSampleDate = day + '-' + month.toLocaleString('default', { month: 'long' }) + '-' + now.getFullYear()

        $("#received_design_date").datepicker({
            format: 'dd-mm-yyyy',
            defaultDate: new Date(),
        });

        $("#sample_date").datepicker({
            format: 'dd-mm-yyyy',
            defaultDate: new Date(),
        });

        // preview design image
        $("#design_image").change(function(){
            readURL(this, null);
        });

        // preview sample image
        $("#sample_image").change(function(){
            readURL(null, this);
        });

        $("#frm-add-development").on("submit", function(e){
            e.preventDefault()
            
            var formData = new FormData()

            // Assign image value
            if($('#design_image').val() == ""){
                design_image = null
            } else{
                design_image = $('#design_image')[0].files[0]
            }

            if($('#sample_image').val() == ""){
                sample_image = null
            } else{
                sample_image = $('#sample_image')[0].files[0]
            }

            received_design_date = $("#received_design_date").val().split("-").reverse().join("-")
            sample_date = $("#sample_date").val().split("-").reverse().join("-")

            formData.append('id', $('#id').val())
            formData.append('title', $('#title').val())
            formData.append('received_design_date', received_design_date)
            formData.append('sample_date', sample_date)
            formData.append('design_image', design_image)
            formData.append('sample_image', sample_image)
            formData.append('description',  $('#description').val())

            $.ajax({
                type: "POST",
                url: "/api/development/update",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function (response) {
                    if(response.status == 200){
                        $.confirm({
                            title: 'Pesan ',
                            content: 'Data Development berhasil diperbarui !',
                            buttons: {
                                Ya: {
                                    btnClass: 'btn-success any-other-class',
                                    action: function(){
                                        window.location.href = '/production/development'
                                    }
                                },
                            }
                        });
                    }
                }
            });
        })
    });

    function readURL(design_image = null, sample_image = null) {
        if(design_image != null){
            if (design_image.files && design_image.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#preview_design_image').attr('src', e.target.result);
                }
                reader.readAsDataURL(design_image.files[0]);
            }
        }
       
        if(sample_image != null){
            if(sample_image.files && sample_image.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#preview_sample_image').attr('src', e.target.result);
                }
                reader.readAsDataURL(sample_image.files[0]);
            }
        }
    }

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.4/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.js"></script>

@endsection
@section('pagespecificscripts')
   
@stop