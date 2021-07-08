import ApiService from './api.service'

const CheckControlSerivce = {
	getcheckContols(){
		return ApiService.get(`/api/tender/check-tenders`)
	},
	getappcars(id){
		return ApiService.get(`/api/tender/app-cars/${id}`)
	},
	getUserAppcars(id){
		return ApiService.get(`/api/tender/user-app-cars/${id}`)
	},
	statusCar(data){
		return ApiService.post(`/api/application/car/setstatus`,data)
	},
	closeLot(id){
		return ApiService.post(`/api/tender/approve/${id}`)
	},
	checkLicense(inn){
		return ApiService.get(`/api/get-license-list/${inn}`)
	},
	appFiles(data){
		return ApiService.post(`/api/appfile`,data)
	},
	appFileStore(data){
		return ApiService.post(`/api/appfile/store`,data)
	},
	appFileRemove(id){
		return ApiService.delete(`/api/appfile/destroy/${id}`)
	},
	apptarget(data){
		return ApiService.post(`/api/application/addition-status`,data)
	},
};

export { CheckControlSerivce };
