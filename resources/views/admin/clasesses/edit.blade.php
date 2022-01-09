@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.clasess.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.clasesses.update", [$clasess->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="class_name">{{ trans('cruds.clasess.fields.class_name') }}</label>
                <input class="form-control {{ $errors->has('class_name') ? 'is-invalid' : '' }}" type="text" name="class_name" id="class_name" value="{{ old('class_name', $clasess->class_name) }}" required>
                @if($errors->has('class_name'))
                    <span class="text-danger">{{ $errors->first('class_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.clasess.fields.class_name_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection