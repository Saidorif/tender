import ApiService from './api.service'

const ProtocolService = {
	protocolId(id){
		return ApiService.get(`/api/tender/getinfo/${id}`)
	},
};

export { ProtocolService };
