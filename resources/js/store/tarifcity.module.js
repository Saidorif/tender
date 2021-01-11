import {TarifCityService} from "../services/tarifcity.service";

const state = {
	tarifcitys: {},
	message: [],
	tarifcity: [],
	tarifcitysList: [],
};

const getters = {
	getTarifcitys(state){
		return state.tarifcitys
	},
	getMassage(state){
		return state.message
	},
	getTarifcity(state){
		return state.tarifcity
	},
	getTarifcityList(state){
		return state.tarifcitysList
	}
};


const actions = {
	async actionAreas({commit},page){
		try {
			const areas =  await TarifCityService.tarifcitys(page);
			await commit('setTarifcitys',areas.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionAreaByRegion({commit},id){
		try {
			const areas =  await TarifCityService.getTarifcityByRegion(id);
			await commit('setTarifcityList',areas.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionAddArea({commit},payload){
		try {
			const areas =  await TarifCityService.addtarifcity(payload);
			await commit('setMessage',areas.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionEditArea({commit},id){
		try {
			const areas =  await TarifCityService.edittarifcity(id);
			await commit('setEditTarifcity',areas.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionUpdateArea({commit},payload){
		try {
			const area =  await TarifCityService.updatetarifcity(payload);
			await commit('setMessage',area.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionDeleteArea({commit},id){
		try {
			const area =  await TarifCityService.deletetarifcity(id);
			await commit('setMessage',area.data)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	setTarifcitys(state, tarifcitys){
		state.tarifcitys = tarifcitys
	},
	setTarifcityList(state, tarifcityList){
		state.tarifcitysList = tarifcityList
	},
	setMessage(state, message){
		state.message = message
	},
	setEditTarifcity(state, tarifcity){
		state.tarifcity = tarifcity
	},
};

export const tarifcity = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
