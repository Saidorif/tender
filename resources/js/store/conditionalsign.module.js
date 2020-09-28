import {ConditionalSignService} from "../services/conditionalsign.service";

const state = {
	conditionalsigns: {},
	conditionalsignlist: [],
	message: [],
	conditionalsign: [],
};

const getters = {
	getConditionalSignList(state){
		return state.conditionalsignlist
	},
	getConditionalSigns(state){
		return state.conditionalsigns
	},
	getMassage(state){
		return state.message
	},
	getConditionalSign(state){
		return state.conditionalsign
	},
};


const actions = {
	async actionConditionalSignList({commit}){
		try {
			const conditionalsigns =  await ConditionalSignService.conditionalsignList();
			await commit('setRegionList',conditionalsigns.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionConditionalSigns({commit},page){
		try {
			const conditionalsigns =  await ConditionalSignService.conditionalsignAll(page);
			await commit('setConditionalSigns',conditionalsigns.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionAddConditionalSign({commit},payload){
		try {
			const conditionalsigns =  await ConditionalSignService.addconditionalsign(payload);
			await commit('setMessage',conditionalsigns.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionEditConditionalSign({commit},id){
		try {
			const conditionalsigns =  await ConditionalSignService.editconditionalsign(id);
			await commit('setConditionalSign',conditionalsigns.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionUpdateConditionalSign({commit},payload){
		try {
			const conditionalsign =  await ConditionalSignService.updateconditionalsign(payload);
			await commit('setMessage',conditionalsign.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionDeleteConditionalSign({commit},id){
		try {
			const conditionalsign =  await ConditionalSignService.deleteconditionalsign(id);
			await commit('setMessage',conditionalsign.data)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	actionConditionalSignList(state, conditionalsignlist){
		state.conditionalsignlist = conditionalsignlist
	},
	setConditionalSigns(state, conditionalsigns){
		state.conditionalsigns = conditionalsigns
	},
	setMessage(state, message){
		state.message = message
	},
	setConditionalSign(state, conditionalsign){
		state.conditionalsign = conditionalsign
	},
};

export const conditionalsign = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
