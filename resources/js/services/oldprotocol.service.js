import ApiService from './api.service'

const OldprotocolService = {
	oldprotocolList(){
		return ApiService.get(`/api/oldprotocol/list`)
	},
	alloldprotocols(page){
		return ApiService.post(`/api/oldprotocol?page=${page}`)
	},
	addoldprotocol(data){
		return ApiService.post(`/api/oldprotocol/store`,data)
	},
	editoldprotocol(id){
		return ApiService.get(`/api/oldprotocol/edit/${id}`)
	},
	updateoldprotocol(data){
		return ApiService.post(`/api/oldprotocol/update/${data.id}`,data)
	},
	deleteoldprotocol(id){
		return ApiService.delete(`/api/oldprotocol/destroy/${id}`)
	},
};

export { OldprotocolService };
