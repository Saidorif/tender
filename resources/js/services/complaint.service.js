import ApiService from './api.service'

const ComplaintService = {
	contact(data){
		return ApiService.post(`/api/complaint/store`,data)
	},
	complaintLength(){
		return ApiService.get(`/api/complaint/length`)
	},
	complaintListsAll(data){
		return ApiService.post(`/api/complaint?page=${data.page}`,data.items)
	},
	complaintListsEditAll(id){
		return ApiService.get(`/api/complaint/edit/${id}`)
	},
	complaintListsUpdateAll(data){
		return ApiService.post(`/api/complaint/update/${data.id}`,data.items)
	},
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
