<div class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.packs.new') }}" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Установить пакет из шаблона</h4>
                </div>
                <div class="modal-body">
                    <div class="well" style="margin-bottom:0">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="pEggIdModal" class="form-label">Ассоциированное яйцо:</label>
                                <select id="pEggIdModal" name="egg_id" class="form-control">
                                    @foreach($nests as $nest)
                                        <optgroup label="{{ $nest->name }}">
                                            @foreach($nest->eggs as $egg)
                                                <option value="{{ $egg->id }}">{{ $egg->name }}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                                <p class="text-muted small">Яйцо, с которым связан этот пакет. Только серверы, которым назначено это Яйцо, смогут получить доступ к этому пакету.</p>
                            </div>
                        </div>
                        <div class="row" style="margin-top:15px;">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label class="control-label">Архив пакетов:</label>
                                        <input name="file_upload" type="file" accept=".zip,.json, application/json, application/zip" />
                                        <p class="text-muted"><small>Этот файл должен быть либо файлом шаблона <code>.json </code>, либо архивом пакета <code>.zip </code>, содержащим <code>archive.tar.gz </code> и <code>import.json </code>. <br /> <br /> Этот сервер в настоящее время настроен со следующими ограничениями: <code>upload_max_filesize={{ ini_get('upload_max_filesize') }}</code> и <code>post_max_size={{ ini_get('post_max_size') }}</code>. Если ваш файл больше любого из этих значений, этот запрос не будет выполнен.</small></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {!! csrf_field() !!}
                    <button type="submit" name="action" value="from_template" class="btn btn-primary btn-sm">Установка</button>
                    <button type="button" class="btn btn-default btn-sm pull-left" data-dismiss="modal">Отмена</button>
                </div>
            </form>
        </div>
    </div>
</div>
