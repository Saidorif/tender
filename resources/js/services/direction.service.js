import ApiService from './api.service'

const DirectService = {
	directFind(data){
		return ApiService.post(`/api/direction/find`,data)
	},
	directs(data){
		return ApiService.post(`/api/direction?page=${data.page}`,data.items)
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
	deleteCarDirection(id){
		return ApiService.delete(`/api/direction/car/destroy/${id}`)
	},
};

export { DirectService };
