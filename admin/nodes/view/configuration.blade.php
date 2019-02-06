{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.admin')

@section('title')
    {{ $node->name }}: Конфигурация
@endsection

@section('content-header')
    <h1>{{ $node->name }}<small>Ваш конфигурационный файл демона.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Администрация</a></li>
        <li><a href="{{ route('admin.nodes') }}">Узлы</a></li>
        <li><a href="{{ route('admin.nodes.view', $node->id) }}">{{ $node->name }}</a></li>
        <li class="active">Конфигурация</li>
    </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="nav-tabs-custom nav-tabs-floating">
            <ul class="nav nav-tabs">
                <li><a href="{{ route('admin.nodes.view', $node->id) }}">Инфо</a></li>
                <li><a href="{{ route('admin.nodes.view.settings', $node->id) }}">Настройки</a></li>
                <li class="active"><a href="{{ route('admin.nodes.view.configuration', $node->id) }}">Конфигурация</a></li>
                <li><a href="{{ route('admin.nodes.view.allocation', $node->id) }}">Распределения</a></li>
                <li><a href="{{ route('admin.nodes.view.servers', $node->id) }}">Серверы</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Конфигурационный файл</h3>
            </div>
            <div class="box-body">
                <pre class="no-margin">{{ $node->getConfigurationAsJson(true) }}</pre>
            </div>
            <div class="box-footer">
                <p class="no-margin">Этот файл должен быть помещен в каталог <code>config</code> вашего демона в файле с именем <code>core.json</code>.</p>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Авто-развертывание</h3>
            </div>
            <div class="box-body">
                <p class="text-muted small">Чтобы упростить настройку узлов, можно получить конфигурацию с панели. Для этого процесса требуется токен. Кнопка ниже создаст токен и предоставит вам команды, необходимые для автоматической настройки узла. <em>Токены действительны только в течение 5 минут.</em></p>
            </div>
            <div class="box-footer">
                <button type="button" id="configTokenBtn" class="btn btn-sm btn-default" style="width:100%;">Создать токен</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer-scripts')
    @parent
    <script>
    $('#configTokenBtn').on('click', function (event) {
        $.getJSON('{{ route('admin.nodes.view.configuration.token', $node->id) }}').done(function (data) {
            swal({
                type: 'success',
                title: 'Token created.',
                text: 'Your token will expire <strong>in 5 minutes.</strong><br /><br />' +
                      '<p>To auto-configure your node run the following command:<br /><small><pre>npm run configure -- --panel-url {{ config('app.url') }} --token ' + data.token + '</pre></small></p>',
                html: true
            })
        }).fail(function () {
            swal({
                title: 'Error',
                text: 'Something went wrong creating your token.',
                type: 'error'
            });
        });
    });
    </script>
@endsection
