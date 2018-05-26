<body style="padding-top:65px;">
	<h1 class="text-center">Editor Simple de Código HTML</h1>
	<div class="container">
		<div class="row">
			<div class="table-responsive">
				<table class="table table-bordered ">
					<thead class="thead-dark">
						<tr>
							<th>Código CSS</th>
							<th>Código HTML</th>
							<th>Código JS</th>
						</tr>
					</thead>
					<tbody>
						<form action="" method="post">
						<tr>
							<td><textarea class="form-control" name="css" id="css" cols="45" rows="10"></textarea></td>
							<td><textarea class="form-control" name="html" id="html" cols="45" rows="10"></textarea></td>
							<td><textarea class="form-control" name="js" id="js" cols="45" rows="10"></textarea></td>
						</tr>
						<tr>
							<td colspan='3' class="text-center">
								<input type="button" value="Visualizar" onclick="visualizar()" class="btn btn-primary">
							</td>
						</tr>
						<tr>
							<th colspan='3' class="text-center">Resultado</th>
						</tr>
						<tr>
							<td colspan='3'>
								<iframe id="res" src="res" width="100%" frameborder="0"></iframe>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</body>