import ApiService from './api.service'

const ApplicationService = {
	applicationList(){
		return ApiService.get(`/api/application/list`)
	},
	Applications(){
		return ApiService.post(`/api/application`)
	},
	addapplication(data){
		return ApiService.post(`/api/application/store`,data)
	},
	editapplication(id){
		return ApiService.get(`/api/application/edit/${id}`)
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
};

export { ApplicationService };
