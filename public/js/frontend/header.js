/**add event listener */

// toggle menu button
(function() {
	window.onload = () => {
		let avatar = document.querySelector('#avatar');
		let popupMenu = document.querySelector('.avatarPopup');
		clientUtils.togglePopup(avatar, popupMenu);
	};
})();
