import {AreaService} from "../services/area.service";

const state = {
	areas: {},
	message: [],
	area: [],
	areaList: [],
	lists: [],
	xromlists: [],
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
	getAreaList(state){
		return state.areaList
	},
	getAreaLists(state){
		return state.lists
	},
	getAreaXromLists(state){
		return state.xromlists
	}
};


const actions = {
	async actionXromAreaList({commit},data){
		try {
			const areas =  await AreaService.areaxrom(data);
			await commit('setXromAreaLists',areas.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionAreaList({commit}){
		try {
			const areas =  await AreaService.arealist();
			await commit('setAreaLists',areas.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionAreas({commit},page){
		try {
			const areas =  await AreaService.areas(page);
			await commit('setAreas',areas.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionAreaByRegion({commit},id){
		try {
			const areas =  await AreaService.getAreaByRegion(id);
			await commit('setAreaList',areas.data.result)
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
			await commit('setMessage',area.data)
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
	setAreaLists(state, lists){
		state.lists = lists
	},
	setXromAreaLists(state, xromlists){
		state.xromlists = xromlists
	},
	setAreaList(state, areaList){
		state.areaList = areaList
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
