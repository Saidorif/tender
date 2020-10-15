import {ClientService} from "../services/client.service";

const state = {
	clients: {},
	client: [],
	message: [],
};

const getters = {
	getClients(state){
		return state.clients
	},
	getMassage(state){
		return state.message
	},
	getClient(state){
		return state.client
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
	async actionClientEdit({commit},id){
		try {
			const clients =  await ClientService.clientEdit(id);
			await commit('setClient',clients.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionClientUpdate({commit},payload){
		try {
			const clients =  await ClientService.clientUpdate(payload);
			await commit('setMessage',clients.data)
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
	setClient(state, client){
		state.client = client
	},
	setMessage(state, message){
		state.message = message
	},
};

export const client = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
