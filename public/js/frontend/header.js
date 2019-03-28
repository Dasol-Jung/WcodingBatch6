/**add event listener */

// toggle menu button
(function() {
	window.onload = () => {
		let avatar = document.querySelector('#avatar');
		let popupMenu = document.querySelector('.avatarPopup');
		if (avatar && popupMenu) {
			clientUtils.togglePopup(avatar, popupMenu);
		}
	};
})();

// switch accounts button
(function() {
	let anchors = document.querySelectorAll('a.switchAccount');
	anchors.forEach(anchor => {
		anchor.addEventListener('click', e => {
			e.preventDefault();
			e.stopPropagation();
			// send ajax
			let xhr = new XMLHttpRequest();
			xhr.open('GET', `index.php?action=switch&type=${anchor.getAttribute('user')}`);
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4 && xhr.status >= 200 && xhr.status < 300) {
					if (xhr.response == 'success') {
						location.reload();
					}
				}
				if (xhr.status >= 400) {
					//php error page
					return;
				}
			};
			xhr.send();
		});
	});
})();
