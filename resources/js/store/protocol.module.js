import {ProtocolService} from "../services/protocol.service";

const state = {
	message: [],
	protocol: [],
};

const getters = {
	getMessage(state){
		return state.message
	},
	getProtocol(state){
		return state.protocol
	},
};


const actions = {
	async actionProtocol({commit},id){
		try {
			const apply =  await ProtocolService.protocolId(id);
			await commit('setProtocol',apply.data.result)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	setMessage(state, message){
		state.message = message
	},
	setProtocol(state, protocol){
		state.protocol = protocol
	},
};

export const protocol = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
