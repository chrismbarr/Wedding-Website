<?php
	require 'rsvp/rsvp_Database.php';
	$DB = new Database;
	$results = $DB->GetResults();
	$allRows = array();

	$totalResponses = $results->num_rows;
	$totalAccepts = 0;
	$totalDeclines = 0;
	$totalPlusOnes = 0;
	
	while ($row = $results->fetch_assoc()) {
		array_push($allRows, $row);

		if($row["attendance"]){
			$totalAccepts ++;
			
			if($row["plus_one"]){
				$totalPlusOnes ++;
			}
		}else{
			$totalDeclines ++;
		}
	}

	//Free result set?
	$results->free();
	
	//Calculate the grand total
	$grandTotal= $totalAccepts + $totalPlusOnes;
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Chris And Kirstin - RSVP Results!</title>
	<link rel="stylesheet" href="styles/results.css" />
	<!--[if IE]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<script>
		var totalResponses = <? echo $totalResponses; ?>;
		var totalAccepts = <? echo $totalAccepts; ?>;
		var totalDeclines = <? echo $totalDeclines; ?>;
		var totalPlusOnes = <? echo $totalPlusOnes; ?>;
	</script>
</head>
<body>

	<div class="container">

		<div class="row">
			<div class="col-sm-7 col-md-4 col-lg-5">
				<h3>Totals</h3>
				<p>
					There are <strong><? echo $totalResponses;?> total Responses</strong>.
					<br />
					<strong class='text-success'><? echo $totalAccepts;?> have accepted</strong>, and <strong class='text-danger'><? echo $totalDeclines;?> have declined</strong>.
					<br />
					Of those that accepted, <strong class='text-info'><? echo $totalPlusOnes;?> will be bringing a plus-one</strong>.
					<br />
					According to responses, there should be <br/><strong class='text-success' style='font-size: 20px;'><? echo $grandTotal;?> in attendance!</strong>
				</p>
			</div>
			<div class="col-sm-5 col-md-5 col-lg-4">
				<div id="chart-overall" style="height:300px;"></div>
			</div>
			<div class="col-md-3 col-lg-3">
				<h3>Display Options</h3>
				
				<div class="form-group">
					<select id="js-choose-rows" class='form-control'>
						<option value="all" selected='selected'>Show All RSVP's</option>
						<option value="accepts">Only show Acceptances</option>
						<option value="declines">Only show Declines</option>
					</select>
				</div>
				<div class="form-group">
					<div class="checkbox">
						<label>
							<input id="js-show-extra-info" type="checkbox"> Show Extra Info
						</label>
					</div>
				</div>
			</div>
		</div>

		<hr />
		<h3>Responses</h3>

		<h5 class="visible-xs text-info">Scroll right &amp; left to see more of the table!</h5>
		<div class="table-responsive">
			<table id="results-table" class="table table-condensed table-striped table-bordered">
				<colgroup>
					<col class='hide js-extra-info' style="width: 25px;"/>
					<col/>
					<col/>
					<col style="width: 130px;"/>
					<col style="width: 80px;"/>
					<col/>
					<col class='hide js-extra-info' style="width: 90px;"/>
					<col class='hide js-extra-info'/>
				</colgroup>
				<thead>
					<tr>
						<th class='hide js-extra-info'>ID</th>
						<th>Name</th>
						<th>Address</th>
						<th>Attendance?</th>
						<th>Plus One?</th>
						<th>Notes</th>
						<th class='hide js-extra-info'>Date</th>
						<th class='hide js-extra-info'>IP Address</th>
					</tr>
				</thead>
				<tbody>
					<?php
						foreach ($allRows as $row) {
							echo "<tr class='".($row["attendance"] ? 'js-row-accept' : 'js-row-decline')."'>";
							echo "<td class='hide info js-extra-info'>".$row["id"]."</td>";
							echo "<td>".$row["name"]."</td>";
							echo "<td class='cell-multiline'>".$row["address"]."</td>";
							echo "<td class='cell-centered ".($row["attendance"]?"success":"danger")."'>".($row["attendance"] ? "<strong class='text-success'>Yes</strong>" : "<strong class='text-danger'>No</strong>");
							echo ($row["attendance_details"] ? "<br /><small class='text-muted'>(".$row["attendance_details"].")</small>" : "")."</td>";
							if($row["attendance"]){
								echo "<td class='cell-centered ".($row["plus_one"]?"success":"danger")."'>".($row["plus_one"] ? "<strong class='text-success'>Yes</strong>" : "<strong class='text-danger'>No</strong>")."</td>";
							}else{
								echo "<td class='cell-centered text-muted'>N/A</td>";
							}
							echo "<td class='cell-multiline'>".$row["notes"]."</td>";
							echo "<td class='hide info js-extra-info'>".date("D M j", strtotime($row["date"]))."<br/>at ".date("g:ia", strtotime($row["date"]))."</td>";
							echo "<td class='hide info js-extra-info'>";
							echo "<div class='js-ip'>".$row["ipaddress"]."</div>";
							//echo "<a class='js-locate' href='#'>Click to Locate</a><div class='js-location'></div>";
							echo "</td>";
							echo "</tr>";
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
	<?php include_once("parts/scripts.php"); ?>
</body>
</html>