
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
                    <a href="/production/development/add">Tambah</a>
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
                                    <input type="hidden" name="code" id="code" class="form-control" />
                                    <div class="row mt-4">
                                        <div class="col-md-4">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="received_design_date" id="received_design_date"/>
                                                <label for="">Tanggal Terima Design</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="sample_date" id="sample_date"/>
                                                <label for="">Tanggal Jadi Sample</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
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
   
   var design_image, sample_image, received_design_date, sample_date

    $(document).ready(function () {
        var now = new Date();
        var month = (now.getMonth() + 1);               
        var day = now.getDate();

        if (month < 10) 
            month = "0" + month;
        if (day < 10) 
            day = "0" + day;
        var today = now.getFullYear() + '-' + month + '-' + day;

        var convertOrderDate = day + '-' + month.toLocaleString('default', { month: 'long' }) + '-' + now.getFullYear()
        var convertProcessOrderDate = day + '-' + month.toLocaleString('default', { month: 'long' }) + '-' + now.getFullYear()

        $("#received_design_date").datepicker({
            format: 'dd-mm-yyyy',
            defaultDate: new Date(),
        });
        $('#received_design_date').val(convertOrderDate);

        $("#sample_date").datepicker({
            format: 'dd-mm-yyyy',
            defaultDate: new Date(),
        });
        $('#sample_date').val(convertOrderDate);

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
             // Validation form required
            if($("#received_design_date").val() == ""){
                $.alert({
                    title: 'Pesan !',
                    content: 'Tanggal terima design tidak boleh kosong !',
                });
                return 
            }

            if($("#sample_date").val() == ""){
                $.alert({
                    title: 'Pesan !',
                    content: 'Tanggal jadi sample tidak boleh kosong !',
                });
                return 
            }

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

            formData.append('received_design_date', received_design_date)
            formData.append('sample_date', sample_date)
            formData.append('design_image', design_image)
            formData.append('sample_image', sample_image)
            formData.append('description',  $('#description').val())
            
            $.ajax({
                type: "POST",
                url: "/api/development/create",
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