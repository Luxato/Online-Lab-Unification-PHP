@extends('master')

@section('title')
	<?= trans( 'translation.actualities' ) ?>
@stop

@section('content')
    <style>
        [class*="col-"] {
            float: none;
            display: table-cell;
            vertical-align: top;
        }
    </style>
    <h1><?= trans( 'translation.actualities' ) ?></h1>
    <div class="container">
        <div class="row" style="display: table;">
            <div class="col-md-9">
                <?php foreach($actualities as $actuality): ?>
                    <div class="actuality category-<?= $actuality->catID ?> col-md-4" style="float: left;margin-bottom: 20px;">
                        <div class="featured-image">
                            <a href="#">
                                <img src="<?= $actuality->thumbnail_path ?>" alt="">
                            </a>
                            <div class="featured-misc">
                                <h2><a href="<?= url('aktualita/'. $actuality->id .'') ?>"><?= $actuality->name ?></a></h2>
                                <div class="featured-date"><?= $actuality->created_at ?></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="col-md-2 widget">
                <select id="categoryPicker" class="selectpicker" data-style="btn-warning">
                    <?php foreach($categories as $category): ?>
                        <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                    <?php endforeach; ?>
                </select>
                <h2 style="margin-top: 10px; margin-bottom:0;"><?= trans( 'translation.archive' ) ?></h2>
                <div class="months">
                    <ul>
                        <li><a class="disabled" href="#">Januar 2017</a></li>
                        <li><a class="disabled" href="#">Februar 2017</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@stop
@section('custom_bottom_scripts')
    <script>
        $(function(){
            onchange();
        });
        $('#categoryPicker').on('change', function () {
            onchange();
        });
        function onchange() {
            var actualities = $('.actuality');
            var defaultCat  = $( "#categoryPicker option:selected" )[0].value;
            for (var i in actualities) {
                var classes = $(actualities[i]).attr('class').split(/\s+/);
                var hide = true;
                for (var k in classes) {
                    if (classes[k].substring(0, 8) == 'category') {
                        var tmp = classes[k].split('-');
                        var category = tmp[1];
                        console.log('porovnavam ' + category + ' a ' + defaultCat);
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