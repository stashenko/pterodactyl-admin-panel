{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.admin')

@section('title')
    {{ $node->name }}: Серверы
@endsection

@section('content-header')
    <h1>{{ $node->name }}<small>Все серверы назначенные этому узлу.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Администратор</a></li>
        <li><a href="{{ route('admin.nodes') }}">Узлы</a></li>
        <li><a href="{{ route('admin.nodes.view', $node->id) }}">{{ $node->name }}</a></li>
        <li class="active">Серверы</li>
    </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="nav-tabs-custom nav-tabs-floating">
            <ul class="nav nav-tabs">
                <li><a href="{{ route('admin.nodes.view', $node->id) }}">Инфо</a></li>
                <li><a href="{{ route('admin.nodes.view.settings', $node->id) }}">Настройки</a></li>
                <li><a href="{{ route('admin.nodes.view.configuration', $node->id) }}">Конфигурация</a></li>
                <li><a href="{{ route('admin.nodes.view.allocation', $node->id) }}">Распределения</a></li>
                <li class="active"><a href="{{ route('admin.nodes.view.servers', $node->id) }}">Серверы</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Менеджер процессов</h3>
            </div>
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <th>ID</th>
                        <th>Название сервера</th>
                        <th>Владелец</th>
                        <th>Обслуживание</th>
                        <th class="text-center">Память</th>
                        <th class="text-center">Диск</th>
                        <th class="text-center">Процессор</th>
                        <th class="text-center">Статус</th>
                    </tr>
                    @foreach($servers as $server)
                        <tr data-server="{{ $server->uuid }}">
                            <td><code>{{ $server->uuidShort }}</code></td>
                            <td><a href="{{ route('admin.servers.view', $server->id) }}">{{ $server->name }}</a></td>
                            <td><a href="{{ route('admin.users.view', $server->owner_id) }}">{{ $server->user->username }}</a></td>
                            <td>{{ $server->nest->name }} ({{ $server->egg->name }})</td>
                            <td class="text-center"><span data-action="memory">--</span> / {{ $server->memory === 0 ? '∞' : $server->memory }} MB</td>
                            <td class="text-center"><span data-action="disk">--</span> / {{ $server->disk === 0 ? '∞' : $server->disk }} MB </td>
							<td class="text-center"><span data-action="cpu" data-cpumax="{{ $server->cpu }}">--</span> %</td>
                            <td class="text-center" data-action="status">--</td>
                        </tr>
                    @endforeach
                </table>
                @if($servers->hasPages())
                    <div class="box-footer with-border">
                        <div class="col-md-12 text-center">{!! $servers->render() !!}</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer-scripts')
    @parent
    {!! Theme::js('js/admin/node/view-servers.js') !!}
@endsection
