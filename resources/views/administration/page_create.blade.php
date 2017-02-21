@extends('administration/adminmaster')

@section('title')
    Pridať novú stránku
@stop

@section('custom_css')
    <link rel="stylesheet"
          href="<?= URL::to( '/' ); ?>/assets/administration/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
@stop


@section('content')
    <div class="row">
        <form id="new-page-form" action="<?= URL( 'admin/_pages/' ) ?>" method="POST">
            <input name="_token" type="hidden" id="_token" value="{{ csrf_token() }}"/>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="exampleInputEmail1">Nadpis</label>
                    <input id="title-input" class="form-control" name="title" type="text"
                           placeholder="Zadajte nadpis sem">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">URL</label>
                    <input id="url-input" class="form-control" name="url" type="text" placeholder="URL">
                </div>
                <div class="form-group">
                    <label>Lokalizácia</label>
                    <select name="language" class="form-control">
						<?php foreach($languages as $value): ?>
                        <option value="<?= $value->id  ?>"><?= $value->language_title ?></option>
						<?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputEmail1">SEO nadpis</label>
                    <input class="form-control" type="text" placeholder="SEO nadpis">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">SEO popis</label>
                    <textarea class="form-control" rows="3" placeholder="SEO popis"></textarea>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Kľúčové slová</label>
                    <input class="form-control" type="text" placeholder="Kľúčové slová oddelené čiarkou">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="exampleInputEmail1">Obsah</label>
                    <textarea id="editor1" name="slovak" rows="10" cols="80">
                    </textarea>
                </div>
            </div>
            <button id="addLanguage" class="btn btn-info btn-lg" style="width: 49%; float: left; margin-right: 10px;">Pridať jazykovú mutáciu</button>
            <button type="submit" class="btn btn-success btn-lg" style="width: 49%;">Vytvoriť</button>
        </form>
    </div>
@stop

@section('custom_scripts')
    <script src="<?= URL::to( '/' ); ?>/assets/administration/plugins/ckeditor/ckeditor.min.js"></script>
    <script>
        CKEDITOR.replace('editor1');
        /*CKEDITOR.replace('editor2');*/
        $(function () {
            $('#nav-navigacia').addClass('active');
            // TODO REMOVE ľíéšášľťéľížýľš AND !@#$%$^%&&&&&&&&&*)/*-+
            $('#title-input').on('keyup', function () {
                var title = $(this).val();
                title = title.toLowerCase();
                title = title.trim();
                title = title.replace(/ /g, "_");
                for (var i = 0, max = title.length; i < max - 1; i++) {
                    if (title[i] == '_' && title[i + 1]) {
                        console.log('true');
                        title = title.replace("__", "_");
                    }
                }
                title = diaConvert(title);
                $('#url-input').val(title);
            });
        });

        var dia = "áäčďéíľĺňóôŕšťúýÁČĎÉÍĽĹŇÓŠŤÚÝŽ";
        var nodia = "aacdeillnoorstuyACDEILLNOSTUYZ";

        function diaConvert(text) {
            var convertText = "";
            for (var i = 0; i < text.length; i++) {
                if (dia.indexOf(text.charAt(i)) != -1) {
                    convertText += nodia.charAt(dia.indexOf(text.charAt(i)));
                }
                else {
                    convertText += text.charAt(i);
                }
            }
            return convertText;
        }

    </script>
@stop