import ApiService from './api.service'

const ComplaintService = {
	complaintss(){
		return ApiService.get(`/api/complaintcategory`)
	},
	complaintLists(){
		return ApiService.get(`/api/complaintcategory/list`)
	},
	addComplaint(data){
		return ApiService.post(`/api/complaintcategory/store`,data)
	},
	editComplaint(id){
		return ApiService.get(`/api/complaintcategory/edit/${id}`)
	},
	updateComplaint(data){
		return ApiService.post(`/api/complaintcategory/update/${data.id}`,data)
	},
	deleteComplaint(id){
		return ApiService.delete(`/api/complaintcategory/destroy/${id}`)
	},
};

export { ComplaintService };
