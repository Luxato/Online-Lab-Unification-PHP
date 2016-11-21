@extends('administration/adminmaster')

@section('title')
    Nastavenia
@stop

@section('custom_css') {{--CSS specified only for this site--}}
<link rel="stylesheet" href="<?= URL::to( '/' ); ?>/assets/administration/css/dataTables.bootstrap.css">
@stop


@section('content')
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Nastavenia</a></li>
        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Nastavenia 2</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade in active" id="home">Tu budu nejake nastavenia</div>
        <div role="tabpanel" class="tab-pane fade in" id="profile">..asc</div>
    </div>
@stop

@section('custom_scripts') {{--JS specified only for this site--}}

<script>
    $('#nav-settings').addClass('active');
    $('#myTabs a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
    });
    /*$('#myTabs a[href="#profile"]').tab('show'); // Select tab by name*/
    $('#myTabs a:first').tab('show'); // Select first tab
    $('#myTabs a:last').tab('show'); // Select last tab
    /*$('#myTabs li:eq(2) a').tab('show'); // Select third tab (0-indexed)*/
</script>
@stop