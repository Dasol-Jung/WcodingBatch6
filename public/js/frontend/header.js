/**add event listener */
(function() {
	window.onload = () => {
		let avatar = document.querySelector('#avatar');
		let popupMenu = document.querySelector('.avatarPopup');
		clientUtils.togglePopup(avatar, popupMenu);
	};
})();
