import {ApplicationService} from "../services/application.service";

const state = {
	applications: {},
	applicationlist: [],
	message: [],
	addmessage: [],
	application: [],
	usereditapplication: [],
	userapplications: [],
};

const getters = {
	getApplicationList(state){
		return state.applicationlist
	},
	getApplications(state){
		return state.applications
	},
	getMassage(state){
		return state.message
	},
	getApplication(state){
		return state.application
	},
	getAddMessage(state){
		return state.addmessage
	},
	getUserApplications(state){
		return state.userapplications
	},
	getUserEditApplication(state){
		return state.usereditapplication
	},
};


const actions = {
	async actionUserEditApplication({commit},data){
		try {
			const applications =  await ApplicationService.sendusereditapplication(data);
			await commit('setUserEditApplication',applications.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionApplicationList({commit},data){
		try {
			const applications =  await ApplicationService.sendUserApplication(data);
			await commit('setUserApplications',applications.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionApplicationList({commit},page){
		try {
			const applications =  await ApplicationService.applicationList(page);
			await commit('setApplicationList',applications.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionApplications({commit},page){
		try {
			const applications =  await ApplicationService.Applications(page);
			await commit('setApplications',applications.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionAddApplication({commit},payload){
		try {
			const applications =  await ApplicationService.addapplication(payload);
			await commit('setAddMessage',applications.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionEditApplication({commit},id){
		try {
			const applications =  await ApplicationService.editapplication(id);
			await commit('setEditApplication',applications.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionUpdateApplication({commit},payload){
		try {
			const application =  await ApplicationService.updateapplication(payload);
			await commit('setEditApplication',application.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionDeleteApplication({commit},id){
		try {
			const application =  await ApplicationService.deleteapplication(id);
			await commit('setMessage',application.data)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	setApplicationList(state, applicationlist){
		state.applicationlist = applicationlist
	},
	setApplications(state, applications){
		state.applications = applications
	},
	setAddMessage(state, addmessage){
		state.addmessage = addmessage
	},
	setMessage(state, message){
		state.message = message
	},
	setEditApplication(state, application){
		state.application = application
	},
	setUserEditApplication(state, usereditapplication){
		state.usereditapplication = usereditapplication
	},
	setUserApplications(state, userapplications){
		state.userapplications = userapplications
	},
};

export const application = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
