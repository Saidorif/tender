import {ConfirmTitulSerivce} from "../services/confirmtitul.service";

const state = {
	message: [],
	titul: {},
	showTitul: {},
};

const getters = {
	getTitulMassage(state){
		return state.message
	},
	getTituls(state){
		return state.titul
	},
	getShowTitul(state){
		return state.showTitul
	},
};


const actions = {
	async actionTituls({commit},page){
		try {
			const types =  await ConfirmTitulSerivce.tituls(page);
			await commit('setTitul',types.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionTitulShow({commit},id){
		try {
			const types =  await ConfirmTitulSerivce.titulShow(id);
			await commit('setShowTitul',types.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionApproveTitul({commit},id){
		try {
			const types =  await ConfirmTitulSerivce.approveTitul(id);
			await commit('setMessage',types.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionActivateTitul({commit},id){
		try {
			const types =  await ConfirmTitulSerivce.activateTitul(id);
			await commit('setMessage',types.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionRejectTitul({commit},id){
		try {
			const types =  await ConfirmTitulSerivce.rejectTitul(id);
			await commit('setMessage',types.data)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	setTitul(state, titul){
		state.titul = titul
	},
	setShowTitul(state, showTitul){
		state.showTitul = showTitul
	},
	setMessage(state, message){
		state.message = message
	},
};

export const confirmtitul = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
