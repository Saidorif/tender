import ApiService from './api.service'

const CheckControlSerivce = {
	getcheckContols(){
		return ApiService.get(`/api/tender/check-tenders`)
	},
	getappcars(id){
		return ApiService.get(`/api/tender/app-cars/${id}`)
	},
	statusCar(data){
		return ApiService.post(`/api/application/car/setstatus`,data)
	},
};

export { CheckControlSerivce };
