import ApiService from './api.service'

const ConfirmTitulSerivce = {
	tituls(data){
		return ApiService.post(`/api/titul?page=${data.page}`,data.items)
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
