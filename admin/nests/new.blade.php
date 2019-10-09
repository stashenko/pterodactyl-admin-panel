{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.admin')

@section('title')
    Новое Гнездо
@endsection

@section('content-header')
    <h1>Новое Гнездо<small>Настройте новое гнездо для развертывания на всех узлах.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Администратор</a></li>
        <li><a href="{{ route('admin.nests') }}">Гнезда</a></li>
        <li class="active">Новое</li>
    </ol>
@endsection

@section('content')
<form action="{{ route('admin.nests.new') }}" method="POST">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Новое Гнездо</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label class="control-label">Название</label>
                        <div>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" />
                            <p class="text-muted"><small>Это должно быть описательным названием категории, которая охватывает все яйца в гнезде.</small></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Опимание</label>
                        <div>
                            <textarea name="description" class="form-control" rows="6">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    {!! csrf_field() !!}
                    <button type="submit" class="btn btn-primary pull-right">Сохранить</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
