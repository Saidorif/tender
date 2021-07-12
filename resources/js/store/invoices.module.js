import {InvoicesService} from "../services/invoices.service";

const state = {
	invoices: {},
	invoice: {},
	user_invoice: {},
	u_invoice: {},
};

const getters = {
	getInvoices(state){
		return state.invoices
	},
	getInvoice(state){
		return state.invoice
	},
	getUserInvoice(state){
		return state.user_invoice
	},
	getShowUserInvoice(state){
		return state.u_invoice
	},
};


const actions = {
	async actionInvoice({commit},page){
		try {
			const apply =  await InvoicesService.invoice(page);
			await commit('setInvoices',apply.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionInvoiceUser({commit},page){
		try {
			const apply =  await InvoicesService.invoiceUser(page);
			await commit('setUserInvoice',apply.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionShowInvoice({commit},id){
		try {
			const apply =  await InvoicesService.invoiceEdit(id);
			await commit('setInvoice',apply.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionShowUserInvoice({commit},id){
		try {
			const apply =  await InvoicesService.invoiceUserEdit(id);
			await commit('setShowUserInvoice',apply.data.result)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	setInvoices(state, invoice){
		state.invoices = invoice
	},
	setInvoice(state, invoice){
		state.invoice = invoice
	},
	setUserInvoice(state, invoice){
		state.user_invoice = invoice
	},
	setShowUserInvoice(state, invoice){
		state.u_invoice = invoice
	},
};

export const invoices = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
