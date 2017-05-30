@extends('administration/adminmaster')

@section('title')
    Nastavenia
@stop

@section('custom_css') {{--CSS specified only for this site--}}
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
                <form name="finalForm" id="finalForm" action="<?= URL( 'admin/settings/' ) ?>" method="POST" data-parsley-validate="">
                    <input name="_token" type="hidden" id="_token" value="{{ csrf_token() }}"/>
                    <div class="col-md-6">
                        <br>
                        <h2>Zmena hesla administrátora</h2>
                        <div class="form-group">
                            <label>Nové heslo</label>
                            <input name="password" type="password" class="form-control" placeholder="Nové heslo" data-parsley-minlength="6">
                        </div>
                        <div class="form-group">
                            <label>Nové heslo znovu</label>
                            <input name="password_confirmation" type="password" class="form-control" placeholder="Nové heslo znovu" data-parsley-minlength="6">
                        </div>
                        <br>
                        <h2>Defaultný jazyk stránky</h2>
                        <p>Nastavenie hlavného jazyka stránky.</p>
                        <select id="languageSelection" name="language" class="form-control" required="">
                            <?php foreach($languages as $language): ?>
                            <option <?= $default_lang == $language->language_shortcut ? 'selected' : '' ?> value="<?= $language->language_shortcut ?>"><?= $language->language_title ?></option>
                            <?php endforeach; ?>
                        </select>
                        <br>
                        <h2>Landing pages</h2>
                        <p>Pre každú jazykovú mutáciu je možné nastaviť pristávaciu stránku.</p>
                        <table class="table table-hover">
                            <thead>
                                <th>Lokalizácia</th>
                                <th>Landing page</th>
                            </thead>
                            <tbody>
                                 <?php foreach($languages as $language):?>
                                    <tr>
                                        <td><?= $language->language_title ?></td>
                                        <td>
                                            <select name="landing_pages[]" class="form-control">
                                                <?php foreach($pages as $page):?>
                                                    <?php if(isset($page->language_shortcut)): ?>
                                                        <?php if($language->language_shortcut == $page->language_shortcut): ?>
                                                        <option value="<?= $language->language_shortcut . '_' . $page->section_id ?>" <?= isset($default_pages[$language->language_shortcut]) ? $default_pages[$language->language_shortcut] == $page->section_id ? 'selected' : '' : '' ?>>
                                                            <?= $page->title ?></option>
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                    <option value="<?= $language->language_shortcut . '_' . $page->section_id ?>" <?= isset($default_pages[$language->language_shortcut]) ? $default_pages[$language->language_shortcut] == $page->section_id ? 'selected' : '' : 'selected' ?>>
                                                        <?= $page->title ?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            <div role="tabpanel" class="tab-pane fade in" id="profile">..asc</div>
            <div class="col-md-12">
                <button id="sendForm" type="submit" class="btn btn-success btn-md pull-right" >Uložiť
                </button>
            </div>
        </div>
    </div>
    </div>

@stop

@section('custom_scripts') {{--JS specified only for this site--}}

<script>
    $(function () {
        $('#finalForm').parsley().on('field:validated', function() {
            var ok = $('.parsley-error').length === 0;
            $('.bs-callout-info').toggleClass('hidden', !ok);
            $('.bs-callout-warning').toggleClass('hidden', ok);
        })
    });
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