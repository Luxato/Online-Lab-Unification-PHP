@extends('master')

@section('title')
    Aktuality
@stop

@section('content')
    <style>
        [class*="col-"] {
            float: none;
            display: table-cell;
            vertical-align: top;
        }
    </style>
    <h1>Aktuality</h1>
    <div class="container">
        <div class="row" style="display: table;">
            <div class="col-md-4">
                <div class="featured-image">
                    <a href="#">
                        <img src="http://uniqmag.different-themes.com/html/demo/block-layout-4/2.jpg" alt="">
                    </a>
                    <div class="featured-misc">
                        <h2><a href="#">Lorem ipsum dolor sit amet</a></h2>
                        <div class="featured-date">Feb 20, 2017</div>
                    </div>
                </div>

                <div class="news">
                    <div class="news-image">
                        <a href="#"><img src="http://uniqmag.different-themes.com/html/demo/block-layout-2/13.jpg"
                                         alt=""></a>
                    </div>
                    <div class="news-headline"><a href="#"><h3>Lorem ipsum dolot sit amet</h3></a></div>
                    <div class="news-date">Feb 20, 2017</div>
                </div>

                <div class="news">
                    <div class="news-image">
                        <a href="#"><img src="http://uniqmag.different-themes.com/html/demo/block-layout-2/13.jpg"
                                         alt=""></a>
                    </div>
                    <div class="news-headline"><a href="#"><h3>Lorem ipsum dolot sit amet</h3></a></div>
                    <div class="news-date">Feb 20, 2017</div>
                </div>

                <div class="news">
                    <div class="news-image">
                        <a href="#"><img src="http://uniqmag.different-themes.com/html/demo/block-layout-2/13.jpg"
                                         alt=""></a>
                    </div>
                    <div class="news-headline"><a href="#"><h3>Lorem ipsum dolot sit amet</h3></a></div>
                    <div class="news-date">Feb 20, 2017</div>
                </div>

            </div>
            <div class="col-md-4">
                <div class="featured-image">
                    <a href="#">
                        <img src="http://uniqmag.different-themes.com/html/demo/block-layout-4/2.jpg" alt="">
                    </a>
                    <div class="featured-misc">
                        <h2><a href="#">Lorem ipsum dolor sit amet</a></h2>
                        <div class="featured-date">Feb 20, 2017</div>
                    </div>
                </div>
                <div class="news">
                    <div class="news-image">
                        <a href="#"><img src="http://uniqmag.different-themes.com/html/demo/block-layout-2/13.jpg"
                                         alt=""></a>
                    </div>
                    <div class="news-headline"><a href="#"><h3>Lorem ipsum dolot sit amet</h3></a></div>
                    <div class="news-date">Feb 20, 2017</div>
                </div>

                <div class="news">
                    <div class="news-image">
                        <a href="#"><img src="http://uniqmag.different-themes.com/html/demo/block-layout-2/13.jpg"
                                         alt=""></a>
                    </div>
                    <div class="news-headline"><a href="#"><h3>Lorem ipsum dolot sit amet</h3></a></div>
                    <div class="news-date">Feb 20, 2017</div>
                </div>

                <div class="news">
                    <div class="news-image">
                        <a href="#"><img src="http://uniqmag.different-themes.com/html/demo/block-layout-2/13.jpg"
                                         alt=""></a>
                    </div>
                    <div class="news-headline"><a href="#"><h3>Lorem ipsum dolot sit amet</h3></a></div>
                    <div class="news-date">Feb 20, 2017</div>
                </div>
            </div>
            <div class="col-md-2 widget">
                <select class="selectpicker" data-style="btn-warning">
                    <option value="0">Nezaradené</option>
                    <option value="1">Zaradene</option>
                </select>
                <h2 style="margin-top: 10px; margin-bottom:0;">Archív</h2>
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
			