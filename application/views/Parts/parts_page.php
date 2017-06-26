<h1>Parts</h1>
<div align="center"><br>
<form method="post" action="PartController/build">
	<button class="btn btn-secondary btn-lg">Build more parts</button>
</form><br><br>
<form method="post" action="PartController/buy">
	<button class="btn btn-secondary btn-lg">Buy parts</button>
</form><br><br>
</div>

<div class="row">
	{parts}
		<div class="col-xs-4" id="thePart">
			<a href="/parts/{partID}">
				<img class="img-responsive" src="/pix/parts/{model}{piece}.jpeg" title="{model}{piece}">
			</a>
			<h5 class="partTag1">Piece model: {model}</h5>
			<h5 class="partTag2">Line: {line}</h5>
		</div>
	{/parts}
</div>