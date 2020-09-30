import {PassportTabService} from "../services/passportTab.service";

const state = {
	passports: {},
	timingMessage: [],
	passport: [],
	tarifs: [],
	schedule: [],
	schedule_msg: ''
};

const getters = {
	getTimingMassage(state){
		return state.timingMessage
	},
	getTarif(state){
		return state.tarifs
	},
	getScheduleResMsg(state){
		return state.schedule_msg
	},
	getSchedule(state){
		return state.schedule
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
	async actionSetScheduleTable({commit},payload){
		try {
			const tarif =  await PassportTabService.setScheduleTable(payload);
			await commit('setScheduleMsg', tarif.data)
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
	setTimingMessage(state, timingMessage){
		state.timingMessage = timingMessage
	},
	setTarif(state, tarifs){
		state.tarifs = tarifs
	},
	setSchedule(state, item){
		state.schedule = item
	},
	setScheduleMsg(state, item){
		state.schedule_msg = item
	}
};

export const passportTab = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
