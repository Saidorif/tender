import ApiService from './api.service'

const FrontService = {
    requirement(id){
		return ApiService.get(`/api/front/requirement/${id}`)
	},
    direction(id){
		return ApiService.get(`/api/front/direction/edit/${id}`)
	},
    timingtarif(id){
		return ApiService.get(`/api/front/timingtarif/${id}`)
	},
    getschedule(id){
		return ApiService.get(`/api/front/getschedule/${id}`)
	},
};

export { FrontService };
