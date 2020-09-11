import ApiService from './api.service'

const TypeofdirectionService = {
	typeofdirectionList(){
		return ApiService.get(`/api/typeofdirection/list`)
	},
	typeofdirections(){
		return ApiService.post(`/api/typeofdirection`)
	},
	addtypeofdirection(data){
		return ApiService.post(`/api/typeofdirection/store`,data)
	},
	edittypeofdirection(id){
		return ApiService.get(`/api/typeofdirection/edit/${id}`)
	},
	updatetypeofdirection(data){
		return ApiService.post(`/api/typeofdirection/update/${data.id}`,data)
	},
	deletetypeofdirection(id){
		return ApiService.delete(`/api/typeofdirection/destroy/${id}`)
	},
};

export { TypeofdirectionService };
