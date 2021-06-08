import ApiService from './api.service'

const ConfirmDemandSerivce = {
	demands(data){
		return ApiService.post(`/api/dirreq?page=${data.page}`,data.items)
	},
	demandShow(id){
		return ApiService.get(`/api/dirreq/edit/${id}`)
	},
	approvedemand(id){
		return ApiService.get(`/api/dirreq/approve/${id}`)
	},
	activatedemand(id){
		return ApiService.get(`/api/dirreq/activate/${id}`)
	},
	rejectdemand(id){
		return ApiService.get(`/api/dirreq/reject/${id}`)
	},
};

export { ConfirmDemandSerivce };
