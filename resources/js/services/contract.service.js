import ApiService from './api.service'

const ContractService = {
	contract(id){
		return ApiService.get(`/api/contract/edit/${id}`)
	},
	contractlist(page){
		return ApiService.post(`/api/contract?page=${page}`)
	},
};

export { ContractService };
