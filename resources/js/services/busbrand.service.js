import ApiService from './api.service'

const BusBrandService = {
	busmarkaList(){
		return ApiService.get(`/api/busmarka/list`)
	},
	busmarkas(){
		return ApiService.post(`/api/busmarka`)
	},
	addbusmarka(data){
		return ApiService.post(`/api/busmarka/store`,data)
	},
	editbusmarka(id){
		return ApiService.get(`/api/busmarka/edit/${id}`)
	},
	updatebusmarka(data){
		return ApiService.post(`/api/busmarka/update/${data.id}`,data)
	},
	deletebusmarka(id){
		return ApiService.delete(`/api/busmarka/destroy/${id}`)
	},
};

export { BusBrandService };
