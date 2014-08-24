<h2 class="section-title">Honeymoon Photos</h2>

<div class="row">
	<?
	for ($i=1; $i <= 50; $i++) {
		$num = $i < 10 ? "0".$i : $i;
	?>
		<div class="col-xs-3 col-md-2">
			<a href="images/honeymoon-<? echo $num; ?>.jpg" class="thumbnail" data-lightbox="honeymoon">
				<img class="img-rounded" src="images/honeymoon-<? echo $num; ?>-thumb.jpg" alt="">
			</a>
		</div>
	<? } ?>
</div>

<p>photos by <a href="http://chris-barr.com">Chris Barr</a></h3>