@extends('administration.adminmaster')

@section('title')
    Jazyky
@stop

@section('custom_css') {{--CSS specified only for this site--}}
<link rel="stylesheet" href="<?= URL::to( '/' ); ?>/assets/administration/dataTables.min.css">
@stop


@section('content')
    <a class="admin-sub-options success" href="<?= URL::to( 'admin/languages/create' ); ?>"><i class="fa fa-plus"
                                                                                           aria-hidden="true"></i>
        Vytvoriť jazyk</a>
    <table id="example2" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>Názov</th>
            <th>Skratka</th>
            <th>Možnosti</th>
        </tr>
        </thead>
        <tbody>
		<?php foreach ( $languages as $page ): ?>
        <tr>
            <td><?= $page->language_title ?></td>
            <td><?= $page->language_shortcut ?></td>
            <td><a href="languages/<?= $page->id ?>/edit"><i class="fa fa-pencil" aria-hidden="true"></i></a> |
                <a class="<?= $page->id == 0 ? 'disabled' : '' ?>" onclick="deleteModal(<?= $page->id.',\''. $page->language_title.'\'' ?>)"><i class="fa fa-trash <?= $page->id === 0 ? 'disabled' : '' ?>" aria-hidden="true"></i></a></td>
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
                        Vymazanie jazyka</h4>
                </div>
                <div class="modal-body">
                    <p>Určite chcete vymazať jazyk <span id="langVar">:var</span> a všetky jeho súčasti?</p>
                    {!! Form::open(['url' => URL::to( '/admin/languages/' ), 'method' => 'delete', 'id' => 'deleteForm']) !!}

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
        $('#nav-languages').addClass('active');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "pageLength": 20,
            "bSort": false,
            "aaSorting": [[]]
        });
    });
    $(document).ready(function () {

        var navListItems = $('ul.setup-panel li a'),
            allWells = $('.setup-content');

        allWells.hide();

        navListItems.click(function (e) {
            e.preventDefault();
            var $target = $($(this).attr('href')),
                $item = $(this).closest('li');

            if (!$item.hasClass('disabled')) {
                navListItems.closest('li').removeClass('active');
                $item.addClass('active');
                allWells.hide();
                $target.show();
            }
        });
        $('ul.setup-panel li.active a').trigger('click');

        $('#activate-step-2').on('click', function (e) {
            $('ul.setup-panel li:eq(1)').removeClass('disabled');
            $('ul.setup-panel li a[href="#step-2"]').trigger('click');
            $(this).remove();
        })
    });
    var action = $('#deleteForm').attr('action');
    function deleteModal(id, name) {
        $('#deleteForm').html('<input name="_method" type="hidden" value="DELETE">' +
            '<input id="title-input" class="form-control" name="languageID" type="hidden" value="' + id + '">' +
            '<input name="_token" type="hidden" id="_token" value="' + window.Laravel.csrfToken + '" />');
        $('#langVar').html("<strong>'" + name + "'</strong>");
        $('#deleteForm').attr('action', action + '/' + id);
        $('#deleteModal').modal('show');
    }

    setTimeout(function () {
        $('.alert-success').fadeOut();
    }, 3000);

    $('#submitDelete').on('click', function () {
        $('#deleteForm').submit();
    });
</script>
@stop