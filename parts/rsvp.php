<?php $rsvpForm = "rsvp/form.php"; ?>
<div class="row">
	<div class="col-sm-6">
		<h2 class="section-title">RSVP</h2>
	</div>
	<div class="col-sm-6">
		<h3 class="sub-section-title text-right hidden-xs" style="padding-top: 20px;">Please RSVP before July 1<sup>st</sup>!</h3>
		<h3 class="sub-section-title visible-xs">Please RSVP before July 1<sup>st</sup>!</h3>
	</div>
</div>

<form action="<?php echo $rsvpForm; ?>" method="get" accept-charset="utf-8" id="js-rsvp-form">
	
	<p>If you're here, then you've probably been invited to our wedding! Please fill out the form below to let us know if you plan on attending or not.</p>

	<div class="row">
		<div class="col-sm-6 col-md-5 col-md-offset-1 col-lg-4 col-lg-offset-2">
			<div class="form-group">
				<label class="control-label" for="name">Your Name(s)</label>
				<input type="text" class="form-control" id="name" name="name" placeholder="John &amp; Jane Doe" />
			</div>
		
			<div class="form-group">
				<label class="control-label" for="address">Your Address</label>
				<textarea class="form-control" id="address" name="address"></textarea>
			</div>

			<div class="form-group">
				<label class="control-label" for="attendance_details">Attendance</label>
				<span class="help-block">Do you accept our invitation?</span>
				<select name="attendance_details" id="attendance_details" class="form-control">
					<option value=""></option>
					<option value="Gladfully Accept" data-accept="true">I Will Gladfully ACCEPT</option>
					<option value="Regretfully Decline" data-accept="false">I Must Regretfully DECLINE</option>
					<option value="Regretfully Accept" data-accept="true">I Will Regretfully ACCEPT</option>
					<option value="Enthusiastically Decline" data-accept="false">I Enthusiastically DECLINE</option>
				</select>
			</div>
			
			<div class="form-group" id="js-plus-one">
				<label class="control-label">Plus One</label>
				<div id="radio">
					<label>
						<input type="radio" name="plus_one" value="false" checked="checked"> I <em class='text-info'>will not</em> be bringing a plus-one.
					</label>
				</div>
				<div id="radio">
					<label>
						<input type="radio" name="plus_one" value="true"> I <em class='text-info'>will</em> be bringing a plus-one.
					</label>
					<small>(More than 1 person attending)</small>
				</div>
				
			</div>
		</div>

		<div class="col-sm-6 col-md-5 col-lg-4">

			<div class="form-group">
				<label class="control-label" for="verification">Verification</label>
				<div class="help-block">To ensure that only those with invitations fill out this RSVP form, <strong>please enter the <u>fifth word</u> on the <u>front</u> of the invitation</strong> (it's in pink and begins with "e").</div>
				<input type="text" class="form-control" id="verification" name="verification" />
			</div>

			<div class="form-group">
				<label class="control-label" for="notes">Notes</label>
				<div class="help-block">Want to send us a message or let us know anything else? It's optional, no pressure.</div>
				<textarea name="notes" id="notes" class="form-control"></textarea>
			</div>
		</div>
	</div>

	<div class="row">
		
		<div class="col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
			<input type="submit" class="btn btn-block" value="Send My RSVP Information!"/>	
		</div>
	</div>
</form>

<h2 id="js-rsvp-success" class="hide">Thanks for sending your RSVP!</h2>

<a href="#" id="js-make-change" class="space-top">I already RSVP'd, but I need to make a change!</a>

<form action="<?php echo $rsvpForm; ?>" method="get" accept-charset="utf-8" id="js-rsvp-change" class="hide">
	
	<p>Did your plans change? Did you forget to mention something? Let us know about it!</p>
	<div class="row">
		<div class="col-sm-6 col-md-5 col-md-offset-1 col-lg-4 col-lg-offset-2">
			<div class="form-group">
				<label class="control-label" for="change_name">Your Name(s)</label>
				<input type="text" class="form-control" id="change_name" name="change_name" placeholder="John &amp; Jane Doe" />
			</div>
		
		</div>

		<div class="col-sm-6 col-md-5 col-lg-4">

			<div class="form-group">
				<label class="control-label" for="change_notes">What Needs To change?</label>
				<textarea name="change_notes" id="change_notes" class="form-control"></textarea>
			</div>
		</div>
	</div>

	<div class="row">
		
		<div class="col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
			<input type="submit" class="btn btn-block" value="Send My RSVP Change Information!"/>	
		</div>
	</div>

	<a href="#" id="js-no-change" class="space-top">I don't need to make a change.</a>
</form>

<div id="error-display">
	<h4>RSVP Error!</h4>
	<p id="js-rsvp-error"></p>
</div>
<div id="error-backdrop"></div>