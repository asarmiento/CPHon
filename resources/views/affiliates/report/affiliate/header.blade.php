{{ addPage(1) }}
<img src="{{ asset('images/logo.jpg') }}" style="float: right; height: 85px; position: absolute; right: 5em; top: -1em;">
<p style="margin:0; font-size: 14px;">Página: {{ Session::get('page') }} impreso el: {{ $arrDateNow[0] }} Hora: {{ $arrDateNow[1] }}</p>
<p style="margin:0; font-size: 14px;">INSTITUTO DE PREVISION SOCIAL DEL PERIODISTA</p>
<p style="margin:0; font-size: 14px;">{{ strtoupper($affiliate->fullname()) }}</p>
<p style="margin:1em 0 0 0; font-size: 14px;">Pago de Contribución Afiliado</p>