@extends('administration/adminmaster')

@section('title')
    Jazyky
@stop

@section('custom_css') {{--CSS specified only for this site--}}
<link rel="stylesheet" href="<?= URL::to( '/' ); ?>/assets/administration/css/dataTables.bootstrap.css">
@stop


@section('content')
    <a class="admin-sub-options success" href="<?= URL::to( '/admin/create_lang' ); ?>"><i class="fa fa-plus" aria-hidden="true"></i> Vytvoriť jazyk</a>
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
            <td><i class="fa fa-pencil" aria-hidden="true"></i> | <i class="fa fa-trash" aria-hidden="true"></i></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
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
            "pageLength": 20
        });
    });
    $(document).ready(function() {

        var navListItems = $('ul.setup-panel li a'),
                allWells = $('.setup-content');

        allWells.hide();

        navListItems.click(function(e)
        {
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

        $('#activate-step-2').on('click', function(e) {
            $('ul.setup-panel li:eq(1)').removeClass('disabled');
            $('ul.setup-panel li a[href="#step-2"]').trigger('click');
            $(this).remove();
        })
    });
</script>
@stop