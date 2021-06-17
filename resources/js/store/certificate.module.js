import {CertificateService} from "../services/certificate.service";

const state = {
	certificates: {},
	usercertificates: {},
	certificatelist: [],
	message: [],
	certificate: [],
	usercertificate: [],
};

const getters = {
	getCertificateList(state){
		return state.certificatelist
	},
	getCertificates(state){
		return state.certificates
	},
	getUserCertificates(state){
		return state.usercertificates
	},
	getMassage(state){
		return state.message
	},
	getCertificate(state){
		return state.certificate
	},
	getUserCertificate(state){
		return state.usercertificate
	},
};


const actions = {
	async actionUserCertificates({commit},page){
		try {
			const certificates =  await CertificateService.allusercertificates(page);
			await commit('setUserCertificates',certificates.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionEditUserCertificate({commit},id){
		try {
			const certificates =  await CertificateService.editusercertificate(id);
			await commit('setEditUserCertificate',certificates.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionCertificateList({commit},page){
		try {
			const certificates =  await CertificateService.certificateList(page);
			await commit('setCertificateList',certificates.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionCertificates({commit},page){
		try {
			const certificates =  await CertificateService.allcertificates(page);
			await commit('setCertificates',certificates.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionAddCertificate({commit},payload){
		try {
			const certificates =  await CertificateService.addcertificate(payload);
			await commit('setMessage',certificates.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionEditCertificate({commit},id){
		try {
			const certificates =  await CertificateService.editcertificate(id);
			await commit('setEditCertificate',certificates.data.result)
			return true
		} catch (error) {
			return false
		}
	},
	async actionUpdateCertificate({commit},payload){
		try {
			const certificate =  await CertificateService.updatecertificate(payload);
			await commit('setMessage',certificate.data)
			return true
		} catch (error) {
			return false
		}
	},
	async actionDeleteCertificate({commit},id){
		try {
			const certificate =  await CertificateService.deletecertificate(id);
			await commit('setMessage',certificate.data)
			return true
		} catch (error) {
			return false
		}
	},
};

const mutations = {
	setCertificateList(state, certificatelist){
		state.certificatelist = certificatelist
	},
	setCertificates(state, certificates){
		state.certificates = certificates
	},
	setUserCertificates(state, usercertificates){
		state.usercertificates = usercertificates
	},
	setMessage(state, message){
		state.message = message
	},
	setEditCertificate(state, certificate){
		state.certificate = certificate
	},
	setEditUserCertificate(state, usercertificate){
		state.usercertificate = usercertificate
	},
};

export const certificate = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
