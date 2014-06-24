<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script>if (typeof jQuery == 'undefined')document.write(unescape("%3Cscript src='scripts/_libraries/jquery.min.js'%3E%3C/script%3E"));</script>
<?php
	$urlPath = parse_url(($_SERVER['REQUEST_URI']))["path"];
	$isLocal = in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1', 'localhost'));
	if(stristr($urlPath, "results")){ ?>
		<script src='http://code.highcharts.com/highcharts.js'></script>
		<script src="scripts/results.js"></script>
	<?
	}else{
		if($isLocal){
		?>
			<script src="scripts/_libraries/jquery.easing.js"></script>
			<script src="scripts/_libraries/jquery.stellar.js"></script>
			<script src="scripts/_bootstrap/scrollspy.js"></script>
			<script src="scripts/site.js"></script>
		<? }else{ ?>
			<script src="scripts/site.min.js"></script>
<?		}
	}?>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-47826171-1', 'chrisandkirstin.com');
  ga('send', 'pageview');
</script>