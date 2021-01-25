import ApiService from './api.service'

const CompletedTendersSerivce = {
	completedTendersList(data){
		return ApiService.post(`/api/tender/completed-tenders?page=${data.page}`,data.items)
	},
	completedTendersShow(id){
		return ApiService.get(`/api/tender/completed-tenders/${id}`)
	},
};

export { CompletedTendersSerivce };
