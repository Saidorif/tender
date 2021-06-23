import {FrontService} from "../services/front.service";

const state = {
	requirement: {},
	direction: {},
	timingtarif: {},
	schedule: {},
};

const getters = {
	getRequirement(state){
		return state.requirement
	},
	getDirection(state){
		return state.requirement
	},
	getTimingtarif(state){
		return state.timingtarif
	},
	getSchedule(state){
		return state.schedule
	},
};


const actions = {
	async actionRequirement({commit},id){
		try {
			const requirement =  await FrontService.requirement(id);
			await commit('setRequirement',requirement.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionDirection({commit},id){
		try {
			const requirement =  await FrontService.direction(id);
			await commit('setDirection',requirement.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionTimingtarif({commit},id){
		try {
			const timingtarif =  await FrontService.timingtarif(id);
			await commit('setTimingtarif',timingtarif.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionSchedule({commit},id){
		try {
			const schedule =  await FrontService.getschedule(id);
			await commit('setSchedule',schedule.data.result)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	setRequirement(state, requirement){
		state.requirement = requirement
	},
	setDirection(state, direction){
		state.direction = direction
	},
	setTimingtarif(state, timingtarif){
		state.timingtarif = timingtarif
	},
	setSchedule(state, schedule){
		state.schedule = schedule
	},
};

export const front = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
