
@extends('master')

@section('title') Tlmený harmonický oscilátor @stop

@section('seo_description') @stop

@section('keywords') @stop

@section('content')
	<?php
	$path = './applications/tlmeny-harmonicky-oscilator/';
	include $path . 'TlmenyHarmonickyOscliator.php';
	?>
@stop