<<<<<<< HEAD
<h1>Parts</h1>

<form method="post" action="PartController/build">
	<button class="btn btn-default">Build more parts</button>
</form>

<form method="post" action="PartController/buy">
	<button class="btn btn-default">Buy parts</button>
</form>

<br>

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
=======
<h1>Parts</h1>

<form method="post" action="PartController/build">
	<button class="btn btn-default">Build more parts</button>
</form>

<form method="post" action="PartController/buy">
	<button class="btn btn-default">Buy parts</button>
</form>

<br>

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
>>>>>>> 54ba26353fe409c8e34ed40f8aea2fb87b078a36
</div>