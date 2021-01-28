import {DirectService} from "../services/direction.service";

const state = {
	directions: {},
	message: [],
	direction: [],
	directionFindList: [],
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
	getDirectionFindList(state){
		return state.directionFindList
	},
};


const actions = {
	async actionCarDeleteDirection({commit},id){
		try {
			const directions =  await DirectService.deleteCarDirection(id);
			await commit('setMessage',directions.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionDirectionFind({commit},payload){
		try {
			const directions =  await DirectService.directFind(payload);
			await commit('setDirectionFind',directions.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionDirections({commit},payload){
		try {
			const directions =  await DirectService.directs(payload);
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
			await commit('setMessage',direction.data)
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
	setDirectionFind(state, directionFindList){
		state.directionFindList = directionFindList
	},
};

export const direction = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
