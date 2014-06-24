$(function () {
	var $table = $("#results-table");
	var $tableRows = $table.find("tbody > tr");

	$("#js-show-extra-info")
		.on("click",function(){
			$table
				.find(".js-extra-info")
				.toggleClass("hide", !this.checked);
		});

	$("#js-choose-rows")
		.on("change", function(){
			if(this.value==='accepts'){
				$tableRows.hide().filter(".js-row-accept").show();
			}else if(this.value==='declines'){
				$tableRows.hide().filter(".js-row-decline").show();
			}else{
				$tableRows.show();
			}
		});

		$('#chart-overall').highcharts({
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false
			},
			credits:{enabled:false},
			title: {text: null},
			tooltip: {
				formatter:function(){
					return "<strong>"+this.y + " " + this.point.name + "</strong><br/>" + this.percentage.toFixed(1)+"%"
				}
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						distance: -40,
						color: '#FFFFFF',
						formatter:function(){
							return "<strong>"+this.y + " " + this.point.name + "</strong>";//<br/>" + this.percentage.toFixed(1)+"%"
						}
					}
				}
			},
			series: [{
				type: 'pie',
				size: "100%",
				data: [
					{
						name: 'Accepts',
						y: totalAccepts,
						color: '#3c763d'
					},
					{
						name: "Plus One's",
						y: totalPlusOnes,
						color: '#31708f'
					},
					{
						name: 'Declines',
						y: totalDeclines,
						color: '#a94442',
					},
				]
			}]
		});
	
	$tableRows.find('.js-locate').on("click", function(ev){
		ev.preventDefault();

		var $me = $(this);
		var $location = $(this).siblings('.js-location');
		var $ip = $me.siblings('.js-ip')
		var ipUrl = 'http://smart-ip.net/geoip-json/'+ $ip.text().trim()+'?callback='+callbackFn;
		var callbackFn = 'jsonCallback';

		$me.hide();
		$location.removeClass('text-danger').html("Locating...")
		
		$.ajax({
		   type: 'GET',
			url: ipUrl,
			async: false,
			jsonpCallback: callbackFn,
			contentType: "application/json",
			dataType: 'jsonp',
			success: function(json) {
				//console.log(json);
				if(!json.error && json.city && json.region){
					$ip.addClass('text-muted');
					var htmlString = json.city + ", " + json.region;
					if(json.latitude && json.longitude){
						htmlString +="<br/><a target='_blank' href='http://maps.google.com/maps?q="+json.latitude+","+json.longitude+"'>View Map</a>";
					}

					$location.html(htmlString);
				}else{
					$me.show();
					$location.addClass('text-danger').text('Could not locate!')
				}

			},
			error: function(e) {
			   //console.error(e);
			   $me.show();
			   $location.addClass('text-danger').text('Could not locate!')
			}
		});
	});
});