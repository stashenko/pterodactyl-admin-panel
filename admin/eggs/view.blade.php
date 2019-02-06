{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.admin')

@section('title')
    Гнезда &rarr; Яйцо: {{ $egg->name }}
@endsection

@section('content-header')
    <h1>{{ $egg->name }}<small>{{ str_limit($egg->description, 50) }}</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Администратор</a></li>
        <li><a href="{{ route('admin.nests') }}">Гнезда</a></li>
        <li><a href="{{ route('admin.nests.view', $egg->nest->id) }}">{{ $egg->nest->name }}</a></li>
        <li class="active">{{ $egg->name }}</li>
    </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="nav-tabs-custom nav-tabs-floating">
            <ul class="nav nav-tabs">
                <li class="active"><a href="{{ route('admin.nests.egg.view', $egg->id) }}">Конфигурация</a></li>
                <li><a href="{{ route('admin.nests.egg.variables', $egg->id) }}">Переменные</a></li>
                <li><a href="{{ route('admin.nests.egg.scripts', $egg->id) }}">Скрипты</a></li>
            </ul>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="alert alert-info">
            <strong>Обратите внимание:</strong> для редактирования яйца или любого из полей управления процессами <em>требуется</em> перезагрузка каждого демона, чтобы применить изменения.
        </div>
    </div>
</div>
<form action="{{ route('admin.nests.egg.view', $egg->id) }}" enctype="multipart/form-data" method="POST">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-danger">
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-8">
                            <div class="form-group no-margin-bottom">
                                <label for="pName" class="control-label">Файл яйца</label>
                                <div>
                                    <input type="file" name="import_file" class="form-control" style="border: 0;margin-left:-10px;" />
                                    <p class="text-muted small no-margin-bottom">Если вы хотите заменить настройки для этого яйца, загрузив новый файл JSON, просто выберите его здесь и нажмите "Обновить яйцо". Это не изменит существующие строки запуска или образы Docker для существующих серверов.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            {!! csrf_field() !!}
                            <button type="submit" name="_method" value="PUT" class="btn btn-sm btn-danger pull-right">Обновить яйцо</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<form action="{{ route('admin.nests.egg.view', $egg->id) }}" method="POST">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Конфигурация</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="pName" class="control-label">Название <span class="field-required"></span></label>
                                <input type="text" id="pName" name="name" value="{{ $egg->name }}" class="form-control" />
                                <p class="text-muted small">Простое, понятное человеку имя для использования в качестве идентификатора для этого яйца.</p>
                            </div>
                            <div class="form-group">
                                <label for="pUuid" class="control-label">UUID</label>
                                <input type="text" id="pUuid" readonly value="{{ $egg->uuid }}" class="form-control" />
                                <p class="text-muted small">Это глобально уникальный идентификатор для этого яйца, который демон использует в качестве идентификатора.</p>
                            </div>
                            <div class="form-group">
                                <label for="pAuthor" class="control-label">Автор</label>
                                <input type="text" id="pAuthor" readonly value="{{ $egg->author }}" class="form-control" />
                                <p class="text-muted small">Автор этой версии Яйца. Загрузка новой конфигурации Яйца от другого автора изменит это.</p>
                            </div>
                            <div class="form-group">
                                <label for="pDockerImage" class="control-label">Образ Докера <span class="field-required"></span></label>
                                <input type="text" id="pDockerImage" name="docker_image" value="{{ $egg->docker_image }}" class="form-control" />
                                <p class="text-muted small">Образ докера по умолчанию, который должен использоваться для новых серверов, использующих это яйцо. Это может быть изменено для каждого сервера по мере необходимости.</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="pDescription" class="control-label">Описание <span class="field-required"></span></label>
                                <textarea id="pDescription" name="description" class="form-control" rows="6">{{ $egg->description }}</textarea>
                                <p class="text-muted small">Описание этого яйца, которое будет отображаться по всей панели по мере необходимости.</p>
                            </div>
                            <div class="form-group">
                                <label for="pStartup" class="control-label">Команда запуска <span class="field-required"></span></label>
                                <textarea id="pStartup" name="startup" class="form-control" rows="6">{{ $egg->startup }}</textarea>
                                <p class="text-muted small">Команда запуска по умолчанию, которая должна использоваться для новых серверов, использующих это яйцо.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Управление процессом</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="alert alert-warning">
                                <p>Следующие параметры конфигурации не должны редактироваться, если вы не понимаете, как работает эта система. В случае неправильного изменения демон может сломаться.</p>
                                <p>Все поля являются обязательными, если вы не выберете отдельную опцию в раскрывающемся меню "Копировать настройки из", и в этом случае поля можно оставить пустыми, чтобы использовать значения из этого яйца.</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="pConfigFrom" class="form-label">Копировать настройки из</label>
                                <select name="config_from" id="pConfigFrom" class="form-control">
                                    <option value="">None</option>
                                    @foreach($egg->nest->eggs as $o)
                                        <option value="{{ $o->id }}" {{ ($egg->config_from !== $o->id) ?: 'selected' }}>{{ $o->name }} &lt;{{ $o->author }}&gt;</option>
                                    @endforeach
                                </select>
                                <p class="text-muted small">Если вы хотите использовать настройки по умолчанию для другого яйца, выберите его в меню выше.</p>
                            </div>
                            <div class="form-group">
                                <label for="pConfigStop" class="form-label">Команда Стоп</label>
                                <input type="text" id="pConfigStop" name="config_stop" class="form-control" value="{{ $egg->config_stop }}" />
                                <p class="text-muted small">Команда, которая должна быть отправлена на серверные процессы, чтобы остановить их изящно. Если вам нужно отправить <code>SIGINT</code>, введите <code>^C</code> .</p>
                            </div>
                            <div class="form-group">
                                <label for="pConfigLogs" class="form-label">Конфигурация логов</label>
                                <textarea data-action="handle-tabs" id="pConfigLogs" name="config_logs" class="form-control" rows="6">{{ ! is_null($egg->config_logs) ? json_encode(json_decode($egg->config_logs), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : '' }}</textarea>
                                <p class="text-muted small">Это должно быть представление JSON того, где хранятся файлы логов, и должен ли демон создавать собственные логи.</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="pConfigFiles" class="form-label">Конфигурационные файлы</label>
                                <textarea data-action="handle-tabs" id="pConfigFiles" name="config_files" class="form-control" rows="6">{{ ! is_null($egg->config_files) ? json_encode(json_decode($egg->config_files), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : '' }}</textarea>
                                <p class="text-muted small">Это должно быть JSON-представление файлов конфигурации, которые нужно изменить, и какие части следует изменить.</p>
                            </div>
                            <div class="form-group">
                                <label for="pConfigStartup" class="form-label">Конфигурация запуска</label>
                                <textarea data-action="handle-tabs" id="pConfigStartup" name="config_startup" class="form-control" rows="6">{{ ! is_null($egg->config_startup) ? json_encode(json_decode($egg->config_startup), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : '' }}</textarea>
                                <p class="text-muted small">Это должно быть представление JSON того, какие значения должен искать демон при загрузке сервера и чтобы определить завершение.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    {!! csrf_field() !!}
                    <button type="submit" name="_method" value="PATCH" class="btn btn-primary btn-sm pull-right">Сохранить</button>
                    <a href="{{ route('admin.nests.egg.export', ['option' => $egg->id]) }}" class="btn btn-sm btn-info pull-right" style="margin-right:10px;">Экспорт</a>
                    <button id="deleteButton" type="submit" name="_method" value="DELETE" class="btn btn-danger btn-sm muted muted-hover">
                        <i class="fa fa-trash-o"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="alert alert-info">
                <strong>Обратите внимание:</strong> для редактирования яйца или любого из полей управления процессами <em>требуется</em> перезагрузка каждого демона, чтобы применить изменения.
            </div>
        </div>
    </div>
</form>
@endsection

@section('footer-scripts')
    @parent
    <script>
    $('#pConfigFrom').select2();
    $('#deleteButton').on('mouseenter', function (event) {
        $(this).find('i').html(' Delete Egg');
    }).on('mouseleave', function (event) {
        $(this).find('i').html('');
    });
    $('textarea[data-action="handle-tabs"]').on('keydown', function(event) {
        if (event.keyCode === 9) {
            event.preventDefault();

            var curPos = $(this)[0].selectionStart;
            var prepend = $(this).val().substr(0, curPos);
            var append = $(this).val().substr(curPos);

            $(this).val(prepend + '    ' + append);
        }
    });
    </script>
@endsection
