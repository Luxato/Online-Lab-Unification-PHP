@extends('master')

@section('title')
	<?= $actualities->name ?>
@stop

@section('content')
    <h1><?= $actualities->name ?></h1>
    <p><?= $actualities->content ?></p>
@stop