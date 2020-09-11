import {TypeofbusService} from "../services/typeofbus.service";

const state = {
	typeofbuss: {},
	typeofbuslist: [],
	message: [],
	typeofbus: [],
};

const getters = {
	getTypeofbusList(state){
		return state.typeofbuslist
	},
	getTypeofbuss(state){
		return state.typeofbuss
	},
	getMassage(state){
		return state.message
	},
	getTypeofbus(state){
		return state.typeofbus
	},
};


const actions = {
	async actionTypeofbusList({commit},page){
		try {
			const types =  await TypeofbusService.typeofbusList(page);
			await commit('setTypeofbusList',types.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionTypeofbuss({commit},page){
		try {
			const types =  await TypeofbusService.typeofbuss(page);
			await commit('setTypeofbuss',types.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionAddTypeofbus({commit},payload){
		try {
			const types =  await TypeofbusService.addtypeofbus(payload);
			await commit('setMessage',types.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionEditTypeofbus({commit},id){
		try {
			const types =  await TypeofbusService.edittypeofbus(id);
			await commit('setEditTypeofbus',types.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionUpdateTypeofbus({commit},payload){
		try {
			const types =  await TypeofbusService.updatetypeofbus(payload);
			await commit('setMessage',types.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionDeleteTypeofbus({commit},id){
		try {
			const types =  await TypeofbusService.deletetypeofbus(id);
			await commit('setMessage',types.data)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	setTypeofbusList(state, typeofbuslist){
		state.typeofbuslist = typeofbuslist
	},
	setTypeofbuss(state, typeofbuss){
		state.typeofbuss = typeofbuss
	},
	setMessage(state, message){
		state.message = message
	},
	setEditTypeofbus(state, typeofbus){
		state.typeofbus = typeofbus
	},
};

export const typeofbus = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
