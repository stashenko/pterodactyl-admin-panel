@section('settings::notice')
    @if(config('pterodactyl.load_environment_only', false))
        <div class="row">
            <div class="col-xs-12">
                <div class="alert alert-danger">
                    В настоящее время ваша панель настроена на чтение параметров только из среды. Вам нужно будет установить <code>LOAD_ENVIRONMENT_ONLY=false</code> в файле среды для динамической загрузки настроек.
                </div>
            </div>
        </div>
    @endif
@endsection
