import {TarifannounceService} from "../services/tarifannounce.service";

const state = {
	passportList: [],
	message: [],
};

const getters = {
	getPassportList(state){
		return state.passportList
    },
    getMassage(state){
        return state.message
    }
};


const actions = {
	async actionPortTarifList({commit},page){
		try {
			const passportList =  await TarifannounceService.passportTarifList(page);
			await commit('setPassportList',passportList.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionApprovePassportTarifList({commit},payload){
		try {
			const passportList =  await TarifannounceService.approvePassportTarifList(payload);
			await commit('setMassage',passportList.data.result)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	setPassportList(state, passportList){
		state.passportList = passportList
	},
	setMassage(state, message){
		state.message = message
	},
};

export const tarifannounce = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
