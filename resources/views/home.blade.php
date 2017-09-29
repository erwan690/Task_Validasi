@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @role('user')
                    @if (count($cek)>= 1)
                  @if ($cek[0]->isvalid != 1)
                    Permintaan Anda Sedang Di proses
                    @else
                    Permintaan Anda Telah Diterima
                  @endif

                @else
                  Silahkan Upload CV Anda
                  @endif
                  @endrole


                </div>
            </div>
        </div>

      @role('administrator')
        <table id="users-table" class="table table-bordered">
    <thead>
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Email</th>
        <th>filename</th>
        <th>Action</th>
    </tr>
    </thead>
</table>
        @endrole

      @role('user')
      @if (!count($cek) >= 1)
        {!! Form::open(['method' => 'POST', 'route' => 'addcv', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) !!}
          <div class="form-group{{ $errors->has('name_file') ? ' has-error' : '' }}">
              {!! Form::label('name_file', 'Input', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                  {!! Form::text('name_file', null, ['class' => 'form-control', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('name_file') }}</small>
              </div>
          </div>
          <div class="form-group{{ $errors->has('lamaran') ? ' has-error' : '' }}">
              {!! Form::label('lamaran', 'Upload Cv', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-9">
                      {!! Form::file('lamaran', ['required' => 'required']) !!}
                      <p class="help-block">Help block text</p>
                      <small class="text-danger">{{ $errors->first('lamaran') }}</small>
                  </div>
          </div>

            <div class="btn-group pull-right">
                {!! Form::reset("Reset", ['class' => 'btn btn-warning']) !!}
                {!! Form::submit("Add", ['class' => 'btn btn-success']) !!}
            </div>
        {!! Form::close() !!}
      @endif
      @endrole
    </div>
</div>

<!-- MODAL DELETE -->
<div id="modalDelete" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Hapus Data</h4>
      </div>

      <div class="modal-body">
        <p>Hapus data ini?</p>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
        <button type="button" class="btn btn-danger" id="btnDelete">Ya</button>
      </div>

    </div>
  </div>
</div>

@endsection

@section('js')
  <script type="text/javascript">
    $(function () {
        var table = $('#users-table').DataTable({
            serverSide: true,
            processing: true,
            ajax: '{{ url("getuser") }}',
            columns: [
                {data: 'id'},
                {data: 'name'},
                {data: 'email'},
                {data: 'filename', name: 'aplication.filename'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });
    });

    function reloadTable() {
        table.ajax.reload(null, false); //reload datatable ajax
    }

     function delete_data(id) {
      $('#modalDelete').modal('show');
        // execute delete
        $('#btnDelete').click(function() {
            $.ajax({
                url : '{{ url ("delete_aplication")}}' + id_angket,
                type: "DELETE",
                dataType: "JSON",
                success: function(data) {
                    //if success reload ajax table
                    $('#modalDelete').modal('hide');
                    reload_table();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error deleting data');
                }
            });
        });
    }

    function valid_data(id) {
            $.ajax({
                url : '{{ url ("delete_aplication")}}' + id_angket,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    //if success reload ajax table
                    $('#modalDelete').modal('hide');
                    reload_table();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error deleting data');
                }
            });
    }
</script>

@endsection
