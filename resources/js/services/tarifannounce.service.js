import ApiService from './api.service'

const TarifannounceService = {
	passportTarifList(){
		return ApiService.get(`/api/direction/passporttarif/list`)
	},
	approvePassportTarifList(tarifId){
		return ApiService.post(`/api/direction/passporttarif/approve`, tarifId)
	},
};

export { TarifannounceService };
