{{-- <p style="margin: 0.5em 0 0 0;">Sueldo Promedio: {{ $salary_prom }} </p>
<p style="margin-bottom: 0;">Cuotas por pagar: {{ $dues_total - $dues_payment }} </p>
<p>Cuotas pagadas: {{ $dues_payment }} de {{ $dues_total }}. </p> --}}
<p style="font-size: 14px;margin: 0;">Total Sueldos D. Cont.: {{ $salary_affiliate }}</p>
<p style="font-size: 14px;margin: 0;">Sueldo Promedio Cont.: {{ number_format( (float) $salary_private / $dues_total_affiliate,2 ,'.',',') }} </p>
<p style="font-size: 14px;margin: 0 0 1em 0;">Total Pagado Cont.: {{ $amount_affiliate }} </p>
<p style="font-size: 14px;margin: 0;">Total Sueldos D. 10%.: {{ $salary_private }}</p>
<p style="font-size: 14px;margin: 0;">Sueldo Promedio Cont.: {{  number_format($salary_private / $dues_total_private, 2, '.', ',') }}</p>
<p style="font-size: 14px;margin: 0;">Total Pagado Cont.: {{ $amount_private }}</p>