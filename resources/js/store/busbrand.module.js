import {BusBrandService} from "../services/busbrand.service";

const state = {
	busbrands: {},
	busbrandlist: [],
	message: [],
	busbrand: [],
};

const getters = {
	getBusBrandList(state){
		return state.busbrandlist
	},
	getBusBrands(state){
		return state.busbrands
	},
	getMassage(state){
		return state.message
	},
	getBusBrand(state){
		return state.busbrand
	},
};


const actions = {
	async actionBusBrandList({commit},page){
		try {
            const types =  await BusBrandService.busmarkaList(page);
			await commit('setBusBrandList',types.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionBusBrands({commit},page){
		try {
			const types =  await BusBrandService.busmarkas(page);
			await commit('setBusBrands',types.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionAddBusBrand({commit},payload){
		try {
			const types =  await BusBrandService.addbusmarka(payload);
			await commit('setMessage',types.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionEditBusBrand({commit},id){
		try {
			const types =  await BusBrandService.editbusmarka(id);
			await commit('setEditBusBrand',types.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionUpdateBusBrand({commit},payload){
		try {
			const types =  await BusBrandService.updatebusmarka(payload);
			await commit('setMessage',types.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionDeleteBusBrand({commit},id){
		try {
			const types =  await BusBrandService.deletebusmarka(id);
			await commit('setMessage',types.data)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	setBusBrandList(state, busbrandlist){
		state.busbrandlist = busbrandlist
	},
	setBusBrands(state, busbrand){
		state.busbrands = busbrand
	},
	setMessage(state, message){
		state.message = message
	},
	setEditBusBrand(state, busbrand){
		state.busbrand = busbrand
	},
};

export const busbrand = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
