import {CheckControlSerivce} from "../services/checkcontrol.service";

const state = {
    controlCompanyList: [],
};

const getters = {
	getCheckContolsList(state){
		return state.controlCompanyList
    },
};


const actions = {
	async actionCheckContolsList({commit},page){
		try {
			const types =  await CheckControlSerivce.getcheckContols(page);
			await commit('setCheckContolsList',types.data.result)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	setCheckContolsList(state, tendersList){
		state.controlCompanyList = tendersList
	},
};

export const checkcontrol = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
