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
			emailReg = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
			firstNameReg = /^[a-z ,.'-]+$/i;
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

				case 'firstName':
					if (!firstNameReg.test(String(input.value))) {
						errorMsg['firstName'] = 'Invalid First Name';
					}
					break;

				case 'avatar':
					if (input.files.length == 1) {
						let file = input.files[0];
						let ext = file.name.slice(file.name.lastIndexOf('.') + 1);
						let allowedExt = [ 'jpg', 'jpeg', 'png' ];
						let isValidExt = allowedExt.includes(ext);
						if (file.size / 1000 > 500) {
							errorMsg['avatar'] = 'File size should be smaller than 500KB';
							break;
						} else if (!isValidExt) {
							errorMsg['avatar'] = 'Only jpg, jpeg, png files are allowed';
							break;
						}
					}

				default:
					break;
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

	/**
 * ----------------------------------------------------------------------------------
 * public
 * showPopup : show hidden popup menu
 * @param
 * -(HTMLelement) : a button to toggle popup menu
 * -(HTMLelement) : an html element to show
 * ----------------------------------------------------------------------------------
 */
	function togglePopup(button, menu) {
		button.addEventListener('click', e => {
			menu.classList.toggle('hidden');
		});
	}

	/**
 * ----------------------------------------------------------------------------------
 * public
 * createModal: create Moda
 * @param
 * -(HTMLelement) : content to put in the modal
 * -(array) optional : [width, height]
 * @return
 * -(HTMLelement) : modal element to append to body
 * ----------------------------------------------------------------------------------
 */

	function createModal(element, sizeArr) {
		element.style.display = 'block';
		let modalContainer = document.createElement('div');
		let modalBackground = document.createElement('div');
		let closeButton = document.createElement('div');

		closeButton.innerHTML = '<i class="fas fa-times"></i>';

		let body = document.body,
			html = document.documentElement;

		// get the height of full html document
		let maxHeight = Math.max(
			body.scrollHeight,
			body.offsetHeight,
			html.clientHeight,
			html.scrollHeight,
			html.offsetHeight
		);

		//modal close button style

		closeButton.style.position = 'absolute';
		closeButton.style.top = '10px';
		closeButton.style.right = '10px';
		closeButton.style.fontSize = '1rem';
		closeButton.style.display = 'flex';
		closeButton.style.alignItems = 'flex-start';
		closeButton.style.cursor = 'pointer';

		//modal background style
		modalBackground.style.position = 'absolute';
		modalBackground.style.display = 'flex';
		modalBackground.style.justifyContent = 'center';
		modalBackground.style.alignItems = 'flex-start';
		modalBackground.style.height = '100%';
		modalBackground.style.width = '100%';
		modalBackground.style.top = '0';
		modalBackground.style.left = '0';
		modalBackground.style.backgroundColor = 'rgba(0,0,0,0.5)';

		//modal container style
		modalContainer.style.backgroundColor = 'white';
		modalContainer.style.position = 'relative';
		modalContainer.style.padding = '40px';
		modalContainer.style.width = sizeArr ? sizeArr[0] + 'px' : 'max-content';
		modalContainer.style.height = sizeArr ? sizeArr[1] + 'px' : 'max-content';
		modalContainer.style.margin = 'auto';
		modalContainer.style.zIndex = '1';

		// close modal

		modalBackground.addEventListener(
			'click',
			e => {
				if (e.target === e.currentTarget) {
					e.currentTarget.style.display = 'none';
					element.style.display = 'none';
				}
			},
			true
		);

		closeButton.addEventListener('click', e => {
			modalBackground.style.display = 'none';
			element.style.display = 'none';
		});

		//append modal content, close button, and container to modal background
		modalContainer.appendChild(closeButton);
		modalContainer.appendChild(element);
		modalBackground.appendChild(modalContainer);

		return modalBackground;
	}

	/**
 * ----------------------------------------------------------------------------------
 * public
 * initialize : initialize anything you need
 * ----------------------------------------------------------------------------------
 */

	function initialize() {
		//hide modal contents

		let modalTargets = document.querySelectorAll('.modalTarget');
		modalTargets.forEach(target => {
			target.style.display = 'none';
		});

		//toggle buttons

		let toggleButtons = document.querySelectorAll('.toggleButton');
		toggleButtons.forEach(toggleBtn => {
			toggleBtn.addEventListener('click', () => {
				toggleBtn.classList.toggle('on');
			});
		});
	}

	return {
		validator,
		renderErrorMsg,
		togglePopup,
		createModal,
		initialize
	};
})();
