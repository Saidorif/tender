import ApiService from './api.service'

const ApplyService = {
	apply(page){
		return ApiService.post(`/api/getaccess/index?page=${page}`)
	},
	applySend(data){
		return ApiService.post(`/api/getaccess`,data)
	},
	checkInn(data){
		return ApiService.post(`/api/checkuser`,data)
	},
	checkEmail(data){
		return ApiService.post(`/api/checkemail`,data)
	},
	activateAll(data){
		return ApiService.post(`/api/getaccess/activate`,data)
	},
};

export { ApplyService };
