import {PassportTabService} from "../services/passportTab.service";

const state = {
	passports: {},
	timingMessage: [],
	passport: [],
	tarifs: [],
};

const getters = {
	getTimingMassage(state){
		return state.timingMessage
	},
	getTarif(state){
		return state.tarifs
	}
};


const actions = {
	async actionTarif({commit},payload){
		try {
			const tarif =  await PassportTabService.tarif(payload);
			await commit('setTarif',tarif.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionAddTiming({commit},payload){
		try {
			const timingData =  await PassportTabService.addTiming(payload);
			await commit('setTimingMessage',timingData.data)
			return true
		} catch (error) {
			return false
		}
	},
	async clearTimingTable({commit},payload){
		try {
			const timingData =  await PassportTabService.clearTimingTable(payload);
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
	setTarif(state, tarifs){
		state.tarifs = tarifs
	},
};

export const passportTab = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
