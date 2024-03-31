import jQuery from 'jquery';(function ($) {
	"use strict";

	function Selector_Cache() {
		var collection = {};

		function get_from_cache(selector) {
			if (undefined === collection[selector]) {
				collection[selector] = $(selector);
			}

			return collection[selector];
		}

		return { get: get_from_cache };
	}

	var selectors = new Selector_Cache();

	jQuery(document).ready(function ($) { // wait until the document is ready
		$('#send').on('click', function () { // when the button is clicked the code executes
			$('.error').fadeOut('slow'); // reset the error messages (hides them)

			var error = false; // we will set this true if the form isn't valid

			var name = $('input#name').val(); // get the value of the input field
			if (name == "" || name == " ") {
				$('#err-name').fadeIn('slow'); // show the error message
				error = true; // change the error state to true
			}

			var email_compare = /^([a-z0-9_.-]+)@([da-z.-]+).([a-z.]{2,6})$/; // Syntax to compare against input
			var email = $('input#email').val(); // get the value of the input field
			if (email == "" || email == " ") { // check if the field is empty
				$('#err-email').fadeIn('slow'); // error - empty
				error = true;
			} else if (!email_compare.test(email)) { // if it's not empty check the format against our email_compare variable
				$('#err-emailvld').fadeIn('slow'); // error - not right format
				error = true;
			}
			var phone = $('input#phone').val(); // get the value of the input field
			if (phone == "" || phone == " ") {
				$('#err-phone').fadeIn('slow'); // show the error message
				error = true; // change the error state to true
			}
			var field = $('input#field').val(); // get the value of the input field
			if (field == "" || field == " ") {
				$('#err-field').fadeIn('slow'); // show the error message
				error = true; // change the error state to true
			}
			var company = $('input#company').val(); // get the value of the input field
			if (company == "" || company == " ") {
				$('#err-company').fadeIn('slow'); // show the error message
				error = true; // change the error state to true
			}
			var profession = $('input#profession').val(); // get the value of the input field
			if (profession == "" || profession == " ") {
				$('#err-profession').fadeIn('slow'); // show the error message
				error = true; // change the error state to true
			}
			var wilaya = $('input#wilaya').val(); // get the value of the input field
			if (wilaya == "" || wilaya == " ") {
				$('#err-wilaya	').fadeIn('slow'); // show the error message
				error = true; // change the error state to true
			}

			if (error == true) {
				$('#err-form').slideDown('slow');
				return false;
			}

			var data_string = $('#inscriptions-form').serialize(); // Collect data from form

			$.ajax({
				type: "POST",
				url: "server.php",
				data: data_string,
				timeout: 6000,
				error: function (request, error) {
					if (error == "timeout") {
						$('#err-timedout').slideDown('slow');
					}
					else {
						$('#err-state').slideDown('slow');
						$("#err-state").html('An error occurred: ' + error + '');
					}
				},
				success: function () {
					$('#contact-form').slideUp('slow');
					$('#ajaxsuccess').slideDown('slow');
				}
			});

			return false; // stops user browser being directed to the php file
		}); // end click function
		//Visitors function
		$('#sendVisitors').on('click', function () { // when the button is clicked the code executes
			$('.error').fadeOut('slow'); // reset the error messages (hides them)

			var error = false; // we will set this true if the form isn't valid

			var name = $('input#name').val(); // get the value of the input field
			if (name == "" || name == " ") {
				$('#err-name').fadeIn('slow'); // show the error message
				error = true; // change the error state to true
			}

			var email_compare = /^([a-z0-9_.-]+)@([da-z.-]+).([a-z.]{2,6})$/; // Syntax to compare against input
			var email = $('input#email').val(); // get the value of the input field
			if (email == "" || email == " ") { // check if the field is empty
				$('#err-email').fadeIn('slow'); // error - empty
				error = true;
			} else if (!email_compare.test(email)) { // if it's not empty check the format against our email_compare variable
				$('#err-emailvld').fadeIn('slow'); // error - not right format
				error = true;
			}
			var name = $('input#phone').val(); // get the value of the input field
			if (name == "" || name == " ") {
				$('#err-phone').fadeIn('slow'); // show the error message
				error = true; // change the error state to true
			}
			var name = $('input#field').val(); // get the value of the input field
			if (name == "" || name == " ") {
				$('#err-field').fadeIn('slow'); // show the error message
				error = true; // change the error state to true
			}
			var name = $('input#company').val(); // get the value of the input field
			if (name == "" || name == " ") {
				$('#err-company').fadeIn('slow'); // show the error message
				error = true; // change the error state to true
			}
			var name = $('input#profession').val(); // get the value of the input field
			if (name == "" || name == " ") {
				$('#err-profession').fadeIn('slow'); // show the error message
				error = true; // change the error state to true
			}
			var name = $('input#wilaya').val(); // get the value of the input field
			if (name == "" || name == " ") {
				$('#err-wilaya	').fadeIn('slow'); // show the error message
				error = true; // change the error state to true
			}

			if (error == true) {
				$('#err-form').slideDown('slow');
				return false;
			}

			var data_string = $('#visitors-form').serialize(); // Collect data from form

			$.ajax({
				type: "POST",
				url: $('#visitors-form').attr('action'),
				data: data_string,
				error: function (request, error) {
					if (error == "timeout") {
						$('#err-timedout').slideDown('slow');
					}
					else {
						$('#err-state').slideDown('slow');
						$("#err-state").html('An error occurred: ' + error + '');
					}
				},
				success: function () {
					$('#visitors-form').slideUp('slow');
					$('#ajaxsuccess').slideDown('slow');
				}
			});

			return false; // stops user browser being directed to the php file
		}); // end click function

		//Newsletter function
		$('#send-newsletter').on('click', function () { // when the button is clicked the code executes
			
			var data_string = $('#newsletter-form').serialize(); // Collect data from form

			$.ajax({
				type: "POST",
				url: $('#newsletter-form').attr('action'),
				data: data_string,
				error: function (request, error) {
					if (error == "timeout") {
						$('#err-timedout').slideDown('slow');
					}
					else {
						$('#err-state').slideDown('slow');
						$("#err-state").html('An error occurred: ' + error + '');
					}
				},
				success: function () {
				}
			});

			return false; // stops user browser being directed to the php file
		}); // end click function
		//Exposition Function
		$('#sendExhibit').on('click', function () { // when the button is clicked the code executes
			$('.error').fadeOut('slow'); // reset the error messages (hides them)

			var error = false; // we will set this true if the form isn't valid

			// Exposition Checks
			var companyEmail_compare = /^([a-z0-9_.-]+)@([da-z.-]+).([a-z.]{2,6})$/; // Syntax to compare against input
			var companyEmail = $('input#companyEmail').val(); // get the value of the input field
			if (companyEmail == "" || companyEmail == " ") { // check if the field is empty
				$('#err-companyEmail').fadeIn('slow'); // error - empty
				error = true;
			} else if (!companyEmail_compare.test(companyEmail)) { // if it's not empty check the format against our email_compare variable
				$('#err-emailvld').fadeIn('slow'); // error - not right format
				error = true;
			}
			var companyName = $('input#companyName').val(); // get the value of the input field
			if (companyName == "" || companyName == " ") {
				$('#err-companyName	').fadeIn('slow'); // show the error message
				error = true; // change the error state to true
			}
			var companySector = $('input#companySector').val(); // get the value of the input field
			if (companySector == "" || companySector == " ") {
				$('#err-companySector	').fadeIn('slow'); // show the error message
				error = true; // change the error state to true
			}
			var companyAdresse = $('input#companyAdresse').val(); // get the value of the input field
			if (companyAdresse == "" || companyAdresse == " ") {
				$('#err-companyAdresse	').fadeIn('slow'); // show the error message
				error = true; // change the error state to true
			}
			var companyCity = $('input#companyCity').val(); // get the value of the input field
			if (companyCity == "" || companyCity == " ") {
				$('#err-companyCity	').fadeIn('slow'); // show the error message
				error = true; // change the error state to true
			}
			var companyWilaya = $('input#companyWilaya').val(); // get the value of the input field
			if (companyWilaya == "" || companyWilaya == " ") {
				$('#err-companyWilaya	').fadeIn('slow'); // show the error message
				error = true; // change the error state to true
			}
			var companySpace = $('input#companySpace').val(); // get the value of the input field
			if (companySpace == "" || companySpace == " ") {
				$('#err-companySpace	').fadeIn('slow'); // show the error message
				error = true; // change the error state to true
			}
			var companyPhone = $('input#companyPhone').val(); // get the value of the input field
			if (companyPhone == "" || companyPhone == " ") {
				$('#err-companyPhone	').fadeIn('slow'); // show the error message
				error = true; // change the error state to true
			}
			var companyFax = $('input#companyFax').val(); // get the value of the input field
			if (companyFax == "" || companyFax == " ") {
				$('#err-companyFax	').fadeIn('slow'); // show the error message
				error = true; // change the error state to true
			}
			var companyWebsite = $('input#companyWebsite').val(); // get the value of the input field
			if (companyWebsite == "" || companyWebsite == " ") {
				$('#err-companyWebsite	').fadeIn('slow'); // show the error message
				error = true; // change the error state to true
			}
			var companyNrc = $('input#companyNrc').val(); // get the value of the input field
			if (companyNrc == "" || companyNrc == " ") {
				$('#err-companyNrc	').fadeIn('slow'); // show the error message
				error = true; // change the error state to true
			}
			var companyNif = $('input#companyNif').val(); // get the value of the input field
			if (companyNif == "" || companyNif == " ") {
				$('#err-companyNif	').fadeIn('slow'); // show the error message
				error = true; // change the error state to true
			}
			var companyArticle = $('input#companyArticle').val(); // get the value of the input field
			if (companyArticle == "" || companyArticle == " ") {
				$('#err-companyArticle	').fadeIn('slow'); // show the error message
				error = true; // change the error state to true
			}

			if (error == true) {
				$('#err-form').slideDown('slow');
				return false;
			}

			var data_string = $('#exhibit-form').serialize(); // Collect data from form

			$.ajax({
				type: "POST",
				url: $('#exhibit-form').attr('action'),
				data: data_string,
				timeout: 6000,
				error: function (request, error) {
					if (error == "timeout") {
						$('#err-timedout').slideDown('slow');
					}
					else {
						$('#err-state').slideDown('slow');
						$("#err-state").html('An error occurred: ' + error + '');
					}
				},
				success: function () {
					$('#exhibit-form').slideUp('slow');
					$('#ajaxsuccess').slideDown('slow');
				}
			});

			return false; // stops user browser being directed to the php file
		}); // end click function
	});

})(jQuery); 