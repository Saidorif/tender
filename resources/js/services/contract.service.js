import ApiService from './api.service'

const ContractService = {
	contract(id){
		return ApiService.get(`/api/contract/edit/${id}`)
	},
	contractlist(data){
		return ApiService.post(`/api/contract?page=${data.page}&type=${data.type}`)
	},
	contractCheck(data){
		return ApiService.post(`/api/tender/car-check`,data)
	},
};

export { ContractService };
