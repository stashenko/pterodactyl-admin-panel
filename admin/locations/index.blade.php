{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.admin')

@section('title')
    Распределения
@endsection

@section('content-header')
    <h1>Распределения<small>Все местоположения, которым могут быть назначены узлы для упрощения классификации.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Администратор</a></li>
        <li class="active">Распределения</li>
    </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Список распределений</h3>
                <div class="box-tools">
                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#newLocationModal">Создать новое</button>
                </div>
            </div>
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <th>Короткий код</th>
                            <th>Описание</th>
                            <th class="text-center">Узлы</th>
                            <th class="text-center">Серверы</th>
                        </tr>
                        @foreach ($locations as $location)
                            <tr>
                                <td><code>{{ $location->id }}</code></td>
                                <td><a href="{{ route('admin.locations.view', $location->id) }}">{{ $location->short }}</a></td>
                                <td>{{ $location->long }}</td>
                                <td class="text-center">{{ $location->nodes_count }}</td>
                                <td class="text-center">{{ $location->servers_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="newLocationModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.locations') }}" method="POST">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Создать распределение</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="pShortModal" class="form-label">Короткий код</label>
                            <input type="text" name="short" id="pShortModal" class="form-control" />
                            <p class="text-muted small">Короткий идентификатор, используемый для отличия этого места от других. Должно быть от 1 до 60 символов, например, <code>us.nyc.lvl3</code>.</p>
                        </div>
                        <div class="col-md-12">
                            <label for="pLongModal" class="form-label">Описание</label>
                            <textarea name="long" id="pLongModal" class="form-control" rows="4"></textarea>
                            <p class="text-muted small">Более подробное описание этого распределения. Должно быть не более 255 символов.</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {!! csrf_field() !!}
                    <button type="button" class="btn btn-default btn-sm pull-left" data-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-success btn-sm">Создать</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
