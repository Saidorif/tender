import ApiService from './api.service'

const AppealService = {
	appealList(){
		return ApiService.get(`/api/contract/user/appeal/list`)
	},
	allappeals(page){
		return ApiService.post(`/api/contract/user/appeal?page=${page}`)
	},
	addappeal(data){
		return ApiService.post(`/api/contract/user/sendappeal`,data)
	},
	editappeal(id){
		return ApiService.get(`/api/contract/user/appeal/edit/${id}`)
	},
	updateappeal(data){
		return ApiService.post(`/api/contract/user/appeal/update/${data.id}`,data)
	},
	deleteappeal(id){
		return ApiService.delete(`/api/contract/destroy/${id}`)
	},
};

export { AppealService };
