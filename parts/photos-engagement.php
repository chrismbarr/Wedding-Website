<h2 class="section-title">Engagement Photos</h2>

<div class="row">
	<?
	for ($i=1; $i <= 15; $i++) {
		$num = $i < 10 ? "0".$i : $i;
	?>
		<div class="col-xs-3 col-md-2">
			<a href="images/engagement-<? echo $num; ?>.jpg" class="thumbnail" data-lightbox="engagement">
				<img class="img-rounded" src="images/engagement-<? echo $num; ?>-thumb.jpg" alt="">
			</a>
		</div>
	<? } ?>
</div>

<p>photos by <a href="http://swakphotography.com">SWAK Photography</a></p>