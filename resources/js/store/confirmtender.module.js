import {ConfirmtenderSerivce} from "../services/confirmtender.service";

const state = {
	message: [],
	list: {},
};

const getters = {
	getRejMassage(state){
		return state.message
	},
	getConfirmList(state){
		return state.list
	},
};


const actions = {
	async actionConfirmList({commit},payload){
		try {
			const types =  await ConfirmtenderSerivce.confirmTenderList(payload);
			await commit('setConfirmList',types.data.result)
			return true
		} catch (error) {
			return false
		}
	},
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
	setConfirmList(state, list){
		state.list = list
	},
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
