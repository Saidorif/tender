import ApiService from './api.service'

const ApplicationService = {
	applicationList(){
		return ApiService.get(`/api/application/list`)
	},
	UserApplications(page){
		return ApiService.post(`/api/application/user?page=`+page)
	},
	Applications(page){
		return ApiService.post(`/api/application?page=`+page)
	},
	addapplication(data){
		return ApiService.post(`/api/application/store`,data)
	},
	editapplication(id){
		return ApiService.get(`/api/application/edit/${id}`)
	},
	showapplication(data){
		return ApiService.get(`/api/application/show/${data.id}?page=${data.page}`)
	},
	updateapplication(data){
		return ApiService.post(`/api/application/update/${data.id}`,data)
	},
	deleteapplication(id){
		return ApiService.delete(`/api/application/destroy/${id}`)
	},
	sendusereditapplication(data){
		return ApiService.post(`/api/application/tender/store`,data)
	},
	sendUserApplication(data){
		return ApiService.post(`/api/application`,data)
	},
	addCar(data){
		return ApiService.post(`/api/application/car/store`,data)
	},
	addFile(data){
		return ApiService.post(`/api/file/store`,data)
	},
	removeFile(id){
		return ApiService.delete(`/api/file/destroy/`+id)
	},
	removeCar(id){
		return ApiService.delete(`/api/application/car/destroy/`+id)
	},
	gaiApi(data){
		return ApiService.post(`/api/gai/vehicle`,data)
	},
	adliyaApi(data){
		return ApiService.post(`/api/adliya`,data)
	},
	activate(id){
		return ApiService.get(`/api/application/activate/${id}`)
	},
};

export { ApplicationService };
