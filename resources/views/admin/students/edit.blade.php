@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.student.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.students.update", [$student->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.student.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $student->name) }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.student.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="class_iid_id">{{ trans('cruds.student.fields.class_iid') }}</label>
                <select class="form-control select2 {{ $errors->has('class_iid') ? 'is-invalid' : '' }}" name="class_iid_id" id="class_iid_id">
                    @foreach($class_iids as $id => $entry)
                        <option value="{{ $id }}" {{ (old('class_iid_id') ? old('class_iid_id') : $student->class_iid->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('class_iid'))
                    <span class="text-danger">{{ $errors->first('class_iid') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.student.fields.class_iid_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="country_code_id">{{ trans('cruds.student.fields.country_code') }}</label>
                <select class="form-control select2 {{ $errors->has('country_code') ? 'is-invalid' : '' }}" name="country_code_id" id="country_code_id" required>
                    @foreach($country_codes as $id => $entry)
                        <option value="{{ $id }}" {{ (old('country_code_id') ? old('country_code_id') : $student->country_code->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('country_code'))
                    <span class="text-danger">{{ $errors->first('country_code') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.student.fields.country_code_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="date_of_birth">{{ trans('cruds.student.fields.date_of_birth') }}</label>
                <input class="form-control date {{ $errors->has('date_of_birth') ? 'is-invalid' : '' }}" type="text" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $student->date_of_birth) }}" required>
                @if($errors->has('date_of_birth'))
                    <span class="text-danger">{{ $errors->first('date_of_birth') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.student.fields.date_of_birth_helper') }}</span>
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