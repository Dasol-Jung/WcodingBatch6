let form = document.querySelector('form');
let signup = document.querySelector('button#signupBtn');

signup.addEventListener('click', e => {
	e.preventDefault();
	let isValid = clientUtils.validator(form);
	if (isValid !== true) {
		clientUtils.renderErrorMsg(isValid, form);
	}
});
