import ApiService from './api.service'

const ContractService = {
	contract(id){
		return ApiService.get(`/api/contract/edit/${id}`)
	},
	contractlist(data){
		return ApiService.get(`/api/contract?page=${data.page}&type=${data.type}`)
	},
};

export { ContractService };
