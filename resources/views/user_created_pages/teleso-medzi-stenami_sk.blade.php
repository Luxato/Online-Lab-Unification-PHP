
@extends('master')

@section('title') Teleso medzi stenami @stop

@section('seo_description') @stop

@section('keywords') @stop

@section('content')
	<?php
	$path = './applications/teleso-medzi-stenami/';
	include $path . 'TelesoMedziStenami.php';
	?>
@stop