@extends('administration/adminmaster')

@section('title')
    Vytvoriť jazyk
@stop

@section('custom_css') {{--CSS specified only for this site--}}
<link rel="stylesheet" href="<?= URL::to( '/' ); ?>/assets/administration/css/dataTables.bootstrap.css">
@stop


@section('content')
    <div class="row form-group">
        <div class="col-xs-12">
            <ul class="nav nav-pills nav-justified thumbnail setup-panel">
                <li id="firstStep" class="active"><a href="#step-1">
                        <h4 class="list-group-item-heading">Krok 1</h4>
                        <p class="list-group-item-text">Vyplnenie informácií o jazyku</p>
                    </a></li>
                <li class="disabled"><a href="#step-2">
                        <h4 class="list-group-item-heading">Krok 2</h4>
                        <p class="list-group-item-text">Preklad</p>
                    </a></li>
            </ul>
        </div>
    </div>
    <form id="langCreate">
        <div class="row setup-content" id="step-1">
            <div class="col-xs-12">
                <div class="col-md-12 well text-center">
                    <h1>Krok 1</h1>
                    <div class="col-lg-6 col-lg-offset-3">
                        <div class="form-group">
                            <input id="title-input" class="form-control" name="title" type="text"
                                   placeholder="Jazyk napr. Slovenčina" required="">
                        </div>
                        <div class="form-group">
                            <input id="url-input" class="form-control" name="shortcut" type="text"
                                   placeholder="Skratka jazyka napr. sk" required="">
                        </div>
                        <button id="activate-step-2" class="btn btn-primary btn-sm pull-right">Ďalej</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
        <div class="row setup-content" id="step-2">
            <div class="col-xs-12">
                <div class="col-md-12 well">
                    <div class="col-lg-6 col-lg-offset-3">
                        <form name="finalForm" id="finalForm" action="<?= URL::to( '/worker/do_create_language' ); ?>" method="POST">
                            <input name="_token" type="hidden" id="_token" value="{{ csrf_token() }}">
                            <h1 class="text-center">Krok 2</h1>
                            <div class="col-md-6"></div>
                            <div class="col-md-6"></div>
							<?php foreach($translations as $value): ?>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input name="key[]" class="form-control" type="text" value="<?= $value['field'] ?>"
                                           readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input name="value[]" type="text" class="form-control">
                                </div>
                            </div>
							<?php endforeach; ?>
                            <div class="col-md-6"></div>
                            <button id="sendForm" type="submit" class="btn btn-success btn-sm pull-right">Vytvoriť
                            </button>
                        </form>
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
        $('#langCreate').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
            $('.bs-callout-info').toggleClass('hidden', !ok);
            $('.bs-callout-warning').toggleClass('hidden', ok);
        });

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
    $(document).ready(function () {
        $('#activate-step-2').on('click', function () {
            if ($(".data").is('*')) {
                $(".data").empty();
            }
             $('#finalForm').append("<div id='data'> <input name='title' style='display:none;' value='"+$('#title-input')[0].value+"'> " +
                 " <input name='shortcut' style='display:none;' value='"+$('#url-input')[0].value+"'> "+
                 "</div>");
        });

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

        $('#firstStep').on('click', function () {
            $('ul.setup-panel li:eq(1)').addClass('disabled');
        });

        $("#langCreate").on('submit', function (e) {
            e.preventDefault();
            var form = $(this);
            form.parsley().validate();
            if (form.parsley().isValid()) {
                $('ul.setup-panel li:eq(1)').removeClass('disabled');
                $('ul.setup-panel li a[href="#step-2"]').trigger('click');
            }
        });
    });
</script>
@stop