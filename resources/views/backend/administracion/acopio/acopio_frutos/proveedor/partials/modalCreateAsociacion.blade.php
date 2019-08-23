

     <div class="modal fade bs-example-modal-md in" id="nuevaAsociacion" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Nueva Asociacion</h4>
                </div>
                <div class="modal-body">
                    {!! Form::open(['id'=>'asociacion1'])!!}
                    <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                    <input id="id" name="id_asociacion" type="hidden" value="">
                        <fieldset>
                        <div class="row">
                            <div class="form-group">
                                <label class="col-md-3 control-label text-right" for="name">Nombre de la asociacion:</label>
                                <div class="col-md-9">
                                    {!! Form::text('asociacion', null, array('placeholder' => 'Ingrese nombre de la asociacion','maxlength'=>'50','class' => 'form-control','id'=>'asociacion')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label class="col-md-3 control-label text-right" for="name">Sigla:</label>
                                <div class="col-md-9">
                                    {!! Form::text('sigla', null, array('placeholder' => 'Ingrese sigla','maxlength'=>'50','class' => 'form-control','id'=>'sigla')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                 <label class="col-md-3 control-label text-right" for="name">Municipio:</label>
                                 <div class="col-md-9">
                                    <!-- {!! Form::select('id_municipio', $municipio, null,['class'=>'form-control','name'=>'id_municipio', 'id'=>'id_municipio']) !!} -->
                                     <select name="id_municipio" class="form-control id_municipioAso" id="id_municipio" style="width: 100%"></select>
                                 </div>
                            </div>
                        </div>
                        </fieldset>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Cerrar</button>
                    {!!link_to('#',$title='Registrar', $attributes=['id'=>'registroAsociacion','class'=>'btn btn-primary','style'=>'background:#57BC90'], $secure=null)!!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
{!! Html::script('js/jquery-3.1.0.min.js') !!}
{!! Html::script('plugins/select2/select2.min.js') !!}
{!! Html::script('plugins/select2/i18n/es.js') !!}
<script type="text/javascript">
    $('.id_municipioAso').select2({
    dropdownParent: $('#nuevaAsociacion'),
    placeholder: "Selec. Municipio",
    municipio: true,
    tokenSeparators: [','],
    ajax: {
        dataType: 'json',
        url: '{{ url("obtenerMunicipio") }}',
        delay: 250,
        data: function(params) {
            return {
                term: params.term
            }
        },
        processResults: function (data, page) {
            return {
            results: data
            };
        },
    },
    language: "es",
});
</script>