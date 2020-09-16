import {ClientService} from "../services/client.service";

const state = {
	clients: {},
	message: [],
};

const getters = {
	getClients(state){
		return state.clients
	},
	getMassage(state){
		return state.message
	},

};


const actions = {
	async actionClients({commit},page){
		try {
			const clients =  await ClientService.clientList(page);
			await commit('setClients',clients.data.result)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	setClients(state, clients){
		state.clients = clients
	},
};

export const client = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
