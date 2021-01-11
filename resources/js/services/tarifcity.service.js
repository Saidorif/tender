import ApiService from './api.service'

const TarifCityService = {
	tarifcitys(page){
		return ApiService.post(`/api/tarifcity?page=${page}`)
	},
	getTarifcityByRegion(id){
		return ApiService.post(`/api/tarifcity/regionby`, id)
	},
	addtarifcity(data){
		return ApiService.post(`/api/tarifcity/store`,data)
	},
	edittarifcity(id){
		return ApiService.get(`/api/tarifcity/edit/${id}`)
	},
	updatetarifcity(data){
		return ApiService.post(`/api/tarifcity/update/${data.id}`,data)
	},
	deletetarifcity(id){
		return ApiService.delete(`/api/tarifcity/destroy/${id}`)
	},
};

export { TarifCityService };
