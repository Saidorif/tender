import ApiService from './api.service'

const PaymentService = {
	paymentList(){
		return ApiService.get(`/api/payment/list`)
	},
	payments(page){
		return ApiService.post(`/api/payment?page=${page}`)
	},
	addpayment(data){
		return ApiService.post(`/api/payment/store`,data)
	},
	editpayment(id){
		return ApiService.get(`/api/payment/edit/${id}`)
	},
	updatepayment(data){
		return ApiService.post(`/api/payment/update/${data.id}`,data)
	},
	deletepayment(id){
		return ApiService.delete(`/api/payment/destroy/${id}`)
	},
};

export { PaymentService };
