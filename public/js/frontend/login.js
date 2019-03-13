(function formHandler() {
	let form = document.querySelector('form');
	let signup = document.querySelector('button#signupBtn');

	signup.addEventListener('click', e => {
		e.preventDefault();

		//check if form inputs are valid
		let isValid = clientUtils.validator(form);
		if (isValid !== true) {
			// render error message
			clientUtils.renderErrorMsg(isValid, form);
		} else {
			// send ajax
			let xhr = new XMLHttpRequest();
			let formData = new FormData(form);
			formData.append('action', 'signup');
			xhr.open('POST', 'index.php');
			xhr.setRequestHeader('Content-Type', 'application/form-data');
			xhr.onreadystatechange = function() {
				if (xhr.readyState != 4) {
					alert('something went wrong');
					return;
				}
				if (xhr.status >= 200 && xhr.status < 300) {
					// redirect to signup page
					window.location = 'signup.php';
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
