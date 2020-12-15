import {CheckControlSerivce} from "../services/checkcontrol.service";

const state = {
    controlCompanyList: [],
    appcars: [],
    statuscar: [],
};

const getters = {
	getCheckContolsList(state){
		return state.controlCompanyList
    },
	getAppCars(state){
		return state.appcars
    },
	getStatusMessage(state){
		return state.statuscar
    },
};


const actions = {
	async actionStatusMessage({commit},payload){
		try {
			const types =  await CheckControlSerivce.statusCar(payload);
			await commit('setStatusMessage',types.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionCheckContolsList({commit},page){
		try {
			const types =  await CheckControlSerivce.getcheckContols(page);
			await commit('setCheckContolsList',types.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionAppCars({commit},page){
		try {
			const types =  await CheckControlSerivce.getappcars(page);
			await commit('setAppCars',types.data.result)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	setCheckContolsList(state, controlCompanyList){
		state.controlCompanyList = controlCompanyList
	},
	setStatusMessage(state, statuscar){
		state.statuscar = statuscar
	},
	setAppCars(state, appcars){
		state.appcars = appcars
	},
};

export const checkcontrol = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
