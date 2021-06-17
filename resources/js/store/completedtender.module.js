import {CompletedTendersSerivce} from "../services/completedtender.service";

const state = {
    tender: [],
    tendersList: {},
};

const getters = {
	getTender(state){
		return state.tender
    },
	getTendersList(state){
		return state.tendersList
    },
};


const actions = {
	async actionCompletedTendersList({commit},payload){
		try {
			const types =  await CompletedTendersSerivce.completedTendersList(payload);
			await commit('setTendersList',types.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionCompletedTendersShow({commit},id){
		try {
			const types =  await CompletedTendersSerivce.completedTendersShow(id);
			await commit('setTender',types.data)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	setTender(state, tender){
		state.tender = tender
	},
	setTendersList(state, tendersList){
		state.tendersList = tendersList
	},
};

export const completedtender = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
