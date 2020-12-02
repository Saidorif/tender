import ApiService from './api.service'

const CompletedTendersSerivce = {
	completedTendersList(){
		return ApiService.get(`/api/tender/completed-tenders/`)
	},
	completedTendersShow(id){
		return ApiService.get(`/api/tender/completed-tenders/${id}`)
	},
};

export { CompletedTendersSerivce };
