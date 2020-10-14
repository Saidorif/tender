import {FindService} from "../services/find.service";

const state = {
	companies: [],
};

const getters = {
	getFindByCompanies(state){
		return state.companies
	},
};


const actions = {
	async actionFindByCompanies({commit},payload){
		try {
			const companies =  await FindService.findUserByCompanyName(payload);
			await commit('setFindByCompanies',companies.data.result)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	setFindByCompanies(state, companies){
		state.companies = companies
	},
};

export const find = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
