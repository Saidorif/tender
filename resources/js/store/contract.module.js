import {ContractService} from "../services/contract.service";

const state = {
	message: [],
	contract: [],
	contractList: {},
};

const getters = {
	getContractList(state){
		return state.contractList
	},
	getMassage(state){
		return state.message
	},
	getContract(state){
		return state.contract
	},
};


const actions = {
	async actionContractList({commit},data){
		try {
			const areas =  await ContractService.contractlist(data);
			await commit('setContractLists',areas.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionContract({commit},id){
		try {
			const areas =  await ContractService.contract(id);
			await commit('setContract',areas.data.result)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	setContractLists(state, contractList){
		state.contractList = contractList
	},
	setContract(state, contract){
		state.contract = contract
	},
	setMessage(state, message){
		state.message = message
	},
};

export const contract = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
