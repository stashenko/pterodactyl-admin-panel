{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.admin')

@section('title')
    Список пакетов
@endsection

@section('content-header')
    <h1>Packs<small>Все сервисные пакеты доступные в системе.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Администратор</a></li>
        <li class="active">Пакеты</li>
    </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Список пакетов</h3>
                <div class="box-tools">
                    <form action="{{ route('admin.packs') }}" method="GET">
                        <div class="input-group input-group-sm">
                            <input type="text" name="query" class="form-control pull-right" style="width:30%;" value="{{ request()->input('query') }}" placeholder="Search Packs">
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                <a href="{{ route('admin.packs.new') }}"><button type="button" class="btn btn-sm btn-primary" style="border-radius: 0 3px 3px 0;margin-left:-1px;">Создать новый</button></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <th>Название пакета</th>
                            <th>Версия</th>
                            <th>Описание</th>
                            <th>Яйцо</th>
                            <th class="text-center">Серверы</th>
                        </tr>
                        @foreach ($packs as $pack)
                            <tr>
                                <td class="middle" data-toggle="tooltip" data-placement="right" title="{{ $pack->uuid }}"><code>{{ $pack->id }}</code></td>
                                <td class="middle"><a href="{{ route('admin.packs.view', $pack->id) }}">{{ $pack->name }}</a></td>
                                <td class="middle"><code>{{ $pack->version }}</code></td>
                                <td class="col-md-6">{{ str_limit($pack->description, 150) }}</td>
                                <td class="middle"><a href="{{ route('admin.nests.egg.view', $pack->egg->id) }}">{{ $pack->egg->name }}</a></td>
                                <td class="middle text-center">{{ $pack->servers_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($packs->hasPages())
                <div class="box-footer with-border">
                    <div class="col-md-12 text-center">{!! $packs->appends(['query' => Request::input('query')])->render() !!}</div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
