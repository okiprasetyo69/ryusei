
@extends('layout.home')
@section('title','Vendor')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Management Transaksi</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item ">
                    <a href="#">Pembelian</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="/vendors">Pemasok - Vendor</a>
                </li>
                <li class="breadcrumb-item active">
                    <a href="#">Detail</a>
                </li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row"> 
                            <form class="row g-2" action="#" id="frm-add-vendor">
                                <input type="hidden" class="form-control" name="id" id="id" value="{{ $vendor->id }}">
                                <div class="col-md-6">
                                    <div class="col-12">
                                        <label for="" class="form-label">Kode</label>
                                        <input type="text" class="form-control" name="vendor_code" id="vendor_code" value="{{ $vendor->vendor_code}}">
                                    </div>
                                    <div class="col-12 mt-2">
                                        <label for="" class="form-label">Nama</label>
                                        <input type="text" class="form-control" name="name" id="name" value="{{ $vendor->name}}">
                                    </div>
                                    <div class="col-12 mt-2">
                                        <label for="" class="form-label">Alias</label>
                                        <input type="text" class="form-control" name="alias" id="alias" value="{{ $vendor->alias}}">
                                    </div>
                                    <div class="col-12 mt-2">
                                        <label for="" class="form-label">Branch</label>
                                        <input type="text" class="form-control" name="branch" id="branch" value="{{ $vendor->branch}}">
                                    </div>
                                    <div class="col-12 mt-2">
                                        <label for="" class="form-label">Kategori</label>
                                        <input type="text" class="form-control" name="category" id="category" value="{{ $vendor->category}}">
                                    </div>
                                    <div class="col-12 mt-2">
                                        <label for="inputAddress" class="form-label">Currency</label>
                                        <select class="form-control" name="currency" id="currency"> 
                                            <option value="1" {{ $vendor->currency == 1 ? "selected" : ""}}> IDR </option>
                                            <option value="2" {{ $vendor->currency == 2 ? "selected" : ""}}> USD </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-12">
                                        <label for="" class="form-label">Phone</label>
                                        <input type="text" class="form-control" name="phone" id="phone" value="{{  $vendor->phone }}">
                                    </div>
                                    <div class="col-12 mt-2">
                                        <label for="" class="form-label">Mobile Phone</label>
                                        <input type="text" class="form-control" name="mobile" id="mobile" value="{{  $vendor->mobile }}">
                                    </div>
                                    <div class="col-12 mt-2">
                                        <label for="" class="form-label">Email</label>
                                        <input type="text" class="form-control" name="email" id="email" value="{{  $vendor->email }}">
                                    </div>
                                    <div class="col-12 mt-2">
                                        <label for="" class="form-label">Balance</label>
                                        <input type="number" min="0" class="form-control" name="balance" id="balance"  value="{{  $vendor->balance }}" >
                                    </div>
                                    <div class="col-12 mt-2"> 
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="is_tax_on_purchase" {{  $vendor->is_tax_on_purchase == 1 ? "checked" : "" }}>
                                            <label class="form-check-label" for="">
                                                Tax On Purchase
                                            </label>
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script type="text/javascript"> 
    

    $(document).ready(function () {
        $("#frm-add-vendor").on("submit", function(e){
            e.preventDefault()
            if($("#name").val() == ""){
                $.alert({
                    title: 'Pesan !',
                    content: 'Nama tidak boleh kosong !',
                });
                return 
            }
            
            var isTax = 0
            if($("#is_tax_on_purchase").prop('checked') == true){
                isTax = 1
            }

            $.ajax({
                type: "POST",
                url: "/api/vendor/create",
                data: {
                    id : $("#id").val(),
                    name : $("#name").val(),
                    alias:  $("#alias").val(),
                    branch:  $("#branch").val(),
                    category:  $("#category").val(),
                    currency:  $("#currency option:selected").val(),
                    phone:  $("#phone").val(),
                    mobile:  $("#mobile").val(),
                    email:  $("#email").val(),
                    balance:  $("#balance").val(),
                    is_tax_on_purchase : isTax
                },
                dataType: "JSON",
                success: function (response) {
                    console.log(response)
                    if(response.status == 200){
                        $.confirm({
                            title: 'Pesan ',
                            content: 'Data vendor berhasil diperbarui !',
                            buttons: {
                                Ya: {
                                    btnClass: 'btn-success any-other-class',
                                    action: function(){
                                       window.location.href = '/vendors'
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

@endsection
@section('pagespecificscripts')
   
@stop