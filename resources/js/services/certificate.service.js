import ApiService from './api.service'

const CertificateService = {
	certificateList(){
		return ApiService.get(`/api/certificate/list`)
	},
	allcertificates(page){
		return ApiService.post(`/api/certificate?page=${page}`)
	},
	addcertificate(data){
		return ApiService.post(`/api/certificate/store`,data)
	},
	editcertificate(id){
		return ApiService.get(`/api/certificate/${id}`)
	},
	updatecertificate(data){
		return ApiService.post(`/api/certificate/update/${data.id}`,data)
	},
	deletecertificate(id){
		return ApiService.delete(`/api/certificate/destroy/${id}`)
	},
};

export { CertificateService };
