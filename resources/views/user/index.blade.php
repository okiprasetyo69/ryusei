
@extends('layout.home')
@section('title','Dashboard')

@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Management Pengguna</h1>
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Pengguna</a></li>
            <li class="breadcrumb-item active">Pengaturan</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mt-2">
                            <label> <strong><span>Pencarian : </span></strong> </label>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" name="filter_name" class="form-control" id="filter_name" placeholder="Masukkan nama" autofocus/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" name="filter_email" class="form-control" id="filter_email" placeholder="Masukkan email"/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" name="filter_phone" class="form-control" id="filter_phone" placeholder="Masukkan nomor kontak"/>
                                </div>
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
                                <button type="button" class="btn btn-md btn-primary rounded-pill btn-add" data-toggle="modal" data-target="#userModal">
                                    <i class="bi bi-person-plus"></i>
                                </button>
                            </div>
                            <div class="table-responsive mt-4">
                                <table class="table table-striped" id="table-user">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Kontak</th>
                                            <th scope="col">Role</th>
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
    </section>
</main>
<!-- End #main -->

<!-- Modal -->
<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Tambah Pengguna</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="#" id="frm-user">
        @csrf
      <div class="modal-body">
        <input type="hidden" name="id" id="id" class="form-control" />
        <div class="row">
          <div class="col-md-12 mt-2">
            <label> Nama</label>
            <input type="text" class="form-control" name="name" id="name" />
          </div>
          <div class="col-md-12 mt-2">
            <label> Email</label>
            <input type="text" class="form-control" name="email" id="email" />
          </div>
          <div class="col-md-12 mt-2">
            <label> Kontak</label>
            <input type="text" class="form-control" name="phone" id="phone" />
          </div>
          <div class="col-md-12 mt-2">
            <label> Role</label>
            <select name="role_id" id="role_id" class="form-control"> 
                <option value=""> -Pilih Role-</option>
            </select>
          </div>
          <div class="col-md-12 mt-2">
            <label> Password</label>
            <input type="password" min="1" class="form-control" name="password" id="password" />
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-md btn-success">Simpan</button>
        <button type="button" class="btn btn-md btn-secondary" data-dismiss="modal" id="btn-close">Batal</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript"> 
    
    var table
    var name
    var email
    var phone

      $(document).ready(function(){

            datatable()
            // show modal

            $(".btn-add").click(function (e) { 
                e.preventDefault();
                $("#userModal").modal("show")
            });

            // close modal
            $("#btn-close").click(function(e){
                e.preventDefault();
                $("#userModal").modal("hide")
            })
            
            // filter
            $("#filter_name").keyup(function (e) { 
                name =  $("#filter_name").val()
                datatable(name)
            });

            $("#filter_email").keyup(function (e) { 
                email =  $("#filter_email").val()
                datatable(name, email)
            });

            $("#filter_phone").keyup(function (e) { 
                phone =  $("#filter_phone").val()
                datatable(name, email, phone)
            });
      })

      function datatable(name=null, email=null, phone=null){
        if (table != null) {
            table.destroy();
        }

        table = $("#table-user").DataTable({
            "lengthChange": false,
			"searching": false,
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "bAutoWidth": true,
            "scrollX" : true,
            "scrollCollapse" : true,
            "columns":[
                { 
                    data: 'id', 
                    name: 'id',
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }  
                },
                { 
                    data: null, 
                    orderable: false,
                    render: function(response){
                        return response.name
                    }
                },
                { 
                    data: null, 
                    orderable: false,
                    render: function(response){
                        return response.email
                    }
                },
                { 
                    data: null, 
                    orderable: false,
                    render: function(response){
                        return response.phone
                    }
                },
                { 
                    data: null, 
                    orderable: false,
                    render: function(response){
                        return response.role.name
                    }
                },
                { 
                    data: null,
                    searchable: false,
                    orderable: false,
                    render: function(response) {
                        html = "<button type='button' class='btn btn-sm btn-warning' onclick='detail("+response.id+")'> Ubah </button> <button type='button' class='btn btn-sm btn-danger' onclick='confirmDelete("+response.id+")'> Hapus </button>"
                        return html
                    }
                }
            ],
            "ajax": function(data, callback, settings) {
                let length = data.length
                let pages = (data.start / 10) + 1
                $.get('/api/user', {
                    _token: "{{ csrf_token() }}",
                    limit: length,
                    page: pages,
                    name: name,
                    email: email,
                    phone: phone
                    }, function(response) {
                        callback({
                            recordsTotal: response.recordsTotal,
                            recordsFiltered: response.recordsFiltered,
                            data: response.data
                    });
                });
            },
        })

      }

      function detail(id=null){
        console.log(id)
        $.ajax({
            type: "POST",
            url: "/api/user/detail",
            data: {
                id : id
            },
            dataType: "JSON",
            success: function (response) {
                var data = response.data
                $("#id").val(data.id)
                $("#name").val(data.name)
                $("#email").val(data.email)
                $("#phone").val(data.phone)

                $("#userModal").modal("show")
            }
        });
      }

      function confirmDelete(id=null){}

      function delete(id=null){}

      function getRole(id=null){
        $.ajax({
            type: "method",
            url: "url",
            data: "data",
            dataType: "dataType",
            success: function (response) {
                
            }
        });
      }
</script>

@endsection
@section('pagespecificscripts')
   
@stop