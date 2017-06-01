
@extends('master')

@section('title')
	LED cube
@stop

@section('content')
	<?php
	$path = './applications/led-cube/';
	include $path . 'index.php';
	?>
@stop