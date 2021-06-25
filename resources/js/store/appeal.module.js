import {AppealService} from "../services/appeal.service";

const state = {
	appeals: {},
	appeallist: [],
	message: [],
	appeal: [],
};

const getters = {
	getAppealList(state){
		return state.appeallist
	},
	getAppeals(state){
		return state.appeals
	},
	getMassage(state){
		return state.message
	},
	getAppeal(state){
		return state.appeal
	},
};


const actions = {
	async actionAppealList({commit},page){
		try {
			const appeals =  await AppealService.appealList(page);
			await commit('setAppealList',appeals.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionAppeals({commit},page){
		try {
			const appeals =  await AppealService.allappeals(page);
			await commit('setAppeals',appeals.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionAddAppeal({commit},payload){
		try {
			const appeals =  await AppealService.addappeal(payload);
			await commit('setMessage',appeals.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionEditAppeal({commit},id){
		try {
			const appeals =  await AppealService.editappeal(id);
			await commit('setEditAppeal',appeals.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionUpdateAppeal({commit},payload){
		try {
			const appeal =  await AppealService.updateappeal(payload);
			await commit('setMessage',appeal.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionDeleteAppeal({commit},id){
		try {
			const appeal =  await AppealService.deleteappeal(id);
			await commit('setMessage',appeal.data)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	setAppealList(state, appeallist){
		state.appeallist = appeallist
	},
	setAppeals(state, appeals){
		state.appeals = appeals
	},
	setMessage(state, message){
		state.message = message
	},
	setEditAppeal(state, appeal){
		state.appeal = appeal
	},
};

export const appeal = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
