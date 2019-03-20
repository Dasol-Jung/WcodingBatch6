(function() {
	let changePWBtn = document.querySelector('#changePassword');
	if (changePWBtn) {
		changePWBtn.addEventListener('click', e => {
			let modalTarget = document.querySelector('.modalTarget');
			document.body.appendChild(clientUtils.createModal(modalTarget, [ 400, 200 ]));
		});
	}
})();
