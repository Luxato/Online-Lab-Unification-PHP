@extends('administration/adminmaster')

@section('title')
    Editovanie používateľa <?= $user['name'] . ' - ' . $user['email'] ?>
@stop

@section('custom_css') {{--CSS specified only for this site--}}

@stop


@section('content')
        <form action="<?= URL::to( '/admin/users/' . $user->id ) ?>" method="POST">
            <input name="_token" type="hidden" id="_token" value="{{ csrf_token() }}">
            <input name="_method" type="hidden" value="put">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputEmail1">Meno</label>
                    <input id="title-input" class="form-control" name="name" type="text" required="" value="<?= $user['name'] ?>">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <input id="title-input" class="form-control" name="name" type="text" required="" value="<?= $user['email'] ?>">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Nové Heslo</label>
                    <input id="title-input" class="form-control" name="name" type="text">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputEmail1">API kľúč</label>
                    <input id="title-input" class="form-control" name="name" type="text" value="<?= isset($user->apikey->key) ? $user->apikey->key : '-' ?>">
                </div>
            </div>
            <div class="col-md-12">
                <button type="submit" class="btn btn-success btn-lg pull-right" style="width: 49%;">Upraviť</button>
            </div>
        </form>
@stop

@section('custom_scripts') {{--JS specified only for this site--}}
<script>
    $('#nav-users').addClass('active');
</script>
@stop