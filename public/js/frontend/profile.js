(function() {
	let changePWBtn = document.querySelector('#changePassword');
	if (changePWBtn) {
		changePWBtn.addEventListener('click', e => {
			let modalTarget = document.querySelector('.modalTarget');
			document.body.appendChild(clientUtils.createModal(modalTarget, [ 400, 200 ]));
		});
	}
})();

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
