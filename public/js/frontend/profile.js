// ADD EVENT LISTENER //

/**
 * adding an event to show modal when an user clicks change password button
 */
(function() {
	let changePWBtn = document.querySelector('#changePassword');
	if (changePWBtn) {
		changePWBtn.addEventListener('click', e => {
			let modalTarget = document.querySelector('.modalTarget.checkCurrentPW');
			document.body.appendChild(clientUtils.createModal(modalTarget));
		});
	}
})();

/**
 * checks if the user entered the right password before proceeding to changing password
 */

(function() {
	let changePWConfirmBtn = document.querySelector('form.checkCurrentPW');
	if (changePWConfirmBtn) {
		changePWConfirmBtn.addEventListener('submit', e => {
			e.preventDefault();
			let form = e.target;
			// send ajax
			let xhr = new XMLHttpRequest();
			let formData = new FormData(form);
			formData.append('action', 'checkCurrentPW');
			xhr.open('POST', 'index.php');
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4 && xhr.status >= 200 && xhr.status < 300) {
					form.reset();
					switch (xhr.response) {
						case 'success':
							changePasswordForm(form);
							break;
						case 'incorrect':
							alert('Incorrect Password');
							break;
						case 'failure':
							alert('Something went wrong');
						default:
							break;
					}
				}
				if (xhr.status >= 400) {
					//php error page
					return;
				}
			};
			xhr.send(formData);
		});
	}
})();

/**
 * add an event to show the preview of an avatar when an user selects an image on input element
 */

(function() {
	let avatar = document.querySelector('input#changeAvatar');
	let avatarPreview = document.querySelector('img#profileAvatar');
	if (avatar) {
		avatar.addEventListener('change', e => {
			let file = avatar.files[0];

			//check file size
			if (file.size / 1000 > 500) {
				alert('File size should be smaller than 500KB');
				e.target.value = '';
				return;
			}

			//check file extension
			let ext = file.name.slice(file.name.lastIndexOf('.') + 1);
			let allowedExt = [ 'jpg', 'jpeg', 'png' ];
			let isValidExt = allowedExt.includes(ext);
			if (isValidExt) {
				avatarPreview.src = URL.createObjectURL(file);
			} else {
				alert('Invalid file type');
				e.target.value = '';
			}
		});
	}
})();

/**
 * add an event listener to a form to change personal info(first name or avatar)
 */

(function() {
	let formToSend = document.querySelector('form.personalInfo');
	formToSend.addEventListener('submit', e => {
		e.preventDefault();
		let isValid = clientUtils.validator(formToSend);
		if (isValid !== true) {
			// render error message
			clientUtils.renderErrorMsg(isValid, formToSend);
		} else {
			clientUtils.renderErrorMsg(isValid, formToSend);
			// send ajax
			let xhr = new XMLHttpRequest();
			let formData = new FormData(formToSend);
			formData.append('action', 'changePersonalInfo');
			xhr.open('POST', 'index.php');
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4 && xhr.status >= 200 && xhr.status < 300) {
					console.log(xhr.response);
					switch (xhr.response) {
						case 'success':
							alert('Your personal info has been successfully changed');
							location.reload();
							break;

						case 'failure':
							alert('Something Went Wrong');
							break;

						default:
							break;
					}
					return;
				}
				if (xhr.status >= 400) {
					//php error page
					return;
				}
			};
			xhr.send(formData);
		}
	});
})();

/**
 * adding an event to show modal when an user clicks signout button
 */

(function() {
	let signOutBtn = document.querySelector('button#signOut');
	if (signOutBtn) {
		signOutBtn.addEventListener('click', e => {
			let checkSignOut = document.querySelector('.modalTarget.checkSignOut');
			if (checkSignOut) {
				document.body.appendChild(clientUtils.createModal(checkSignOut));
				return null;
			}
			let checkSignOutInternal = document.querySelector('.modalTarget.checkSignOutInternal');
			if (checkSignOutInternal) {
				document.body.appendChild(clientUtils.createModal(checkSignOutInternal));
				return null;
			}
		});
	}
})();

/**
 * adding an event to disconnect account when an user clicks disconnect button
 */

(function() {
	let discntBtns = document.querySelectorAll('button.discnt');
	if (discntBtns) {
		let nbBtn = discntBtns.length,
			i;
		for (i = 0; i < nbBtn; i++) {
			let discntBtn = discntBtns[i];
			let userId = discntBtn.getAttribute('userId');
			let userType = discntBtn.id;
			discntBtn.addEventListener('click', e => {
				if (confirm('Do you really want to disconnect this account?')) {
					disconnectAcct(userId, userType);
				}
			});
		}
	}
})();

/**
 * checks if the internal user entered the right password before proceeding to signing out
 */

(function() {
	let changePWConfirmBtn = document.querySelector('form.checkSignOutInternal');
	if (changePWConfirmBtn) {
		changePWConfirmBtn.addEventListener('submit', e => {
			e.preventDefault();
			let form = e.target;
			// send ajax
			let xhr = new XMLHttpRequest();
			let formData = new FormData(form);
			formData.append('action', 'checkCurrentPW');
			xhr.open('POST', 'index.php');
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4 && xhr.status >= 200 && xhr.status < 300) {
					form.reset();
					switch (xhr.response) {
						case 'success':
							if (confirm('Do you really want to sign out?')) {
								requestSignOut(form);
							}
							break;
						case 'incorrect':
							alert('Incorrect Password');
							break;
						case 'failure':
							alert('Something went wrong');
						default:
							break;
					}
				}
				if (xhr.status >= 400) {
					//php error page
					return;
				}
			};
			xhr.send(formData);
		});
	}
})();

/**
 * confirm if the user really wants to sign out send a request
 */

(function() {
	let confirmSignOutBtn = document.querySelector('button.confirmSignOut');
	if (confirmSignOutBtn) {
		confirmSignOutBtn.addEventListener('click', e => {
			e.preventDefault();
			let formData = new FormData();
			// send ajax
			let xhr = new XMLHttpRequest();
			formData.append('action', 'signOut');
			xhr.open('POST', 'index.php');
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4 && xhr.status >= 200 && xhr.status < 300) {
					switch (xhr.response) {
						case 'success':
							alert('Your account has been successfully deleted. Thank you for using Weeky');
							window.location.href = 'index.php';
							break;
						case 'failure':
							alert('Something Went Wrong');
							break;

						default:
							break;
					}
					return;
				}
				if (xhr.status >= 400) {
					//php error page
					return;
				}
			};
			xhr.send(formData);
		});
	}
})();

/**
 * adding an event to user setting-default view button
 */

(function() {
	let settings = document.querySelectorAll('.toggleContainer');
	if (settings) {
		settings.forEach(setting => {
			let settingType = setting.id;
			let settingBtn = setting.querySelector('.toggleButton');

			settingBtn.addEventListener('click', () => {
				let status = Array.prototype.indexOf.call(settingBtn.classList, 'on') == -1 ? 'm' : 'w';
				changeUserSetting(status, settingType);
			});
		});
	}
})();

// FUNCTIONS //

/**
 * changePasswordForm : a function to send ajax request to change password
 * @param : form element that the user typed current password in
 */

function changePasswordForm(form) {
	// create a form to enter new password

	let newForm = document.createElement('form');
	newForm.innerHTML = `<label for="password">Password</label>
    <input name="password" id="password" type="password"/>
    <span class='error' id='error_password'></span>
    <label for="confirmPassword">Confirm Password</label>
    <input name="confirmPassword" id="confirmPassword" type="password"/>
	<span class='error' id='error_confirmPassword'></span>
	<button id="changePassword">Change Password</button>`;
	newForm.addEventListener('submit', e => {
		e.preventDefault();
		let isValid = clientUtils.validator(newForm);
		if (isValid !== true) {
			// render error message
			clientUtils.renderErrorMsg(isValid, newForm);
		} else {
			clientUtils.renderErrorMsg(isValid, newForm);
			// send ajax
			let xhr = new XMLHttpRequest();
			let formData = new FormData(newForm);
			formData.append('action', 'changePassword');
			xhr.open('POST', 'index.php');
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4 && xhr.status >= 200 && xhr.status < 300) {
					switch (xhr.response) {
						case 'success':
							alert('Your password has been successfully changed');
							newForm.parentElement.parentElement.style.display = 'none';
							break;
						case 'invalid':
							alert('Invalid password');
							break;
						case 'failure':
							alert('Something Went Wrong');
							break;
					}
					return;
				}
				if (xhr.status >= 400) {
					//php error page
					return;
				}
			};
			xhr.send(formData);
		}
	});
	form.style.display = 'none';
	form.parentElement.appendChild(newForm);
}

/**
 * requestSignOut : a function to send ajax request to sign out
 * @param : form element that the user typed current password in
 */

function requestSignOut(form) {
	// create a form to enter new password

	let xhr = new XMLHttpRequest();
	let formData = new FormData();
	formData.append('action', 'signOut');
	xhr.open('POST', 'index.php');
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && xhr.status >= 200 && xhr.status < 300) {
			switch (xhr.response) {
				case 'success':
					form.style.display = 'none';
					alert('Your account has been successfully deleted. Thank you for using Weeky');
					let logoutReq = new XMLHttpRequest();
					logoutReq.open('GET', 'index.php?action=logout');
					if (xhr.readyState == 4 && xhr.status >= 200 && xhr.status < 300) {
						window.location.href = 'index.php';
					}
					logoutReq.send();
					break;
				case 'failure':
					alert('Something went wrong');
					break;
				default:
					alert('Soemthing went wrong');
					break;
			}
			return;
		}
		if (xhr.status >= 400) {
			//php error page
			return null;
		}
	};
	xhr.send(formData);
}

/**
 * changeUserSetting : send a request to the server in order to change user setting
 * @param
 * -value : value of the setting 'on' or 'off'
 * -type : type of the setting. ex) defaultView
 */

function changeUserSetting(value, type) {
	// create a form to enter new password

	let xhr = new XMLHttpRequest();
	let formData = new FormData();
	formData.append('action', 'changeSetting');
	formData.append('type', type);
	formData.append('value', value);
	xhr.open('POST', 'index.php');
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && xhr.status >= 200 && xhr.status < 300) {
			switch (xhr.response) {
				case 'success':
					break;
				case 'failure':
					alert('Something went wrong');
					break;
				default:
					alert('Soemthing went wrong');
					break;
			}
			return;
		}
		if (xhr.status >= 400) {
			//php error page
			return null;
		}
	};
	xhr.send(formData);
}

/**
 * disconnectAcct : a function to send ajax request to disconnect an account
 * @param : (string) userId to disconnect
 */

function disconnectAcct(userId, userType) {
	let xhr = new XMLHttpRequest();
	let formData = new FormData();
	formData.append('action', 'disconnect');
	formData.append('userId', userId);
	formData.append('userType', userType);
	xhr.open('POST', 'index.php');
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && xhr.status >= 200 && xhr.status < 300) {
			switch (xhr.response) {
				case 'success':
					alert('Your account has been successfully disconnected');
					location.reload();
					break;
				case 'failure':
					alert('Something went wrong');
					break;
				default:
					alert('Soemthing went wrong');
					break;
			}
			return;
		}
		if (xhr.status >= 400) {
			//php error page
			return null;
		}
	};
	xhr.send(formData);
}
