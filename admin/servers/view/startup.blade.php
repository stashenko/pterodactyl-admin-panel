{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.admin')

@section('title')
    Сервер — {{ $server->name }}: Запуск
@endsection

@section('content-header')
    <h1>{{ $server->name }}<small>Управляйте командой запуска, а также переменными.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Администратор</a></li>
        <li><a href="{{ route('admin.servers') }}">Серверы</a></li>
        <li><a href="{{ route('admin.servers.view', $server->id) }}">{{ $server->name }}</a></li>
        <li class="active">Запуск</li>
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
                    <li class="active"><a href="{{ route('admin.servers.view.startup', $server->id) }}">Запуск</a></li>
                    <li><a href="{{ route('admin.servers.view.database', $server->id) }}">База данных</a></li>
                    <li><a href="{{ route('admin.servers.view.manage', $server->id) }}">Управление</a></li>
                @endif
                <li class="tab-danger"><a href="{{ route('admin.servers.view.delete', $server->id) }}">Удалить</a></li>
                <li class="tab-success"><a href="{{ route('server.index', $server->uuidShort) }}"><i class="fa fa-external-link"></i></a></li>
            </ul>
        </div>
    </div>
</div>
<form action="{{ route('admin.servers.view.startup', $server->id) }}" method="POST">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Модификация команды запуска</h3>
                </div>
                <div class="box-body">
                    <label for="pStartup" class="form-label">Команды запуска</label>
                    <input id="pStartup" name="startup" class="form-control" type="text" value="{{ old('startup', $server->startup) }}" />
                    <p class="small text-muted">Отредактируйте команду запуска вашего сервера. Следующие переменные доступны по умолчанию: <code>@{{SERVER_MEMORY}}</code>, <code>@{{SERVER_IP}}</code>, и <code>@{{SERVER_PORT}}</code>.</p>
                </div>
                <div class="box-body">
                    <label for="pDefaultStartupCommand" class="form-label">Команда запуска по умолчанию</label>
                    <input id="pDefaultStartupCommand" class="form-control" type="text" readonly />
                </div>
                <div class="box-footer">
                    {!! csrf_field() !!}
                    <button type="submit" class="btn btn-primary btn-sm pull-right">Сохранить изменения</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Конфигурация сервиса</h3>
                </div>
                <div class="box-body row">
                    <div class="col-xs-12">
                        <p class="small text-danger">
                            Изменение любого из приведенных ниже значений приведет к тому, что сервер обработает команду переустановки. Сервер будет остановлен и продолжит работу.
                            Если вы меняете пакет, существующие данные <em>могут </em> быть перезаписаны. Если вы хотите, чтобы служебные сценарии не запускались, убедитесь, что флажок внизу установлен.
                        </p>
                        <p class="small text-danger">
                            <strong>Это разрушительная операция во многих случаях. Этот сервер будет немедленно остановлен для продолжения этого действия.</strong>
                        </p>
                    </div>
                    <div class="form-group col-xs-12">
                        <label for="pNestId">Гнездо</label>
                        <select name="nest_id" id="pNestId" class="form-control">
                            @foreach($nests as $nest)
                                <option value="{{ $nest->id }}"
                                    @if($nest->id === $server->nest_id)
                                        selected
                                    @endif
                                >{{ $nest->name }}</option>
                            @endforeach
                        </select>
                        <p class="small text-muted no-margin">Выберите Гнездо, в которое этот сервер будет сгруппирован.</p>
                    </div>
                    <div class="form-group col-xs-12">
                        <label for="pEggId">Яйцо</label>
                        <select name="egg_id" id="pEggId" class="form-control"></select>
                        <p class="small text-muted no-margin">Выберите Яйцо, которое обеспечит обработку данных для этого сервера.</p>
                    </div>
                    <div class="form-group col-xs-12">
                        <label for="pPackId">Пакет данных</label>
                        <select name="pack_id" id="pPackId" class="form-control"></select>
                        <p class="small text-muted no-margin">Выберите пакет данных, который будет автоматически установлен на этом сервере при первом создании.</p>
                    </div>
                    <div class="form-group col-xs-12">
                        <div class="checkbox checkbox-primary no-margin-bottom">
                            <input id="pSkipScripting" name="skip_scripting" type="checkbox" value="1" @if($server->skip_scripts) checked @endif />
                            <label for="pSkipScripting" class="strong">Пропустить скрипт установки яйца</label>
                        </div>
                        <p class="small text-muted no-margin">Если к выбранному яйцу прикреплен скрипт установки, он будет запущен во время установки после установки пакета. Если вы хотите пропустить этот шаг, установите этот флажок.</p>
                    </div>
                </div>
            </div>
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Конфигурация Docker-контейнера</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="pDockerImage" class="control-label">Образ</label>
                        <input type="text" name="docker_image" id="pDockerImage" value="{{ $server->image }}" class="form-control" />
                        <p class="text-muted small">Образ Docker для использования на этом сервере. Образ по умолчанию для выбранного яйца <code id="setDefaultImage"></code>.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row" id="appendVariablesTo"></div>
        </div>
    </div>
</form>
@endsection

@section('footer-scripts')
    @parent
    {!! Theme::js('vendor/lodash/lodash.js') !!}
    <script>
    $(document).ready(function () {
        $('#pPackId').select2({placeholder: 'Select a Service Pack'});
        $('#pEggId').select2({placeholder: 'Select a Nest Egg'}).on('change', function () {
            var selectedEgg = _.isNull($(this).val()) ? $(this).find('option').first().val() : $(this).val();
            var parentChain = _.get(Pterodactyl.nests, $("#pNestId").val());
            var objectChain = _.get(parentChain, 'eggs.' + selectedEgg);

            $('#setDefaultImage').html(_.get(objectChain, 'docker_image', 'undefined'));
            $('#pDockerImage').val(_.get(objectChain, 'docker_image', 'undefined'));
            if (objectChain.id === parseInt(Pterodactyl.server.egg_id)) {
                $('#pDockerImage').val(Pterodactyl.server.image);
            }

            if (!_.get(objectChain, 'startup', false)) {
                $('#pDefaultStartupCommand').val(_.get(parentChain, 'startup', 'ERROR: Startup Not Defined!'));
            } else {
                $('#pDefaultStartupCommand').val(_.get(objectChain, 'startup'));
            }

            $('#pPackId').html('').select2({
                data: [{id: '0', text: 'No Service Pack'}].concat(
                    $.map(_.get(objectChain, 'packs', []), function (item, i) {
                        return {
                            id: item.id,
                            text: item.name + ' (' + item.version + ')',
                        };
                    })
                ),
            });

            if (Pterodactyl.server.pack_id !== null) {
                $('#pPackId').val(Pterodactyl.server.pack_id);
            }

            $('#appendVariablesTo').html('');
            $.each(_.get(objectChain, 'variables', []), function (i, item) {
                var setValue = _.get(Pterodactyl.server_variables, item.env_variable, item.default_value);
                var isRequired = (item.required === 1) ? '<span class="label label-danger">Required</span> ' : '';
                var dataAppend = ' \
                    <div class="col-xs-12"> \
                        <div class="box"> \
                            <div class="box-header with-border"> \
                                <h3 class="box-title">' + isRequired + item.name + '</h3> \
                            </div> \
                            <div class="box-body"> \
                                <input name="environment[' + item.env_variable + ']" class="form-control" type="text" id="egg_variable_' + item.env_variable + '" /> \
                                <p class="no-margin small text-muted">' + item.description + '</p> \
                            </div> \
                            <div class="box-footer"> \
                                <p class="no-margin text-muted small"><strong>Startup Command Variable:</strong> <code>' + item.env_variable + '</code></p> \
                                <p class="no-margin text-muted small"><strong>Input Rules:</strong> <code>' + item.rules + '</code></p> \
                            </div> \
                        </div> \
                    </div>';
                $('#appendVariablesTo').append(dataAppend).find('#egg_variable_' + item.env_variable).val(setValue);
            });
        });

        $('#pNestId').select2({placeholder: 'Select a Nest'}).on('change', function () {
            $('#pEggId').html('').select2({
                data: $.map(_.get(Pterodactyl.nests, $(this).val() + '.eggs', []), function (item) {
                    return {
                        id: item.id,
                        text: item.name,
                    };
                }),
            });

            if (_.isObject(_.get(Pterodactyl.nests, $(this).val() + '.eggs.' + Pterodactyl.server.egg_id))) {
                $('#pEggId').val(Pterodactyl.server.egg_id);
            }

            $('#pEggId').change();
        }).change();
    });
    </script>
@endsection
