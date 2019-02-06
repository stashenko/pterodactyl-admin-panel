{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.admin')

@section('title')
    Менеджер Пользователей: {{ $user->username }}
@endsection

@section('content-header')
    <h1>{{ $user->name_first }} {{ $user->name_last}}<small>{{ $user->username }}</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Администратор</a></li>
        <li><a href="{{ route('admin.users') }}">Пользователь</a></li>
        <li class="active">{{ $user->username }}</li>
    </ol>
@endsection

@section('content')
<div class="row">
    <form action="{{ route('admin.users.view', $user->id) }}" method="post">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Подлинность</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="email" class="control-label">Email</label>
                        <div>
                            <input readonly type="email" name="email" value="{{ $user->email }}" class="form-control form-autocomplete-stop">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="registered" class="control-label">Имя пользователя</label>
                        <div>
                            <input readonly type="text" name="username" value="{{ $user->username }}" class="form-control form-autocomplete-stop">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="registered" class="control-label">Имя клиента</label>
                        <div>
                            <input readonly type="text" name="name_first" value="{{ $user->name_first }}" class="form-control form-autocomplete-stop">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="registered" class="control-label">Фамилия клиента</label>
                        <div>
                            <input readonly type="text" name="name_last" value="{{ $user->name_last }}" class="form-control form-autocomplete-stop">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Язык по умолчанию</label>
                        <div>
                            <select name="language" class="form-control">
                                @foreach($languages as $key => $value)
                                    <option value="{{ $key }}" @if($user->language === $key) selected @endif>{{ $value }}</option>
                                @endforeach
                            </select>
                            <p class="text-muted"><small>Язык по умолчанию, используемый для этого пользователя.</small></p>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    {!! csrf_field() !!}
                    {!! method_field('PATCH') !!}
                    <input type="submit" value="Update User" class="btn btn-primary btn-sm">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Пароль</h3>
                </div>
                <div class="box-body">
                    <div class="alert alert-success" style="display:none;margin-bottom:10px;" id="gen_pass"></div>
                    <div class="form-group no-margin-bottom">
                        <label for="password" class="control-label">Пароль <span class="field-optional"></span></label>
                        <div>
                            <input readonly type="password" id="password" name="password" class="form-control form-autocomplete-stop">
                            <p class="text-muted small">Оставьте пустым, чтобы сохранить пароль этого пользователя тем же. Пользователь не получит никакого уведомления, если пароль будет изменен.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Права</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="root_admin" class="control-label">Администратор</label>
                        <div>
                            <select name="root_admin" class="form-control">
                                <option value="0">@lang('strings.no')</option>
                                <option value="1" {{ $user->root_admin ? 'selected="selected"' : '' }}>@lang('strings.yes')</option>
                            </select>
                            <p class="text-muted"><small>Установка 'Yes' дает пользователю полный административный доступ.</small></p>
                        </div>
                        <div class="checkbox checkbox-primary">
                            <input type="checkbox" id="pIgnoreConnectionError" value="1" name="ignore_connection_error">
                            <label for="pIgnoreConnectionError"> Игнорировать исключения, возникающие при отзыве ключей.</label>
                            <p class="text-muted small">Если установлен этот флажок, любые ошибки, возникающие при отзыве ключей между узлами, будут игнорироваться. Вам следует избегать этого флажка, если это возможно, так как любые неотозванные ключи могут оставаться активными в течение 24 часов после изменения этой учетной записи. Если вам необходимо немедленно отозвать разрешения учетной записи и у вас возникают проблемы с узлами, установите этот флажок и перезапустите все узлы, которые не удалось обновить, чтобы очистить все сохраненные ключи.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    {{--<div class="col-xs-12">--}}
        {{--<div class="box">--}}
            {{--<div class="box-header with-border">--}}
                {{--<h3 class="box-title">Ассоциированные серверы</h3>--}}
            {{--</div>--}}
            {{--<div class="box-body table-responsive no-padding">--}}
                {{--<table class="table table-hover">--}}
                    {{--<thead>--}}
                        {{--<tr>--}}
                            {{--<th style="width:2%;"></th>--}}
                            {{--<th>Идентификатор</th>--}}
                            {{--<th>Название сервера</th>--}}
                            {{--<th>Доступ</th>--}}
                            {{--<th>Узел</th>--}}
                            {{--<th style="width:10%;"></th>--}}
                        {{--</tr>--}}
                    {{--</thead>--}}
                    {{--<tbody>--}}
                        {{--@foreach($user->setAccessLevel('subuser')->access()->get() as $server)--}}
                            {{--<tr>--}}
                                {{--<td><a href="{{ route('server.index', $server->uuidShort) }}/"><i class="fa fa-tachometer"></i></a></td>--}}
                                {{--<td><code>{{ $server->uuidShort }}</code></td>--}}
                                {{--<td><a href="{{ route('admin.servers.view', $server->id) }}">{{ $server->name }}</a></td>--}}
                                {{--<td>--}}
                                    {{--@if($server->owner_id === $user->id)--}}
                                        {{--<span class="label bg-purple">Владелец</span>--}}
                                    {{--@else--}}
                                        {{--<span class="label bg-blue">Субпользователь</span>--}}
                                    {{--@endif--}}
                                {{--</td>--}}
                                {{--<td><a href="{{ route('admin.nodes.view', $server->node->id) }}">{{ $server->node->name }}</a></td>--}}
                                {{--<td class="centered">@if($server->suspended === 0)<span class="label muted muted-hover label-success">Активный</span>@else<span class="label label-warning">Приостановленный</span>@endif</td>--}}
                            {{--</td>--}}
                        {{--@endforeach--}}
                    {{--</tbody>--}}
                {{--</table>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
    <div class="col-xs-12">
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Удалить пользователя</h3>
            </div>
            <div class="box-body">
                <p class="no-margin">Для удаления этой учетной записи не должно быть серверов, связанных с этой учетной записью.</p>
            </div>
            <div class="box-footer">
                <form action="{{ route('admin.users.view', $user->id) }}" method="POST">
                    {!! csrf_field() !!}
                    {!! method_field('DELETE') !!}
                    <input id="delete" type="submit" class="btn btn-sm btn-danger pull-right" {{ $user->servers->count() < 1 ?: 'disabled' }} value="Delete User" />
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
