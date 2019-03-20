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
		attachSignin(document.getElementById('customBtn'));
	});
};

function attachSignin(element) {
	auth2.attachClickHandler(
		element,
		{},
		function() {
			onSuccess(auth2.currentUser.get());
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
function onSuccess(googleUser) {
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
	ajax.open('POST', 'index.php?action=googleLogin', true);
	ajax.setRequestHeader('Content-type', 'application/json');
	ajax.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var googleLoginResult = this.response;
			googleLoginResult == 'success'
				? (window.location.href = 'index.php?action=weeklySchedule')
				: alert('Google Login failed');
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

// /**
//  * Main function of google to trigger the sign/log in button
//  */
// function renderButton() {
// 	gapi.signin2.render('googleLogin', {
// 		scope: 'profile email',
// 		width: 240,
// 		height: 50,
// 		longtitle: false,
// 		theme: 'dark',
// 		onsuccess: onSuccess,
// 		onfailure: onFailure
// 	});
// }

/**
 * function to logout the user
 * NO USE for now we'll see later if we need
 */
function signOut() {
	var auth2 = gapi.auth2.getAuthInstance();
	if (googleIdSession) {
		auth2.signOut().then(function() {
			console.log('User signed out.');
		});
	} else {
		console.log('Not logged in.');
	}
}
