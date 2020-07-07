import {AreaService} from "../services/area.service";

const state = {
	areas: {},
	message: [],
	area: [],
};

const getters = {
	getAreas(state){
		return state.areas
	},
	getMassage(state){
		return state.message
	},
	getArea(state){
		return state.area
	},
};


const actions = {
	async actionAreas({commit},page){
		try {
			const areas =  await AreaService.areas(page);
			await commit('setAreas',areas.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionAddArea({commit},payload){
		try {
			const areas =  await AreaService.addarea(payload);
			await commit('setMessage',areas.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionEditArea({commit},id){
		try {
			const areas =  await AreaService.editarea(id);
			await commit('setEditArea',areas.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionUpdateArea({commit},payload){
		try {
			const area =  await AreaService.updatearea(payload);
			await commit('setEditArea',area.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionDeleteArea({commit},id){
		try {
			const area =  await AreaService.deletearea(id);
			await commit('setMessage',area.data)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	setAreas(state, areas){
		state.areas = areas
	},
	setMessage(state, message){
		state.message = message
	},
	setEditArea(state, area){
		state.area = area
	},
};

export const area = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
