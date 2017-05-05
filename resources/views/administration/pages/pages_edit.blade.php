@extends('administration/adminmaster')

@section('title')
    Upraviť stránku
@stop

@section('custom_css')
    <link rel="stylesheet" href="<?= url( 'assets/css/switchery.min.css' ) ?>">
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.3/summernote.css" rel="stylesheet">
@stop


@section('content')
    <div class="row">
        <form id="new-page-form" onsubmit="return validateForm()" action="<?= URL( 'admin/pages/' ) ?>" method="POST">
            <input name="_token" type="hidden" id="_token" value="{{ csrf_token() }}"/>
            <div class="col-lg-12">
                <div class="form-group">
                    <i data-toggle="tooltip"
                       title="Ak stránka nemá mať žiaden obsah, teda bude v navigácii, ale nebude sa ňu to dať klikať"
                       class="fa fa-question-circle" aria-hidden="true"></i>
                    <label for="noContent">Stránka bez obsahu</label>
                    <input id="noContent" name="noContent" type="checkbox" class="js-switch js-check-change">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="exampleInputEmail1">Nadpis</label>
                    <input id="title-input" class="form-control" name="name[]" type="text"
                           placeholder="Zadajte nadpis sem" required="" value="<?= $page['feature'][0]['title'] ?>">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">URL</label>
                    <input id="url-input" class="form-control" name="url[]" type="text" placeholder="URL" required=""
                           value="<?= $page['feature'][0]['controller'] ?>">
                </div>
                <div class="form-group">
                    <label>Lokalizácia</label>
                    <select id="languageSelection" name="language[]" class="form-control" required="">
						<?php foreach($languages as $value): ?>
                        <option value="<?= $value['id']  ?>" <?= $page['feature'][0]['language_id'] == $value['id'] ? 'selected' : '' ?>><?= $value['language_title'] ?></option>
						<?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputEmail1">SEO nadpis</label>
                    <input class="form-control disabled" type="text" placeholder="SEO nadpis">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">SEO popis</label>
                    <textarea class="form-control disabled" rows="3" placeholder="SEO popis"></textarea>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Kľúčové slová</label>
                    <input class="form-control disabled" type="text" placeholder="Kľúčové slová oddelené čiarkou">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="exampleInputEmail1">Obsah</label>
                    <textarea class="editor" id="editor" name="cont[]" rows="6" cols="80">
                        <?=  isset( $page['feature'][0]['content'] ) ? htmlspecialchars( $page['feature'][0]['content'] ) : '' ?>
                    </textarea>
                </div>
            </div>

            <div id="another-lang">
                <?php $i = 0; foreach($page['feature'] as $feature): ?>
                    <?php
                        if ($i == 0) {
                            $i++;
                            continue;
                        }
                    ?>
                    <div id="langSection<?= $i ?>" class="lang-section">
                        <hr>
                        <h2>Ďalšia jazyková mutácia</h2>
                        <div class="cancelLang"><i class="fa fa-times" aria-hidden="true"></i></div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nadpis</label>
                                <input class="form-control" name="name[]" type="text" placeholder="Zadajte nadpis sem" required="" value="<?= $feature['title'] ?>">
                                </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">URL</label>
                                <input class="form-control" name="url[]" type="text" placeholder="URL" required="" value="<?= $feature['controller'] ?>">
                                </div>
                            <div class="form-group">
                                <label>Lokalizácia</label>
                                <select id="-langSelection" name="language[]" class="form-control" required="">
                                    <?php foreach($languages as $value): ?>
                                    <option value="<?= $value['id']  ?>" <?= $feature['language_id'] == $value['id'] ? 'selected' : '' ?>><?= $value['language_title'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                </div>
                            </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">SEO nadpis</label>
                                <input class="form-control disabled" type="text" placeholder="SEO nadpis">
                                </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">SEO popis</label>
                                <textarea class="form-control disabled" rows="3" placeholder="SEO popis"></textarea>
                                </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Kľúčové slová</label>
                                <input class="form-control disabled" type="text" placeholder="Kľúčové slová oddelené čiarkou">
                                </div>
                            </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Obsah</label>
                                <textarea class="editor" id="editor <?= $i ?>" name="cont[]" rows="6" cols="80">
                                    <?= $feature['content'] ?>
                                </textarea>
                                </div>
                            </div>
                        </div>
                <?php endforeach; ?>
            </div>

            <div class="col-md-12">
                <button id="addLanguage" class="btn btn-info btn-lg"
                        style="width: 49%; float: left; margin-right: 10px;">Pridať jazykovú mutáciu
                </button>
                <button type="submit" class="btn btn-success btn-lg" style="width: 49%;">Upraviť</button>
            </div>
        </form>
    </div>
@stop

@section('custom_scripts')
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.3/summernote.js"></script>
    <script src="<?= url( 'assets/js/switchery.min.js' ) ?>"></script>
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

        var elem = document.querySelector('.js-switch');
        var switchery = new Switchery(elem, {size: 'small'});
        var changeCheckbox = document.querySelector('.js-switch');
        var p = 0;
        changeCheckbox.onchange = function () {
            p++;
            if (p % 2 == 1) {
                $('#new-page-form').parsley().destroy();
                $('#addLanguage').hide();
                console.log('test');
                $('.lang-section').remove();
                $(":input").each(function () {
                    $(this).addClass('disabled');
                });
                $('#title-input').removeClass('disabled');
                $('#languageSelection').removeClass('disabled');
                $(':submit').removeClass('disabled');
                $('#cke_editor').hide();
            } else {
                $('#cke_editor').show();
                $('#addLanguage').removeClass('btn-disabled');
                $('#new-page-form').parsley();
                $('#addLanguage').show();
                maxLanguages = $('#languageSelection').children('option').length - 2;
                var i = 0;
                $(":input").each(function () {
                    $(this).removeClass('disabled');
                });
            }
        };

        function hasDuplicates(array) {
            return (new Set(array)).size !== array.length;
        }
        function validateForm() {
            var selectedValues = [];
            for (var box in selectBoxes) {
                //console.log(selectBoxes[box].id);
                selectedValues.push($(selectBoxes[box].id + ' option:selected')[0]['value']);
            }
            console.log(selectedValues);
            if (hasDuplicates(selectedValues)) {
                generate('warning', '<div class="activity-item"> <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <div class="activity">Vyplnené jazyky v lokalizácii musia byť rôzne a zároveň musia byť zvolené.</div> </div>');
                return false;
            } else {
                return true;
            }
        }

        $(function () {
            $('#new-page-form').parsley().on('field:validated', function () {
                var ok = $('.parsley-error').length === 0;
                $('.bs-callout-info').toggleClass('hidden', !ok);
                $('.bs-callout-warning').toggleClass('hidden', ok);
            });

            $('#nav-navigacia').addClass('active');
            // TODO REMOVE !@#$%$^%&&&&&&&&&*)/*-+
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

        var i = <?= sizeof($page['feature']) ?>;
        var maxLanguages = $('#languageSelection').children('option').length - 2;
        console.log(i);
        console.log(maxLanguages);
        if($('#languageSelection').children('option').length == i) {
            $('#addLanguage').addClass('btn-disabled');
        }
        $('#addLanguage').on('click', function (e) {
            e.preventDefault();
            if (maxLanguages <= 0) {
                return;
            }
            i++;
            addLangSection(i);
            maxLanguages--;
            if (maxLanguages == 0) {
                $('#addLanguage').addClass('btn-disabled');
            }
        });

        selectBoxes = [];
        selectBoxes.push({
            'id': '#languageSelection',
            'index': 0
        });

        function addLangSection(i) {
            var newLang =
                '<div id="langSection' + i + '" class="lang-section" style="display:none;">' +
                '<hr> ' +
                '<h2>Ďalšia jazyková mutácia</h2>' +
                '<div class="cancelLang"><i class="fa fa-times" aria-hidden="true"></i></div>' +
                '<div class="col-lg-6">' +
                '<div class="form-group">' +
                '<label for="exampleInputEmail1">Nadpis</label>' +
                '<input class="form-control" name="name[]" type="text" placeholder="Zadajte nadpis sem" required="">' +
                '</div>' +
                '<div class="form-group">' +
                '<label for="exampleInputEmail1">URL</label>' +
                '<input class="form-control" name="url[]" type="text" placeholder="URL" required="">' +
                '</div>' +
                '<div class="form-group">' +
                '<label>Lokalizácia</label>' +
                '<select id="' + i + '-langSelection" name="language[]" class="form-control" required="">' +
                '</select>' +
                '</div>' +
                '</div>' +
                '<div class="col-md-6">' +
                '<div class="form-group">' +
                '<label for="exampleInputEmail1">SEO nadpis</label>' +
                '<input class="form-control disabled" type="text" placeholder="SEO nadpis">' +
                '</div>' +
                '<div class="form-group">' +
                '<label for="exampleInputEmail1">SEO popis</label>' +
                '<textarea class="form-control disabled" rows="3" placeholder="SEO popis"></textarea>' +
                '</div>' +
                '<div class="form-group">' +
                '<label for="exampleInputEmail1">Kľúčové slová</label>' +
                '<input class="form-control disabled" type="text" placeholder="Kľúčové slová oddelené čiarkou">' +
                '</div>' +
                '</div>' +
                '<div class="col-md-12">' +
                '<div class="form-group">' +
                '<label for="exampleInputEmail1">Obsah</label>' +
                '<textarea class="editor" id="editor' + i + '" name="cont[]" rows="6" cols="80">' +
                '</textarea>' +
                '</div>' +
                '</div>' +
                '</div>';
            $('#another-lang').append(newLang);
            initEditor();
            $('#langSection' + i).fadeIn('slow');
            var offset = $('#langSection' + i).offset();
            $('html, body').stop().animate({
                scrollTop: offset.top
            });

            selectBoxes.push({
                'id': '#langSection' + '' + i
            });

            $('#languageSelection option').each(function (index) {
                $('#' + i + '-langSelection').append($('<option>', {
                    value: $(this)[0].value,
                    text: $(this).text()
                }));
            });

            //Reinitialize validator
            $('#new-page-form').parsley().on('field:validated', function () {
                var ok = $('.parsley-error').length === 0;
                $('.bs-callout-info').toggleClass('hidden', !ok);
                $('.bs-callout-warning').toggleClass('hidden', ok);
            });
        }

        $(document).on('click', 'div.cancelLang', function () {
            var langSection = $(this).closest('div.lang-section');
            langSection.fadeOut('slow', function () {
                langSection.remove();
            });
            maxLanguages++;
            console.log(maxLanguages);
            $('#addLanguage').removeClass('btn-disabled');
        });

        function Worker() {
            this.numberOfInstances = 0;
            this.init = function () {
            };
            this.reorder = function () {

            };
            this.languages = function () {
                this.numberOfInstances++;
                var allowedLanguages = [];
                for (var index in selectBoxes) {
                    console.log('selectBoxes length = ' + selectBoxes.length);
                    if (index != 0 && (selectBoxes.length - 1 == this.numberOfInstances)) {
                        console.log('zapisujem nasledovne optiony ');
                        console.log(allowedLanguages);
                        for (var key in allowedLanguages) {
                            $(selectBoxes[index].id).append($('<option>', {
                                value: allowedLanguages[key].id,
                                text: allowedLanguages[key].language
                            }));
                        }
                    }
                    var tmp = selectBoxes[index].id;
                    var allowedLanguages = [];
                    $(selectBoxes[index].id + ' option:not(:selected)').each(function (index) {
                        allowedLanguages.push({
                            'id': tmp,
                            'language': $(this).text()
                        });
                    });
                }

            };
            this.init();
        }
    </script>
@stop