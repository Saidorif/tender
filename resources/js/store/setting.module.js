import {SettingService} from "../services/setting.service";

const state = {
	message: [],
	setting: [],
};

const getters = {
	getSetting(state){
		return state.setting
	},
	getMassage(state){
		return state.message
	},
};


const actions = {
	async actionSetting({commit}){
		try {
			const items =  await SettingService.settings();
			await commit('setSetting',items.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionUpdateSetting({commit},payload){
		try {
			const items =  await SettingService.updateSetting(payload);
			await commit('setMessage',items.data)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	setSetting(state, setting){
		state.setting = setting
	},
	setMessage(state, message){
		state.message = message
	},
};

export const setting = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
