import {PassportService} from "../services/passport.service";

const state = {
	passports: {},
	message: [],
	passport: [],
};

const getters = {
	getPassports(state){
		return state.passports
	},
	getMassage(state){
		return state.message
	},
	getPassport(state){
		return state.passport
	},
};


const actions = {
	async actionPassports({commit},page){
		try {
			const passports =  await PassportService.passports(page);
			await commit('setPassports',passports.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionAddPassport({commit},payload){
		try {
			// const passports =  await PassportService.addpassport(payload);
			const passports =  await PassportService.fileSend(payload);
			await commit('setMessage',passports.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionEditPassport({commit},id){
		try {
			const passports =  await PassportService.editpassport(id);
			await commit('setEditPassport',passports.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionUpdatePassport({commit},payload){
		try {
			const area =  await PassportService.updatepassport(payload);
			await commit('setEditPassport',area.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionDeletePassport({commit},id){
		try {
			const area =  await PassportService.deletepassport(id);
			await commit('setMessage',area.data)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	setPassports(state, passports){
		state.passports = passports
	},
	setMessage(state, message){
		state.message = message
	},
	setEditPassport(state, passport){
		state.passport = passport
	},
};

export const passport = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
