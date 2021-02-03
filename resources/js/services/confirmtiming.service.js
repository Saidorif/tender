import ApiService from './api.service'

const ConfirmTimingSerivce = {
	xronoms(){
		return ApiService.get(`/api/xronom`)
	},
	xronomShow(id){
		return ApiService.get(`/api/xronom/edit/${id}`)
	},
	approvexronom(id){
		return ApiService.get(`/api/xronom/approve/${id}`)
	},
	activatexronom(id){
		return ApiService.get(`/api/xronom/activate/${id}`)
	},
	rejectxronom(id){
		return ApiService.get(`/api/xronom/reject/${id}`)
	},
};

export { ConfirmTimingSerivce };
