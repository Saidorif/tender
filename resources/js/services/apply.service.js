import ApiService from './api.service'

const ApplyService = {
	apply(page){
		// return ApiService.post(`/api/apply?page=${page}`)
	},
	applySend(data){
		return ApiService.post(`/api/getaccess`,data)
	},
	checkInn(data){
		return ApiService.post(`/api/checkuser`,data)
	},
};

export { ApplyService };
