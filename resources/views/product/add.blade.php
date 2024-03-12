
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
                <li class="breadcrumb-item active">
                    <a href="/product">Product</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="/product/add">Tambah</a>
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
                                <form action="#" id="frm-add-product" class="row g-3">
                                    @csrf
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="code" id="code" placeholder="Kode SKU">
                                            <label for="">Kode SKU</label>
                                        </div>
                                    </div>                                
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="article" id="article" placeholder="Nama Artikel">
                                            <label for="">Nama Artikel</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="sku" id="sku" placeholder="Nama SKU">
                                            <label for="floatingPassword">Nama SKU</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <select class="form-select" name="size" id="size">
                                                <option value="" >- Pilih Size - </option>
                                                <option value="1">S</option>
                                                <option value="2">M</option>
                                                <option value="3">L</option>
                                                <option value="4">XL</option>
                                                <option value="5">XXL</option>
                                                <option value="6">XXXL</option>
                                            </select>
                                            <label for="">Size</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-floating">
                                            <input type="number" min="0" class="form-control" name="price" id="price" placeholder="Harga">
                                            <label for="floatingTextarea">Harga</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-12">
                                            <div class="form-floating">
                                                <select name="category_id" id="category_id" class="form-control" placeholder="Kategori"> 
                                                    <option> - Pilih Kategori - </option>
                                                </select>
                                                <label for="floatingCity">Kategori</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <fieldset class="row mb-3">
                                                <legend class="col-form-label">Status</legend>
                                                <div class="col-sm-10">
                                                    <div class="form-check">
                                                        <input class="form-check-input status" type="radio" name="status" id="status" value="0">
                                                        <label class="form-check-label" for="">
                                                            Not Ready
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input status" type="radio" name="status" id="status" value="1">
                                                        <label class="form-check-label" for="">
                                                            Ready
                                                        </label>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="col-md-6"> 
                                        <div class="col-md-12">
                                            <label for="inputNumber" class="col-sm-2 col-form-label">Upload Gambar</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="file" id="image_path">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6"> 
                                        
                                    </div>
                                    <div class="col-md-6"> 
                                        <label for="floatingCity">Preview : </label>
                                        <img id="preview_image" src="#" alt="product"  class="rounded float-left" style="height: 200px; width: 300px"/>
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
    var category_id
    var image_path
    var status
    $(document).ready(function () {

        // preview image product
        $("#image_path").change(function(){
            readURL(this);
        });

        // get category 
        getCategory()

        // store product
        $("#frm-add-product").on("submit", function(e){
            e.preventDefault()

            // Validation form required
            if($("#code").val() == "" ){
                $.alert({
                    title: 'Pesan !',
                    content: 'Kode SKU tidak boleh kosong !',
                });
                return 
            }

            if($("#article").val() == ""){
                $.alert({
                    title: 'Pesan !',
                    content: 'Nama Artikel tidak boleh kosong !',
                });
                return 
            }

            if($("#sku").val() == ""){
                $.alert({
                    title: 'Pesan !',
                    content: 'Nama SKU tidak boleh kosong !',
                });
                return 
            }

            if($("#size").val() == ""){
                $.alert({
                    title: 'Pesan !',
                    content: 'Silakan pilih size !',
                });
                return 
            }

            if($("#price").val() == ""){
                $.alert({
                    title: 'Pesan !',
                    content: 'Harga tidak boleh kosong !',
                });
                return 
            }

            if($("#category_id").prop('selected', true) == ""){
                $.alert({
                    title: 'Pesan !',
                    content: 'Kategori tidak boleh kosong !',
                });
                return 
            }

            var formData = new FormData();

            // Assign value
            if($('#image_path').val() == ""){
                image_path = null
            } else{
                image_path = $('#image_path')[0].files[0]
            }

           if($('input[name="status"]:checked').val() == 1){
                status = 1
           } else {
                status = 0
           }

            formData.append('code', $('#code').val())
            formData.append('article', $('#article').val())
            formData.append('sku', $('#sku').val())
            formData.append('size', $('#size option:selected').val())
            formData.append('price', $('#price').val())
            formData.append('category_id', $('#category_id option:selected').val())
            formData.append('image_path', image_path)
            formData.append("status", status)
            
            //console.log(formData)
            $.ajax({
                type: "POST",
                url: "/api/product/create",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function (response) {
                    console.log(response)
                    if(response.status == 200){
                        $.confirm({
                            title: 'Pesan ',
                            content: 'Data produk berhasil diperbarui !',
                            buttons: {
                                Ya: {
                                    btnClass: 'btn-success any-other-class',
                                    action: function(){
                                        window.location.href = '/product'
                                    }
                                },
                            }
                        });
                    }
                }
            });
        })
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#preview_image').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function getCategory(){
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