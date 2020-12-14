import ApiService from './api.service'

const CheckControlSerivce = {
	getcheckContols(){
		return ApiService.get(`/api/tender/check-tenders`)
	},
	getappcars(id){
		return ApiService.get(`/api/tender/app-cars/${id}`)
	},
};

export { CheckControlSerivce };
