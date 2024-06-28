
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
                                                <input type="text" class="form-control" name="article" id="article" placeholder="Masukkan Artikel" autofocus/>
                                                <label for="">Nama Artikel</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-floating mb-3">
                                                <select class="form-control category" id="category" style="width:100%;">
                                                    <option > - Pilih Kategori -</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-floating mb-3">
                                                <select class="form-control vendor" id="vendor">
                                                    <option > - Pilih Vendor -</option>
                                                </select>
                                                
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2 text-center"> 
                                        <div class="col-md-12">
                                            <label> <strong class="" > Qty </strong> </label>
                                        </div>
                                    </div>

                                    <div class="row mt-2"> 
                                        <div class="col-md-2">
                                            <div class="form-floating">
                                                <input type="number" min="0" class="form-control" name="qty_size_s" id="qty_size_s"/>
                                                <label for="">Size S</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-floating">
                                                <input type="number" min="0" class="form-control" name="qty_size_m" id="qty_size_m"/>
                                                <label for="">Size M</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-floating">
                                                <input type="number" min="0" class="form-control" name="qty_size_l" id="qty_size_l"/>
                                                <label for="">Size L</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-floating">
                                                <input type="number" min="0" class="form-control" name="qty_size_xl" id="qty_size_xl"/>
                                                <label for="">Size XL</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-floating">
                                                <input type="number" min="0" class="form-control" name="qty_size_3xl" id="qty_size_3xl"/>
                                                <label for="">Size 3XL</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-floating">
                                                <input type="number" min="0" class="form-control" name="total_qty" id="total_qty" readonly/>
                                                <label for="">Total</label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row mt-4"> 
                                        <div class="">
                                            <label> <strong class="" > Status : </strong> </label>
                                        </div>
                                        <div class="col-md-2">
                                            <input class="form-check-input" type="radio" name="status" id="status_po" value="1">
                                            <label class="form-check-label" for="">
                                                PO
                                            </label>
                                        </div>
                                        <div class="col-md-2">
                                            <input class="form-check-input" type="radio" name="status" id="status_film" value="2">
                                            <label class="form-check-label" for="">
                                                Film
                                            </label>
                                        </div>
                                        <div class="col-md-2">
                                            <input class="form-check-input" type="radio" name="status" id="status_sampling" value="3">
                                            <label class="form-check-label" for="">
                                                Sampling
                                            </label>
                                        </div>
                                        <div class="col-md-2">
                                            <input class="form-check-input" type="radio" name="status" id="status_production" value="4">
                                            <label class="form-check-label" for="">
                                                Produksi
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row mt-4"> 
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
                                                <input type="text" class="form-control" name="film_date" id="film_date"/>
                                                <label for="">Tanggal Film</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-md-3">
                                            <img id="preview_design_image" src="#" alt="Design"  class="rounded float-left" style="height: 200px; width: 300px"/>
                                            <div class="col-md-12">
                                                <label for="">Upload Foto Design</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="file" id="design_image">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
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
   
   var design_image, sample_image, received_design_date, sample_date, film_date, qtysizeS, qtysizeM, qtysizeL, qtysizeXL, qtysize3XL, status
   var totalQty = 0

    $(document).ready(function () {

        $("#received_design_date").datepicker({
            format: 'dd-mm-yyyy',
            defaultDate: new Date(),
        });

        $("#sample_date").datepicker({
            format: 'dd-mm-yyyy',
            defaultDate: new Date(),
        });

        $("#film_date").datepicker({
            format: 'dd-mm-yyyy',
            defaultDate: new Date(),
        });

        $(".category").select2()
        $(".vendor").select2()

        getCategory()
        getVendor()

        qtysizeS = $("#qty_size_s").val() ? $("#qty_size_s").val() : 0
        qtysizeM = $("#qty_size_m").val() ? $("#qty_size_m").val() : 0
        qtysizeL = $("#qty_size_l").val() ? $("#qty_size_l").val() : 0
        qtysizeXL = $("#qty_size_xl").val() ? $("#qty_size_xl").val() : 0
        qtysize3XL = $("#qty_size_3xl").val() ? $("#qty_size_3xl").val() : 0

        // preview design image
        $("#design_image").change(function(){
            readURL(this, null);
        });

        // preview sample image
        $("#sample_image").change(function(){
            readURL(null, this);
        });

        // on change qty sizes
        $("#qty_size_s").on("change", function(e){
            e.preventDefault()
            qtysizeS = this.value
            totalQty =  parseInt(qtysizeS) + parseInt(qtysizeM) + parseInt(qtysizeL) + parseInt(qtysizeXL) + parseInt(qtysize3XL)
            $("#total_qty").val(totalQty)
        })

        $("#qty_size_m").on("change", function(e){
            e.preventDefault()
            qtysizeM = this.value
            totalQty =  parseInt(qtysizeS) + parseInt(qtysizeM) + parseInt(qtysizeL) + parseInt(qtysizeXL) + parseInt(qtysize3XL)
            $("#total_qty").val(totalQty)
        })

        $("#qty_size_l").on("change", function(e){
            e.preventDefault()
            qtysizeL = this.value
            totalQty =  parseInt(qtysizeS) + parseInt(qtysizeM) + parseInt(qtysizeL) + parseInt(qtysizeXL) + parseInt(qtysize3XL)
            $("#total_qty").val(totalQty)
        })

        $("#qty_size_xl").on("change", function(e){
            e.preventDefault()
            qtysizeXL = this.value
            totalQty =  parseInt(qtysizeS) + parseInt(qtysizeM) + parseInt(qtysizeL) + parseInt(qtysizeXL) + parseInt(qtysize3XL)
            $("#total_qty").val(totalQty)
        })

        $("#qty_size_3xl").on("change", function(e){
            e.preventDefault()
            qtysize3XL = this.value
            totalQty =  parseInt(qtysizeS) + parseInt(qtysizeM) + parseInt(qtysizeL) + parseInt(qtysizeXL) + parseInt(qtysize3XL)
            $("#total_qty").val(totalQty)
        })

        // Save
        $("#frm-add-development").on("submit", function(e){
            e.preventDefault()
            var formData = new FormData()
            var qtyDevelopment = []

            qtysizeS = $("#qty_size_s").val() 
            qtysizeM = $("#qty_size_m").val() 
            qtysizeL = $("#qty_size_l").val() 
            qtysizeXL = $("#qty_size_xl").val() 
            qtysize3XL = $("#qty_size_3xl").val()
            totalQty = $("#total_qty").val()

            if(qtysizeS != ""){
                qtyDevelopment.push({'size':'S', 'qty':qtysizeS})
            }

            if(qtysizeM != ""){
                qtyDevelopment.push({'size':'M', 'qty':qtysizeM})
            }

            if(qtysizeL != ""){
                qtyDevelopment.push({'size':'L', 'qty':qtysizeL})
            }

            if(qtysizeXL != ""){
                qtyDevelopment.push({'size':'XL', 'qty':qtysizeXL})
            }

            if(qtysize3XL != ""){
                qtyDevelopment.push({'size':'3XL', 'qty':qtysize3XL})
            }

            status = $('input[name="status"]:checked').val();
        
            var jsonQtyPerSize = JSON.stringify(qtyDevelopment);

            // Assign image value
            if($('#design_image').val() == ""){
                design_image = null
            } else {
                design_image = $('#design_image')[0].files[0]
            }

            if($('#sample_image').val() == ""){
                sample_image = null
            } else {
                sample_image = $('#sample_image')[0].files[0]
            }

            received_design_date = $("#received_design_date").val().split("-").reverse().join("-")
            sample_date = $("#sample_date").val().split("-").reverse().join("-")
            film_date = $("#film_date").val().split("-").reverse().join("-")

            formData.append('article', $('#article').val())
            formData.append('category_id', $('#category option:selected').val())
            formData.append('vendor_id', $('#vendor option:selected').val())
            formData.append('qty_per_size', jsonQtyPerSize)
            formData.append('qty', totalQty)
            formData.append('status', status)
            formData.append('received_design_date', received_design_date)
            formData.append('sample_date', sample_date)
            formData.append('film_date', film_date)
            formData.append('design_image', design_image)
            formData.append('sample_image', sample_image)
           
            $.ajax({
                type: "POST",
                url: "/api/development",
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
                                somethingElse: {
                                    text: 'Tambah data lagi',
                                    btnClass: 'btn-blue',
                                    keys: ['enter', 'shift'],
                                    action: function(){
                                        window.location.href = '/production/development/add'
                                    }
                                },
                                cancel: function () {
                                    window.location.href = '/production/development'
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

    function getCategory(){
        let category = $('.category').val()
        $(".category").select2({
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

    function getVendor(){
        let vendor = $('.vendor').val()
        $(".vendor").select2({
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

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection
@section('pagespecificscripts')
   
@stop