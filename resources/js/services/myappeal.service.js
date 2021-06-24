import ApiService from './api.service'

const MyAppealService = {
	myappealList(){
		return ApiService.get(`/api/contract/user/appeal/list`)
	},
	allmyappeals(page){
		return ApiService.post(`/api/contract/user/appeal?page=${page}`)
	},
	addmyappeal(data){
		return ApiService.post(`/api/contract/user/sendappeal`,data)
	},
	editmyappeal(id){
		return ApiService.get(`/api/contract/user/appeal/edit/${id}`)
	},
	updatemyappeal(data){
		return ApiService.post(`/api/contract/user/appeal/update/${data.id}`,data)
	},
	deletemyappeal(id){
		return ApiService.delete(`/api/contract/destroy/${id}`)
	},
};

export { MyAppealService };
