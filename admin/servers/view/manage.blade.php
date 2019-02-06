{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.admin')

@section('title')
    Сервер — {{ $server->name }}: Управление
@endsection

@section('content-header')
    <h1>{{ $server->name }}<small>Additional actions to control this server.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Администратор</a></li>
        <li><a href="{{ route('admin.servers') }}">Серверы</a></li>
        <li><a href="{{ route('admin.servers.view', $server->id) }}">{{ $server->name }}</a></li>
        <li class="active">Управление</li>
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
                    <li class="active"><a href="{{ route('admin.servers.view.manage', $server->id) }}">Управление</a></li>
                @endif
                <li class="tab-danger"><a href="{{ route('admin.servers.view.delete', $server->id) }}">Удалить</a></li>
                <li class="tab-success"><a href="{{ route('server.index', $server->uuidShort) }}"><i class="fa fa-external-link"></i></a></li>
            </ul>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Переустановить сервер</h3>
            </div>
            <div class="box-body">
                <p>Это переустановит сервер с назначенным пакетом и служебными скриптами. <strong>Опасно!</strong> Это может перезаписать данные сервера.</p>
            </div>
            <div class="box-footer">
                @if($server->installed === 1)
                    <form action="{{ route('admin.servers.view.manage.reinstall', $server->id) }}" method="POST">
                        {!! csrf_field() !!}
                        <button type="submit" class="btn btn-danger">Переустановить сервер</button>
                    </form>
                @else
                    <button class="btn btn-danger disabled">Сервер должен быть установлен правильно, чтобы переустановить</button>
                @endif
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Статус установки</h3>
            </div>
            <div class="box-body">
                <p>Если вам нужно изменить статус установки с удаленного на установленный или наоборот, вы можете сделать это с помощью кнопки ниже.</p>
            </div>
            <div class="box-footer">
                <form action="{{ route('admin.servers.view.manage.toggle', $server->id) }}" method="POST">
                    {!! csrf_field() !!}
                    <button type="submit" class="btn btn-primary">Переключить статус установки</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Восстановить контейнер</h3>
            </div>
            <div class="box-body">
                <p>Это вызовет перестройку контейнера сервера при следующем запуске. Это полезно, если вы изменили файл конфигурации сервера вручную или что-то не сработало правильно.</p>
            </div>
            <div class="box-footer">
                <form action="{{ route('admin.servers.view.manage.rebuild', $server->id) }}" method="POST">
                    {!! csrf_field() !!}
                    <button type="submit" class="btn btn-default">Восстановить контейнер сервера</button>
                </form>
            </div>
        </div>
    </div>
    @if(! $server->suspended)
        <div class="col-sm-4">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Приостановить работу сервера</h3>
                </div>
                <div class="box-body">
                    <p>Это приостановит работу сервера, остановит все запущенные процессы и немедленно заблокирует пользователю возможность доступа к своим файлам или иным образом управлять сервером через панель или API.</p>
                </div>
                <div class="box-footer">
                    <form action="{{ route('admin.servers.view.manage.suspension', $server->id) }}" method="POST">
                        {!! csrf_field() !!}
                        <input type="hidden" name="action" value="suspend" />
                        <button type="submit" class="btn btn-warning">Приостановить работу сервера</button>
                    </form>
                </div>
            </div>
        </div>
    @else
        <div class="col-sm-4">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Разблокировать сервер</h3>
                </div>
                <div class="box-body">
                    <p>Это разблокирует сервер и восстановит нормальный пользовательский доступ.</p>
                </div>
                <div class="box-footer">
                    <form action="{{ route('admin.servers.view.manage.suspension', $server->id) }}" method="POST">
                        {!! csrf_field() !!}
                        <input type="hidden" name="action" value="unsuspend" />
                        <button type="submit" class="btn btn-success">Разблокировать сервер</button>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
