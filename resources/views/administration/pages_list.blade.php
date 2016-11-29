@extends('administration/adminmaster')

@section('title')
    Stránky
@stop

@section('custom_css') {{--CSS specified only for this site--}}
<link rel="stylesheet" href="<?= URL::to( '/' ); ?>/assets/administration/css/dataTables.bootstrap.css">
@stop


@section('content')
	<?php if(isset( $status ) && $status == 'create-success'): ?>
    <div id="msgSucces" class="alert alert-success fade in alert-dismissable" style="margin-top:18px;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
        Stránka bola úspešne pridaná.
    </div>
	<?php endif; ?>
	<?php if(isset( $status ) && $status == 'delete-success'): ?>
    <div id="msgSucces" class="alert alert-success fade in alert-dismissable" style="margin-top:18px;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
        Stránka bola úspešne vymazaná.
    </div>

	<?php endif; ?>
    <a class="admin-sub-options success" href="<?= URL::to( '/admin/page_create' ); ?>"><i class="fa fa-plus"
                                                                                           aria-hidden="true"></i>
        Vytvoriť stránku</a>
    <table id="example2" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>Názov</th>
            <th>URL</th>
            <th>Dátum</th>
            <th>SEO Nadpis</th>
            <th>SEO kľúčové slová</th>
            <th>SEO popis</th>
            <th>Možnosti</th>
        </tr>
        </thead>
        <tbody>
		<?php foreach ( $pages as $page ): ?>
        <tr>
            <td><?= $page->name ?></td>
            <td><?= $page->controller ?></td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td><i class="fa fa-pencil disabled" aria-hidden="true"></i> | <a onclick="deleteModal(<?= $page->section_id ?>)"><i
                            class="fa fa-trash" aria-hidden="true"></i></a></td>
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
                    <p>Určite chcete vymazať stránky <span id="langVar">:var</span>?</p>
                    <form id="deleteForm" action="<?= URL::to( '/worker/do_delete_page' ); ?>" method="POST"
                          style="display: none;">

                    </form>
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
        $('#nav-navigacia').addClass('active');
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
    function deleteModal(id) {
        $('#deleteForm').html('<input id="title-input" class="form-control" name="pageID" type="text" value="' + id + '">' +
            '<input name="_token" type="hidden" id="_token" value="' + window.Laravel.csrfToken + '" />');
        $('#deleteModal').modal('show');
    }
    $('#submitDelete').on('click', function () {
        $('#deleteForm').submit();
    });
</script>
@stop