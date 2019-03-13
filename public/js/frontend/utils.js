/**
 * ==================================================================================
 * serviceUtils : This file is for client side utils
 * ==================================================================================
 */

const clientUtils = (() => {
	/**
 * ----------------------------------------------------------------------------------
 * public
 * isEmptyObj: checks if an object is empty
 * @param : (Object)
 * @return : (Boolean) true if the object is empty
 * ----------------------------------------------------------------------------------
 */

	function isEmptyObj(obj) {
		for (var key in obj) {
			if (obj.hasOwnProperty(key)) return false;
		}
		return true;
	}
	/**
 * ----------------------------------------------------------------------------------
 * public
 * insertAfter : insertAfter HTML element
 * @param
 * -refChild : an element that the new element will be inserted after
 * -newElement : a new element to insert
 * ----------------------------------------------------------------------------------
 */

	function insertAfter(refChild, newElement) {
		refChild.parentNode.insertBefore(newElement, refChild.nextSibling);
		return;
	}

	/**
 * ----------------------------------------------------------------------------------
 * public
 * validator : validate a form
 * @param : (HTMLelement) form element
 * @return : if all inputs are valid return true, otherwise return an object with error messages in it
 * ----------------------------------------------------------------------------------
 */

	function validator(form) {
		let inputs = form.querySelectorAll('input'),
			errorMsg = {},
			//at least one special character, alphabet, and number. Should be 8 characters or longer
			passwordLengthReg = /^(?=.{8,})/,
			passwordSpecialReg = /^(?=.*[!@#\$%\^&\*])/,
			passwordLetterReg = /^(?=.*[a-z])(?=.*[0-9])/,
			emailReg = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		inputs.forEach(input => {
			switch (input.name) {
				case 'email':
					if (!emailReg.test(String(input.value).toLowerCase())) {
						errorMsg['email'] = 'Invalid email';
					}
					break;

				case 'password':
					if (!passwordLetterReg.test(String(input.value))) {
						errorMsg['password'] = 'The password should have at least one number and alphabet';
					}
					if (!passwordSpecialReg.test(String(input.value))) {
						errorMsg['password'] = 'The password should have at least one special character';
					}
					if (!passwordLengthReg.test(String(input.value))) {
						errorMsg['password'] = 'The password should be at least 8 characters';
					}

					break;

				case 'confirmPassword':
					let password = form.querySelector("input[name='password']").value;
					if (password != input.value) {
						errorMsg['confirmPassword'] = "Passwords don't match";
					}
					break;

				default:
			}
		});

		if (isEmptyObj(errorMsg)) {
			return true;
		}
		return errorMsg;
	}

	/**
 * ----------------------------------------------------------------------------------
 * public
 * renderErrorMsg : show error messages under each input
 * @param
 * -(object) an error message object
 * -(HTMLelement) a form to show error messages on
 * ----------------------------------------------------------------------------------
 */

	function renderErrorMsg(errors, form) {
		let inputs = form.querySelectorAll('input');
		inputs.forEach(input => {
			let errorMsg = form.querySelector(`span#error_${input.name}`);
			if (errors[input.name]) {
				errorMsg.textContent = errors[input.name];
				input.classList.add('errorBorder');
			} else {
				errorMsg.textContent = '';
				input.classList.remove('errorBorder');
			}
		});
	}

	return {
		validator,
		renderErrorMsg
	};
})();
