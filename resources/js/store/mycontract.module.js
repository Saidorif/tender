import {MycontractService} from "../services/mycontract.service";

const state = {
	mycontracts: {},
	mycontractlist: [],
	message: [],
	mycontract: [],
};

const getters = {
	getMycontractList(state){
		return state.mycontractlist
	},
	getMycontracts(state){
		return state.mycontracts
	},
	getMassage(state){
		return state.message
	},
	getMycontract(state){
		return state.mycontract
	},
};


const actions = {
	async actionMycontractList({commit},page){
		try {
			const mycontract =  await mycontractService.mycontractList(page);
			await commit('setMycontractList',mycontract.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionMycontracts({commit},page){
		try {
			const mycontract =  await mycontractService.allmycontracts(page);
			await commit('setMycontracts',mycontract.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionContractActivate({commit},payload){
		try {
			const mycontract =  await mycontractService.contractActivate(payload);
			await commit('setMessage',mycontract.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionAddMycontract({commit},payload){
		try {
			const mycontract =  await mycontractService.addmycontract(payload);
			await commit('setMessage',mycontract.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionEditmycontract({commit},id){
		try {
			const mycontract =  await mycontractService.editmycontract(id);
			await commit('setEditMycontract',mycontract.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionUpdatemycontract({commit},payload){
		try {
			const mycontract =  await mycontractService.updatemycontract(payload);
			await commit('setMessage',mycontract.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionDeletemycontract({commit},id){
		try {
			const mycontract =  await mycontractService.deletemycontract(id);
			await commit('setMessage',mycontract.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionDeletemycontractCar({commit},id){
		try {
			const mycontract =  await mycontractService.deletemycontractcar(id);
			await commit('setMessage',mycontract.data)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	setMycontractList(state, mycontractlist){
		state.mycontractlist = mycontractlist
	},
	setMycontracts(state, mycontracts){
		state.mycontracts = mycontracts
	},
	setMessage(state, message){
		state.message = message
	},
	setEditMycontract(state, mycontract){
		state.mycontract = mycontract
	},
};

export const mycontract = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
