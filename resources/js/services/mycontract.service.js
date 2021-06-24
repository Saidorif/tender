import ApiService from './api.service'

const MycontractService = {
	mycontractList(){
		return ApiService.get(`/api/contract/list`)
	},
	allmycontracts(page){
		return ApiService.post(`/api/contract/user?page=${page}`)
	},
	listmycontracts(){
		return ApiService.get(`/api/contract/user/list`)
	},
	contractActivate(data){
		return ApiService.post(`/api/contract/agree`,data)
	},
	addmycontract(data){
		return ApiService.post(`/api/contract/store`,data)
	},
	editmycontract(id){
		return ApiService.get(`/api/contract/user/edit/${id}`)
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
