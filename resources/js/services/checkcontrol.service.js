import ApiService from './api.service'

const CheckControlSerivce = {
	getcheckContols(){
		return ApiService.get(`/api/tender/check-tenders`)
	},
};

export { CheckControlSerivce };
