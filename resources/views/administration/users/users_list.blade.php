@extends('administration/adminmaster')

@section('title')
    Užívatelia
@stop

@section('custom_css') {{--CSS specified only for this site--}}
<link rel="stylesheet" href="<?= URL::to( '/' ); ?>/assets/administration/css/dataTables.bootstrap.css">
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
            <td><i class="fa fa-pencil disabled" aria-hidden="true"></i> | <i class="fa fa-trash disabled" aria-hidden="true"></i></td>
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