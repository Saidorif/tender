import {PassportTabService} from "../services/passportTab.service";

const state = {
	passports: {},
	timingMessage: [],
	passport: [],
	tarifs: [],
	schedule: [],
	demand: [],
};

const getters = {
	getTimingMassage(state){
		return state.timingMessage
	},
	getTarif(state){
		return state.tarifs
	},
	getSchedule(state){
		return state.schedule
	},
	getDemand(state){
		return state.demand
	}
};


const actions = {
	async actionDemand({commit},id){
		try {
			const demand =  await PassportTabService.demands(id);
			await commit('setDemand',demand.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionTarif({commit},payload){
		try {
			const tarif =  await PassportTabService.tarif(payload);
			await commit('setTarif',tarif.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionGetScheduleTable({commit},payload){
		try {
			const tarif =  await PassportTabService.getScheduleTable(payload);
			await commit('setSchedule', tarif.data)
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
	setDemand(state, demand){
		state.demand = demand
	},
	setTimingMessage(state, timingMessage){
		state.timingMessage = timingMessage
	},
	setTarif(state, tarifs){
		state.tarifs = tarifs
	},
	setSchedule(state, item){
		state.schedule = item
	}
};

export const passportTab = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
