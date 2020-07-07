import ApiService from './api.service'

const RegionService = {
	regionList(){
		return ApiService.get(`/api/region/list`)
	},
	regions(){
		return ApiService.post(`/api/region`)
	},
	addregion(data){
		return ApiService.post(`/api/region/store`,data)
	},
	editregion(id){
		return ApiService.get(`/api/region/edit/${id}`)
	},
	updateregion(data){
		return ApiService.post(`/api/region/update/${data.id}`,data)
	},
	deleteregion(id){
		return ApiService.delete(`/api/region/destroy/${id}`)
	},
};

export { RegionService };
