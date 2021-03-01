import ApiService from './api.service'

const ConfirmDemandSerivce = {
	demands(){
		return ApiService.get(`/api/dirreq`)
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
