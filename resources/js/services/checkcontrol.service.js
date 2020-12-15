import ApiService from './api.service'

const CheckControlSerivce = {
	getcheckContols(){
		return ApiService.get(`/api/tender/check-tenders`)
	},
	getappcars(id){
		return ApiService.get(`/api/tender/app-cars/${id}`)
	},
	activeCar(data){
		// return ApiService.post(`/api/tender/app-cars/${data.id}`,data)
	},
	denyCar(data){
		// return ApiService.post(`/api/tender/app-cars/${data.id}`,data)
	}
};

export { CheckControlSerivce };
