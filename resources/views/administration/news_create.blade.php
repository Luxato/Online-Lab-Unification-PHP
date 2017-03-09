@extends('administration/adminmaster')

@section('title')
Pridať novú aktualitu
@stop

@section('custom_css')
<link rel="stylesheet"
      href="<?= URL::to( '/' ); ?>/assets/administration/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
@stop


@section('content')
<br>
<div class="row">
	<form id="new-page-form" onsubmit="return validateForm()" action="<?= URL( 'admin/pages/' ) ?>" method="POST">
		<input name="_token" type="hidden" id="_token" value="{{ csrf_token() }}"/>
		<div class="col-lg-6">
			<div class="form-group">
				<label for="exampleInputEmail1">Nadpis</label>
				<input id="title-input" class="form-control" name="name[]" type="text"
				       placeholder="Zadajte nadpis sem" required="">
			</div>
			<div class="form-group">
				<label for="exampleInputEmail1">Ak</label>
				<input id="url-input" class="form-control" name="url[]" type="text" placeholder="URL" required="">
			</div>
		</div>
		<div class="col-md-6">
            <div class="form-group">
                <label for="exampleInputEmail1">Obsah</label>
                <textarea id="editor" name="cont[]" rows="6" cols="80">
                    </textarea>
            </div>
		</div>
		<div class="col-md-12">
			{{--<div class="form-group">
				<label for="exampleInputEmail1">Obsah</label>
				<textarea id="editor" name="cont[]" rows="6" cols="80">
                    </textarea>
			</div>--}}
		</div>

		<div id="another-lang"></div>

		<div class="col-md-12">
			<button type="submit" class="btn btn-success btn-lg pull-right" style="width: 49%;">Vytvoriť</button>
		</div>
	</form>
</div>
@stop

@section('custom_scripts')
<script src="<?= URL::to( '/' ); ?>/assets/administration/plugins/ckeditor/ckeditor.min.js"></script>
<script>
    CKEDITOR.replace('editor');
</script>
@stop