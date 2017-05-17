@extends('administration/adminmaster')

@section('title')
    Nástenka
@stop

@section('content')
    <style>
        pre {
            background: none;
            border: none;
        }
    </style>
    <h1>Mapa administrácie</h1>
    <ul>
        <li>Stránky</li>
        <li>
            <ul>
                <li>Všetky stránky</li>
                <li>Usporiadanie navigácie</li>
                <li>Pridať novú</li>
            </ul>
        </li>
        <li>Aktuality</li>
        <li>
            <ul>
                <li>Všetky aktuality</li>
                <li>Pridať novú</li>
            </ul>
        </li>
        <li>Užívatelia</li>
        <li>Jazyky</li>
        <li>
            <ul>
                <li>Jazyky</li>
                <li>Vytvoriť jazyk</li>
            </ul>
        </li>
        <li>Nastavenia</li>
    </ul>
@stop


@section('custom_scripts') {{--JS specified only for this site--}}
<script>
    $('#nav-dashboard').addClass('active');
</script>
@stop