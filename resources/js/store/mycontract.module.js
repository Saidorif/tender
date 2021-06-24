import {MycontractService} from "../services/mycontract.service";

const state = {
	mycontracts: {},
	mycontractlist: [],
	message: [],
	mycontract: [],
	usermycontracts: [],
	usermycontractlist: [],
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
	getUserMycontracts(state){
		return state.usermycontracts
	},
	getUserMycontractList(state){
		return state.usermycontractlist
	},
};


const actions = {
	async actionUserMycontractList({commit}){
		try {
			const mycontract =  await MycontractService.listmycontracts();
			await commit('setUserMycontractList',mycontract.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionMycontractList({commit},page){
		try {
			const mycontract =  await MycontractService.mycontractList(page);
			await commit('setMycontractList',mycontract.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionMycontracts({commit},page){
		try {
			const mycontract =  await MycontractService.allmycontracts(page);
			await commit('setMycontracts',mycontract.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionContractActivate({commit},payload){
		try {
			const mycontract =  await MycontractService.contractActivate(payload);
			await commit('setMessage',mycontract.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionAddMycontract({commit},payload){
		try {
			const mycontract =  await MycontractService.addmycontract(payload);
			await commit('setMessage',mycontract.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionEditMycontract({commit},id){
		try {
			const mycontract =  await MycontractService.editmycontract(id);
			await commit('setEditMyUsercontract',mycontract.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionUpdateMycontract({commit},payload){
		try {
			const mycontract =  await MycontractService.updatemycontract(payload);
			await commit('setMessage',mycontract.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionDeletemycontract({commit},id){
		try {
			const mycontract =  await MycontractService.deletemycontract(id);
			await commit('setMessage',mycontract.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionDeletemycontractCar({commit},id){
		try {
			const mycontract =  await MycontractService.deletemycontractcar(id);
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
	setEditMyUsercontract(state, usermycontracts){
		state.usermycontracts = usermycontracts
	},
	setMycontracts(state, mycontracts){
		state.mycontracts = mycontracts
	},
	setMessage(state, message){
		state.message = message
	},
	setUserMycontractList(state, usermycontractlist){
		state.usermycontractlist = usermycontractlist
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
