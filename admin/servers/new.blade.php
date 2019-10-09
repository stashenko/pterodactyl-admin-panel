{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.admin')

@section('title')
    Новый сервер
@endsection

@section('content-header')
    <h1>Создание сервера<small>Добавить новый сервер в панель.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Администратор</a></li>
        <li><a href="{{ route('admin.servers') }}">Серверы</a></li>
        <li class="active">Создать сервер</li>
    </ol>
@endsection

@section('content')
<form action="{{ route('admin.servers.new') }}" method="POST">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Основные детали</h3>
                </div>
                <div class="box-body row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pName">Название сервера</label>
                            <input type="text" class="form-control" id="pName" name="name" value="{{ old('name') }}" placeholder="Server Name">
                            <p class="small text-muted no-margin">Ограничение символов: <code>a-z A-Z 0-9 _ - .</code> и <code>[Space]</code> (maкс 200 символов).</p>
                        </div>
                        <div class="form-group">
                            <label for="pUserId">Владелец сервера</label>
                            <select class="form-control" style="padding-left:0;" name="owner_id" id="pUserId"></select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="description" class="control-label">Описание сервера</label>
                            <textarea name="description" rows="3" class="form-control">{{ old('description') }}</textarea>
                            <p class="text-muted small">Краткое описание этого сервера.</p>
                        </div>
                        <div class="form-group">
                            <div class="checkbox checkbox-primary no-margin-bottom">
                                <input id="pStartOnCreation" name="start_on_completion" type="checkbox" value="1" checked />
                                <label for="pStartOnCreation" class="strong">Запустить сервер после установки</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="overlay" id="allocationLoader" style="display:none;"><i class="fa fa-refresh fa-spin"></i></div>
                <div class="box-header with-border">
                    <h3 class="box-title">Управление распределением</h3>
                </div>
                <div class="box-body row">
                    <div class="form-group col-sm-4">
                        <label for="pNodeId">Узел</label>
                        <select name="node_id" id="pNodeId" class="form-control">
                            @foreach($locations as $location)
                                <optgroup label="{{ $location->long }} ({{ $location->short }})">
                                @foreach($location->nodes as $node)

                                <option value="{{ $node->id }}"
                                    @if($location->id === old('location_id')) selected @endif
                                >{{ $node->name }}</option>

                                @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        <p class="small text-muted no-margin">Узел, на котором будет развернут этот сервер.</p>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="pAllocation">Распределение по умолчанию</label>
                        <select name="allocation_id" id="pAllocation" class="form-control"></select>
                        <p class="small text-muted no-margin">Основное Распределение, которое будет назначено этому серверу.</p>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="pAllocationAdditional">Дополнительное распределение</label>
                        <select name="allocation_additional[]" id="pAllocationAdditional" class="form-control" multiple></select>
                        <p class="small text-muted no-margin">Дополнительные распределения для назначения этому серверу при создании.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="overlay" id="allocationLoader" style="display:none;"><i class="fa fa-refresh fa-spin"></i></div>
                <div class="box-header with-border">
                    <h3 class="box-title">Пределы возможностей приложения</h3>
                </div>
                <div class="box-body row">
                    <div class="form-group col-xs-6">
                        <label for="cpu" class="control-label">Ограничение базы данных</label>
                        <div>
                            <input type="text" name="database_limit" class="form-control" value="{{ old('database_limit', 0) }}"/>
                        </div>
                        <p class="text-muted small">Общее количество баз данных, которые пользователь может создать для этого сервера. Оставьте пустым, чтобы разрешить неограничено.</p>
                    </div>
                    <div class="form-group col-xs-6">
                        <label for="cpu" class="control-label">Предел распределения</label>
                        <div>
                            <input type="text" name="allocation_limit" class="form-control" value="{{ old('allocation_limit', 0) }}"/>
                        </div>
                        <p class="text-muted small">Общее количество портов, которые пользователь может создать для этого сервера. Оставьте пустым, чтобы разрешить неограниченное.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Управление ресурсами</h3>
                </div>
                <div class="box-body row">
                    <div class="form-group col-sm-4">
                        <label for="pMemory">Память</label>
                        <div class="input-group">
                            <input type="text" value="{{ old('memory') }}" class="form-control" name="memory" id="pMemory" />
                            <span class="input-group-addon">MB</span>
                        </div>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="pSwap">Своп</label>
                        <div class="input-group">
                            <input type="text" value="{{ old('swap', 0) }}" class="form-control" name="swap" id="pSwap" />
                            <span class="input-group-addon">MB</span>
                        </div>
                    </div>
                </div>
                <div class="box-footer no-border no-pad-top no-pad-bottom">
                    <p class="text-muted small">Если вы не хотите назначать пространство подкачки серверу, просто укажите значение <code>0</code> или <code>-1</code>, чтобы разрешить неограниченное пространство подкачки. Если вы хотите отключить ограничение памяти на сервере, просто введите <code>0</code> в поле памяти.<p>
                </div>
                <div class="box-body row">
                    <div class="form-group col-sm-4">
                        <label for="pDisk">Дисковое пространство</label>
                        <div class="input-group">
                            <input type="text" class="form-control" value="{{ old('disk') }}" name="disk" id="pDisk" />
                            <span class="input-group-addon">MB</span>
                        </div>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="pCPU">Предел процессора</label>
                        <div class="input-group">
                            <input type="text" class="form-control" value="{{ old('cpu', 0) }}" name="cpu" id="pCPU" />
                            <span class="input-group-addon">%</span>
                        </div>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="pIO">Вес блока ввода-вывода</label>
                        <div class="input-group">
                            <input type="text" class="form-control" value="{{ old('io', 500) }}" name="io" id="pIO" />
                            <span class="input-group-addon">I/O</span>
                        </div>
                    </div>
                </div>
                <div class="box-footer no-border no-pad-top no-pad-bottom">
                    <p class="text-muted small">Если вы не хотите ограничивать использование ЦП, установите значение <code>0</code>. Чтобы определить значение, возьмите количество <em>physical</em> ядер и умножьте его на 100. Например, в четырехъядерной системе <code>(4 * 100 = 400)</code> то <code>400%</code> доступно. Чтобы ограничить использование сервером половины одного ядра, вы должны установить значение <code>50</code>. Чтобы разрешить серверу использовать до двух физических ядер, установите значение <code>200</code>. Блок ввода-вывода должен иметь значение между <code>10</code> и <code>1000</code>. Для получения дополнительной информации см. <a href="https://docs.docker.com/engine/reference/run/#/block-io-bandwidth-blkio-constraint" target="_blank"> эту документацию </a><p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Конфигурация гнезда</h3>
                </div>
                <div class="box-body row">
                    <div class="form-group col-xs-12">
                        <label for="pNestId">Гнездо</label>
                        <select name="nest_id" id="pNestId" class="form-control">
                            @foreach($nests as $nest)
                                <option value="{{ $nest->id }}"
                                    @if($nest->id === old('nest_id'))
                                        selected="selected"
                                    @endif
                                >{{ $nest->name }}</option>
                            @endforeach
                        </select>
                        <p class="small text-muted no-margin">Выберите Гнездо, под которым этот сервер будет сгруппирован.</p>
                    </div>
                    <div class="form-group col-xs-12">
                        <label for="pEggId">Яйцо</label>
                        <select name="egg_id" id="pEggId" class="form-control"></select>
                        <p class="small text-muted no-margin">Выберите Яйцо, которое определит, как должен работать этот сервер.</p>
                    </div>
                    <div class="form-group col-xs-12">
                        <label for="pPackId">Пакет данных</label>
                        <select name="pack_id" id="pPackId" class="form-control"></select>
                        <p class="small text-muted no-margin">Выберите пакет данных, который будет автоматически установлен на этом сервере при первом создании.</p>
                    </div>
                    <div class="form-group col-xs-12">
                        <div class="checkbox checkbox-primary no-margin-bottom">
                            <input id="pSkipScripting" name="skip_scripts" type="checkbox" value="1" />
                            <label for="pSkipScripting" class="strong">Пропустить скрипт установки яйца</label>
                        </div>
                        <p class="small text-muted no-margin">Если к выбранному Яйцу присоединен скрипт установки, он будет запущен во время установки после установки пакета. Если вы хотите пропустить этот шаг, установите этот флажок.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Конфигурация Докера</h3>
                </div>
                <div class="box-body row">
                    <div class="form-group col-xs-12">
                        <label for="pDefaultContainer">Образ Докера</label>
                        <input id="pDefaultContainer" name="image" value="{{ old('image') }}" class="form-control" />
                        <p class="small text-muted no-margin">Это образ Docker по умолчанию, который будет использоваться для запуска этого сервера.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Конфигурация запуска</h3>
                </div>
                <div class="box-body row">
                    <div class="form-group col-xs-12">
                        <label for="pStartup">Команда запуска</label>
                        <input type="text" id="pStartup" value="{{ old('startup') }}" class="form-control" name="startup" />
                        <p class="small text-muted no-margin">Для команды запуска доступны следующие заменители данных: <code>@{{SERVER_MEMORY}}</code>, <code>@{{SERVER_IP}}</code>, и <code>@{{SERVER_PORT}}</code>. Они будут заменены на выделенную память, IP-адрес сервера и порт сервера соответственно.</p>
                    </div>
                </div>
                <div class="box-header with-border" style="margin-top:-10px;">
                    <h3 class="box-title">Переменные обслуживания</h3>
                </div>
                <div class="box-body row" id="appendVariablesTo"></div>
                <div class="box-footer">
                    {!! csrf_field() !!}
                    <input type="submit" class="btn btn-success pull-right" value="Create Server" />
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('footer-scripts')
    @parent
    {!! Theme::js('vendor/lodash/lodash.js') !!}
    {!! Theme::js('js/admin/new-server.js') !!}
@endsection
