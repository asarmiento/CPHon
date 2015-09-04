<p style="font-size: 14px;margin: 0;">Total Sueldos D. Cont.: {{ number_format($dataAffiliate[count($dataAffiliate)-1][1],2,'.',',') }}</p>
<p style="font-size: 14px;margin: 0;">Sueldo Promedio Cont.: {{ number_format( ($dataAffiliate[count($dataAffiliate)-1][3]/$dataAffiliate[count($dataAffiliate)-1][2]), 2, '.', ',') }} </p>
<p style="font-size: 14px;margin: 0 0 1em 0;">Total Pagado Cont.: {{ number_format($dataAffiliate[count($dataAffiliate)-1][3],2,'.',',') }} </p>
<p style="font-size: 14px;margin: 0;">Total Sueldos D. 10%.: {{ number_format($dataPrivate[count($dataPrivate)-1][1],2,'.',',') }}</p>
<p style="font-size: 14px;margin: 0;">Sueldo Promedio 10%.: {{  number_format( ($dataPrivate[count($dataPrivate)-1][3]/$dataPrivate[count($dataPrivate)-1][2]), 2, '.', ',') }}</p>
<p style="font-size: 14px;margin: 0;">Total Pagado 10%.: {{ number_format($dataPrivate[count($dataPrivate)-1][3],2,'.',',') }}</p>
{{ destroyPage() }}