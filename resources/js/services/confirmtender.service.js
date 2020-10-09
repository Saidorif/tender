import ApiService from './api.service'

const ConfirmtenderSerivce = {
	rejectTender(data){
		return ApiService.post(`/api/tender/reject/${data.id}`, data)
	},
	completedTender(id){
		return ApiService.get(`/api/tender/complete/${id}`)
	},
};

export { ConfirmtenderSerivce };
