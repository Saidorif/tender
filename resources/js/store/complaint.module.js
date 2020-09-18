import {ComplaintService} from "../services/complaint.service";

const state = {
	complaintListAll: {},
	complaints: {},
	message: [],
	complaint: [],
	complaintEditListAll: [],
	complaintList: [],
	contacts:[]
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
	getComplaintEditListAll(state){
		return state.complaintEditListAll
	},
	getComplaintListAll(state){
		return state.complaintListAll
	},
	getComplaintList(state){
		return state.complaintList
	},
	getContacts(state){
		return state.complaintList
	},
};


const actions = {
	async actionSendContact({commit},payload){
		try {
			const contacts =  await ComplaintService.contact(payload);
			await commit('setMessage',contacts.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionComplaintUpdateListAll({commit},payload){
		try {
			const complaint =  await ComplaintService.complaintListsUpdateAll(payload);
			await commit('setMessage',complaint.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionComplaintEditListAll({commit},id){
		try {
			const complaint =  await ComplaintService.complaintListsEditAll(id);
			await commit('setComplaintEditListAll',complaint.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionComplaintListAll({commit},payload){
		try {
			const complaint =  await ComplaintService.complaintListsAll(payload);
			await commit('setComplaintListAll',complaint.data.result)
			return true
		} catch (error) {
			return false
		}
	},
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
	setComplaintEditListAll(state, complaintEditListAll){
		state.complaintEditListAll = complaintEditListAll
	},
	setEditComplaint(state, complaint){
		state.complaint = complaint
	},
	setComplaintList(state, complaintList){
		state.complaintList = complaintList
	},
	setComplaintListAll(state, complaintListAll){
		state.complaintListAll = complaintListAll
	},
};

export const complaint = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
