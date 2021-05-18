import ApiService from './api.service'

const ConfirmScheduleSerivce = {
	schedules(data){
		return ApiService.post(`/api/xjadval?page=${data.page}`,data.items)
	},
	scheduleShow(id){
		return ApiService.get(`/api/xjadval/edit/${id}`)
	},
	approveSchedule(id){
		return ApiService.get(`/api/xjadval/approve/${id}`)
	},
	activateSchedule(id){
		return ApiService.get(`/api/xjadval/activate/${id}`)
	},
	rejectSchedule(id){
		return ApiService.get(`/api/xjadval/reject/${id}`)
	},
};

export { ConfirmScheduleSerivce };
