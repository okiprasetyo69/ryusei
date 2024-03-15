
@extends('layout.home')
@section('title','Dashboard')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">+
<style> 
.pagination {
    margin-top: 20px;
}

.pagination ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
}

.pagination ul li {
    display: inline;
    margin-right: 5px;
    padding: 5px 10px;
    background-color: #B3F461;
    color: #fff;
    border-radius: 3px;
    cursor: pointer;
}

.pagination ul li.disabled {
    cursor: not-allowed;
    background-color: #ccc;
}
</style>
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
            <form method="GET" action="{{ route('product') }}"> 
                <div class="card">
                    <div class="card-body">
                        <div class="row mt-2">
                           <div class="col-md-4">
                                <label> <strong><span>Pencarian Artikel </span></strong> </label>
                           </div>
                           <div class="col-md-2"> 
                                <label> <strong><span>Kategori </span></strong> </label>
                           </div>
                           <div class="col-md-2"> 
                                <label> <strong><span>Ukuran </span></strong> </label>
                           </div>
                           <div class="col-md-2"> 
                                <label> <strong><span>Urutkan Harga </span></strong> </label>
                           </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" name="filter_article" class="form-control" id="filter_article" placeholder="Masukkan kata kunci" autofocus/>
                                </div>
                            </div>
                            <div class="col-md-2"> 
                                <div class="form-group"> 
                                    <select name="category_id" class="form-control" id="category_id"> 
                                    <option value=""> - Pilih Kategori - </option>
                                        @foreach($category as $item)
                                            <option value="{{$item->id}}"> {{$item->name}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2"> 
                                <div class="form-group"> 
                                    <select name="size" class="form-control" id="size"> 
                                        <option value=""> - Pilih Ukuran - </option>
                                        @foreach($size as $item)
                                            <option value="{{$item->id}}"> {{$item->name}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2"> 
                                <div class="form-group"> 
                                    <select name="price" class="form-control" id="price"> 
                                        <option value=""> - Pilih Urutan - </option>
                                        <option value="1"> Rendah - Tinggi </option>
                                        <option value="2"> Tinggi - Rendah </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2"> 
                                <div class="form-group"> 
                                    <button type="submit" class="btn btn-success" style="border-radius:50px;"> <i class="bi bi-search"></i> Cari </button>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </form>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mt-4" id="item-list">
                            @foreach ($data as $item)
                                <div class="col-lg-2">
                                    <div class="card">
                                        <div class="filter">
                                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                <li class="dropdown-header text-start">
                                                        <h6>Aksi</h6>
                                                </li>
                                                <li><a class="dropdown-item" href="/product/edit/{{$item->code}}">Ubah</a></li>
                                                <li><button type="button" class="dropdown-item" onclick="confirmDelete({{$item->id}})">Hapus</button></li>
                                            </ul>
                                        </div>
                                        <img class="card-img-top" src="{{ asset('/uploads/product/'. $item->image_path ) }}">
                                        <div class="card-body">
                                            <h5 class="card-title text-center">{{ $item->article }}</h5>
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <?php 
                                                $sizeName = "";
                                                if($item->size == 1){
                                                    $sizeName = "S";
                                                } 

                                                if($item->size == 2){
                                                    $sizeName = "M";
                                                } 

                                                if($item->size == 3){
                                                    $sizeName = "L";
                                                } 

                                                if($item->size == 4){
                                                    $sizeName = "XL";
                                                } 

                                                if($item->size == 5){
                                                    $sizeName = "XXL";
                                                } 

                                                if($item->size == 6){
                                                    $sizeName = "3XL";
                                                } 
                                            ;?>
                                            <li class="list-group-item">Kode SKU : {{ $item->sku }} </li>
                                            <li class="list-group-item">{{ $item->name }} </li>
                                            <li class="list-group-item">Ukuran: {{ $sizeName }}</li>
                                            <li class="list-group-item">Harga : Rp. {{ number_format($item->price)}}</li>
                                            <li class="list-group-item">{{ $item->status == 1 ? "Ready" : "Not Ready"}}</li>
                                            <li class="list-group-item"> Kategori : {{ $item->category->name }}</li>
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4"></div>
                            <div class="col-md-4 text-center">
                                <div class="pagination">
                                    <ul>
                                        <!-- Previous Page Link -->
                                        @if ($data->onFirstPage())
                                            <li class="disabled">Previous</li>
                                        @else
                                            <li><a href="{{ $data->previousPageUrl() }}">Previous</a></li>
                                        @endif

                                        <!-- Next Page Link -->
                                        @if ($data->hasMorePages())
                                            <li><a href="{{ $data->nextPageUrl() }}">Next</a></li>
                                        @else
                                            <li class="disabled">Next</li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4"></div>                     
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<!-- End #main -->

<script type="text/javascript"> 

    $(document).ready(function () {
        //loadProduct()
        //getCategory()
        //getSize()
        
    });

    function getCategory(){
        $.ajax({
            type: "GET",
            url: "/api/category",
            data: "data",
            dataType: "JSON",
            success: function (response) {
                var data = response.data
                $("#category_id").html("");
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

    function getSize(){
        $.ajax({
            type: "GET",
            url: "/api/size",
            data: "data",
            dataType: "JSON",
            success: function (response) {
                var data = response.data
                var option = ""
                $("#size").html("")
                $.each(data, function (i, val) { 
                    option += "<option value="+val.id+"> "+val.name+" </option>"
                });
                $("#size").append(option)
                //console.log(response)
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
        console.log("masuk sini : " + id)
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
                                    window.location = "/product"
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
@endsection
@section('pagespecificscripts')
   
@stop