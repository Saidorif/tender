import ApiService from './api.service'

const BusModelService = {
	busmodelList(){
		return ApiService.get(`/api/busmodel/list`)
	},
	busmodels(page){
		return ApiService.post(`/api/busmodel?page=${page}`)
	},
	busmodelfind(data){
		return ApiService.post(`/api/busmodel/find`, data)
	},
	addbusmodel(data){
		return ApiService.post(`/api/busmodel/store`,data)
	},
	addbybrandbusmodel(data){
		return ApiService.post(`/api/busmodel/get-by-marka`,data)
	},
	editbusmodel(id){
		return ApiService.get(`/api/busmodel/edit/${id}`)
	},
	updatebusmodel(data){
		return ApiService.post(`/api/busmodel/update/${data.id}`,data)
	},
	deletebusmodel(id){
		return ApiService.delete(`/api/busmodel/destroy/${id}`)
	},
};

export { BusModelService };
