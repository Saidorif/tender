import {ApplyService} from "../services/apply.service";

const state = {
	applies: {},
	message: [],
	inn: [],
	email: [],
};

const getters = {
	getApplies(state){
		return state.applies
	},
	getApplyMessage(state){
		return state.message
	},
	getCheckInn(state){
		return state.inn
	},
	getCheckEmail(state){
		return state.email
	},
};


const actions = {
	async actionApplies({commit},page){
		try {
			const applies =  await ApplyService.apply(page);
			await commit('setApplies',applies.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionSendApply({commit},payload){
		try {
			const applies =  await ApplyService.applySend(payload);
			await commit('setMessage',applies.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionCheckInn({commit},payload){
		try {
			const applies =  await ApplyService.checkInn(payload);
			await commit('setCheckInn',applies.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionCheckEmail({commit},payload){
		try {
			const applies =  await ApplyService.checkEmail(payload);
			await commit('setCheckEmail',applies.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionSendApplyActive({commit},payload){
		try {
			const applies =  await ApplyService.activateAll(payload);
			await commit('setCheckEmail',applies.data)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	setApplies(state, applies){
		state.applies = applies
	},
	setMessage(state, message){
		state.message = message
	},
	setCheckInn(state, inn){
		state.inn = inn
	},
	setCheckEmail(state, email){
		state.email = email
	},
};

export const apply = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
