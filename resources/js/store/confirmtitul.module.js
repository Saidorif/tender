import {ConfirmTitulSerivce} from "../services/confirmtitul.service";

const state = {
	message: [],
	titul: {},
};

const getters = {
	getTitulMassage(state){
		return state.message
	},
	getTituls(state){
		return state.titul
	},
};


const actions = {
	async actionTituls({commit}){
		try {
			const types =  await ConfirmTitulSerivce.tituls();
			await commit('setTitul',types.data.result)
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
