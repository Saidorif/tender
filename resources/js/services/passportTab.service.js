import ApiService from './api.service'

const PassportTabService = {
	addTiming(data){
		return ApiService.post(`/api/timing/store/${data.timing[0].direction_id}`,data)
	},
	setScheduleTable(data){
		return ApiService.post(`/api/direction/schedule/${data.id}`,data)
	},
	addSchemadetail(data){
		return ApiService.post(`/api/schemadetail/store/${data.id}`,data)
	},
	getScheduleTable(id){
		return ApiService.get(`/api/direction/getschedule/${id}`)
	},
	clearTimingTable(id){
		return ApiService.delete(`/api/timing/destroy/${id}`)
	},
	tarif(id){
		return ApiService.get(`/api/direction/timingtarif/${id}`)
	},
	tarifConfirm(data){
		return ApiService.post(`/api/direction/passporttarif/${data.id}`,data)
	},
	demands(id){
		return ApiService.get(`/api/direction/requirement/${id}`)
	},
	demandSave(data){
		return ApiService.post(`/api/direction/requirement/${data.id}`,data.items)
	}
};

export { PassportTabService };
