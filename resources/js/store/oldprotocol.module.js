import {OldprotocolService} from "../services/oldprotocol.service";

const state = {
	oldprotocols: {},
	oldprotocollist: [],
	message: [],
	oldprotocol: [],
	oldprotocolfind: [],
};

const getters = {
	getOldprotocolList(state){
		return state.oldprotocollist
	},
	getOldprotocols(state){
		return state.oldprotocols
	},
	getMassage(state){
		return state.message
	},
	getOldprotocol(state){
		return state.oldprotocol
	},
	getOldprotocolFind(state){
		return state.oldprotocolfind
	},
};


const actions = {
	async actionOldprotocolFind({commit},page){
		try {
			const oldprotocol =  await OldprotocolService.findoldprotocol(page);
			await commit('setOldprotocolFind',oldprotocol.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionOldprotocolList({commit},page){
		try {
			const oldprotocol =  await OldprotocolService.oldprotocolList(page);
			await commit('setOldprotocolList',oldprotocol.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionOldprotocols({commit},page){
		try {
			const oldprotocol =  await OldprotocolService.alloldprotocols(page);
			await commit('setOldprotocols',oldprotocol.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionAddOldprotocol({commit},payload){
		try {
			const oldprotocol =  await OldprotocolService.addoldprotocol(payload);
			await commit('setMessage',oldprotocol.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionEditOldprotocol({commit},id){
		try {
			const oldprotocol =  await OldprotocolService.editoldprotocol(id);
			await commit('setEditOldprotocol',oldprotocol.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionUpdateOldprotocol({commit},payload){
		try {
			const oldprotocol =  await OldprotocolService.updateoldprotocol(payload);
			await commit('setMessage',oldprotocol.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionDeleteOldprotocol({commit},id){
		try {
			const oldprotocol =  await OldprotocolService.deleteoldprotocol(id);
			await commit('setMessage',oldprotocol.data)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	setOldprotocolFind(state, oldprotocolfind){
		state.oldprotocolfind = oldprotocolfind
	},
	setOldprotocolList(state, oldprotocollist){
		state.oldprotocollist = oldprotocollist
	},
	setOldprotocols(state, oldprotocols){
		state.oldprotocols = oldprotocols
	},
	setMessage(state, message){
		state.message = message
	},
	setEditOldprotocol(state, oldprotocol){
		state.oldprotocol = oldprotocol
	},
};

export const oldprotocol = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
