<template>
	<div class="add_cont">
		<Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-cog"></i>
				    {{$t('Tizim sozlamalari')}}
				</h4>
		  	</div>
		  	<div class="card-body">
		  		<form @submit.prevent.enter="saveSetting" >
					<div class="row">
					  <div class="form-group col-md-9">
					    <label for="salary"> {{$t('Ariza narxi')}} </label>
					    <input
					    	type="text"
					    	class="form-control input_style"
					    	id="salary"
					    	v-model="form.salary"
					    	:class="isRequired(form.salary) ? 'isRequired' : ''"
				    	>
					  </div>
					  <div class="form-group col-md-6">
					    <label for="name"> {{$t('Vazirlik nomi')}} </label>
					    <input
					    	type="text"
					    	class="form-control input_style"
					    	id="name"
					    	v-model="form.name"
					    	:class="isRequired(form.name) ? 'isRequired' : ''"
				    	>
					  </div>
					  <div class="form-group col-md-6">
					    <label for="oked"> {{$t('Vazirlik manzili')}} </label>
					    <input
					    	type="text"
					    	class="form-control input_style"
					    	id="oked"
					    	v-model="form.oked"
					    	:class="isRequired(form.oked) ? 'isRequired' : ''"
				    	>
					  </div>
					  <div class="form-group col-md-6">
					    <label for="phone"> {{$t('contacts_page.phone')}} </label>
					    <input
					    	type="text"
					    	class="form-control input_style"
					    	id="phone"
					    	v-model="form.phone"
					    	:class="isRequired(form.phone) ? 'isRequired' : ''"
				    	>
					  </div>
					  <div class="form-group col-md-6">
					    <label for="email"> {{$t('Email')}} </label>
					    <input
					    	type="text"
					    	class="form-control input_style"
					    	id="email"
					    	v-model="form.email"
					    	:class="isRequired(form.email) ? 'isRequired' : ''"
				    	>
					  </div>
					  <div class="form-group col-md-6">
					    <label for="address"> {{$t('Bankning manzili')}} </label>
					    <input
					    	type="text"
					    	class="form-control input_style"
					    	id="address"
					    	v-model="form.address"
					    	:class="isRequired(form.address) ? 'isRequired' : ''"
				    	>
					  </div>
					  <div class="form-group col-md-6">
					    <label for="bank_number"> {{$t('X/raqam')}} </label>
					    <input
					    	type="text"
					    	class="form-control input_style"
					    	id="bank_number"
					    	v-model="form.bank_number"
					    	:class="isRequired(form.bank_number) ? 'isRequired' : ''"
				    	>
					  </div>
					  <div class="form-group col-md-4">
					    <label for="inn"> {{$t('INN')}} </label>
					    <input
					    	type="text"
					    	class="form-control input_style"
					    	id="inn"
					    	v-model="form.inn"
					    	:class="isRequired(form.inn) ? 'isRequired' : ''"
				    	>
					  </div>
					  <div class="form-group col-md-4">
					    <label for="mfo"> {{$t('MFO')}} </label>
					    <input
					    	type="text"
					    	class="form-control input_style"
					    	id="mfo"
					    	v-model="form.mfo"
					    	:class="isRequired(form.mfo) ? 'isRequired' : ''"
				    	>
					  </div>
					  <div class="form-group col-md-4">
					    <label for="oked"> {{$t('OKED')}} </label>
					    <input
					    	type="text"
					    	class="form-control input_style"
					    	id="oked"
					    	v-model="form.oked"
					    	:class="isRequired(form.oked) ? 'isRequired' : ''"
				    	>
					  </div>
					  <div class="form-group col-lg-3 form_btn">
					  	<button type="submit" class="btn btn-primary btn_save_category">
					  		<i class="fas fa-save"></i>
						  	{{$t('Saqlash')}}
						</button>
				  	  </div>
					</div>
				</form>
		  	</div>
	  	</div>
	</div>
</template>
<script>
	import Loader from '../../Loader'
	import {mapActions, mapGetters} from 'vuex'
	export default{
		components:{
			Loader
		},
		data(){
			return{
				form:{
					salary:'',
                    name: '',
                    oked: '',
                    phone: '',
                    email: '',
                    address: '',
                    bank_number: '',
                    inn: '',
                    mfo: '',
                    oked: '',
				},
				requiredInput:false,
				laoding: true
			}
		},
		async mounted(){
			await this.actionSetting()
			this.form = this.getSetting
			this.laoding = false
		},
		computed:{
			...mapGetters('setting',['getMessage','getSetting'])
		},
		methods:{
			...mapActions('setting',['actionSetting','actionUpdateSetting']),
			isRequired(input){
	    		return this.requiredInput && input === '';
		    },
		    async saveSetting(){
		    	if (this.form.salary != ''){
					this.laoding = true
					await this.actionUpdateSetting(this.form)
					this.laoding = false
					if (this.getMessage.success) {
						toast.fire({
					    	type: 'success',
					    	icon: 'success',
							title: this.getMessage.message,
					    })
						this.requiredInput =false
					}else{
						toast.fire({
					    	type: 'error',
					    	icon: 'error',
							title: this.getMessage.message,
					    })
					}
				}else{
					this.requiredInput =true
				}
		    }
		}
	}
</script>
<style scoped>

</style>
