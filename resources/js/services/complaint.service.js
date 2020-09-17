import ApiService from './api.service'

const ComplaintService = {
	complaints(){
		// return ApiService.get(`/api/controller`)
	},
	addComplaint(data){
		// return ApiService.post(`/api/controller/store`,data)
	},
	editComplaint(id){
		// return ApiService.get(`/api/controller/edit/${id}`)
	},
	updateComplaint(data){
		// return ApiService.post(`/api/controller/update/${data.id}`,data)
	},
	deleteComplaint(id){
		// return ApiService.delete(`/api/controller/destroy/${id}`)
	},
};

export { ComplaintService };
