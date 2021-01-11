import ApiService from './api.service'

const TarifCityService = {
	tarifcitys(page){
		return ApiService.get(`/api/tarifcity?page=${page}`)
	},
	getTarifcityByRegion(id){
		return ApiService.post(`/api/tarifcity/regionby`, id)
	},
	addtarifcity(data){
		return ApiService.postWithfile(`/api/tarifcity/store`,data)
	},
	edittarifcity(id){
		return ApiService.get(`/api/tarifcity/edit/${id}`)
	},
	updatetarifcity(data){
		return ApiService.postWithfile(`/api/tarifcity/update/${data.id}`,data.data)
	},
	deletetarifcity(id){
		return ApiService.delete(`/api/tarifcity/destroy/${id}`)
	},
};

export { TarifCityService };
