import ApiService from './api.service'

const TenderAnnounceService = {
	tenderannounceList(){
		return ApiService.get(`/api/tenderannounce/list`)
	},
	tenderannounces(){
		return ApiService.post(`/api/tenderannounce`)
	},
	addtenderannounce(data){
		return ApiService.post(`/api/tenderannounce/store`,data)
	},
	edittenderannounce(id){
		return ApiService.get(`/api/tenderannounce/edit/${id}`)
	},
	updatetenderannounce(data){
		return ApiService.post(`/api/tenderannounce/update/${data.id}`,data)
	},
	deletetenderannounce(id){
		return ApiService.delete(`/api/tenderannounce/destroy/${id}`)
	},
};

export { TenderAnnounceService };
