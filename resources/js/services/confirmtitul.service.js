import ApiService from './api.service'

const ConfirmTitulSerivce = {
	tituls(){
		return ApiService.get(`/api/titul`)
	},
	approveTitul(id){
		return ApiService.get(`/api/titul/approve/${id}`)
	},
	activateTitul(id){
		return ApiService.get(`/api/titul/activate/${id}`)
	},
	rejectTitul(id){
		return ApiService.get(`/api/titul/activate/${id}`)
	},
};

export { ConfirmTitulSerivce };
