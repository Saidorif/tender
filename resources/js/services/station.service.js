import ApiService from './api.service'

const StationService = {
	stations(){
		return ApiService.post(`/api/station`)
	},
	stationByRegion(data){
		return ApiService.post(`/api/station/regionby`, data)
	},
	addstation(data){
		return ApiService.post(`/api/station/store`,data)
	},
	editstation(id){
		return ApiService.get(`/api/station/edit/${id}`)
	},
	updatestation(data){
		return ApiService.post(`/api/station/update/${data.id}`,data)
	},
	deletestation(id){
		return ApiService.delete(`/api/station/destroy/${id}`)
	},
};

export { StationService };
