{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.admin')

@section('title')
    Новый &rarr; Узел
@endsection

@section('content-header')
    <h1>Новый узел<small>Создайте новый локальный или удаленный узел для серверов, который будет установлен.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Администратор</a></li>
        <li><a href="{{ route('admin.nodes') }}">Узлы</a></li>
        <li class="active">Новый</li>
    </ol>
@endsection

@section('content')
<form action="{{ route('admin.nodes.new') }}" method="POST">
    <div class="row">
        <div class="col-sm-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Основные детали</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="pName" class="form-label">Название</label>
                        <input type="text" name="name" id="pName" class="form-control" value="{{ old('name') }}"/>
                        <p class="text-muted small">Лимит символов: <code>a-zA-Z0-9_.-</code> и <code>[Space]</code> (мин 1, макс 100 символов).</p>
                    </div>
                    <div class="form-group">
                        <label for="pDescription" class="form-label">Описание</label>
                        <textarea name="description" id="pDescription" rows="4" class="form-control">{{ old('description') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="pLocationId" class="form-label">Локация</label>
                        <select name="location_id" id="pLocationId">
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}" {{ $location->id != old('location_id') ?: 'selected' }}>{{ $location->short }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Видимость узла</label>
                        <div>
                            <div class="radio radio-success radio-inline">

                                <input type="radio" id="pPublicTrue" value="1" name="public" checked>
                                <label for="pPublicTrue"> Публичный </label>
                            </div>
                            <div class="radio radio-danger radio-inline">
                                <input type="radio" id="pPublicFalse" value="0" name="public">
                                <label for="pPublicFalse"> Приватный </label>
                            </div>
                        </div>
                        <p class="text-muted small">Установив для узла значение <code>Приватный</code>, вы запретите автоматическое развертывание на этом узле.
                    </div>
                    <div class="form-group">
                        <label for="pFQDN" class="form-label">FQDN</label>
                        <input type="text" name="fqdn" id="pFQDN" class="form-control" value="{{ old('fqdn') }}"/>
                        <p class="text-muted small">Пожалуйста, введите доменное имя (например, <code>node.example.com</code>), которое будет использоваться для подключения к демону. IP-адрес может использоваться <em>только</em>, если вы не используете SSL для этого узла.</p>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Связь через SSL</label>
                        <div>
                            <div class="radio radio-success radio-inline">
                                <input type="radio" id="pSSLTrue" value="https" name="scheme" checked>
                                <label for="pSSLTrue"> Использовать SSL соединение</label>
                            </div>
                            <div class="radio radio-danger radio-inline">
                                <input type="radio" id="pSSLFalse" value="http" name="scheme" @if(request()->isSecure()) disabled @endif>
                                <label for="pSSLFalse"> Использовать HTTP соединение</label>
                            </div>
                        </div>
                        @if(request()->isSecure())
                            <p class="text-danger small">Ваша панель в настоящее время настроена на использование безопасного соединения. Чтобы браузеры могли подключаться к вашему узлу, он <strong>должен</strong> использовать соединение SSL.</p>
                        @else
                            <p class="text-muted small">В большинстве случаев вам следует использовать SSL-соединение. Если вы используете IP-адрес или вообще не хотите использовать SSL, выберите HTTP-соединение.</p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="form-label">Прокси</label>
                        <div>
                            <div class="radio radio-success radio-inline">
                                <input type="radio" id="pProxyFalse" value="0" name="behind_proxy" checked>
                                <label for="pProxyFalse"> Не за прокси </label>
                            </div>
                            <div class="radio radio-info radio-inline">
                                <input type="radio" id="pProxyTrue" value="1" name="behind_proxy">
                                <label for="pProxyTrue"> За прокси </label>
                            </div>
                        </div>
                        <p class="text-muted small">Если вы работаете с демоном за прокси-сервером, таким как Cloudflare, выберите этот параметр, чтобы демон пропускал поиск сертификатов при загрузке.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Конфигурация</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="form-group col-xs-12">
                            <label for="pDaemonBase" class="form-label">Файловый каталог Daemon Server</label>
                            <input type="text" name="daemonBase" id="pDaemonBase" class="form-control" value="/srv/daemon-data" />
                            <p class="text-muted small">Введите каталог, в котором должны храниться файлы сервера. <strong>Если вы используете OVH, вам следует проверить схему разделов. Вам может понадобиться использовать<code>/home/daemon-data</code>, чтобы иметь достаточно места.</strong></p>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pMemory" class="form-label">Общая память</label>
                            <div class="input-group">
                                <input type="text" name="memory" data-multiplicator="true" class="form-control" id="pMemory" value="{{ old('memory') }}"/>
                                <span class="input-group-addon">MB</span>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pMemoryOverallocate" class="form-label">Перераспределение памяти</label>
                            <div class="input-group">
                                <input type="text" name="memory_overallocate" class="form-control" id="pMemoryOverallocate" value="{{ old('memory_overallocate') }}"/>
                                <span class="input-group-addon">%</span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <p class="text-muted small">Введите общий объем памяти, доступный для новых серверов. Если вы хотите разрешить перераспределение памяти, введите процент, который вы хотите разрешить. Чтобы отключить проверку перераспределения, введите <code>-1</code> в поле. Ввод <code>0</code> предотвратит создание новых серверов, если это приведет к превышению лимита узла.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="pDisk" class="form-label">Общее дисковое пространство</label>
                            <div class="input-group">
                                <input type="text" name="disk" data-multiplicator="true" class="form-control" id="pDisk" value="{{ old('disk') }}"/>
                                <span class="input-group-addon">MB</span>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pDiskOverallocate" class="form-label">Перераспределение дисков</label>
                            <div class="input-group">
                                <input type="text" name="disk_overallocate" class="form-control" id="pDiskOverallocate" value="{{ old('disk_overallocate') }}"/>
                                <span class="input-group-addon">%</span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <p class="text-muted small">Введите общий объем дискового пространства, доступного для новых серверов. Если вы хотите разрешить перераспределение дискового пространства, введите процент, который вы хотите разрешить. Чтобы отключить проверку перераспределения, введите <code>-1</code> в поле. Ввод <code>0</code> предотвратит создание новых серверов, если это приведет к превышению лимита узла.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="pDaemonListen" class="form-label">Порт Демона</label>
                            <input type="text" name="daemonListen" class="form-control" id="pDaemonListen" value="8080" />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pDaemonSFTP" class="form-label">SFTP порт Демона</label>
                            <input type="text" name="daemonSFTP" class="form-control" id="pDaemonSFTP" value="2022" />
                        </div>
                        <div class="col-md-12">
                            <p class="text-muted small">Демон запускает свой собственный контейнер управления SFTP и не использует процесс SSHd на главном физическом сервере. <strong>Не используйте тот же порт, который вы назначили для процесса SSH вашего физического сервера.</strong> Если вы будете запускать демона за CloudFlare&reg; вам следует установить для порта демона значение <code>8443</code>, чтобы разрешить прокси-соединение через SSL.</p>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    {!! csrf_field() !!}
                    <button type="submit" class="btn btn-success pull-right">Создать узел</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('footer-scripts')
    @parent
    <script>
        $('#pLocationId').select2();
    </script>
@endsection