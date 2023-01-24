"use strict";

// Class Definition
var KTModalCreateApp = function () {
	// Elements
	var _stepperEl;
	var _stepperFormEl;
	var _stepperFormSubmitButtonEl;

	// Variables
	var _stepperObj;
	var _validations = [];

	// Private Functions
	var _initStepper = function () {
		// Initialize Stepper
		_stepperObj = new KTStepper(_stepperEl);

		// Validation before going to next page
		_stepperObj.on('kt.stepper.next', function (stepper) {
			console.log('kt.stepper.next');

			// Validate form before change stepper step
			var validator = _validations[stepper.getCurrentStepIndex() - 1]; // get validator for currnt step

			if (validator) {
				validator.validate().then(function (status) {
					console.log('validated!');

					if (status == 'Valid') {
						stepper.goNext();

						KTUtil.scrollTop();
					} else {
						Swal.fire({
							text: "Sorry, looks like there are some errors detected, please try again.",
							icon: "error",
							buttonsStyling: false,
							confirmButtonText: "Ok, got it!",
							customClass: {
								confirmButton: "btn btn-light"
							}
						}).then(function () {
							KTUtil.scrollTop();
						});
					}
				});
			} else {
				stepper.goNext();
				KTUtil.scrollTop();
			}
		});

		// Prev event
		_stepperObj.on('kt.stepper.previous', function (stepper) {
			console.log('stepper.previous');

			stepper.goPrevious();
			KTUtil.scrollTop();
		});

		// Submit event
		_stepperFormSubmitButtonEl.addEventListener('click', function (e) {
			e.preventDefault();

			Swal.fire({
				text: "All is good! Please confirm the form submission.",
				icon: "success",
				showCancelButton: true,
				buttonsStyling: false,
				confirmButtonText: "Yes, submit!",
				cancelButtonText: "No, cancel",
				customClass: {
					confirmButton: "btn fw-bold btn-primary",
					cancelButton: "btn fw-bold btn-active-light-primary"
				}
			}).then(function (result) {
				if (result.value) {
					_stepperFormEl.submit(); // Submit form
				} else if (result.dismiss === 'cancel') {
					Swal.fire({
						text: "Your form has not been submitted!.",
						icon: "error",
						buttonsStyling: false,
						confirmButtonText: "Ok, got it!",
						customClass: {
							confirmButton: "btn btn-primary",
						}
					});
				}
			});
		});
	}

	var _initValidation = function () {
		// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
		// Step 1
		_validations.push(FormValidation.formValidation(
			_stepperFormEl,
			{
				fields: {
					appname: {
						validators: {
							notEmpty: {
								message: 'App name is required'
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap5({
						eleValidClass: '',
						rowSelector: '.fv-row'
					})
				}
			}
		));

		// Step 2
		_validations.push(FormValidation.formValidation(
			_stepperFormEl,
			{
				fields: {
					dbname: {
						validators: {
							notEmpty: {
								message: 'Database name is required'
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap5({
						eleValidClass: '',
						rowSelector: '.fv-row'
					})
				}
			}
		));
	}

	return {
		// Public Functions
		init: function () {
			_stepperEl = document.querySelector('#kt_modal_create_app_stepper');
			_stepperFormEl = document.querySelector('#kt_modal_create_app_form');
			_stepperFormSubmitButtonEl = document.querySelector('[data-kt-stepper-action="submit"]');

			_initStepper();
			_initValidation();
		}
	};
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    KTModalCreateApp.init();
});