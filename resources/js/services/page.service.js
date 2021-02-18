import ApiService from './api.service'

const PageService = {
	tenderIndex(page){
		return ApiService.post(`/api/tender/index?page=${page}`)
	},
	tenderIndexCompleted(page){
		return ApiService.post(`/api/tender/index-completed?page=${page}`)
	},
	getTarifByNumber(data){
		return ApiService.post(`/api/get-tarif-by-number`, data)
	},
};

export { PageService };
