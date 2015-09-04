{{ addPage(1) }}
<p style="margin:0; font-size: 14px;">Página: {{ Session::get('page') }} impreso el: {{ $arrDateNow[0] }} Hora: {{ $arrDateNow[1] }}</p>
<p style="margin:0; font-size: 14px;">INSTITUTO DE PREVISION SOCIAL DEL PERIODISTA</p>
<p style="margin:0; font-size: 14px;">{{ strtoupper($affiliate->fullname()) }}</p>
<p style="font-size: 14px; margin: 1em 0 0 0;">Sueldo Declarado del Sector Privado</p>