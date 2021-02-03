import {ConfirmTimingSerivce} from "../services/confirmtiming.service";

const state = {
	message: [],
	timing: {},
	showTiming: {},
};

const getters = {
	getTimingMassage(state){
		return state.message
	},
	getTimings(state){
		return state.timing
	},
	getShowTiming(state){
		return state.showTiming
	},
};


const actions = {
	async actionTimings({commit}){
		try {
			const types =  await ConfirmTimingSerivce.xronoms();
			await commit('setTiming',types.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionTimingShow({commit},id){
		try {
			const types =  await ConfirmTimingSerivce.xronomShow(id);
			await commit('setShowTiming',types.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionApproveTiming({commit},id){
		try {
			const types =  await ConfirmTimingSerivce.approvexronom(id);
			await commit('setMessage',types.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionActivateTiming({commit},id){
		try {
			const types =  await ConfirmTimingSerivce.activatexronom(id);
			await commit('setMessage',types.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionRejectTiming({commit},id){
		try {
			const types =  await ConfirmTimingSerivce.rejectxronom(id);
			await commit('setMessage',types.data)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	setTiming(state, timing){
		state.timing = timing
	},
	setShowTiming(state, showTiming){
		state.showTiming = showTiming
	},
	setMessage(state, message){
		state.message = message
	},
};

export const confirmtiming = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
