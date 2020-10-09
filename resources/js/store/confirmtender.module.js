import {ConfirmtenderSerivce} from "../services/confirmtender.service";

const state = {
	message: [],
};

const getters = {
	getRejMassage(state){
		return state.message
	},
};


const actions = {
	async actionRejectTender({commit},payload){
		try {
			const types =  await ConfirmtenderSerivce.rejectTender(payload);
			await commit('setMessage',types.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionCompletedTender({commit},id){
		try {
			const types =  await ConfirmtenderSerivce.completedTender(id);
			await commit('setMessage',types.data)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	setMessage(state, message){
		state.message = message
	},
};

export const confirmtender = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
