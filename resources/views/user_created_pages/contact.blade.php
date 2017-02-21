@extends('master')

@section('title')
    Kontakt
@stop

@section('content')
    <h1>Kontakt</h1>
    <i class="fa fa-map-marker" aria-hidden="true" style="font-size: 25px; float: left;"></i>
    <address style="margin-left: 25px;">
        <div class="address-line strong">Fakulta elektrotechniky a informatiky</div>
        <div class="address-line">Ilkovičova 3 </div>
        <div class="address-line">812 19 Bratislava 1 </div>
        <div class="address-line">Slovenská republika </div>
        <div class="address-line"><a target="_blank" href="http://www.fei.stuba.sk">www.fei.stuba.sk</a> </div>
    </address>
    <i class="fa fa-envelope" aria-hidden="true" style="font-size: 19px; float: left;"></i>
    <div style="margin-left: 25px;"><a href="mailto:zakova@is.stuba.sk">katarina.zakova@stuba.sk</a></div>
    <div id="map" style="width: 100%; height: 400px;"></div>
    <script>
        var map;
        function initMap() {
            var stufei = {lat: 48.151965, lng: 17.072995};
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 15,
                center: stufei
            });
            var marker = new google.maps.Marker({
                position: stufei,
                map: map
            });
        }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAHVpII9dUxzd4518mCYhIYsIyDkfdG8Mc&callback=initMap">
    </script>
@stop