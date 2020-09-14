import ApiService from './api.service'

const PassportTabService = {
	addTiming(data){
		return ApiService.post(`/api/timing/store`,data)
	},
};

export { PassportTabService };
