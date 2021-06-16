import {CertificateService} from "../services/certificate.service";

const state = {
	certificates: {},
	certificatelist: [],
	message: [],
	certificate: [],
};

const getters = {
	getCertificateList(state){
		return state.certificatelist
	},
	getCertificates(state){
		return state.certificates
	},
	getMassage(state){
		return state.message
	},
	getCertificate(state){
		return state.certificate
	},
};


const actions = {
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
	setMessage(state, message){
		state.message = message
	},
	setEditCertificate(state, certificate){
		state.certificate = certificate
	},
};

export const certificate = {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
}
