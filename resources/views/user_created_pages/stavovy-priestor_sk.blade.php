
@extends('master')

@section('title') Stavový priestor @stop

@section('seo_description') @stop

@section('keywords') @stop

@section('content')
	<?php
	$path = './applications/stavovy-priestor/';
	include $path . 'index.php';
	?>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@stop