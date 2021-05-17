import {ConfirmDemandSerivce} from "../services/confirmdemand.service";

const state = {
	message: [],
	demand: {},
	showdemand: {},
};

const getters = {
	getDemandConfirmMassage(state){
		return state.message
	},
	getDemands(state){
		return state.demand
	},
	getShowDemand(state){
		return state.showdemand
	},
};


const actions = {
	async actionDemands({commit},page){
		try {
			const types =  await ConfirmDemandSerivce.demands(page);
			await commit('setDemand',types.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionDemandShow({commit},id){
		try {
			const types =  await ConfirmDemandSerivce.demandShow(id);
			await commit('setShowDemand',types.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionApproveDemand({commit},id){
		try {
			const types =  await ConfirmDemandSerivce.approvedemand(id);
			await commit('setMessage',types.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionActivateDemand({commit},id){
		try {
			const types =  await ConfirmDemandSerivce.activatedemand(id);
			await commit('setMessage',types.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionRejectDemand({commit},id){
		try {
			const types =  await ConfirmDemandSerivce.rejectdemand(id);
			await commit('setMessage',types.data)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	setDemand(state, demand){
		state.demand = demand
	},
	setShowDemand(state, showdemand){
		state.showdemand = showdemand
	},
	setMessage(state, message){
		state.message = message
	},
};

export const confirmdemand = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
