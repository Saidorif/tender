import {PaymentService} from "../services/payment.service";

const state = {
	payments: {},
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
			await commit('setEditPayment',payment.data.result)
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
