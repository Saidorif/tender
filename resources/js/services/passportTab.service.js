import ApiService from './api.service'

const PassportTabService = {
	addTiming(data){
		return ApiService.post(`/api/timing/store/${data.timing[0].direction_id}`,data)
	},
};

export { PassportTabService };
