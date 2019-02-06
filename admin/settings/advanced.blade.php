@extends('layouts.admin')
@include('partials/admin.settings.nav', ['activeTab' => 'advanced'])

@section('title')
    Расширенные настройки
@endsection

@section('content-header')
    <h1>Расширенные настройки<small>Настройте дополнительные параметры для Pterodactyl.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Администратор</a></li>
        <li class="active">Настройки</li>
    </ol>
@endsection

@section('content')
    @yield('settings::nav')
    <div class="row">
        <div class="col-xs-12">
            <form action="" method="POST">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">reCAPTCHA</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="control-label">Статус</label>
                                <div>
                                    <select class="form-control" name="recaptcha:enabled">
                                        <option value="true">Вкл.</option>
                                        <option value="false" @if(old('recaptcha:enabled', config('recaptcha.enabled')) == '0') selected @endif>Выкл.</option>
                                    </select>
                                    <p class="text-muted small">Если эта опция включена, формы входа в систему и формы сброса пароля будут выполнять автоматическую проверку капчи и при необходимости отображать видимую капчу.</p>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Site Key</label>
                                <div>
                                    <input type="text" required class="form-control" name="recaptcha:website_key" value="{{ old('recaptcha:website_key', config('recaptcha.website_key')) }}">
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Secret Key</label>
                                <div>
                                    <input type="text" required class="form-control" name="recaptcha:secret_key" value="{{ old('recaptcha:secret_key', config('recaptcha.secret_key')) }}">
                                    <p class="text-muted small">Используется для связи между вашим сайтом и Google. Обязательно держите это в секрете.</p>
                                </div>
                            </div>
                        </div>
                        @if($showRecaptchaWarning)
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="alert alert-warning no-margin">
                                        В настоящее время вы используете ключи reCAPTCHA, поставляемые с этой панелью. Для повышения безопасности рекомендуется <a href="https://www.google.com/recaptcha/admin">создавать новые невидимые ключи reCAPTCHA</a>, которые привязаны к вашему веб-сайту.
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">HTTP соединения</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="control-label">Время соединения вышло</label>
                                <div>
                                    <input type="number" required class="form-control" name="pterodactyl:guzzle:connect_timeout" value="{{ old('pterodactyl:guzzle:connect_timeout', config('pterodactyl.guzzle.connect_timeout')) }}">
                                    <p class="text-muted small">Время ожидания в секундах до открытия соединения перед выдачей ошибки.</p>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label">Тайм-аут запроса</label>
                                <div>
                                    <input type="number" required class="form-control" name="pterodactyl:guzzle:timeout" value="{{ old('pterodactyl:guzzle:timeout', config('pterodactyl.guzzle.timeout')) }}">
                                    <p class="text-muted small">Время ожидания в секундах для завершения запроса до выдачи ошибки.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Консоль</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="control-label">Количество сообщений</label>
                                <div>
                                    <input type="number" required class="form-control" name="pterodactyl:console:count" value="{{ old('pterodactyl:console:count', config('pterodactyl.console.count')) }}">
                                    <p class="text-muted small">Количество сообщений, передаваемых на консоль за такт частоты.</p>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label">Частота такта</label>
                                <div>
                                    <input type="number" required class="form-control" name="pterodactyl:console:frequency" value="{{ old('pterodactyl:console:frequency', config('pterodactyl.console.frequency')) }}">
                                    <p class="text-muted small">Интервал времени в миллисекундах между каждым тиком отправки консольного сообщения.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box box-primary">
                    <div class="box-footer">
                        {{ csrf_field() }}
                        <button type="submit" name="_method" value="PATCH" class="btn btn-sm btn-primary pull-right">Сохранить</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
