@extends('administration/adminmaster')

@section('title')
    Jazyky
@stop

@section('custom_css') {{--CSS specified only for this site--}}
<link rel="stylesheet" href="<?= URL::to( '/' ); ?>/assets/administration/css/dataTables.bootstrap.css">
@stop


@section('content')
    <?php if(isset( $status ) && $status == 'create-success'): ?>
    <div id="msgSucces" class="alert alert-success fade in alert-dismissable" style="margin-top:18px;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
        Jazyk bol úspešne pridaný.
    </div>
    <?php endif; ?>
    <?php if(isset( $status ) && $status == 'delete-success'): ?>
        <div id="msgSucces" class="alert alert-success fade in alert-dismissable" style="margin-top:18px;">
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
            Jazyk bol úspešne vymazaný.
        </div>
    <?php endif; ?>


    <a class="admin-sub-options success" href="<?= URL::to( '/admin/create_lang' ); ?>"><i class="fa fa-plus"
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
            <td><i class="fa fa-pencil disabled" aria-hidden="true"></i> | <a onclick="deleteModal(<?= $page->id ?>)"><i
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
                        Vymazanie jazyka</h4>
                </div>
                <div class="modal-body">
                    <p>Určite chcete vymazať jazyk <span id="langVar">:var</span>?</p>
                    <form id="deleteForm" action="<?= URL::to( '/worker/do_delete_language' ); ?>" method="POST"
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
        $('#nav-languages').addClass('active');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "pageLength": 20,
            "bSort": false
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

    function deleteModal(id) {
        $('#deleteForm').html('<input id="title-input" class="form-control" name="languageID" type="text" value="' + id + '">' +
                '<input name="_token" type="hidden" id="_token" value="' + window.Laravel.csrfToken + '" />');
        $('#deleteModal').modal('show');
    }

    setTimeout(function () {
        $('#msgSucces').fadeOut();
    }, 3000);

    $('#submitDelete').on('click', function () {
        $('#deleteForm').submit();
    });
</script>
@stop