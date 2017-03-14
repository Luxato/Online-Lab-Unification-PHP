@extends('administration/adminmaster')

@section('title')
    Pridať novú aktualitu
@stop

@section('custom_css')
    <link rel="stylesheet"
          href="<?= URL::to( '/' ); ?>/assets/administration/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
@stop


@section('content')
    <br>
    <div class="row">
        <form id="new-page-form" onsubmit="return validateForm()" action="<?= URL( 'admin/news/' ) ?>" method="POST">
            <input name="_token" type="hidden" id="_token" value="{{ csrf_token() }}"/>
            <div id="dateRange"></div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputEmail1">Nadpis</label>
                    <input id="title-input" class="form-control" name="name" type="text"
                           placeholder="Zadajte nadpis sem" required="">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Jazyk</label>
                    <select id="languageSelection" name="language" class="form-control" required="">
						<?php foreach($languages as $language): ?>
                        <option value="<?= $language->id ?>"><?= $language->language_title ?></option>
						<?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group" style="height: 59px;">
                    <label for="exampleInputEmail1">Do kedy je aktualita aktuálna</label>
                    <br>
                    <input id="infinityCheckbox" type="checkbox" name="infinity" value="on" checked> Navždy
                    <div id="reportrange" class="disabled pull-right"
                         style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                        <span></span> <b class="caret"></b>
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Kategória</label>
                    <select id="categorySelection" name="category" class="form-control" required="">
						<?php foreach($categories as $category): ?>
                        <option value="<?= $category->id ?>"><?= $category->name ?></option>
						<?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="exampleInputEmail1">Obsah</label>
                    <textarea id="editor" name="cont" rows="6" cols="80">
                    </textarea>
                </div>
            </div>

            <div id="another-lang"></div>

            <div class="col-md-12">
                <button type="submit" class="btn btn-success btn-lg pull-right" style="width: 49%;">Vytvoriť</button>
            </div>
        </form>
    </div>
@stop

@section('custom_scripts')
    <script src="<?= URL::to( '/' ); ?>/assets/administration/plugins/ckeditor/ckeditor.min.js"></script>
    <script>
        CKEDITOR.replace('editor');
        $(function () {
            $('#nav-news').addClass('active');

            var start = moment().subtract(29, 'days');
            var end = moment();

            function cb(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Dnes': [moment(), moment()],
                    'Tento mesiac': [moment().startOf('month'), moment().endOf('month')]
                }
            }, cb);
            cb(start, end);
            $('#infinityCheckbox').on('change', function(){
                $('#reportrange').toggleClass('disabled');
            });
        });


        var startDate = 0;
        var endDate = 0;
        /*$('#reportrange').change(function(){
         startDate = $('input[name="daterangepicker_start"]')[0].value;
         console.log('nastala zmena');
         });*/
        /*$('input[name="daterangepicker_end"]').on('change', function(){
         endDate = $(this)[0].value;
         });*/
        function validateForm() {
            var dateRange = $('#dateRange');
            dateRange.empty();
            dateRange.append('<input name="startDate" type="hidden" id="startDate" value="' +
                $('input[name="daterangepicker_start"]')[0].value + '">' +
                '<input name="endDate" type="hidden" id="endDate" value="' +
                $('input[name="daterangepicker_end"]')[0].value
                + '">');
            return true;
        }
    </script>
@stop