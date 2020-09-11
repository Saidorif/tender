import {BusclassService} from "../services/busclass.service";

const state = {
	busclasses: {},
	busclasslist: [],
	message: [],
	busclass: [],
};

const getters = {
	getBusclassList(state){
		return state.busclasslist
	},
	getBusclasses(state){
		return state.busclasses
	},
	getMassage(state){
		return state.message
	},
	getBusclass(state){
		return state.busclass
	},
};


const actions = {
	async actionBusclassList({commit},page){
		try {
			const types =  await BusclassService.busclassList(page);
			await commit('setBusclassList',types.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionBusclasses({commit},page){
		try {
			const types =  await BusclassService.busclasses(page);
			await commit('setBusclasses',types.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionAddBusclass({commit},payload){
		try {
			const types =  await BusclassService.addbusclass(payload);
			await commit('setMessage',types.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionEditBusclass({commit},id){
		try {
			const types =  await BusclassService.editbusclass(id);
			await commit('setEditBusclass',types.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionUpdateBusclass({commit},payload){
		try {
			const types =  await BusclassService.updatebusclass(payload);
			await commit('setMessage',types.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionDeleteBusclass({commit},id){
		try {
			const types =  await BusclassService.deletebusclass(id);
			await commit('setMessage',types.data)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	setBusclassList(state, busclasslist){
		state.busclasslist = busclasslist
	},
	setBusclasses(state, busclasses){
		state.busclasses = busclasses
	},
	setMessage(state, message){
		state.message = message
	},
	setEditBusclass(state, busclass){
		state.busclass = busclass
	},
};

export const busclass = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
