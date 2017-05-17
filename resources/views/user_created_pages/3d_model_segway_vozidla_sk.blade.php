
@extends('master')

@section('title')
	3D model segway vozidla
@stop

@section('seo_description')3D model segway vozidla
@stop

@section('keywords')webgl, 3D model
@stop

@section('content')
				<?php
                    $path = './applications/segway/';
                    include $path . 'content.php';
				?>
@stop