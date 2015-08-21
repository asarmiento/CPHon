{{-- <p style="margin: 0.5em 0 0 0;">Sueldo Promedio: {{ $salary_prom }} </p> --}}
<p style="margin:0;font-size: 14px;">Cuotas por pagar: {{ $dues_total - $dues_payment }} </p>
<p style="margin:0;font-size: 14px;">Cuotas pagadas: {{ $dues_payment }} de {{ $dues_total }}. </p>