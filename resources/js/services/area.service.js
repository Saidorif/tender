import ApiService from './api.service'

const AreaService = {
	areas(page){
		return ApiService.post(`/api/area?page=${page}`)
	},
	getAreaByRegion(id){
		return ApiService.post(`/api/area/regionby`, id)
	},
	addarea(data){
		return ApiService.post(`/api/area/store`,data)
	},
	editarea(id){
		return ApiService.get(`/api/area/edit/${id}`)
	},
	updatearea(data){
		return ApiService.post(`/api/area/update/${data.id}`,data)
	},
	deletearea(id){
		return ApiService.delete(`/api/area/destroy/${id}`)
	},
};

export { AreaService };
