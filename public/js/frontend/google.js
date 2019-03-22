/**
 * 
 * initializing google api
 */
var googleUser = {};

var startApp = function() {
	gapi.load('auth2', function() {
		// Retrieve the singleton for the GoogleAuth library and set up the client.
		auth2 = gapi.auth2.init({
			client_id: '852784944923-o4n8r0gg2sl9k3tdgu2fue8uq13esm82.apps.googleusercontent.com',
			cookiepolicy: 'single_host_origin',
			scope: 'profile email'
			// Request scopes in addition to 'profile' and 'email'
			//scope: 'additional_scope'
		});
		let loginBtn = document.getElementById('googleLogin');
		if (loginBtn) {
			attachSignin(loginBtn, 'login');
		}
		let connectBtn = document.getElementById('connectGoogle');
		if (connectBtn) {
			attachSignin(connectBtn, 'connect');
		}
	});
};

function attachSignin(element, type) {
	auth2.attachClickHandler(
		element,
		{},
		function() {
			onSuccess(auth2.currentUser.get(), type);
		},
		function(error) {
			onFailure(error);
		}
	);
	element.style.cursor = 'pointer';
}

/* function trigger when the login of the user succeed
** @param googleUser Object The googleUser
**
*/
function onSuccess(googleUser, type) {
	// Google treatment for the user
	var profile = googleUser.getBasicProfile();
	var idToken = googleUser.getAuthResponse().id_token;
	var profileData = {
		access_token: idToken,
		google_id: profile.getId(),
		first_name: profile.getGivenName(),
		last_name: profile.getFamilyName(),
		image_url: profile.getImageUrl(),
		email: profile.getEmail()
	};

	// we trigger our ajax on success
	var ajax = new XMLHttpRequest();
	ajax.open('POST', `index.php?action=googleLogin&type=${type}`, true);
	ajax.setRequestHeader('Content-type', 'application/json');
	ajax.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var googleLoginResult = this.response;
			if (type == 'login') {
				googleLoginResult == 'success'
					? (window.location.href = 'index.php?action=weeklySchedule')
					: alert('Google Login failed');
			} else if (type == 'connect') {
				googleLoginResult == 'success' ? location.reload() : alert('Google connection failed');
			}
		}
	};
	var params = JSON.stringify(profileData);
	ajax.send(params);
}

/**
 * Function triggered when the google auth fail
 * @param {String} error 
 */
function onFailure(error) {
	// change to throw new exception later .....
	console.log(error);
}

/**
 * function to logout the user
 * NO USE for now we'll see later if we need
 */
function googleLogOut() {
	var auth2 = gapi.auth2.getAuthInstance();
	if (googleIdSession) {
		auth2.signOut().then(function() {
			console.log('User signed out.');
		});
	} else {
		console.log('Not logged in.');
	}
}
