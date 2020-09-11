import {TypeofdirectionService} from "../services/typeofdirection.service";

const state = {
	typeofdirections: {},
	typeofdirectionlist: [],
	message: [],
	typeofdirection: [],
};

const getters = {
	getTypeofdirectionList(state){
		return state.typeofdirectionlist
	},
	getTypeofdirections(state){
		return state.typeofdirections
	},
	getMassage(state){
		return state.message
	},
	getTypeofdirection(state){
		return state.typeofdirection
	},
};


const actions = {
	async actionTypeofdirectionList({commit},page){
		try {
			const types =  await TypeofdirectionService.typeofdirectionList(page);
			await commit('setTypeofdirectionList',types.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionTypeofdirections({commit},page){
		try {
			const types =  await TypeofdirectionService.typeofdirections(page);
			await commit('setTypeofdirections',types.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionAddTypeofdirection({commit},payload){
		try {
			const types =  await TypeofdirectionService.addtypeofdirection(payload);
			await commit('setMessage',types.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionEditTypeofdirection({commit},id){
		try {
			const types =  await TypeofdirectionService.edittypeofdirection(id);
			await commit('setEditTypeofdirection',types.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionUpdateTypeofdirection({commit},payload){
		try {
			const types =  await TypeofdirectionService.updatetypeofdirection(payload);
			await commit('setMessage',types.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionDeleteTypeofdirection({commit},id){
		try {
			const types =  await TypeofdirectionService.deletetypeofdirection(id);
			await commit('setMessage',types.data)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	setTypeofdirectionList(state, typeofdirectionlist){
		state.typeofdirectionlist = typeofdirectionlist
	},
	setTypeofdirections(state, typeofdirections){
		state.typeofdirections = typeofdirections
	},
	setMessage(state, message){
		state.message = message
	},
	setEditTypeofdirection(state, typeofdirection){
		state.typeofdirection = typeofdirection
	},
};

export const typeofdirection = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
