<h2 class="section-title">Wedding Photos</h2>

<div class="row">
	<?
	for ($i=1; $i <= 15; $i++) {
		$num = $i < 10 ? "0".$i : $i;
	?>
		<div class="col-xs-3 col-md-2">
			<a href="images/wedding-fb-<? echo $num; ?>.jpg" class="thumbnail" data-lightbox="wedding-fb">
				<img class="img-rounded" src="images/wedding-fb-<? echo $num; ?>-thumb.jpg" alt="">
			</a>
		</div>
	<? } ?>
</div>

<p>photos from friends on facebook</p>


<hr />
<h3 class="text-center">Professional Photos Coming Soon!</h3>