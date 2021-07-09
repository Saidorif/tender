import ApiService from './api.service'



const InvoicesService = {
	invoice(page){
		return ApiService.post(`/api/invoice?page=${page}`)
	},
	invoiceUser(){
		return ApiService.post(`/api/invoice/user`)
	},
	invoiceUserEdit(id){
		return ApiService.get(`/api/invoice/user/edit/${id}`)
	},
	invoiceEdit(id){
		return ApiService.get(`/api/invoice/edit/${id}`)
	},
	invoiceAct(id){
		return ApiService.get(`/api/invoice/act/${id}`)
	},
	invoiceAdminAct(id){
		return ApiService.get(`/api/invoice/adminact/${id}`)
	},
};

export { InvoicesService };
