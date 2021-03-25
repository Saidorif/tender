import {UserService} from "../services/user.service";

const state = {
	message: {},
	profile:[],
	userfindList:[],
};

const getters = {
	getMessage(state){
		return state.message
	},
	getProfile(state){
		return state.profile
	},
	getUserfindList(state){
		return state.userfindList
	},
};


const actions = {
	async ActionUserFind({commit}, data){
		try {
			let sendData = await UserService.userFind(data);
			await commit('setUserFind',sendData.data.result)
			return true
		}catch(e){
			return false
		}
	},
	async ActionUpdatePassword({commit}, data){
		try {
			let sendData = await UserService.updatePassword(data);
			await commit('setMessage',sendData.data)
			return true
		}catch(e){
			return false
		}
	},	
	async ActionRegisterUser({commit}, data){
		try {
			let sendData = await UserService.registerUser(data);
			await commit('setMessage',sendData.data)
			return true
		}catch(e){
			return false
		}
	},	
	async ActionProfile({commit}){
		try {
			let sendData = await UserService.profileUser();
			await commit('setProfile',sendData.data.result)
			return true
		}catch(e){
			return false
		}
	},
	async ActionProfileUpdate({commit},payload){
		try {
			let sendData = await UserService.profileUpdate(payload);
			await commit('setMessage',sendData.data)
			return true
		}catch(e){
			return false
		}
	},
	async ActionChangePassword({commit},payload){
		try {
			let sendData = await UserService.changePass(payload);
			await commit('setMessage',sendData.data)
			return true
		}catch(e){
			return false
		}
	},
};

const mutations = {
	setMessage(state, data){
		state.message = data
	},
	setProfile(state, data){
		state.profile = data
	},
	setUserFind(state, data){
		state.userfindList = data
	}
};

export const user = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
