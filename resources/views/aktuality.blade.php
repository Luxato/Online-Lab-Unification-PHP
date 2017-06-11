@extends('master')

@section('title')
	<?= trans( 'translation.actualities' ) ?>
@stop

@section('content')
    <style>
        @media screen and (min-width: 1200px) {
            .actualities [class*="col-"] {
                float: none;
                display: table-cell;
                vertical-align: top;
            }
        }
    </style>
    <h1><?= trans( 'translation.actualities' ) ?></h1>
    <div class="container">
        <div class="row actualities">
            <div class="col-xs-12 col-lg-2 widget">
                <select id="categoryPicker" class="selectpicker" data-style="btn-warning">
                    <option selected value="all"><?= trans('translation.all_actualities') ?></option>
			        <?php foreach($categories as $category): ?>
                    <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
			        <?php endforeach; ?>
                </select>
                <!--<h2 style="margin-top: 10px; margin-bottom:0;"><?= trans( 'translation.archive' ) ?></h2>
                <div class="months">
                    <ul>
                        <li><a class="disabled" href="#">Januar 2017</a></li>
                        <li><a class="disabled" href="#">Februar 2017</a></li>
                    </ul>
                </div>-->
            </div>
            <div class="col-xs-12 col-lg-10">
                <?php if(sizeof($actualities) == 0): ?>
                	<?= trans('translation.empty_actualities') ?>
                <?php endif; ?>
                <?php foreach($actualities as $actuality): ?>
                    <div class="actuality cat category-<?= $actuality->catID ?> col-md-4" style="float: left;margin-bottom: 20px;">
                        <div class="featured-image">
                            <a href="<?= url('aktualita/'. $actuality->id .'') ?>">
                                <img width="252" height="182" src="<?= $actuality->thumbnail_path ?>" alt="">
                            </a>
                            <div style="color: white;" class="featured-misc">
                                <a href="<?= url('aktualita/'. $actuality->id .'') ?>"><h2 style="color: #fff;"><?= $actuality->name ?></h2>
                                <div class="featured-date"><?= $actuality->created_at ?></div></a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
@stop
@section('custom_bottom_scripts')
    <script>
        $('#categoryPicker').on('change', function () {
            onchange();
        });
        function onchange() {
            var actualities = $('.actuality.cat');
            var defaultCat  = $( "#categoryPicker option:selected" )[0].value;
            for (var i = 0, max = actualities.length; i < max; i++) {
                if (defaultCat == 'all') {
                    $(actualities[i]).slideDown();
                    continue;
                }
                var classes = $(actualities[i]).attr('class').split(/\s+/);
                var hide = true;
                for (var k in classes) {
                    if (classes[k].substring(0, 8) == 'category') {
                        var tmp = classes[k].split('-');
                        var category = tmp[1];
                        if (category == defaultCat) {
                            hide = false;
                        }
                    }
                }
                if (hide) {
                    $(actualities[i]).slideUp();
                } else {
                    $(actualities[i]).slideDown();
                }
            }
        }
    </script>
@stop