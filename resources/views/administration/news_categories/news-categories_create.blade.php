@extends('administration/adminmaster')

@section('title')
Kategórie aktualít
@stop

@section('custom_css') {{--CSS specified only for this site--}}
<link rel="stylesheet" href="<?= URL::to( '/' ); ?>/assets/administration/css/dataTables.bootstrap.css">
@stop


@section('content')
<a id="createButton" class="admin-sub-options success">Vytvoriť kategóriu <i class="fa fa-angle-down" aria-hidden="true"></i></a>
<form id="dropForm" action="<?= URL( 'admin/news-categories' ) ?>" method="POST">
    <input name="_token" type="hidden" id="_token" value="{{ csrf_token() }}"/>
    <div class="col-md-4" style="margin: 20px;">
        <div class="form-group">
            <label for="exampleInputEmail1">Názov kategórie</label>
            <input id="title-input" class="form-control" name="name[]" type="text" placeholder="Zadajte názov" required="">
        </div>
        <button type="submit" class="btn btn-success pull-right">Vytvoriť</button>
    </div>
    <div class="col-md-12">
        <hr>
        <br>
    </div>
</form>
<table id="example2" class="table table-bordered table-hover">
	<thead>
	<tr>
		<th>Kategória</th>
		<th>Možnosti</th>
	</tr>
	</thead>
	<tbody>
    <?php foreach($categories as $category): ?>
        <tr>
            <td><?= $category->name ?></td>
            <td><i class="fa fa-pencil disabled" aria-hidden="true"></i> | <a class="disabled"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
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
    $('#createButton').on('click', function() {
        $('#dropForm').stop().slideToggle();
    });
</script>
@stop