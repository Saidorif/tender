import ApiService from './api.service'

const BusclassService = {
	busclassList(){
		return ApiService.get(`/api/tclass/list`)
	},
	busclasseFind(data){
		return ApiService.post(`/api/tclass/find`,data)
	},
	busclasses(){
		return ApiService.post(`/api/tclass`)
	},
	addbusclass(data){
		return ApiService.post(`/api/tclass/store`,data)
	},
	editbusclass(id){
		return ApiService.get(`/api/tclass/edit/${id}`)
	},
	updatebusclass(data){
		return ApiService.post(`/api/tclass/update/${data.id}`,data)
	},
	deletebusclass(id){
		return ApiService.delete(`/api/tclass/destroy/${id}`)
	},
};

export { BusclassService };
