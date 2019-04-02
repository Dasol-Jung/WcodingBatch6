// ENTER JavaScript key here
Kakao.init('f052909da6fcfda372dafa76cbed98cf');

if (document.querySelector('#kakaoLogin')) {
	Kakao.Auth.createLoginButton({
		container: '#kakaoLogin',
		success: function(authObj) {
			// If login succeeds, call API.
			Kakao.API.request({
				url: '/v2/user/me',
				success: function(res) {
					var params = {
						uid: res.id,
						first_name: res.properties.nickname,
						img: res.properties.thumbnail_image,
						email: res.kakao_account.email,
						accessToken: authObj.access_token,
						refreshToken: authObj.refresh_token
					};
					var xhr = new XMLHttpRequest();
					xhr.open('POST', 'index.php?action=kakaoLogin&type=login', true);
					xhr.setRequestHeader('Content-type', 'application/json');
					xhr.addEventListener('readystatechange', function() {
						if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
							var kakaoLoginResult = this.response;
							switch (kakaoLoginResult) {
								case 'w':
									window.location.href = 'index.php?action=weeklySchedule';
									break;
								case 'm':
									window.location.href = 'index.php?action=monthlySchedule';
									break;
								default:
									alert('Kakao Login failed');
							}
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
}

if (document.querySelector('#connectKakao')) {
	Kakao.Auth.createLoginButton({
		container: '#connectKakao',
		success: function(authObj) {
			// If login succeeds, call API.
			Kakao.API.request({
				url: '/v2/user/me',
				success: function(res) {
					var params = {
						uid: res.id,
						first_name: res.properties.nickname,
						img: res.properties.thumbnail_image,
						email: res.kakao_account.email,
						accessToken: authObj.access_token,
						refreshToken: authObj.refresh_token
					};

					var xhr = new XMLHttpRequest();
					xhr.open('POST', 'index.php?action=kakaoLogin&type=connect', true);
					xhr.setRequestHeader('Content-type', 'application/json');
					xhr.addEventListener('readystatechange', function() {
						if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
							var kakaoLoginResult = this.response;
							if (kakaoLoginResult == 'success') {
								alert('Your Kakao account has been successfully connected');
								location.reload();
							} else {
								alert('Kakao connection failed');
							}
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
}
