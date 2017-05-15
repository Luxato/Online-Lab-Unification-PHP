
@extends('master')

@section('title')
	3D model hydraulickej sústavy
@stop

@section('content')
	<?php
        $path = './applications/hydraulicka-sustava/';
        include $path . 'index.php';
	?>
@stop