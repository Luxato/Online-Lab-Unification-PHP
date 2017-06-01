
@extends('master')

@section('title')
	ITEP2017
@stop

@section('content')
	<?php
	$path = './applications/itep2017/';
	include $path . 'index.show.php';
	?>
@stop