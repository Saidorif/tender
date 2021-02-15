import {PageService} from "../services/page.service";

const state = {
	tenderIndex: [],
	tenderIndexCompleted: [],
};

const getters = {
	getTenderIndex(state){
		return state.tenderIndex
	},
	getTenderIndexCompleted(state){
		return state.tenderIndexCompleted
	},
};


const actions = {
	async actionTenderIndex({commit},page){
		try {
			const actions =  await PageService.tenderIndex(page);
			await commit('setTenderIndex',actions.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionTenderIndexCompleted({commit},page){
		try {
			const actions =  await PageService.tenderIndexCompleted(page);
			await commit('setTenderIndexCompleted',actions.data.result)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	setTenderIndex(state, data){
		state.tenderIndex = data
	},
	setTenderIndexCompleted(state, data){
		state.tenderIndexCompleted = data
	},
};

export const page = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
