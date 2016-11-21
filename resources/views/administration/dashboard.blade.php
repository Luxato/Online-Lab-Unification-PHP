@extends('administration/adminmaster')

@section('title')
    Nástenka
@stop

@section('content')
    toto je test z dashboard.blade.php
@stop


@section('custom_scripts') {{--JS specified only for this site--}}
<script>
    $('#nav-dashboard').addClass('active');
</script>
@stop