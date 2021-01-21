const TOKEN_KEY = 'access_token'
const USER = 'dd'
const GUEST = 'oo'

const TokenService = {
	getToken() {
		return localStorage.getItem(TOKEN_KEY);
	},
	saveToken(token) {
		localStorage.setItem(TOKEN_KEY, token);
	},
	saveCurrentUser(user){
		// let us = btoa(unescape(encodeURIComponent(JSON.stringify(user)))); 
		// let data = JSON.parse(decodeURIComponent(escape(atob(us))));
		// localStorage.setItem(USER, JSON.stringify(us));

		localStorage.setItem(USER, JSON.stringify(user));
	},

	getCurrentUser(){
		// let data = JSON.parse(decodeURIComponent(escape(atob(localStorage.getItem(USER)))));
		// return data;
		let data = JSON.parse(localStorage.getItem(USER));
		return data;
	},
	saveGuestInfo(guest){
		localStorage.setItem(GUEST, JSON.stringify(guest));
	},

	getGuestInfo(){
		let data = JSON.parse(localStorage.getItem(GUEST));
		return data;
	},

	removeCurrentUser(){
		localStorage.removeItem(USER);
	},
	
	removeGuestInfo(){
		localStorage.removeItem(GUEST);
	},

	removeToken() {
		localStorage.removeItem(TOKEN_KEY);
	},
};

export {TokenService}
