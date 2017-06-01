@extends('master')

@section('title') 2 Oscilátory @stop

@section('seo_description') @stop

@section('keywords') @stop

@section('content')
	<?php
	$path = './applications/2-oscilatory/';
	include $path . 'DvaOsc.php';
	?>
@stop