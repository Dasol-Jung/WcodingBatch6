// ENTER JavaScript key here
Kakao.init('f052909da6fcfda372dafa76cbed98cf');

Kakao.Auth.createLoginButton({
	container: '#kakao-login-btn',
	success: function(authObj) {
		// If login succeeds, call API.
		Kakao.API.request({
			url: '/v2/user/me',
			success: function(res) {
				// alert(JSON.stringify(res));
				// alert(JSON.stringify(authObj));
				var params = {
					uid: res.id,
					first_name: res.properties.nickname,
					img: res.properties.thumbnail_image,
					email: res.kakao_account.email,
					accessToken: authObj.access_token,
					refreshToken: authObj.refresh_token
				};

				var xhr = new XMLHttpRequest();
				xhr.open('POST', 'index.php?action=loggedUser', true);
				xhr.setRequestHeader('Content-type', 'application/json');
				xhr.addEventListener('readystatechange', function() {
					if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
						document.body.innerHTML = xhr.responseText;
					}
				});
				xhr.send(JSON.stringify(params));
			},
			fail: function(error) {
				alert(error);
			}
		});
	},
	fail: function(err) {
		alert(err);
	}
});
