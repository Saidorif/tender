import ApiService from './api.service'

const TypeofdirectionService = {
	typeofdirectionList(){
		return ApiService.get(`/api/directiontype/list`)
	},
	typeofdirections(){
		return ApiService.post(`/api/directiontype`)
	},
	addtypeofdirection(data){
		return ApiService.post(`/api/directiontype/store`,data)
	},
	edittypeofdirection(id){
		return ApiService.get(`/api/directiontype/edit/${id}`)
	},
	updatetypeofdirection(data){
		return ApiService.post(`/api/directiontype/update/${data.id}`,data)
	},
	deletetypeofdirection(id){
		return ApiService.delete(`/api/directiontype/destroy/${id}`)
	},
};

export { TypeofdirectionService };
