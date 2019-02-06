{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.admin')

@section('title')
    Гнезда &rarr; Новое яйцо
@endsection

@section('content-header')
    <h1>Новое яйцо<small>Создайте новое яйцо для назначения серверам.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Администратор</a></li>
        <li><a href="{{ route('admin.nests') }}">Гнезда</a></li>
        <li class="active">Новое яйцо</li>
    </ol>
@endsection

@section('content')
<form action="{{ route('admin.nests.egg.new') }}" method="POST">
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
                                <label for="pNestId" class="form-label">Связанное гнездо</label>
                                <div>
                                    <select name="nest_id" id="pNestId">
                                        @foreach($nests as $nest)
                                            <option value="{{ $nest->id }}" {{ old('nest_id') != $nest->id ?: 'selected' }}>{{ $nest->name }} &lt;{{ $nest->author }}&gt;</option>
                                        @endforeach
                                    </select>
                                    <p class="text-muted small">Думайте о гнезде как о категории. Вы можете поместить несколько яиц в гнездо, но рассмотрите возможность размещения в каждом гнезде только тех яиц, которые связаны друг с другом.</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="pName" class="form-label">Название</label>
                                <input type="text" id="pName" name="name" value="{{ old('name') }}" class="form-control" />
                                <p class="text-muted small">Простое, понятное человеку имя для использования в качестве идентификатора для этого яйца. Это то, что пользователи увидят как тип игрового сервера.</p>
                            </div>
                            <div class="form-group">
                                <label for="pDescription" class="form-label">Описание</label>
                                <textarea id="pDescription" name="description" class="form-control" rows="8">{{ old('description') }}</textarea>
                                <p class="text-muted small">Описание этого яйца.</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="pDockerImage" class="control-label">Образ Докера</label>
                                <input type="text" id="pDockerImage" name="docker_image" value="{{ old('docker_image') }}" placeholder="quay.io/pterodactyl/service" class="form-control" />
                                <p class="text-muted small">Образ докера по умолчанию, который должен использоваться для новых серверов, использующих это яйцо. Это может быть изменено для каждого сервера.</p>
                            </div>
                            <div class="form-group">
                                <label for="pStartup" class="control-label">Команда запуска</label>
                                <textarea id="pStartup" name="startup" class="form-control" rows="14">{{ old('startup') }}</textarea>
                                <p class="text-muted small">Команда запуска по умолчанию, которая должна использоваться для новых серверов, созданных с этим яйцом. Вы можете изменить это для сервера по мере необходимости.</p>
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
                                <p>Все поля являются обязательными, если вы не выберете отдельную опцию из выпадающего меню «Копировать настройки из», и в этом случае поля можно оставить пустыми, чтобы использовать значения из этой опции.</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="pConfigFrom" class="form-label">Копировать настройки из</label>
                                <select name="config_from" id="pConfigFrom" class="form-control">
                                    <option value="">НЕТ</option>
                                </select>
                                <p class="text-muted small">Если вы хотите использовать настройки по умолчанию для другого яйца, выберите его в раскрывающемся списке выше.</p>
                            </div>
                            <div class="form-group">
                                <label for="pConfigStop" class="form-label">Команда остановки</label>
                                <input type="text" id="pConfigStop" name="config_stop" class="form-control" value="{{ old('config_stop') }}" />
                                <p class="text-muted small">Команда, которая должна быть отправлена на серверные процессы, чтобы остановить их изящно. Если вам нужно отправить <code>SIGINT</code>, введите <code>^C</code>.</p>
                            </div>
                            <div class="form-group">
                                <label for="pConfigLogs" class="form-label">Конфигурация логов</label>
                                <textarea data-action="handle-tabs" id="pConfigLogs" name="config_logs" class="form-control" rows="6">{{ old('config_logs') }}</textarea>
                                <p class="text-muted small">Это должно быть представление JSON того, где хранятся файлы логов, и должен ли демон создавать собственные логи.</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="pConfigFiles" class="form-label">Конфигурационные файлы</label>
                                <textarea data-action="handle-tabs" id="pConfigFiles" name="config_files" class="form-control" rows="6">{{ old('config_files') }}</textarea>
                                <p class="text-muted small">Это должно быть JSON-представление файлов конфигурации, которые нужно изменить, и какие части следует изменить.</p>
                            </div>
                            <div class="form-group">
                                <label for="pConfigStartup" class="form-label">Конфигурация запуска</label>
                                <textarea data-action="handle-tabs" id="pConfigStartup" name="config_startup" class="form-control" rows="6">{{ old('config_startup') }}</textarea>
                                <p class="text-muted small">Это должно быть представление JSON того, какие значения должен искать демон при загрузке сервера, чтобы определить завершение.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    {!! csrf_field() !!}
                    <button type="submit" class="btn btn-success btn-sm pull-right">Создать</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('footer-scripts')
    @parent
    {!! Theme::js('vendor/lodash/lodash.js') !!}
    <script>
    $(document).ready(function() {
        $('#pNestId').select2().change();
        $('#pConfigFrom').select2();
    });
    $('#pNestId').on('change', function (event) {
        $('#pConfigFrom').html('<option value="">None</option>').select2({
            data: $.map(_.get(Pterodactyl.nests, $(this).val() + '.eggs', []), function (item) {
                return {
                    id: item.id,
                    text: item.name + ' <' + item.author + '>',
                };
            }),
        });
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
