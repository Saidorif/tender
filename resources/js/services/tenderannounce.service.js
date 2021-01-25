import ApiService from './api.service'

const TenderAnnounceService = {
	tenderannounceList(){
		return ApiService.get(`/api/tender/list`)
	},
	tenderannounceses(data){
		return ApiService.post(`/api/tender?page=${data.page}`,data.items)
	},
	addtenderannounce(data){
		return ApiService.post(`/api/tender/store`,data)
	},
	edittenderannounce(id){
		return ApiService.get(`/api/tender/edit/${id}`)
	},
	updatetenderannounce(data){
		return ApiService.post(`/api/tender/update/${data.id}`,data)
	},
	deletetenderannounce(id){
		return ApiService.delete(`/api/tender/destroy/${id}`)
	},
	deletetenderannounceItem(data){
		return ApiService.post(`/api/tender/remove/${data.id}`,data)
	},
};

export { TenderAnnounceService };
