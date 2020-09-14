import {PassportTabService} from "../services/passportTab.service";

const state = {
	passports: {},
	timingMessage: [],
	passport: [],
};

const getters = {
	getTimingMassage(state){
		return state.timingMessage
	},
};


const actions = {
	async actionAddTiming({commit},payload){
		try {
			const timingData =  await PassportTabService.addTiming(payload);
			await commit('setTimingMessage',timingData.data)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	setTimingMessage(state, timingMessage){
		state.timingMessage = timingMessage
	},
};

export const passportTab = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
