import {RegionService} from "../services/region.service";

const state = {
	regions: {},
	message: [],
	region: [],
};

const getters = {
	getRegions(state){
		return state.regions
	},
	getMassage(state){
		return state.message
	},
	getRegion(state){
		return state.region
	},
};


const actions = {
	async actionRegions({commit},page){
		try {
			const regions =  await RegionService.regions(page);
			await commit('setRegions',regions.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionAddRegion({commit},payload){
		try {
			const regions =  await RegionService.addregion(payload);
			await commit('setMessage',regions.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionEditRegion({commit},id){
		try {
			const regions =  await RegionService.editregion(id);
			await commit('setEditRegion',regions.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionUpdateRegion({commit},payload){
		try {
			const region =  await RegionService.updateregion(payload);
			await commit('setEditRegion',region.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionDeleteRegion({commit},id){
		try {
			const region =  await RegionService.deleteregion(id);
			await commit('setMessage',region.data)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	setRegions(state, regions){
		state.regions = regions
	},
	setMessage(state, message){
		state.message = message
	},
	setEditRegion(state, region){
		state.region = region
	},
};

export const region = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
