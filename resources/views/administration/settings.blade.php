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
        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Základné nastavenia</a></li>
        {{--<li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Landing page</a></li>--}}
    </ul>

    <!-- Tab panes -->
    <div class="row">
    <div class="col-md-12">
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active" id="home">
                <form name="finalForm" id="finalForm" action="<?= URL( 'admin/settings/' ) ?>" method="POST">
                    <input name="_token" type="hidden" id="_token" value="{{ csrf_token() }}"/>
                    <div class="col-md-6">
                        <br>
                        <label for="languageSelection">Defaultný jazyk stránky</label>
                        <select id="languageSelection" name="language" class="form-control" required="">
                            <?php foreach($languages as $language): ?>
                            <option <?= $default_lang == $language->language_shortcut ? 'selected' : '' ?> value="<?= $language->language_shortcut ?>"><?= $language->language_title ?></option>
                            <?php endforeach; ?>
                        </select>
                        <br>
                        <label for="languageSelection">Landing pages</label>
                    </div>
                    {{--<div class="col-md-6">
                        <div class="form-group">
                            <input name="" type="text" class="form-control">
                        </div>
                    </div>--}}
                </form>
            </div>
            <div role="tabpanel" class="tab-pane fade in" id="profile">..asc</div>
        </div>

    </div>
    </div>

    <div class="col-md-10">
        <button id="sendForm" type="submit" class="btn btn-success btn-sm pull-right" >Uložiť
        </button>
    </div>
@stop

@section('custom_scripts') {{--JS specified only for this site--}}

<script>
    $(function(){
    	$('#sendForm').on('click', function(){
    	    $('#finalForm').submit();
        });
    });
    $('#nav-settings').addClass('active');
    $('#myTabs a').click(function (e) {
        e.preventDefault();
        $(this).tab('show')
    });
    $('#myTabs a:first').tab('show'); // Select first tab
    $('#myTabs a:last').tab('show'); // Select last tab
</script>
@stop