
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
                    <a href="/product/edit/{{ $product->code}}">Ubah</a>
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
                                    <input type="hidden" name="code" id="code" class="form-control" />
                                    <div class="row mt-4">
                                        <div class="col-md-4">
                                            <button type="button" class="btn btn-md btn-primary" id="btn-add">
                                                <i class="bi bi-plus-circle"></i> Tambah
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="name" id="name" placeholder="Masukkan Nama SKU" autofocus>
                                                <label for="">Nama SKU</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <select name="category_id" id="category_id" class="form-control category_id" placeholder="Kategori"> 
                                                    <option> - Pilih Kategori - </option>
                                                </select>
                                                <label for="">Kategori</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-md-8">
                                            <table class="table table-striped" id="table-add-product">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Size</th>
                                                    <th scope="col">Kode SKU</th>
                                                    <th scope="col">Nama Artikel</th>
                                                    <th scope="col">Harga</th>
                                                    <th scope="col">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody">
                                               
                                            </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-4">
                                            <img id="preview_image" src="#" alt="product"  class="rounded float-left" style="height: 200px; width: 300px"/>
                                            <div class="col-md-12">
                                                <label for="" class="col-sm-12 col-form-label">Upload Gambar</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="file" id="image_path" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-12"> 
                                                <div class="form-floating">
                                                    <fieldset class="row mb-3">
                                                        <legend class="col-form-label">Status</legend>
                                                        <div class="col-sm-12">
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
    var category_id
    var image_path
    var status
    var sizes
    var codes
    var articles
    var prices
    var category_ids
    var sizes = '<?php echo $size ;?>'
    var products = '<?php echo $products ;?>'
    var product_detail = <?php echo $product ;?>
    
    $(document).ready(function () {
        
        // passing data
        var path = ""
        if(product_detail.image_path != ""){
            path = product_detail.image_path
        } 
        var APP_URL = {!! json_encode(url("/uploads/product/")) !!}
        var new_url = APP_URL + "/" + path
     
        $("#code").val(product_detail.code)
        $("#name").val(product_detail.name)
        $("#article").val(product_detail.article)
        $("#sku").val(product_detail.sku)
        $("#size").prop("selected", true).val(product_detail.size)
        $("#price").val(product_detail.price)
        $("input[name='status'][value="+product_detail.status+"]").attr("checked", true)
        $("#preview_image").attr("src", new_url)

        image_path = product_detail.image_path

        // preview image product
        $("#image_path").change(function(){
            readURL(this);
        });

        // get category 
        category_id = product_detail.category_id
        getCategory(category_id)

        // get product
        codes = product_detail.code
        loadProduct(codes)

        // button add
        $("#btn-add").on("click", function(e){
            e.preventDefault()
            let count = $('#table-add-product tr').length
            let row = "<tr><td>"+count+"</td> <td><select class='form-select size' name='size[]' id='size-"+ (count + 1) +"' data-id="+(count+1)+"></select></td> <td><input type='text' class='form-control sku' name='code[]' id='sku' placeholder='Kode SKU'></td> <td><input type='text' class='form-control article' name='article[]' id='article' placeholder='Nama Artikel'></td> <td><input type='number' min='0' class='form-control price' name='price' id='price' placeholder='Harga'></td> <td><button type='button' class='btn btn-sm btn-danger delete-row' id='"+(count+1)+"'><i class='bi bi-trash' aria-hidden='true'></i></button> </td></tr>"
            $('#tbody').append(row);
            var id = $(this).attr('data-id')
            changeSize(id)
        })

         // remove row form table
         $("#tbody").on("click", '.delete-row',function(e){
            e.preventDefault()
            var rowId =  $(this).attr('id')
            $("#"+rowId+"").parent('td').parent('tr').remove(); 
        })
    
        // store product
        $("#frm-add-product").on("submit", function(e){
            e.preventDefault()

            // Validation form required
            if($("#sku").val() == ""){
                $.alert({
                    title: 'Pesan !',
                    content: 'Nama SKU tidak boleh kosong !',
                });
                return 
            }

            var formData = new FormData();
            var products = []
            $("#table-add-product tbody tr").each(function(index){
                sizes = $(this).find('.size option:selected').val()
                skus = $(this).find('.sku').val()
                articles = $(this).find('.article').val()
                prices = $(this).find('.price').val()
                products.push({size : sizes, sku:skus, article:articles, price:prices, category_id, category_ids })
            })

            var formData = new FormData();

            // Assign value
            if($('#image_path').val() == ""){
                image_path = image_path
            } else{
                image_path = $('#image_path')[0].files[0]
            }

            if($('input[name="status"]:checked').val() == 1){
                status = 1
           } else {
                status = 0
           }

            var jsonProducts = JSON.stringify(products);
         
            formData.append('code', $('#code').val())
            formData.append('name', $('#name').val())
            formData.append('image_path', image_path)
            formData.append("status", status)
            formData.append("products", jsonProducts)
            formData.append('category_id', $('#category_id option:selected').val())
            
            console.log(status)
            //console.log(formData)
            $.ajax({
                type: "POST",
                url: "/api/product/update",
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

        $("#table-add-product").on("click", '.size', function(){
                var id = $(this).attr('data-id')
                changeSize(id)
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

    function getCategory(category_id = null){
        $.ajax({
            type: "GET",
            url: "/api/category",
            data: "data",
            dataType: "JSON",
            success: function (response) {

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

    function loadProduct(codes = null){
       $.ajax({
            type: "GET",
            url: "/api/product/list-product",
            data: {
                code : codes
            },
            dataType: "JSON",
            success: function (response) {
                var data = response.data
                var row = ""
                let count = 1
                var selected = ""
                $("#table-add-product").find("tr:gt(0)").remove()
                $.each(data, function (i, val) { 
                    var size = val.sizes
                    row += "<tr><td>"+ (count++) +"</td> <td><select class='form-select size' name='size[]' id='size-"+count+"' data-id="+count+"><option value="+size.id+"> "+size.name+" </option></select></td> <td><input type='text' class='form-control sku' name='sku[]' id='sku' value='"+val.sku+"' placeholder='Kode SKU'></td> <td><input type='text' class='form-control article' name='article[]' value='"+val.article+"' id='article' placeholder='Nama Artikel'></td> <td><input type='number' min='0' value='"+val.price+"' class='form-control price' name='price' id='price' placeholder='Harga'></td> <td><button type='button' class='btn btn-sm btn-danger delete-row' onclick='confirmDelete("+val.id+")'><i class='bi bi-trash' aria-hidden='true'></i></button> </td></tr>"
                });
                $("#table-add-product > tbody:last-child").append(row);
            }
       });
    }

    function confirmDelete(id=null){
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

    function remove(id = null){
        $.ajax({
            type: "POST",
            url: "/api/product/delete",
            data: {
                id : id,
            },
            dataType: "JSON",
            success: function (response) {
                if(response.status == 200){
                    $.confirm({
                        title: 'Pesan',
                        content: 'Data produk berhasil dihapus !',
                        buttons: {
                            Ya: {
                                btnClass: 'btn-success any-other-class',
                                action: function(){
                                    window.location.reload()
                                }
                            },
                        }
                    });
                }
            }
        });
    }

    function getSize(size = null){

        $.ajax({
            type: "GET",
            url: "/api/size",
            data: "data",
            dataType: "JSON",
            success: function (response) {
                //$("#size").html();
                var len = 0;
                var option = ""
                if(response['data'] != null) {
                    len = response['data'].length
                    for(i = 0; i < len; i++) {
                        var selected = ""
                        var id = response['data'][i].id
                        var name = response['data'][i].name

                        if(id == size ){
                            selected = "selected"
                        }
                        option = "<option value='"+id+"' "+selected+">"+ name +"</option>"
                        // $(".size").append(option)
                        $('#size-'+id+'').append(option)
                    }
                }
                
            }
        });
    }

    function changeSize(idRow=null){
        $.ajax({
            type: "GET",
            url: "/api/size",
            data: "data",
            dataType: "JSON",
            success: function (response) {
                $("#size").html();
                var len = 0;
                var option = ""
                if(response['data'] != null) {
                    len = response['data'].length
                    for(i = 0; i < len; i++) {
                        var selected = ""
                        var id = response['data'][i].id
                        var name = response['data'][i].name
                        option = "<option value='"+id+"'>"+ name +"</option>"
                        $('#size-'+idRow+'').append(option)
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