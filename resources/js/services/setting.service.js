import ApiService from './api.service'

const SettingService = {
	settings(){
		return ApiService.get(`/api/setting`)
	},
	updateSetting(data){
		return ApiService.post(`/api/setting/update/${data.id}`,data)
	},
};

export { SettingService };
