import {StationService} from "../services/station.service";

const state = {
	stations: {},
	message: [],
	station: [],
};

const getters = {
	getStations(state){
		return state.stations
	},
	getMassage(state){
		return state.message
	},
	getStation(state){
		return state.station
	},
};


const actions = {
	async actionStations({commit},page){
		try {
			const stations =  await StationService.stations(page);
			await commit('setStations',stations.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionAddStation({commit},payload){
		try {
			const stations =  await StationService.addstation(payload);
			await commit('setMessage',areas.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionEditStation({commit},id){
		try {
			const stations =  await StationService.editstation(id);
			await commit('setEditStation',stations.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionUpdateStation({commit},payload){
		try {
			const stations =  await StationService.updatestation(payload);
			await commit('setEditStation',stations.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionDeleteStation({commit},id){
		try {
			const station =  await StationService.deletestation(id);
			await commit('setMessage',station.data)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	setStations(state, stations){
		state.stations = stations
	},
	setMessage(state, message){
		state.message = message
	},
	setEditStation(state, station){
		state.station = station
	},
};

export const station = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
