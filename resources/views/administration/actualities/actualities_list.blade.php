@extends('administration/adminmaster')

@section('title')
    Aktuality
@stop

@section('custom_css') {{--CSS specified only for this site--}}
<link rel="stylesheet" href="<?= URL::to( '/' ); ?>/assets/administration/css/dataTables.bootstrap.css">
@stop


@section('content')
    <a class="admin-sub-options success" href="<?= URL::to( '/admin/actualities/create' ); ?>"><i class="fa fa-plus"
                                                                                            aria-hidden="true"></i>
        Vytvoriť aktualitu</a>
    <table id="example2" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>Názov</th>
            <th>Kategória</th>
            <th>Lokalizácia</th>
            <th>Dátum</th>
            <th>Možnosti</th>
        </tr>
        </thead>
        <tbody>
		<?php foreach ( $actualities as $actuality ): ?>
        <tr>
            <td><?= $actuality->name ?></td>
            <td><?= $actuality->catname ?></td>
            <td><?= $actuality->language_title ?></td>
            <td><?= $actuality->created_at ?></td>
            <td><a href="<?= url('admin/actualities/'. $actuality->id . '/edit') ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a> | <a onclick="deleteModal(<?= $actuality->id ?>, '<?= $actuality->name ?>')"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
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
                        Vymazanie stránky</h4>
                </div>
                <div class="modal-body">
                    <p>Určite chcete vymazať aktualitu <span id="langVar">:var</span>?</p>
                    {!! Form::open(['url' => URL::to( '/admin/actualities/' ), 'method' => 'delete', 'id' => 'deleteForm']) !!}

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
    $(function () {
        $('#nav-news').addClass('active');
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
    setTimeout(function () {
        $('.alert-success').fadeOut();
    }, 3000);
    var action = $('#deleteForm').attr('action');
    function deleteModal(id, name) {
        $('#deleteForm').html('<input name="_method" type="hidden" value="DELETE">' +
            '<input name="_token" type="hidden" id="_token" value="' + window.Laravel.csrfToken + '" />');
        $('#langVar').html("<strong>'" + name + "'</strong>");
        $('#deleteForm').attr('action', action + '/' + id);
        $('#deleteModal').modal('show');
    }
    $('#submitDelete').on('click', function () {
        $('#deleteForm').submit();
    });
</script>
@stop