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
