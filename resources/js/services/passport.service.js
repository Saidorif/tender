import ApiService from './api.service'

const PassportService = {
	passports(){
		return ApiService.post(`/api/passport`)
	},
	addpassport(data){
		return ApiService.post(`/api/passport/store`,data)
	},
	editpassport(id){
		return ApiService.get(`/api/passport/edit/${id}`)
	},
	updatepassport(data){
		return ApiService.post(`/api/passport/update/${data.id}`,data)
	},
	deletepassport(id){
		return ApiService.delete(`/api/passport/destroy/${id}`)
	},
	fileSend(data){
		return axios.post(`/api/passport/store`, data,{headers: {'Content-Type': 'multipart/form-data'}});
	},
};

export { PassportService };
