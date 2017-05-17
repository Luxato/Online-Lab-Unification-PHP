@extends('administration/adminmaster')

@section('title')
    Užívatelia
@stop

@section('custom_css') {{--CSS specified only for this site--}}
<link rel="stylesheet" href="<?= URL::to( '/' ); ?>/assets/administration/dataTables.min.css">
@stop


@section('content')
    <table id="example2" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>Meno</th>
            <th>Email</th>
            <th>Dátum vytvorenia</th>
            <th>Možnosti</th>
        </tr>
        </thead>
        <tbody>
		<?php foreach($users as $user): ?>
        <tr>
            <td><?= $user->name ?></td>
            <td><?= $user->email ?></td>
            <td><?= $user->created_at ?></td>
            <td><a href="<?= url('admin/users/' . $user['id'] . '/edit') ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a> | <a onclick="deleteModal('<?= $user['id'] ?>', '<?= $user['name'] ?>')"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
        </tr>
		<?php endforeach; ?>
        </tbody>
    </table>
    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-danger">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title"><i class="fa fa-trash" aria-hidden="true" style="color: #fff;"></i>
                        Vymazanie používateľa</h4>
                </div>
                <div class="modal-body">
                    <p>Určite chcete vymazať používateľa <span id="langVar">:var</span> ?</p>
                    {!! Form::open(['url' => URL::to( '/admin/users/' ), 'method' => 'delete', 'id' => 'deleteForm']) !!}

                    {!! Form::close() !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Zavrieť</button>
                    <button id="submitDelete" type="submit" class="btn btn-success">Vymazať</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('custom_scripts') {{--JS specified only for this site--}}
<script src="<?= URL::to( '/' ); ?>/assets/administration/plugins/jquery.dataTables.min.js"></script>
<script src="<?= URL::to( '/' ); ?>/assets/administration/plugins/dataTables.bootstrap.min.js"></script>
<script>
    function deleteModal(id, name) {
        $('#deleteForm').html('<input name="_method" type="hidden" value="DELETE">' +
            '<input name="_token" type="hidden" id="_token" value="' + window.Laravel.csrfToken + '" />');
        $('#langVar').html("<strong>'" + name + "'</strong>");
        $('#deleteForm').attr('action', action + '/' + id);
        $('#deleteModal').modal('show');
    }
    var action = $('#deleteForm').attr('action');
    $('#submitDelete').on('click', function () {
        $('#deleteForm').submit();
    });
    $(function () {
        $('#nav-users').addClass('active');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "pageLength": 20
        });
    });
</script>
@stop