<p>Impreso el: {{ $arrDateNow[0] }} Hora: {{ $arrDateNow[1] }}</p>
<p>INSTITUTO DE PREVISION SOCIAL DEL PERIODISTA</p>
<p>Carnet IPP: {{ $affiliate->charter }} Nacimiento: {{ $affiliate->birthdate }} Edad {{ $age }}</p>
<p>{{ convertTitle($affiliate->fullname()) }}</p>
<p>Tiempo para Jubilación Voluntaria: {{ $age - dateMandatory() .' años.'}}</p>
<p>Tiempo para Jubilación Obligatoria: {{ $age - dateVoluntary() .' años.'}}</p>
<p>Pago de Cuota Sector Privado: {{ recordPercentage()->percentage .' %.'}}</p>