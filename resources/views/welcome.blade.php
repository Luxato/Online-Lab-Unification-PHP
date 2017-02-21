@extends('master')

@section('title')
	<?= $name ?>
@stop

@section('content')
	<?php
        if (isset($content_file)) {
            include_once dirname( getcwd() ) . '/resources/custom_pages/' . $content_file;
        } else {
	        echo "<h2>Na tejto stranke sa nenachadza ziaden obsah</h2>";
        }
	?>
@stop