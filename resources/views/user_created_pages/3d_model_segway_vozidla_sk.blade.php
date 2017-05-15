
@extends('master')

@section('title')
	3D model segway vozidla
@stop

@section('content')
				<?php
                    $path = './applications/segway/';
                    include $path . 'content.php';
				?>
@stop