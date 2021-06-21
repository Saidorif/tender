import ApiService from './api.service'

const MycontractService = {
	mycontractList(){
		return ApiService.get(`/api/contract/list`)
	},
	allmycontracts(page){
		return ApiService.post(`/api/contract/user?page=${page}`)
	},
	contractActivate(id){
		return ApiService.get(`/api/contract/activate/${id}`)
	},
	addmycontract(data){
		return ApiService.post(`/api/contract/store`,data)
	},
	editmycontract(id){
		return ApiService.get(`/api/contract/edit/${id}`)
	},
	updatemycontract(data){
		return ApiService.post(`/api/contract/update/${data.id}`,data.items)
	},
	deletemycontract(id){
		return ApiService.delete(`/api/contract/destroy/${id}`)
	},
	deletemycontractcar(id){
		return ApiService.delete(`/api/contract/car-destroy/${id}`)
	},
};

export { MycontractService };
