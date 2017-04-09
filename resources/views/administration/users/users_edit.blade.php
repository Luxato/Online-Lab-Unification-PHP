@extends('administration/adminmaster')

@section('title')
    Editovanie používateľa
@stop

@section('custom_css') {{--CSS specified only for this site--}}

@stop


@section('content')
    <?php
        echo '<pre>';
        print_r( $user );
        echo '</pre>';
    ?>
    <form action="" method="post">

    </form>
@stop

@section('custom_scripts') {{--JS specified only for this site--}}
<script>
    $('#nav-users').addClass('active');
</script>
@stop