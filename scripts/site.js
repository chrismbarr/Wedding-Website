var CK = (function () {
	var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|Opera Mini|IEMobile|Windows Phone|Zune/i.test(navigator.userAgent);
	var isOldIE = !isMobile && /msie [678]/i.test(navigator.userAgent);
	var $win = $([]);
	var $body = $([]);
	var $header = $([])
	var $links = $([]);
	var $sections = $([]);
	var easing = "easeInOutQuad";

	function setupSizes () {

		//========================================================
		//Add a top margin to the body that equals the height of the header
		//Only do this when the header is fixed
		var topMargin = getHeaderHeight();
		$body.css("margin-top", topMargin);

		if(headerIsFixed()){
			//If the header is fixed, apply ScrollSpy to highlight the current nav item
			$body.scrollspy({
				target: '#nav',
				offset: topMargin
			});

			//WAT?
			setTimeout(function () {
				$body.scrollspy("refresh");
			}, 50);

			//After page is done loading, refresh ScrollSpy to get correct positions now that the images have loaded
			$(document).load(function(){
				$body.scrollspy("refresh");
			});

		}else{
			//if the header is not fixed, we don't care about
			//highlighting the current nav item becasue
			//we won't be able to see it anyway
			$body
				.removeData('bs.scrollspy')
				.off('scroll.bs.scroll-spy.data-api');
			$links.removeClass('active');
		}
		//========================================================



		//========================================================
		//Make each section be at least as tall as the viewport.
		//But on mobile devices it is as tall as the screen
		var sectionHeight = $win.height() - topMargin;
		if(isMobile){
			$sections.not(".photo-section").css("min-height", sectionHeight);
		}else{
			$sections.css("min-height", sectionHeight);
		}
		
		//========================================================



		//========================================================
		//Make the wedding date & remaining days match in height
		var $equalHeightItems = $("#wedding-info-date, #wedding-info-remaining-days");
		$equalHeightItems.removeAttr("style");

		//Only continue for non-XS screen sizes
		if(headerIsFixed()){
			//Make the date & countdown match in height
			var dateSize = 0;
			
			$equalHeightItems.each(function () {
				//Determine the tallest item
				dateSize = Math.max(dateSize, $(this).height());
			});
			$equalHeightItems.height(dateSize);
		}
		//========================================================
	}

	function setupNavigation () {
		var eventName = "click.nav"
		$links.off(eventName).on(eventName, function (event) {
			//stop the default browser jump & URL hash modification
			event.preventDefault();

			//Find the element it would have jumped to
			var $target = $($(this).attr("href"));
			//and calculate it's top position with an offset for the header
			var targetTop = $target.position().top - getHeaderHeight() + 1; //add 1 so we are ensured to trigger the right nav bar highlighting

			$body.add("html").stop().animate({
				scrollTop: targetTop
			}, 2500, easing);
			
		});

		//Click the title to scroll to the first section, a photo.
		$("#title").off(eventName).on(eventName, function () {
			$links.first().triggerHandler(eventName);
		});
	}

	function setupImageEffects () {
		if(isMobile){
			//Remove min-height from photo sections on mobile devices
			$sections
				.filter(".photo-section")
				.removeAttr("style")
				.each(function () {
					//Loop through each photo section and set the BG image path to be on an image tag instead
					var myImage = $(this).css("background-image").replace(/^url\((.*)\)/,"$1");

					$(this)
						.css("background-image", "none")
						.find(".js-mobile-image")
						.removeClass('hide')
						.attr("src", myImage);
				})
		}else{
				//Set up stellar parallax scrolling stuff
			$win.stellar({
				responsive: true,
				horizontalScrolling: false,
				parallaxElements: false
			});
		}
	}

	function setupResizeCalculations () {
		var timer = null;

		$win.on("resize", function(){
			clearTimeout(timer);
			timer = setTimeout(function () {
				setupSizes();
				setupNavigation();

				if(!isMobile) $win.stellar("refresh");
			}, 300);
		});
	}

	function setupDateCountdown () {
		var today = new Date();
		var weddingDay = new Date(2014, 6, 19); //Months are zero-indexed!
		var offset = weddingDay.getTime() -  today.getTime();
		var remainingDays = Math.ceil(offset / 1000/60/60/24);

		if(remainingDays < 0){
			//It's in the past
			$("#js-wedding-past").removeClass("hide");
		}else if(remainingDays === 0){
			//Today
			$("#js-wedding-today").removeClass("hide");
		}else if(remainingDays === 1){
			//Tomorrow
			$("#js-wedding-tomorrow").removeClass("hide");
		}else{
			//Yet to come
			$("#js-wedding-future").removeClass("hide");
			$("#js-remaining-days").text(remainingDays);
		}
	}

	function setupBridalPartyInfo(){
		if(isMobile || isOldIE){
			var $people = $("#wedding-info .wedding-party-person");
			var $infoStuff = $people.find(".wedding-party-info").add("#wedding-party-backdrop");
			$people.find(".wedding-party-more,.wedding-party-img,.wedding-party-name")
				.click(function(event){
					event.preventDefault();
					
					$(this).siblings(".wedding-party-info").add("#wedding-party-backdrop").show();

					$(document).on("touchmove",function(event){
						event.preventDefault();
					});

					if(isMobile){
						//Dumb fix for android browser
						//http://stackoverflow.com/a/3485654/79677
						$body[0].style.display="none";
						$body[0].offsetHeight;
						$body[0].style.display="block";
					}
					
				});

			
			$infoStuff
				.on("click", function(){
					$infoStuff.hide();
					$(document).off("touchmove");
				});
		}
	}

	function setupForm(){
		var $theForm = $("#js-rsvp-form");
		var $changeForm = $("#js-rsvp-change");
		var $success = $("#js-rsvp-success");
		var $fields = $theForm.add($changeForm).find(":input").not(":submit,button");
		var formSpeed = 400;

		var hasPreviouslySubmitted = Boolean(readCookie(rsvpCookie)) == true;
		//var hasPreviouslySubmitted = false;

		if(hasPreviouslySubmitted){
			$theForm.hide();
			$success.removeClass("hide");
		}

		//hide plus-one if not attending & set it's value to be false
		$("#attendance_details").on("change", function(){
			var willAttend = $(this).children("[value='"+this.value+"']").data("accept");
			$("#js-plus-one").toggle(willAttend);

			//The height may have changed, refrsh scrollspy positioning!
			if(headerIsFixed) $body.scrollspy("refresh");

			if(!willAttend){
				$("#js-plus-one").find(":radio[value='false']").prop("checked", true);
			}
		});

		$theForm.on("submit",function (ev) {
			ev.preventDefault();

			//Disable fields while loading...
			_formIsSaving($theForm, true);

			var formData = $(this).serialize();
			var formUrl = $(this).attr("action");
			//console.clear();
			//console.log(formUrl+"?"+formData);

			$.ajax({
				type: "POST",
				url: formUrl,
				data: formData,
				success: function (data, textStatus, xhr) {
					try{
						//console.log("RESPONSE", data, textStatus, xhr);
						//Re-enable fields on success
						_formIsSaving($theForm, false);

						var jsonResponse = $.parseJSON(data);
						_displayValidationErrors(jsonResponse);

						//continute if valid
						if(jsonResponse.allValid){
							if(jsonResponse.rsvp.sent && jsonResponse.rsvp.saved){
								//If the RSVP email has been sent/saved, set a cookie so the users can't do this again
								createCookie(rsvpCookie, true);
								_completeSuccess();
							}else{
								//Problem sending email/saving record! Display a message.
								_displayAjaxErrors(jsonResponse.rsvp.msg, true);
							}
						}
					}catch(ex){
						_displayAjaxErrors(ex, false);
					}
				},
				error:function (event, jqXHR, ajaxSettings, thrownError) {
					//Re-enable fields
					_formIsSaving($theForm, false);
					_displayAjaxErrors(thrownError, true);
				}
			});
		});


		$("#js-make-change").on("click",function(ev){
			ev.preventDefault();
			$(this)
				.add($theForm)
				.add($success)
				.hide();

			$changeForm.removeClass("hide").show();

			//The height may have changed, refrsh scrollspy positioning!
			if(headerIsFixed) $body.scrollspy("refresh");
		});

		$("#js-no-change").on("click", function(ev){
			ev.preventDefault();
			$changeForm.addClass("hide");
			$("#js-make-change").show();

			if(hasPreviouslySubmitted){
				$success.removeClass("hide").show();
			}else{
				$theForm.show();
			}

			//The height may have changed, refrsh scrollspy positioning!
			if(headerIsFixed) $body.scrollspy("refresh");
		});

		$changeForm.on("submit",function (ev) {
			ev.preventDefault();

			//Disable the fields while loading
			_formIsSaving($changeForm, true);

			var formData = $(this).serialize()+"&change=true";
			var formUrl = $(this).attr("action");

			//console.clear();
			//console.log(formUrl+"?"+formData);

			$.ajax({
				type: "POST",
				url: formUrl,
				data: formData,
				success: function (data, textStatus, xhr) {
					try{
						//Re-enable fields on success
						_formIsSaving($changeForm, false);
						//console.log("CHANGE FORM RESPONSE", data, textStatus, xhr);

						var jsonResponse = $.parseJSON(data);
						_displayValidationErrors(jsonResponse);

						//continute if valid
						if(jsonResponse.allValid){
							if(jsonResponse.rsvp.sent){
								_completeSuccess();
							}else{
								//Problem sending email/saving record! Display a message.
								_displayAjaxErrors(jsonResponse.rsvp.msg, true);
							}
						}
					}catch(ex){
						//Re-enable fields
						_displayAjaxErrors(ex, false);
					}
				},
				error:function (event, jqXHR, ajaxSettings, thrownError) {
					_formIsSaving($changeForm, false);
					_displayAjaxErrors(thrownError, true);
				}
			});
		});
		
		var loadingTimer=null;
		function _formIsSaving($form, isSaving){
			var $inputs = $form.find(":input");
			var $submitBtn = $inputs.filter(":submit");
			var txtDataName = "originalText";

			clearTimeout(loadingTimer);
			loadingTimer = setTimeout(function(){
				$inputs.prop("disabled", isSaving);
				
				if(isSaving){
					$submitBtn.data(txtDataName, $submitBtn.val());
					$submitBtn.val("Saving...");
				}else{
					var oText = $submitBtn.data(txtDataName);
					
					if(oText){
						$submitBtn.val(oText);
					}
				}
			}, isSaving?200:0);
		}

		function _displayValidationErrors(responseJsonData){
			var errorClass = "has-error";
			var msgClass = "validation-msg";
			var validationData = responseJsonData.validation;

			//remove all errors intially
			$fields
				.closest('.form-group')
				.removeClass(errorClass)
				.find("."+msgClass)
				.remove();

			//Loop through each error that comes back and derermine what to do
			for (var i = 0; i < validationData.length; i++) {
				var fieldObj = validationData[i];
				var $thisField = $fields.filter("#"+fieldObj.field);

				if(!fieldObj.valid){
					$thisField
						.closest('.form-group')
						.addClass(errorClass)
						.append("<div class='help-block "+msgClass+"'>"+fieldObj.msg+"</div>")
				}
			};

			//Focus on the first error item
			$theForm.find("."+errorClass).first().find(":input").focus();

			//The height may have changed, refrsh scrollspy positioning!
			if(headerIsFixed) $body.scrollspy("refresh");
		}

		function _displayAjaxErrors(data, isUserFriendly){
			if(console && !isUserFriendly) console.error(data);
			
			//If we have an error object, pull the message out of it.
			var msg = isUserFriendly ? data : "There was an error saving your RSVP!<br/>Please try again later, but let us know that you had a problem!";
			
			//Put the error message into the HTML
			$("#js-rsvp-error").html(msg);

			//Display the message, and make it dismissable with a click
			var $items = $("#error-display, #error-backdrop");
			$items
				.fadeIn(formSpeed)
				.one("click", function(){
					$items.fadeOut(formSpeed);
				});
		}

		function _completeSuccess(){
			hasPreviouslySubmitted = true;
			//Show success message and scroll it into view
			$theForm.add($changeForm).hide();
			$success.removeClass("hide").show();
			$("#js-make-change").show();

			//clear out the values
			$fields.filter("select,textarea,:text").val('');

			//Animate to the top of what shows now
			$body.stop().animate({
				scrollTop: $("#rsvp").offset().top - getHeaderHeight()
			}, formSpeed, easing);

			//The height may have changed, refrsh scrollspy positioning!
			if(headerIsFixed) $body.scrollspy("refresh");
		}
	}

	

	//------------------------------------------------
	//Helpers
	function headerIsFixed () {
		return $header.css("position") === "fixed";
	}

	function getHeaderHeight(){
		return topMargin = headerIsFixed() ? $header.outerHeight() : 0;
	}

	var rsvpCookie = "RSVP";
	function createCookie(name, value) {
		var date = new Date();
		date.setTime(date.getTime()+(365*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
		document.cookie = name+"="+value+expires+"; path=/";
	}

	function readCookie(name) {
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for(var i=0;i < ca.length;i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1,c.length);
			if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
		}
		return null;
	}

	//------------------------------------------------
	//Page Load
	$(function () {
		$win = $(window);
		$body = $('body');
		$header = $("#header");
		$links = $('#nav a');
		$sections = $('.main-section');

		//Flag the page as being on a mobile device or a desktop
		$body.addClass("device-type-"+ (isMobile?"mobile":"desktop"));
		$body.addClass(isOldIE ? 'browser-bad' : 'browser-good');

		setupSizes();
		setupNavigation();
		setupImageEffects();
		setupResizeCalculations();
		setupDateCountdown();
		setupBridalPartyInfo();
		setupForm();
	});

	return {
		reset:function(){
			createCookie(rsvpCookie,"",-1);
		}
	}
})();