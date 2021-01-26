import ApiService from './api.service'

const TarifannounceService = {
	passportTarifList(data){
		return ApiService.post(`/api/direction/passporttarif/list?page=${data.page}`,data.items)
	},
	approvePassportTarifList(tarifId){
		return ApiService.post(`/api/direction/passporttarif/approve`, tarifId)
	},
};

export { TarifannounceService };
