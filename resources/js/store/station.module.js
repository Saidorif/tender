import {StationService} from "../services/station.service";

const state = {
	stations: {},
	message: [],
	station: [],
	stationList: [],
};

const getters = {
	getStations(state){
		return state.stations
	},
	getStationsList(state){
		return state.stationList
	},
	getMassage(state){
		return state.message
	},
	getStation(state){
		return state.station
	},
};


const actions = {
	async actionStations({commit},payload){
		try {
			const stations =  await StationService.stations(payload);
			await commit('setStations',stations.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionStationByRegion({commit},page){
		try {
			const stations =  await StationService.stationByRegion(page);
			await commit('setStationsList',stations.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionAddStation({commit},payload){
		try {
			const stations =  await StationService.addstation(payload);
			await commit('setMessage',stations.data)
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
			await commit('setMessage',stations.data)
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
	setStationsList(state, stationList){
		state.stationList = stationList
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
