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
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4 && xhr.status >= 200 && xhr.status < 300) {
					if (xhr.response == 'success') {
						window.location.href = 'http://localhost:8888/index.php?action=welcome';
						
					} else {
						alert(xhr.response);
					}
					// redirect to signup page
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

//adjust kakao button size

(function() {
	//kakao login
	let kakaoBtn = document.querySelector('#kakao-login-btn');
	if (kakaoBtn) {
		let kakaoBtnWrapper = kakaoBtn.parentElement;
		kakaoBtnWrapper.style.width = '100%';
		kakaoBtnWrapper.style.height = '100%';
		kakaoBtn.style.width = '100%';
		kakaoBtn.style.height = '100%';
	}
})();
