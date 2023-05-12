<!DOCTYPE html>
<html>
<head>
	<title>View Export Data</title>
</head>
<body>
	<style type="text/css">
	body{
		font-family: sans-serif;
	}
	table{
		margin: 20px auto;
		border-collapse: collapse;
	}
	table th,
	table td{
		border: 1px solid #3c3c3c;
		padding: 3px 8px;
 
	}
	a{
		background: blue;
		color: #fff;
		padding: 8px 10px;
		text-decoration: none;
		border-radius: 2px;
	}
	</style>

	<?php
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan.xls");
	?>

	<center>
		<h1>Export Data Ke Excel</h1>
	</center>

	<table border="1">
		<tr>
			<th>Tanggal</th>
			<th style="width: 400px;">Rincian Transaksi</th>
			<th>Kredit</th>
			<th>Debit</th>
            <th>No. Dokumen</th>
            <th>Analisis Input</th>
		</tr>
        @foreach ($data as $key)
            <tr>
				<td>{{$key->tanggal}}</td>
                <td>{{$key->rincian_transaksi}}</td>
                <td>{{$key->kredit}}</td>
                <td>{{$key->debit}}</td>
                <td>{{$key->no_dokumen}}</td>
                <td>{{$key->analisis_input}}</td>
            </tr> 
        @endforeach
	</table>
	
</body>
</html>