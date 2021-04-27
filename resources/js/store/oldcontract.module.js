import {OldcontractService} from "../services/oldcontract.service";

const state = {
	oldcontracts: {},
	oldcontractlist: [],
	message: [],
	oldcontract: [],
};

const getters = {
	getOldcontractList(state){
		return state.oldcontractlist
	},
	getOldcontracts(state){
		return state.oldcontracts
	},
	getMassage(state){
		return state.message
	},
	getOldcontract(state){
		return state.oldcontract
	},
};


const actions = {
	async actionOldcontractList({commit},page){
		try {
			const oldcontract =  await OldcontractService.oldcontractList(page);
			await commit('setOldcontractList',oldcontract.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionOldcontracts({commit},page){
		try {
			const oldcontract =  await OldcontractService.alloldcontracts(page);
			await commit('setOldcontracts',oldcontract.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionContractActivate({commit},payload){
		try {
			const oldcontract =  await OldcontractService.contractActivate(payload);
			await commit('setMessage',oldcontract.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionAddOldcontract({commit},payload){
		try {
			const oldcontract =  await OldcontractService.addoldcontract(payload);
			await commit('setMessage',oldcontract.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionEditOldcontract({commit},id){
		try {
			const oldcontract =  await OldcontractService.editoldcontract(id);
			await commit('setEditOldcontract',oldcontract.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionUpdateOldcontract({commit},payload){
		try {
			const oldcontract =  await OldcontractService.updateoldcontract(payload);
			await commit('setMessage',oldcontract.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionDeleteOldcontract({commit},id){
		try {
			const oldcontract =  await OldcontractService.deleteoldcontract(id);
			await commit('setMessage',oldcontract.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionDeleteOldcontractCar({commit},id){
		try {
			const oldcontract =  await OldcontractService.deleteoldcontractcar(id);
			await commit('setMessage',oldcontract.data)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	setOldcontractList(state, oldcontractlist){
		state.oldcontractlist = oldcontractlist
	},
	setOldcontracts(state, oldcontracts){
		state.oldcontracts = oldcontracts
	},
	setMessage(state, message){
		state.message = message
	},
	setEditOldcontract(state, oldcontract){
		state.oldcontract = oldcontract
	},
};

export const oldcontract = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
