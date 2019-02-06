{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.admin')

@section('title')
    Сервер — {{ $server->name }}: Удаление
@endsection

@section('content-header')
    <h1>{{ $server->name }}<small>Удалите этот сервер с панели.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Администратор</a></li>
        <li><a href="{{ route('admin.servers') }}">Серверы</a></li>
        <li><a href="{{ route('admin.servers.view', $server->id) }}">{{ $server->name }}</a></li>
        <li class="active">Удалить</li>
    </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="nav-tabs-custom nav-tabs-floating">
            <ul class="nav nav-tabs">
                <li><a href="{{ route('admin.servers.view', $server->id) }}">О сервере</a></li>
                @if($server->installed === 1)
                    <li><a href="{{ route('admin.servers.view.details', $server->id) }}">Детали</a></li>
                    <li><a href="{{ route('admin.servers.view.build', $server->id) }}">Конфигурация сборки</a></li>
                    <li><a href="{{ route('admin.servers.view.startup', $server->id) }}">Запуск</a></li>
                    <li><a href="{{ route('admin.servers.view.database', $server->id) }}">База данных</a></li>
                    <li><a href="{{ route('admin.servers.view.manage', $server->id) }}">Управление</a></li>
                @endif
                <li class="tab-danger active"><a href="{{ route('admin.servers.view.delete', $server->id) }}">Удалить</a></li>
                <li class="tab-success"><a href="{{ route('server.index', $server->uuidShort) }}"><i class="fa fa-external-link"></i></a></li>
            </ul>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Безопасное удаление сервера</h3>
            </div>
            <div class="box-body">
                <p>Это действие попытается удалить сервер как с панели, так и с демона. Если что-либо сообщит об ошибке, действие будет отменено.</p>
                <p class="text-danger small">Удаление сервера является необратимым действием. <strong>Все данные сервера</strong> (включая файлы и пользователей) будут удалены из системы.</p>
            </div>
            <div class="box-footer">
                <form action="{{ route('admin.servers.view.delete', $server->id) }}" method="POST">
                    {!! csrf_field() !!}
                    <button type="submit" class="btn btn-danger">Безопасно удалить этот сервер</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Принудительно удалить сервер</h3>
            </div>
            <div class="box-body">
                <p>Это действие попытается удалить сервер как с панели, так и с демона. Если демон не отвечает или сообщает об ошибке, удаление будет продолжено.</p>
                <p class="text-danger small">Удаление сервера является необратимым действием. <strong>Все данные сервера</strong> (включая файлы и пользователей) будут удалены из системы. Этот метод может оставить висящие файлы на вашем демоне, если он сообщает об ошибке.</p>
            </div>
            <div class="box-footer">
                <form action="{{ route('admin.servers.view.delete', $server->id) }}" method="POST">
                    {!! csrf_field() !!}
                    <input type="hidden" name="force_delete" value="1" />
                    <button type="submit" class="btn btn-danger">Принудительно удалить этот сервер</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer-scripts')
    @parent
    <script>
    $('form[data-action="delete"]').submit(function (event) {
        event.preventDefault();
        swal({
            title: '',
            type: 'warning',
            text: 'Are you sure that you want to delete this server? There is no going back, all data will immediately be removed.',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            confirmButtonColor: '#d9534f',
            closeOnConfirm: false
        }, function () {
            event.target.submit();
        });
    });
    </script>
@endsection
