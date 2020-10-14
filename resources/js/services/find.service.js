import ApiService from './api.service'

const FindService = {
	findUserByCompanyName(data){
		return ApiService.post(`/api/user/find`,data)
	},
};

export { FindService };
