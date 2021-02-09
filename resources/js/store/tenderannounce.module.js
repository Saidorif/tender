import {TenderAnnounceService} from "../services/tenderannounce.service";

const state = {
	tenderannounces: {},
	tenderannouncelist: [],
	message: [],
	tenderannounce: [],
    tenderAnnounceData: [],
};

const getters = {
	getTenderAnnounceList(state){
		return state.tenderannouncelist
	},
	getTenderAnnounces(state){
		return state.tenderannounces
	},
	getMassage(state){
		return state.message
	},
	getTenderAnnounce(state){
		return state.tenderannounce
	},
    getTenderAnnounceLs(state){
		return state.tenderAnnounceData
    },
};


const actions = {
	async actionTenderAnnounceList({commit},page){
		try {
			const tenderannounces =  await TenderAnnounceService.tenderannounceList(page);
			await commit('setTenderAnnounceList',tenderannounces.data.result)
			return true
		} catch (error) {
			return false
		}
	},
    async actionTenderAnnounceLs({commit},page){
		try {
			const passportList =  await TenderAnnounceService.tenderAnnounce(page);
			await commit('setTenderAnnounceLs',passportList.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionTenderAnnounces({commit},payload){
		try {
			const tenderannounces =  await TenderAnnounceService.tenderannounceses(payload);
			await commit('setTenderAnnounces',tenderannounces.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionAddTenderAnnounce({commit},payload){
		try {
			const tenderannounces =  await TenderAnnounceService.addtenderannounce(payload);
			await commit('setMessage',tenderannounces.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionEditTenderAnnounce({commit},id){
		try {
			const tenderannounces =  await TenderAnnounceService.edittenderannounce(id);
			await commit('setEditTenderAnnounce',tenderannounces.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionUpdateTenderAnnounce({commit},payload){
		try {
			const tenderannounce =  await TenderAnnounceService.updatetenderannounce(payload);
			await commit('setMessage',tenderannounce.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionDeleteTenderAnnounceItem({commit},payload){
		try {
			const tenderannounce =  await TenderAnnounceService.deletetenderannounceItem(payload);
			await commit('setMessage',tenderannounce.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionDeleteTenderAnnounce({commit},id){
		try {
			const tenderannounce =  await TenderAnnounceService.deletetenderannounce(id);
			await commit('setMessage',tenderannounce.data)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
    setTenderAnnounceLs(state, tenderAnnounceData){
		state.tenderAnnounceData = tenderAnnounceData
	},
	setTenderAnnounceList(state, tenderannouncelist){
		state.tenderannouncelist = tenderannouncelist
	},
	setTenderAnnounces(state, tenderannounces){
		state.tenderannounces = tenderannounces
	},
	setMessage(state, message){
		state.message = message
	},
	setEditTenderAnnounce(state, tenderannounce){
		state.tenderannounce = tenderannounce
	},
};

export const tenderannounce = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
