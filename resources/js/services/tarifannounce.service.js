import ApiService from './api.service'

const TarifannounceService = {
	passportTarifList(page){
		return ApiService.get(`/api/direction/passporttarif/list?page=${page}`)
	},
	approvePassportTarifList(tarifId){
		return ApiService.post(`/api/direction/passporttarif/approve`, tarifId)
	},
};

export { TarifannounceService };
