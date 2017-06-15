@extends('administration/adminmaster')

@section('title')
    Nástenka
@stop

@section('content')
    <form id="dashForm" action="" method="GET">
        <input name="_token" type="hidden" id="_token" value="{{ csrf_token() }}"/>
        <input name="days" id="days" type="hidden">
    </form>
    <h2>Štatistiky webslužieb</h2>
    <button id="7" type="button" class="btn <?= isset($_GET['days']) ? $_GET['days'] == 7 ? 'btn-success' : 'btn-info' : 'btn-success'?>">Posledných 7 dní</button>
    <button id="30" type="button" class="btn <?= isset($_GET['days']) ? $_GET['days'] == 30 ? 'btn-success' : 'btn-info' : 'btn-info'?>">Posledných 30 dní</button>
    <button id="all" type="button" class="btn <?= isset($_GET['days']) ? $_GET['days'] == 'all' ? 'btn-success' : 'btn-info' : 'btn-info'?>">Celý čas</button>
    <div id="hero-bar" style="height: 250px;"></div>
@stop

@section('custom_scripts') {{--JS specified only for this site--}}
<script>
    $(function(){
        $('button').on('click', function() {
           $('#days').val($(this).attr('id'));
           $('#dashForm').submit();
        });
        $('#nav-dashboard').addClass('active');
        Morris.Bar({
            element: 'hero-bar',
            data: [
                <?php foreach($statistics as $project): ?>
                    {project: '<?= $project['service'] ?>', requests: <?= $project['counter'] ?>},
                <?php endforeach; ?>
            ],
            xkey: 'project',
            ykeys: ['requests'],
            labels: ['Počet requestov'],
            barRatio: 0.4,
            gridIntegers: true,
            ymin: 0,
            xLabelAngle: 0,
            hideHover: 'auto'
        });
    });
</script>
@stop