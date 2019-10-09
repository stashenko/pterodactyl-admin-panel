{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.admin')

@section('title')
    Packs &rarr; View &rarr; {{ $pack->name }}
@endsection

@section('content-header')
    <h1>{{ $pack->name }}<small>{{ str_limit($pack->description, 60) }}</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Администратор</a></li>
        <li><a href="{{ route('admin.packs') }}">Пакеты</a></li>
        <li class="active">{{ $pack->name }}</li>
    </ol>
@endsection

@section('content')
<form action="{{ route('admin.packs.view', $pack->id) }}" method="POST">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Детали пакета</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="pName" class="form-label">Название</label>
                        <input name="name" type="text" id="pName" class="form-control" value="{{ old('name') }}" />
                        <p class="text-muted small">Краткое, но наглядное название этого пакета. Например, <code>Counter Strike: Source </code>, если это пакет Counter Strike.</p>
                    </div>
                    <div class="form-group">
                        <label for="pDescription" class="form-label">Описание</label>
                        <textarea name="description" id="pDescription" class="form-control" rows="8">{{ old('description') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="pVersion" class="form-label">Версия</label>
                        <input type="text" name="version" id="pVersion" class="form-control" value="{{ old('version') }}" />
                        <p class="text-muted small">Версия этого пакета или версия файлов, содержащихся в пакете.</p>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Место хранения</label>
                        <input type="text" class="form-control" readonly value="{{ storage_path('app/packs/' . $pack->uuid) }}">
                        <p class="text-muted small">Если вы хотите изменить сохраненный пакет, вам нужно будет загрузить новый <code>archive.tar.gz</code> в указанное выше местоположение.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Конфигурация пакета</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="pEggId" class="form-label">Ассоциированный вариант</label>
                        <select id="pEggId" name="egg_id" class="form-control">
                            @foreach($nests as $nest)
                                <optgroup label="{{ $nest->name }}">
                                    @foreach($nest->eggs as $egg)
                                        <option value="{{ $egg->id }}" {{ $pack->egg_id !== $egg->id ?: 'selected' }}>{{ $egg->name }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        <p class="text-muted small">Опция, с которой связан этот пакет. Только серверы, которым назначена эта опция, смогут получить доступ к этому пакету. Эта назначенная опция <em>не может быть</em> изменена, если серверы подключены к этому пакету.</p>
                    </div>
                    <div class="form-group">
                        <div class="checkbox checkbox-primary no-margin-bottom">
                            <input id="pSelectable" name="selectable" type="checkbox" value="1" {{ ! $pack->selectable ?: 'checked' }}/>
                            <label for="pSelectable">
                                Выбираемый
                            </label>
                        </div>
                        <p class="text-muted small">Установите этот флажок, если пользователь должен иметь возможность выбрать этот пакет для установки на своих серверах.</p>
                    </div>
                    <div class="form-group">
                        <div class="checkbox checkbox-primary no-margin-bottom">
                            <input id="pVisible" name="visible" type="checkbox" value="1" {{ ! $pack->visible ?: 'checked' }}/>
                            <label for="pVisible">
                                Видимый
                            </label>
                        </div>
                        <p class="text-muted small">Установите этот флажок, если этот пакет отображается в раскрывающемся меню. Если этот пакет назначен серверу, он будет виден независимо от этого параметра.</p>
                    </div>
                    <div class="form-group">
                        <div class="checkbox checkbox-warning no-margin-bottom">
                            <input id="pLocked" name="locked" type="checkbox" value="1" {{ ! $pack->locked ?: 'checked' }}/>
                            <label for="pLocked">
                                Заблокированный
                            </label>
                        </div>
                        <p class="text-muted small">Установите этот флажок, если серверы, назначенные этому пакету, не могут переключаться на другой пакет.</p>
                    </div>
                </div>
                <div class="box-footer with-border">
                    {!! csrf_field() !!}
                    <button name="_method" value="PATCH" class="btn btn-sm btn-primary pull-right" type="submit">Сохранить</button>
                    <button name="_method" value="DELETE" class="btn btn-sm btn-danger pull-left muted muted-hover" type="submit"><i class="fa fa-trash-o"></i></button>
                </div>
            </div>
        </div>
    </div>
</form>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Серверы, использующие этот пакет</h3>
            </div>
            <div class="box-body no-padding table-responsive">
                <table class="table table-hover">
                    <tr>
                        <th>ID</th>
                        <th>Название сервера</th>
                        <th>Узел</th>
                        <th>Владелец</th>
                    </tr>
                    @foreach($pack->servers as $server)
                        <tr>
                            <td><code>{{ $server->uuidShort }}</code></td>
                            <td><a href="{{ route('admin.servers.view', $server->id) }}">{{ $server->name }}</a></td>
                            <td><a href="{{ route('admin.nodes.view', $server->node->id) }}">{{ $server->node->name }}</a></td>
                            <td><a href="{{ route('admin.users.view', $server->user->id) }}">{{ $server->user->email }}</a></td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-6 col-md-5 col-md-offset-7 col-xs-offset-6">
        <form action="{{ route('admin.packs.view.export', $pack->id) }}" method="POST">
            {!! csrf_field() !!}
            <button type="submit" class="btn btn-sm btn-success pull-right">Экспорт</button>
        </form>
        <form action="{{ route('admin.packs.view.export', ['id' => $pack->id, 'files' => 'with-files']) }}" method="POST">
            {!! csrf_field() !!}
            <button type="submit" class="btn btn-sm pull-right muted muted-hover" style="margin-right:10px;">Экспорт в архив</button>
        </form>
    </div>
</div>
@endsection

@section('footer-scripts')
    @parent
    <script>
        $('#pEggId').select2();
    </script>
@endsection
