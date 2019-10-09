{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.admin')

@section('title')
    Packs &rarr; New
@endsection

@section('content-header')
    <h1>Новый пакет<small>Создайте новый пакет в системе.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Администратор</a></li>
        <li><a href="{{ route('admin.packs') }}">Пакеты</a></li>
        <li class="active">Новый</li>
    </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="nav-tabs-custom nav-tabs-floating">
            <ul class="nav nav-tabs">
                <li class="active"><a href="{{ route('admin.packs.new') }}">Настроить вручную</a></li>
                <li><a href="#modal" id="toggleModal">Установить из шаблона</a></li>
            </ul>
        </div>
    </div>
</div>
<form action="{{ route('admin.packs.new') }}" method="POST" enctype="multipart/form-data">
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
                        <label for="pEggId" class="form-label">Ассоциированное яйцо</label>
                        <select id="pEggId" name="egg_id" class="form-control">
                            @foreach($nests as $nest)
                                <optgroup label="{{ $nest->name }}">
                                    @foreach($nest->eggs as $egg)
                                        <option value="{{ $egg->id }}">{{ $egg->name }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        <p class="text-muted small">Опция, с которой связан этот пакет. Только серверы, которым назначена эта опция, смогут получить доступ к этому пакету.</p>
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
                        <div class="checkbox checkbox-primary no-margin-bottom">
                            <input id="pSelectable" name="selectable" type="checkbox" value="1" checked/>
                            <label for="pSelectable">
                                Выбор
                            </label>
                        </div>
                        <p class="text-muted small">Установите этот флажок, если пользователь должен иметь возможность выбрать этот пакет для установки на своих серверах.</p>
                    </div>
                    <div class="form-group">
                        <div class="checkbox checkbox-primary no-margin-bottom">
                            <input id="pVisible" name="visible" type="checkbox" value="1" checked/>
                            <label for="pVisible">
                                Видимый
                            </label>
                        </div>
                        <p class="text-muted small">Установите этот флажок, если этот пакет отображается в раскрывающемся меню. Если этот пакет назначен серверу, он будет виден независимо от этого параметра.</p>
                    </div>
                    <div class="form-group">
                        <div class="checkbox checkbox-warning no-margin-bottom">
                            <input id="pLocked" name="locked" type="checkbox" value="1"/>
                            <label for="pLocked">
                                Заблокированный
                            </label>
                        </div>
                        <p class="text-muted small">Установите этот флажок, если серверы, назначенные этому пакету, не могут переключаться на другой пакет.</p>
                    </div>
                    <hr />
                    <div class="form-group no-margin-bottom">
                        <label for="pFileUpload" class="form-label">Архивы пакетов</label>
                        <input type="file" accept=".tar.gz, application/gzip" name="file_upload" class="well well-sm" style="width:100%"/>
                        <p class="text-muted small">Этот файл пакета должен быть <code>.tar.gz</code> архивом файлов пакета, который необходимо распаковать в папку на сервере.</p>
                        <p class="text-muted small">Если размер вашего файла превышает <code>50 МБ</code>, рекомендуется загрузить его с использованием SFTP. После того, как вы добавили этот пакет в систему, будет указан путь, куда вы должны загрузить файл.</p>
                        <div class="callout callout-info callout-slim no-margin-bottom">
                            <p class="text-muted small"><strong>Этот сервер в настоящее время настроен со следующими ограничениями:</strong><br /><code>upload_max_filesize={{ ini_get('upload_max_filesize') }}</code><br /><code>post_max_size={{ ini_get('post_max_size') }}</code><br /><br />Если ваш файл больше любого из этих значений, этот запрос не будет выполнен.</p>
                        </div>
                    </div>
                </div>
                <div class="box-footer with-border">
                    {!! csrf_field() !!}
                    <button class="btn btn-sm btn-success pull-right" type="submit">Создать пакет</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('footer-scripts')
    @parent
    <script>
        $('#pEggId').select2();
        $('#toggleModal').on('click', function (event) {
            event.preventDefault();

            $.ajax({
                method: 'GET',
                url: Router.route('admin.packs.new.template'),
                headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
            }).fail(function (jqXhr) {
                console.error(jqXhr);
                alert('Произошла ошибка при попытке создать модал загрузки.');
            }).done(function (data) {
                $(data).modal();
                $('#pEggIdModal').select2();
            });
        });
    </script>
@endsection
