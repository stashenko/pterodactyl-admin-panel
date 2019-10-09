{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.admin')

@section('title')
    Сервер — {{ $server->name }}: Детали сборки
@endsection

@section('content-header')
    <h1>{{ $server->name }}<small>Контролируйте распределение и системные ресурсы для этого сервера.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Администратор</a></li>
        <li><a href="{{ route('admin.servers') }}">Серверы</a></li>
        <li><a href="{{ route('admin.servers.view', $server->id) }}">{{ $server->name }}</a></li>
        <li class="active">Конфигурация сборки</li>
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
                    <li class="active"><a href="{{ route('admin.servers.view.build', $server->id) }}">Конфигурация сборки</a></li>
                    <li><a href="{{ route('admin.servers.view.startup', $server->id) }}">Запуск</a></li>
                    <li><a href="{{ route('admin.servers.view.database', $server->id) }}">База данных</a></li>
                    <li><a href="{{ route('admin.servers.view.manage', $server->id) }}">Управление</a></li>
                @endif
                <li class="tab-danger"><a href="{{ route('admin.servers.view.delete', $server->id) }}">Удалить</a></li>
                <li class="tab-success"><a href="{{ route('server.index', $server->uuidShort) }}"><i class="fa fa-external-link"></i></a></li>
            </ul>
        </div>
    </div>
</div>
<div class="row">
    <form action="{{ route('admin.servers.view.build', $server->id) }}" method="POST">
        <div class="col-sm-5">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Системные ресурсы</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="memory" class="control-label">Выделенная память</label>
                        <div class="input-group">
                            <input type="text" name="memory" data-multiplicator="true" class="form-control" value="{{ old('memory', $server->memory) }}"/>
                            <span class="input-group-addon">MB</span>
                        </div>
                        <p class="text-muted small">Максимальный объем памяти, разрешенный для этого контейнера. Установка этого параметра в <code>0</code> позволит неограниченной памяти в контейнере.</p>
                    </div>
                    <div class="form-group">
                        <label for="swap" class="control-label">Выделенный своп</label>
                        <div class="input-group">
                            <input type="text" name="swap" data-multiplicator="true" class="form-control" value="{{ old('swap', $server->swap) }}"/>
                            <span class="input-group-addon">MB</span>
                        </div>
                        <p class="text-muted small">Установка этого параметра на <code>0</code> отключит пространство подкачки на этом сервере. Установка на <code>-1</code> разрешит неограниченный обмен.</p>
                    </div>
                    <div class="form-group">
                        <label for="cpu" class="control-label">Предел процессора</label>
                        <div class="input-group">
                            <input type="text" name="cpu" class="form-control" value="{{ old('cpu', $server->cpu) }}"/>
                            <span class="input-group-addon">%</span>
                        </div>
                        <p class="text-muted small">Каждое <em>физическое</em> ядро в системе считается <code>100%</code>. Установка этого значения на <code>0</code> позволит серверу использовать процессор без ограничений.</p>
                    </div>
                    <div class="form-group">
                        <label for="io" class="control-label">Пропорция блока ввода/вывода</label>
                        <div>
                            <input type="text" name="io" class="form-control" value="{{ old('io', $server->io) }}"/>
                        </div>
                        <p class="text-muted small">Изменение этого значения может оказать негативное влияние на все контейнеры в системе. Мы настоятельно рекомендуем оставить это значение как <code>500</code>.</p>
                    </div>
                    <div class="form-group">
                        <label for="cpu" class="control-label">Предел дискового пространства</label>
                        <div class="input-group">
                            <input type="text" name="disk" class="form-control" value="{{ old('disk', $server->disk) }}"/>
                            <span class="input-group-addon">MB</span>
                        </div>
                        <p class="text-muted small">Этому серверу не будет разрешено загружаться, если он использует больше этого пространства. Если сервер превысит этот лимит во время работы, он будет безопасно остановлен и заблокирован до тех пор, пока не освободится достаточно места на диске.</p>
                    </div>
                    <div class="form-group">
                        <label for="cpu" class="control-label">OOM Killer</label>
                        <div>
                            <div class="radio radio-danger radio-inline">
                                <input type="radio" id="pOomKillerEnabled" value="0" name="oom_disabled" @if(!$server->oom_disabled)checked @endif>
                                <label for="pOomKillerEnabled">Включен</label>
                            </div>
                            <div class="radio radio-success radio-inline">
                                <input type="radio" id="pOomKillerDisabled" value="1" name="oom_disabled" @if($server->oom_disabled)checked @endif>
                                <label for="pOomKillerDisabled">Выключен</label>
                            </div>
                            <p class="text-muted small">
                                Включение OOM killer может привести к неожиданному завершению процессов сервера.
                            </p>
                       </div>
                   </div>
                </div>
            </div>
        </div>
        <div class="col-sm-7">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Пределы возможностей приложения</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-xs-6">
                                    <label for="cpu" class="control-label">Предел базы данных</label>
                                    <div>
                                        <input type="text" name="database_limit" class="form-control" value="{{ old('database_limit', $server->database_limit) }}"/>
                                    </div>
                                    <p class="text-muted small">Общее количество баз данных, которые пользователь может создать для этого сервера. Оставьте пустым, чтобы разрешить неограничено.</p>
                                </div>
                                <div class="form-group col-xs-6">
                                    <label for="cpu" class="control-label">Предел распределения</label>
                                    <div>
                                        <input type="text" name="allocation_limit" class="form-control" value="{{ old('allocation_limit', $server->allocation_limit) }}"/>
                                    </div>
                                    <p class="text-muted small"><strong>Эта функция в настоящее время не реализована.</strong> Общее количество выделений, которые пользователь может создать для этого сервера. Оставьте пустым, чтобы разрешить неограничено.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Управление распределением</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="pAllocation" class="control-label">Игровой порт</label>
                                <select id="pAllocation" name="allocation_id" class="form-control">
                                    @foreach ($assigned as $assignment)
                                        <option value="{{ $assignment->id }}"
                                            @if($assignment->id === $server->allocation_id)
                                                selected="selected"
                                            @endif
                                        >{{ $assignment->alias }}:{{ $assignment->port }}</option>
                                    @endforeach
                                </select>
                                <p class="text-muted small">Адрес подключения по умолчанию, который будет использоваться для этого игрового сервера.</p>
                            </div>
                            <div class="form-group">
                                <label for="pAddAllocations" class="control-label">Назначить дополнительные порты</label>
                                <div>
                                    <select name="add_allocations[]" class="form-control" multiple id="pAddAllocations">
                                        @foreach ($unassigned as $assignment)
                                            <option value="{{ $assignment->id }}">{{ $assignment->alias }}:{{ $assignment->port }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <p class="text-muted small">Обратите внимание, что из-за ограничений программного обеспечения вы не можете назначать одинаковые порты на разных IP-адресах одному и тому же серверу.</p>
                            </div>
                            <div class="form-group">
                                <label for="pRemoveAllocations" class="control-label">Удалить дополнительные порты</label>
                                <div>
                                    <select name="remove_allocations[]" class="form-control" multiple id="pRemoveAllocations">
                                        @foreach ($assigned as $assignment)
                                            <option value="{{ $assignment->id }}">{{ $assignment->alias }}:{{ $assignment->port }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <p class="text-muted small">Просто выберите, какие порты вы хотите удалить. Если вы хотите назначить порт другому IP-адресу, который уже используется, вы можете выбрать его и удалить здесь.</p>
                            </div>
                        </div>
                        <div class="box-footer">
                            {!! csrf_field() !!}
                            <button type="submit" class="btn btn-primary pull-right">Обновить конфигурацию сборки</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('footer-scripts')
    @parent
    <script>
    $('#pAddAllocations').select2();
    $('#pRemoveAllocations').select2();
    $('#pAllocation').select2();
    </script>
@endsection
