import {CheckControlSerivce} from "../services/checkcontrol.service";

const state = {
    controlCompanyList: [],
    appcars: [],
    deny: [],
    activeCar: [],
};

const getters = {
	getCheckContolsList(state){
		return state.controlCompanyList
    },
	getAppCars(state){
		return state.appcars
    },
	getDenyCar(state){
		return state.deny
    },
	getActiveCar(state){
		return state.activeCar
    },
};


const actions = {
	async actionActiveCar({commit},payload){
		try {
			const types =  await CheckControlSerivce.activeCar(payload);
			await commit('setActiveCar',types.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionDenyCar({commit},payload){
		try {
			const types =  await CheckControlSerivce.denyCar(payload);
			await commit('setDenyCar',types.data)
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
	setDenyCar(state, deny){
		state.deny = deny
	},
	setActiveCar(state, activeCar){
		state.activeCar = activeCar
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
