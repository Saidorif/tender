import {MyAppealService} from "../services/myappeal.service";

const state = {
	myappeals: {},
	myappeallist: [],
	message: [],
	myappeal: [],
};

const getters = {
	getMyAppealList(state){
		return state.myappeallist
	},
	getMyAppeals(state){
		return state.myappeals
	},
	getMassage(state){
		return state.message
	},
	getMyAppeal(state){
		return state.myappeal
	},
};


const actions = {
	async actionMyAppealList({commit},page){
		try {
			const myappeals =  await MyAppealService.myappealList(page);
			await commit('setMyAppealList',myappeals.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionMyAppeals({commit},page){
		try {
			const myappeals =  await MyAppealService.allmyappeals(page);
			await commit('setMyAppeals',myappeals.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionAddMyAppeal({commit},payload){
		try {
			const myappeals =  await MyAppealService.addmyappeal(payload);
			await commit('setMessage',myappeals.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionEditMyAppeal({commit},id){
		try {
			const myappeals =  await MyAppealService.editmyappeal(id);
			await commit('setEditMyAppeal',myappeals.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionUpdateMyAppeal({commit},payload){
		try {
			const myappeal =  await MyAppealService.updatemyappeal(payload);
			await commit('setMessage',myappeal.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionDeleteMyAppeal({commit},id){
		try {
			const myappeal =  await MyAppealService.deletemyappeal(id);
			await commit('setMessage',myappeal.data)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	setMyAppealList(state, myappeallist){
		state.myappeallist = myappeallist
	},
	setMyAppeals(state, myappeals){
		state.myappeals = myappeals
	},
	setMessage(state, message){
		state.message = message
	},
	setEditMyAppeal(state, myappeal){
		state.myappeal = myappeal
	},
};

export const myappeal = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
