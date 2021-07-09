import {InvoicesService} from "../services/invoices.service";

const state = {
	invoices: {},
	invoice: {},
};

const getters = {
	getInvoices(state){
		return state.invoices
	},
	getInvoice(state){
		return state.invoice
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
	async actionShowInvoice({commit},id){
		try {
			const apply =  await InvoicesService.invoiceEdit(id);
			await commit('setInvoice',apply.data.result)
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
};

export const invoices = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
