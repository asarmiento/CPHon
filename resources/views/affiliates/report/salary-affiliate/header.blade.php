<img src="{{ asset('images/logo.jpg') }}" style="float: right; height: 85px; position: absolute; right: 5em; top: -1em;">
<p style="margin:0; font-size: 14px;">Impreso el: {{ $arrDateNow[0] }} Hora: {{ $arrDateNow[1] }}</p>
<p style="margin:0; font-size: 14px;">INSTITUTO DE PREVISION SOCIAL DEL PERIODISTA</p>
{{-- <p style="margin-bottom:0;">Carnet IPP: {{ $affiliate->charter }} - Fecha de Nacimiento: {{ $birthdate }} - Edad: {{ $age }} - Fecha de Ingreso: {{ $date_affiliate }}</p> --}}
<p style="margin:0; font-size: 14px;">{{ strtoupper($affiliate->fullname()) }}</p>
{{-- <p style="margin-bottom:0;">Tiempo para Jubilación Voluntaria: {{ (dateMandatory() - $age) > 0 ? dateMandatory() - $age .' años.' : 'Jubilado'}}</p>
<p style="margin-bottom:0;">Tiempo para Jubilación Obligatoria: {{ (dateVoluntary() - $age) > 0 ?  dateVoluntary() - $age .' años.' : 'Jubilado'}}</p> --}}
<p style="font-size: 14px; margin: 1em 0 0 0;">Sueldo declarado del Afiliado</p>