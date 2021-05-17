import ApiService from './api.service'

const ConfirmTitulSerivce = {
	tituls(page){
		return ApiService.get(`/api/titul?page=${page}`)
	},
	titulShow(id){
		return ApiService.get(`/api/titul/edit/${id}`)
	},
	approveTitul(id){
		return ApiService.get(`/api/titul/approve/${id}`)
	},
	activateTitul(id){
		return ApiService.get(`/api/titul/activate/${id}`)
	},
	rejectTitul(id){
		return ApiService.get(`/api/titul/reject/${id}`)
	},
};

export { ConfirmTitulSerivce };
