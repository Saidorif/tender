import ApiService from './api.service'

const ConfirmtenderSerivce = {
	rejectTender(data){
		return ApiService.post(`/api/tender/reject/${data.id}`, data)
	},
	completedTender(id){
		return ApiService.get(`/api/tender/complete/${id}`)
	},
	confirmTenderList(page){
		return ApiService.post(`/api/tender/announce?page=${page}`)
	},
};

export { ConfirmtenderSerivce };
