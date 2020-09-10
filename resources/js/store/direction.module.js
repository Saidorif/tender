import {DirectService} from "../services/direction.service";

const state = {
	directions: {},
	message: [],
	direction: [],
};

const getters = {
	getDirections(state){
		return state.directions
	},
	getMassage(state){
		return state.message
	},
	getDirection(state){
		return state.direction
	},
};


const actions = {
	async actionDirections({commit},page){
		try {
			const directions =  await DirectService.directs(page);
			await commit('setDirections',directions.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionAddDirection({commit},payload){
		try {
			const directions =  await DirectService.addDirection(payload);
			await commit('setMessage',directions.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionEditDirection({commit},id){
		try {
			const directions =  await DirectService.editDirection(id);
			await commit('setEditDirection',directions.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionUpdateDirection({commit},payload){
		try {
			const direction =  await DirectService.updateDirection(payload);
			await commit('setEditDirection',direction.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionDeleteDirection({commit},id){
		try {
			const direction =  await DirectService.deleteDirection(id);
			await commit('setMessage',direction.data)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	setDirections(state, directions){
		state.directions = directions
	},
	setMessage(state, message){
		state.message = message
	},
	setEditDirection(state, direction){
		state.direction = direction
	},
};

export const direction = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
