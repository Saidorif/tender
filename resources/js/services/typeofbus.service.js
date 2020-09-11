import ApiService from './api.service'

const TypeofbusService = {
	typeofbusList(){
		return ApiService.get(`/api/bustype/list`)
	},
	typeofbuss(){
		return ApiService.post(`/api/bustype`)
	},
	addtypeofbus(data){
		return ApiService.post(`/api/bustype/store`,data)
	},
	edittypeofbus(id){
		return ApiService.get(`/api/bustype/edit/${id}`)
	},
	updatetypeofbus(data){
		return ApiService.post(`/api/bustype/update/${data.id}`,data)
	},
	deletetypeofbus(id){
		return ApiService.delete(`/api/bustype/destroy/${id}`)
	},
};

export { TypeofbusService };
