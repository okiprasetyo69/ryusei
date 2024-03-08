
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
                                <button type="button" class="btn btn-md btn-primary rounded-pill btn-add" data-toggle="modal" data-target="#exampleModalCenter">
                                    <i class="bi bi-person-plus"></i>
                                </button>
                            </div>
                            <div class="table-responsive mt-4">
                                <table class="table" id="table-user">
                                    <thead class="thead-dark">
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
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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

      $(document).ready(function(){
            // show modal
            $(".btn-add").click(function (e) { 
                e.preventDefault();
                $("#exampleModalCenter").modal("show")
            });

            // // close modal
            $("#btn-close").click(function(e){
                e.preventDefault();
                $("#exampleModalCenter").modal("hide")
            })

            // filter
            $("#filter_name").keyup(function (e) { 
                console.log("Masuk filter name")
            });

            $("#filter_email").keyup(function (e) { 
                console.log("Masuk filter email")
            });

            $("#filter_phone").keyup(function (e) { 
                console.log("Masuk filter phone")
            });

           
           datatable()
      })

      function datatable(){
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
                    data: null, 
                    visible: false,   
                    render: (data, type, row, meta) => meta.row
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
                        html = "<button type='button' class='btn btn-sm btn-warning'> Ubah </button> <button type='button' class='btn btn-sm btn-danger'> Hapus </button>"
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
</script>

@endsection
@section('pagespecificscripts')
   
@stop