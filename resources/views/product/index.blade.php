
@extends('layout.home')
@section('title','Dashboard')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">+

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
                        <div class="row mt-2"> 
                            <div class="col md-4">
                                <button type="button" class="btn btn-sm btn-primary rounded-pill" id="btn-add">
                                    <i class="bi bi-plus-circle"></i> Tambah
                                </button>
                                <button type="button" class="btn btn-sm btn-danger rounded-pill" id="btn-sync">
                                    <i class="ri-24-hours-fill"></i> 
                                    <span class="" role="status" id="spinner-sync" aria-hidden="true"></span>
                                    <label id="lbl-sync">Sync Product</label>
                                </button>
                            </div>
                        </div>
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
                                        <img class="card-img-top text-center" src="{{ asset('/uploads/product/'. $item->image_path ) }}" style="height: 200px; width: 200px" />
                                        <div class="card-body">
                                            <h5 class="card-title text-center">{{ $item->article != null ?  $item->article : "-" }}</h5>
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                <h3 class="card-title text-center"> SKU : {{ $item->sku != null ? $item->sku : "-" }}  </h3>
                                            </li>
                                            <li class="list-group-item text-center">
                                                <?php 
                                                    $itemName = "";
                                                    if($item->name == null){
                                                        $itemName = "-";
                                                    } else {
                                                        $itemName = $item->name;
                                                    }
                             
                                                ;?>
                                                <p class="fst-italic fw-bold"> {{ $itemName }} </p>
                                            </li>
                                            <li class="list-group-item">
                                                <?php 
                                                    $sizeName = "";

                                                    if($item->size == null){
                                                        $sizeName = "-";
                                                    } else {
                                                        $sizeName =  $item->sizes->name;
                                                    }
                                                  
                                                ;?>
                                                <p class="text-center fw-bold"> Size : {{  $sizeName }} </p>
                                            </li>
                                            <li class="list-group-item">
                                                <p class="text-center fw-bold">  Harga : Rp. {{ number_format($item->price, 0, ',', '.')}} </p>
                                            </li>
                                            <li class="list-group-item">
                                                <p class="text-center fw-bold"> Status : {{ $item->status == 1 ? "Ready" : "Not Ready"}} </p>
                                            </li>
                                            <li class="list-group-item"> 
                                                <?php 
                                                    $category = "";
                                                    if($item->category == null){
                                                        $category = "-";
                                                    } else {
                                                        $category = $item->category->name;
                                                    }
                                                ;?>
                                                <p class="text-center fw-bold"> Kategori : {{ $category }} </p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4"></div>
                            <div class="col-md-4 text-center">
                                {!! $data->appends(request()->all())->links() !!}
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
        $("#btn-add").on("click", function(e){
            e.preventDefault()
            window.location.href = "/product/add"
        })

        $("#btn-sync").on("click", function(e){
            e.preventDefault()
            $("#btn-sync").attr("disabled", true);
            $("#spinner-sync").attr("class", "spinner-grow spinner-grow-sm")
            $("#lbl-sync").text("Loading...")

            $.ajax({
                type: "GET",
                url: "/jubelio/inventory",
                data: "data",
                dataType: "JSON",
                success: function (response) {

                    if(response.status == 200){
                        $("#btn-sync").attr("disabled", false);
                        $("#spinner-sync").attr("class", "")
                        $("#lbl-sync").text("Sync Product")
                        $.confirm({
                            title: 'Pesan ',
                            content: response.message,
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

                    if(response.status == 401){
                        $("#btn-sync").attr("disabled", false);
                        $("#spinner-sync").attr("class", "")
                        $("#lbl-sync").text("Sync Product")
                        $.confirm({
                            title: 'Pesan ',
                            content: response.message,
                            buttons: {
                                "Update Token": {
                                    btnClass: 'btn-success any-other-class',
                                    action: function(){
                                        updateUserToken()
                                    }
                                },
                            }
                        });
                    }
                }   
            });

        })
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
                                    window.location = "/product"
                                }
                            },
                        }
                    });
                }
            }
        });
    }

    function updateUserToken(){
        $.ajax({
            type: "GET",
            url: "/jubelio/update-token",
            data: "data",
            dataType: "JSON",
            success: function (response) {
                console.log(response)
                if(response.status == 200){
                    $.confirm({
                            title: 'Pesan ',
                            content: response.message,
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
    }
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
@endsection
@section('pagespecificscripts')
   
@stop