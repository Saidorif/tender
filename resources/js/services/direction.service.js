import ApiService from './api.service'

const DirectService = {
	directFind(data){
		return ApiService.post(`/api/direction/find`,data)
	},
	directs(){
		return ApiService.post(`/api/direction`)
	},
	addDirection(data){
		return ApiService.post(`/api/direction/store`,data)
	},
	editDirection(id){
		return ApiService.get(`/api/direction/edit/${id}`)
	},
	updateDirection(data){
		return ApiService.post(`/api/direction/update/${data.id}`,data)
	},
	deleteDirection(id){
		return ApiService.delete(`/api/direction/destroy/${id}`)
	},
};

export { DirectService };
