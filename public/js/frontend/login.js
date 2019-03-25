(function loginHandler() {
	let form = document.querySelector('form.loginForm');
	let loginBtn = document.querySelector('button#signInBtn');

	loginBtn.addEventListener('click', () => {
		console.log('clicked on login')
	})

	loginBtn.addEventListener('click', e => {
		// e.preventDefault();

		// send ajax
		let xhr = new XMLHttpRequest();
		let formData = new FormData(form);
		formData.append('action', 'login');
		xhr.open('POST', '../../index.php');
		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && xhr.status >= 200 && xhr.status < 300) {
				if (xhr.response == 'success') {
					window.location.href = 'http://localhost:8888/index.php?action=weeklySchedule';
				}
			}
			if (xhr.status >= 400) {
				//php error page
				return;
			}
		};
		xhr.send(formData);
	});
})();
