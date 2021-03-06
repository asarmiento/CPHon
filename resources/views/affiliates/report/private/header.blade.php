{{ addPage() }}
<img src="{{ asset('images/logo.jpg') }}" style="float: right; height: 85px; position: absolute; right: 5em; top: -1em;">
<p style="margin:0; font-size: 14px;">Página: {{ Session::get('page') }}  impreso el: {{ $arrDateNow[0] }} Hora: {{ $arrDateNow[1] }}</p>
<p style="margin:0; font-size: 14px;">INSTITUTO DE PREVISION SOCIAL DEL PERIODISTA</p>
<p style="margin:0; font-size: 14px;">Carnet IPP: {{ $affiliate->charter }} - Fecha de Nacimiento: {{ $birthdate }} - Edad: {{ $age }} - Fecha de Ingreso: {{ $date_of_admission }}</p>
<p style="margin:0; font-size: 14px;">{{ strtoupper($affiliate->fullname()) }}</p>
<p style="margin:0; font-size: 14px;">Tiempo para Jubilación Voluntaria: {{ (dateMandatory() - $age) > 0 ? dateMandatory() - $age .' años.' : 'Jubilado'}}</p>
<p style="margin:0; font-size: 14px;">Tiempo para Jubilación Obligatoria: {{ (dateVoluntary() - $age) > 0 ?  dateVoluntary() - $age .' años.' : 'Jubilado'}}</p>
<p style="margin:1em 0 0 0; font-size: 14px;">Pago de Cuota Sector Privado: {{ recordPercentage()->percentage .' %.'}}</p>