import ApiService from './api.service'

const ClientService = {
	clientList(data){
		return ApiService.post(`/api/carrier?page=${data.page}`,data.items)
	},
	clientEdit(id){
		return ApiService.get(`/api/carrier/edit/${id}`)
	},
};

export { ClientService };
