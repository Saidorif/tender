import {PaymentService} from "../services/payment.service";

const state = {
	payments: {},
	userpayments: {},
	paymentlist: [],
	message: [],
	payment: [],
};

const getters = {
	getPaymentList(state){
		return state.paymentlist
	},
	getPayments(state){
		return state.payments
	},
	getUserPayments(state){
		return state.userpayments
	},
	getMassage(state){
		return state.message
	},
	getPayment(state){
		return state.payment
	},
};


const actions = {
	async actionPaymentList({commit},page){
		try {
			const payments =  await PaymentService.paymentList(page);
			await commit('setPaymentList',payments.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionPayments({commit},page){
		try {
			const payments =  await PaymentService.payments(page);
			await commit('setPayments',payments.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionUserPayments({commit},page){
		try {
			const payments =  await PaymentService.userPayments(page);
			await commit('setUserPayments',payments.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionAddPayment({commit},payload){
		try {
			const payments =  await PaymentService.addpayment(payload);
			await commit('setMessage',payments.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionEditPayment({commit},id){
		try {
			const payments =  await PaymentService.editpayment(id);
			await commit('setEditPayment',payments.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionUpdatePayment({commit},payload){
		try {
			const payment =  await PaymentService.updatepayment(payload);
			await commit('setMessage',payment.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionDeletePayment({commit},id){
		try {
			const payment =  await PaymentService.deletepayment(id);
			await commit('setMessage',payment.data)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	setPaymentList(state, paymentlist){
		state.paymentlist = paymentlist
	},
	setPayments(state, payments){
		state.payments = payments
	},
	setUserPayments(state, userpayments){
		state.userpayments = userpayments
	},
	setMessage(state, message){
		state.message = message
	},
	setEditPayment(state, payment){
		state.payment = payment
	},
};

export const payment = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
