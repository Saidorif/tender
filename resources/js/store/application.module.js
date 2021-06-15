import {ApplicationService} from "../services/application.service";

const state = {
	applications: {},
	applicationlist: [],
	showapplications: {},
	usershowapplications: [],
	message: [],
	addmessage: [],
	application: [],
	usereditapplication: [],
	userapplications: [],
	gai: [],
	adliya: [],
	active: [],
	userapps: {},
};

const getters = {
	getUserShowApp(state){
		return state.usershowapplications
	},
	getUserApps(state){
		return state.userapps
	},
	getShowApplications(state){
		return state.showapplications
	},
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
	getGaiVehicle(state){
		return state.gai
	},
	getAdliya(state){
		return state.adliya
	},
	getActivate(state){
		return state.active
	},
};


const actions = {
	async actionUserShowApp({commit},id){
		try {
			const applications =  await ApplicationService.usershowapplication(id);
			await commit('setUserShowApp',applications.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionUserApps({commit},payload){
		try {
			const applications =  await ApplicationService.UserApplications(payload);
			await commit('setUserApps',applications.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionShowApplications({commit},payload){
		try {
			const applications =  await ApplicationService.showapplication(payload);
			await commit('setShowapplications',applications.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionActivate({commit},id){
		try {
			const applications =  await ApplicationService.activate(id);
			await commit('setActivate',applications.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionAdliya({commit},payload){
		try {
			const applications =  await ApplicationService.adliyaApi(payload);
			await commit('setMessage',applications.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionGaiVehicle({commit},payload){
		try {
			const applications =  await ApplicationService.gaiApi(payload);
			await commit('setMessage',applications.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionRemoveCar({commit},id){
		try {
			const applications =  await ApplicationService.removeCar(id);
			await commit('setMessage',applications.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionRemoveFile({commit},id){
		try {
			const applications =  await ApplicationService.removeFile(id);
			await commit('setMessage',applications.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionAddFile({commit},payload){
		try {
			const applications =  await ApplicationService.addFile(payload);
			await commit('setMessage',applications.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionAddCar({commit},payload){
		try {
			const applications =  await ApplicationService.addCar(payload);
			await commit('setMessage',applications.data)
			return true
		} catch (error) {
			return false
		}
	},
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
			await commit('setMessage',application.data)
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
	setUserShowApp(state, usershowapplications){
		state.usershowapplications = usershowapplications
	},
	setUserApps(state, userapps){
		state.userapps = userapps
	},
	setShowapplications(state, showapplications){
		state.showapplications = showapplications
	},
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
	setGaiVehicle(state, gai){
		state.gai = gai
	},
	setAdliya(state, adliya){
		state.adliya = adliya
	},
	setActivate(state, active){
		state.active = active
	},
};

export const application = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
