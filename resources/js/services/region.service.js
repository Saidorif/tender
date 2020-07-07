import ApiService from './api.service'

const RegionService = {
	regions(){
		return ApiService.get(`/api/region`)
	},
	addregion(data){
		return ApiService.post(`/api/region/store`,data)
	},
	editregion(data){
		return ApiService.get(`/api/region/edit/${data.id}`)
	},
	updateregion(data){
		return ApiService.post(`/api/region/update/${data.id}`,data)
	},
	deleteregion(id){
		return ApiService.delete(`/api/region/destroy/${id}`)
	},
};

export { RegionService };
