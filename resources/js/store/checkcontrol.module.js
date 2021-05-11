import {CheckControlSerivce} from "../services/checkcontrol.service";

const state = {
    controlCompanyList: [],
    appcars: [],
    statuscar: [],
    statusLicense: [],
    controlFiles: [],
};

const getters = {
	getCheckContolsList(state){
		return state.controlCompanyList
    },
	getAppCars(state){
		return state.appcars
    },
	getStatusMessage(state){
		return state.statuscar
    },
	getStatusLicense(state){
		return state.statusLicense
    },
	getControlFiles(state){
		return state.controlFiles
    },
};


const actions = {
	async actionControlRemoveFile({commit},id){
		try {
			const types =  await CheckControlSerivce.appFileRemove(id);
			await commit('setStatusMessage',types.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionAppTarget({commit},payload){
		try {
			const types =  await CheckControlSerivce.apptarget(payload);
			await commit('setStatusMessage',types.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionControlFiles({commit},payload){
		try {
			const types =  await CheckControlSerivce.appFiles(payload);
			await commit('setControlFiles',types.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionControlStoreFile({commit},payload){
		try {
			const types =  await CheckControlSerivce.appFileStore(payload);
			await commit('setStatusMessage',types.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionCheckLicense({commit},inn){
		try {
			const types =  await CheckControlSerivce.checkLicense(inn);
			await commit('setStatusLicense',types.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionCloseLot({commit},id){
		try {
			const types =  await CheckControlSerivce.closeLot(id);
			await commit('setStatusMessage',types.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionStatusMessage({commit},payload){
		try {
			const types =  await CheckControlSerivce.statusCar(payload);
			await commit('setStatusMessage',types.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionCheckContolsList({commit},page){
		try {
			const types =  await CheckControlSerivce.getcheckContols(page);
			await commit('setCheckContolsList',types.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionAppCars({commit},page){
		try {
			const types =  await CheckControlSerivce.getappcars(page);
			await commit('setAppCars',types.data.result)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	setCheckContolsList(state, controlCompanyList){
		state.controlCompanyList = controlCompanyList
	},
	setStatusLicense(state, statusLicense){
		state.statusLicense = statusLicense
	},
	setStatusMessage(state, statuscar){
		state.statuscar = statuscar
	},
	setAppCars(state, appcars){
		state.appcars = appcars
	},
	setControlFiles(state, controlFiles){
		state.controlFiles = controlFiles
	},
};

export const checkcontrol = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
