import {ComplaintService} from "../services/complaint.service";

const state = {
	complaints: {},
	message: [],
	complaint: [],
	complaintList: [],
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
	getComplaintList(state){
		return state.complaintList
	},
};


const actions = {
	async actionComplaintList({commit},page){
		try {
			const complaint =  await ComplaintService.complaintLists(page);
			await commit('setComplaintList',complaint.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionComplaints({commit},page){
		try {
			const complaint =  await ComplaintService.complaintss(page);
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
	setComplaintList(state, complaintList){
		state.complaintList = complaintList
	},
};

export const complaint = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
