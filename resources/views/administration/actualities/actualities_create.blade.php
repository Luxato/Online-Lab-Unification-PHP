@extends('administration.adminmaster')

@section('title')
    Pridať novú aktualitu
@stop

@section('custom_css')
    <link rel="stylesheet" href="<?= URL::to( '/' ); ?>/assets/administration/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.3/summernote.css" rel="stylesheet">
@stop


@section('content')
    <br>
    <div class="row">
        <form id="new-page-form" onsubmit="return validateForm()" action="<?= URL( 'admin/actualities/' ) ?>" method="POST" enctype="multipart/form-data">
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
                    <div class="form-group">
                        <br>
                        <label class="control-label">Upload thumbnailu</label>
                        <input name="thumbnail" type="file" class="file">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="categorySelection">Kategória</label>
                    <select id="categorySelection" name="category" class="form-control" required="">
                        <option value="new" >Vytvoriť novú</option>
						<?php foreach($categories as $category): $i = 0;?>
                        <option <?php echo $i == 0 ? 'selected' : $i++ ?> value="<?= $category->id ?>"><?= $category->name ?></option>
						<?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>alebo vytvoriť novú</label>
                    <input id="newCategory" name="newCategory" class="form-control" type="text" value="">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="exampleInputEmail1">Obsah</label>
                    <textarea class="editor" id="editor" name="cont" rows="6" cols="80" ></textarea>
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
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.3/summernote.js"></script>
    <script>
        function initEditor(){
            $('.editor').summernote({
                height: 150,   //set editable area's height
                codemirror: { // codemirror options
                    theme: 'monokai'
                }
            });
        }
        $(function(){
            initEditor();
        });
    </script>

    <script>
        $(function () {
            $('#newCategory').attr('readonly', true);
            $('#categorySelection').change(function () {
               if ($( "#categorySelection option:selected" ).val() == 'new') {
                   $('#newCategory').attr('readonly', false);
               } else {
                   $('#newCategory').attr('readonly', true);
               }
            });
            $('#nav-news').addClass('active');

            function cb(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }
        });


        var startDate = 0;
        var endDate = 0;
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