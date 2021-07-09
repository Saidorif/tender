import {ContractService} from "../services/contract.service";

const state = {
	message: [],
	contract: [],
	contracts: [],
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
	getContracts(state){
		return state.contracts
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
	async actionContractCheck({commit},payload){
		try {
			const areas =  await ContractService.contractCheck(payload);
			await commit('setContractCheck',areas.data)
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
	setContractCheck(state, contracts){
		state.contracts = contracts
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
