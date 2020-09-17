import {ComplaintService} from "../services/complaint.service";

const state = {
	complaints: {},
	message: [],
	complaint: [],
};

const getters = {
	getComplaints(state){
		return state.complaints
	},
	getMassage(state){
		return state.message
	},
	getComplaint(state){
		return state.complaint
	},
};


const actions = {
	async actionComplaints({commit},page){
		try {
			const complaint =  await ComplaintService.complaints(page);
			await commit('setComplaints',complaint.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionAddComplaint({commit},payload){
		try {
			const complaint =  await ComplaintService.addComplaint(payload);
			await commit('setMessage',complaint.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionEditComplaint({commit},payload){
		try {
			const complaint =  await ComplaintService.editComplaint(payload);
			await commit('setEditComplaint',complaint.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionUpdateComplaint({commit},payload){
		try {
			const complaint =  await ComplaintService.updateComplaint(payload);
			await commit('setMessage',complaint.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionDeleteComplaint({commit},id){
		try {
			const complaint =  await ComplaintService.deleteComplaint(id);
			await commit('setMessage',complaint.data)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	setComplaints(state, complaints){
		state.complaints = complaints
	},
	setMessage(state, message){
		state.message = message
	},
	setEditComplaint(state, complaint){
		state.complaint = complaint
	},
};

export const complaint = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
