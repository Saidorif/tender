import ApiService from './api.service'

const OldcontractService = {
	oldcontractList(){
		return ApiService.get(`/api/contract/list`)
	},
	alloldcontracts(page){
		return ApiService.post(`/api/contract?page=${page}`)
	},
	addoldcontract(data){
		return ApiService.post(`/api/contract/store`,data)
	},
	editoldcontract(id){
		return ApiService.get(`/api/contract/edit/${id}`)
	},
	updateoldcontract(data){
		return ApiService.post(`/api/contract/update/${data.id}`,data.items)
	},
	deleteoldcontract(id){
		return ApiService.delete(`/api/contract/destroy/${id}`)
	},
	deleteoldcontractcar(id){
		return ApiService.delete(`/api/contract/car-destroy/${id}`)
	},
};

export { OldcontractService };
