import ApiService from './api.service'

const ConditionalSignService = {
	conditionalsignList(){
		return ApiService.get(`/api/conditionalsign/list`)
	},
	conditionalsignAll(page){
		return ApiService.post(`/api/conditionalsign?page=`+page)
	},
	addconditionalsign(data){
		return ApiService.post(`/api/conditionalsign/store`,data)
	},
	editconditionalsign(id){
		return ApiService.get(`/api/conditionalsign/edit/${id}`)
	},
	updateconditionalsign(data){
		return ApiService.post(`/api/conditionalsign/update/${data.id}`,data.items)
	},
	deleteconditionalsign(id){
		return ApiService.delete(`/api/conditionalsign/destroy/${id}`)
	},
};

export { ConditionalSignService };
