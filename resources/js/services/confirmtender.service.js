import ApiService from './api.service'

const ConfirmtenderSerivce = {
	rejectTender(data){
		return ApiService.post(`/api/tender/reject/${data.id}`, data)
	},
};

export { ConfirmtenderSerivce };
