import {BusModelService} from "../services/busmodel.service";

const state = {
	busmodels: {},
	busmodellist: [],
	busmodelfindlist: [],
	message: [],
	busmodel: [],
};

const getters = {
	getBusmodelList(state){
		return state.busmodellist
	},
	getBusmodelFindList(state){
		return state.busmodelfindlist
	},
	getBusmodels(state){
		return state.busmodels
	},
	getMassage(state){
		return state.message
	},
	getBusmodel(state){
		return state.busmodel
	},
};


const actions = {
	async actionBusmodelList({commit},page){
		try {
			const types =  await BusModelService.busmodelList(page);
			await commit('setBusmodelList',types.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionBusmodelFindList({commit},data){
		try {
			const types =  await BusModelService.busmodelfind(data);
			await commit('setBusmodelFindList',types.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionBusmodelListByBrand({commit},payload){
		try {
			const types =  await BusModelService.addbybrandbusmodel(payload);
			await commit('setBusmodelList',types.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionBusmodels({commit},payload){
		try {
			const types =  await BusModelService.busmodels(payload);
			await commit('setBusmodels',types.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionAddBusmodel({commit},payload){
		try {
			const types =  await BusModelService.addbusmodel(payload);
			await commit('setMessage',types.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionEditBusmodel({commit},id){
		try {
			const types =  await BusModelService.editbusmodel(id);
			await commit('setEditBusmodel',types.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionUpdateBusmodel({commit},payload){
		try {
			const types =  await BusModelService.updatebusmodel(payload);
			await commit('setMessage',types.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionDeleteBusmodel({commit},id){
		try {
			const types =  await BusModelService.deletebusmodel(id);
			await commit('setMessage',types.data)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	setBusmodelFindList(state, busmodellist){
		state.busmodelfindlist = busmodellist
	},
	setBusmodelList(state, busmodellist){
		state.busmodellist = busmodellist
	},
	setBusmodels(state, busmodels){
		state.busmodels = busmodels
	},
	setMessage(state, message){
		state.message = message
	},
	setEditBusmodel(state, busmodel){
		state.busmodel = busmodel
	},
};

export const busmodel = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
