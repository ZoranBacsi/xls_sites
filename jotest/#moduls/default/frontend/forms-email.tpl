<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="{lang:code}">
	<head>
		<title>{fix:mailSubject}</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta http-equiv="Cache-Control" content="no-cache">
		<meta http-equiv="Content-Language" content="{lang:code}">
		<style type="text/css">
			html,body {
				margin: 0px;
				padding: 0px;
				width: 100%;
				height: 100%;
				font-family: Arial;
				font-size: 12px;
				color: #000000;
			}
		</style>
	</head>
	<body>
		<h3>{fix:mailSubject}</h3>
		<table cellspacing="0" cellpadding="0" border="0" style="width:100%;">
			<tbody>
				<tr>
					<td>
						{fix:mailDataRows}
					</td>
				</tr>
			</tbody>
		</table>
	</body>
</html>