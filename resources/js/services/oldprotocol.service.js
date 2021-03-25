import ApiService from './api.service'

const OldprotocolService = {
	oldprotocolList(){
		return ApiService.get(`/api/protocol/list`)
	},
	alloldprotocols(page){
		return ApiService.post(`/api/protocol?page=${page}`)
	},
	addoldprotocol(data){
		return ApiService.post(`/api/protocol/store`,data)
	},
	editoldprotocol(id){
		return ApiService.get(`/api/protocol/edit/${id}`)
	},
	updateoldprotocol(data){
		return ApiService.post(`/api/protocol/update/${data.id}`,data.items)
	},
	findoldprotocol(data){
		return ApiService.post(`/api/protocol/find`,data)
	},
	deleteoldprotocol(id){
		return ApiService.delete(`/api/protocol/destroy/${id}`)
	},
};

export { OldprotocolService };
