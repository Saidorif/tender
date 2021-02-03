import {ConfirmScheduleSerivce} from "../services/confirmschedule.service";

const state = {
	message: [],
	schedule: {},
	showschedule: {},
};

const getters = {
	getScheduleMassage(state){
		return state.message
	},
	getSchedules(state){
		return state.schedule
	},
	getShowschedule(state){
		return state.showschedule
	},
};


const actions = {
	async actionSchedules({commit}){
		try {
			const types =  await ConfirmScheduleSerivce.schedules();
			await commit('setSchedule',types.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionScheduleShow({commit},id){
		try {
			const types =  await ConfirmScheduleSerivce.scheduleShow(id);
			await commit('setShowSchedule',types.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionApproveSchedule({commit},id){
		try {
			const types =  await ConfirmScheduleSerivce.approveSchedule(id);
			await commit('setMessage',types.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionActivateSchedule({commit},id){
		try {
			const types =  await ConfirmScheduleSerivce.activateSchedule(id);
			await commit('setMessage',types.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionRejectSchedule({commit},id){
		try {
			const types =  await ConfirmScheduleSerivce.rejectSchedule(id);
			await commit('setMessage',types.data)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	setSchedule(state, schedule){
		state.schedule = schedule
	},
	setShowSchedule(state, showschedule){
		state.showschedule = showschedule
	},
	setMessage(state, message){
		state.message = message
	},
};

export const confirmschedule = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
