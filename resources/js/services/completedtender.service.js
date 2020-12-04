import ApiService from './api.service'

const CompletedTendersSerivce = {
	completedTendersList(page){
		return ApiService.get(`/api/tender/completed-tenders?page=${page}`)
	},
	completedTendersShow(id){
		return ApiService.get(`/api/tender/completed-tenders/${id}`)
	},
};

export { CompletedTendersSerivce };
