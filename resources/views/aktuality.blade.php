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
                    <div class="col-md-4" style="float: left;margin-bottom: 20px;">
                        <div class="featured-image">
                            <a href="#">
                                <img src="http://uniqmag.different-themes.com/html/demo/block-layout-4/2.jpg" alt="">
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
                <select class="selectpicker" data-style="btn-warning">
                    <?php foreach($categories as $category): ?>
                        <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                    <?php endforeach; ?>
                </select>
                <h2 style="margin-top: 10px; margin-bottom:0;"><?= trans( 'translation.archive' ) ?></h2>
                <div class="months">
                    <ul>
                        <li><a href="#">Januar 2017</a></li>
                        <li><a href="#">Februar 2017</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@stop
			