import {ConfirmSchemeSerivce} from "../services/confirmscheme.service";

const state = {
	message: [],
	scheme: {},
	showscheme: {},
};

const getters = {
	getSchemeMassage(state){
		return state.message
	},
	getSchemes(state){
		return state.scheme
	},
	getShowscheme(state){
		return state.showscheme
	},
};


const actions = {
	async actionSchemes({commit}){
		try {
			const types =  await ConfirmSchemeSerivce.schemes();
			await commit('setScheme',types.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionSchemeShow({commit},id){
		try {
			const types =  await ConfirmSchemeSerivce.schemeShow(id);
			await commit('setShowScheme',types.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionApproveScheme({commit},id){
		try {
			const types =  await ConfirmSchemeSerivce.approveScheme(id);
			await commit('setMessage',types.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionActivateScheme({commit},id){
		try {
			const types =  await ConfirmSchemeSerivce.activateScheme(id);
			await commit('setMessage',types.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionRejectScheme({commit},id){
		try {
			const types =  await ConfirmSchemeSerivce.rejectScheme(id);
			await commit('setMessage',types.data)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	setScheme(state, scheme){
		state.scheme = scheme
	},
	setShowScheme(state, showscheme){
		state.showscheme = showscheme
	},
	setMessage(state, message){
		state.message = message
	},
};

export const confirmscheme = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
