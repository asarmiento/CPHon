{{-- <p style="margin: 0.5em 0 0 0;">Sueldo Promedio: {{ $salary_prom }} </p>
<p style="margin-bottom: 0;">Cuotas por pagar: {{ $dues_total - $dues_payment }} </p>
<p>Cuotas pagadas: {{ $dues_payment }} de {{ $dues_total }}. </p> --}}
<p style="font-size: 14px;margin: 0;">Total Sueldos D. Cont.: {{ $total_private / (recordPercentage()->percentage/100) }}</p>
<p style="font-size: 14px;margin: 0;">Sueldo Promedio Cont.: {{ $total_affiliate / $dues_total }} </p>
<p style="font-size: 14px;margin: 0 0 1em 0;">Total Pagado Cont.: {{ $total_affiliate }} </p>
<p style="font-size: 14px;margin: 0;">Total Sueldos D. 10%.: {{ $total_private / (recordPercentage()->percentage/100) }}</p>
<p style="font-size: 14px;margin: 0;">Sueldo Promedio Cont.: {{  $total_private / $dues_total }}</p>
<p style="font-size: 14px;margin: 0;">Total Pagado Cont.: {{ $total_private }}</p>