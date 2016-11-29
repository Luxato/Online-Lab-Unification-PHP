@extends('master')

@section('title')
    <?= $name ?>
@stop

@section('content')
    <?php
        echo $content;
    ?>
@stop