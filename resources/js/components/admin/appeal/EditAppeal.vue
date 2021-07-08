<template>
	<div class="add_myappeal">
		<Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-file"></i>
				    {{$t('Qoʼshish')}}
				</h4>
				<router-link class="btn btn-primary back_btn" to="/crm/myappeal">
					<span class="peIcon pe-7s-back"></span>
					{{$t('Orqaga')}}
				</router-link>
		  	</div>
		  	<div class="card-body">
		  		<form @submit.prevent.enter="saveMyAppeal">
					<div class="row">
					  	<div class="form-group col-md-6">
				  			<h3>{{$t('Mening xabarim')}}</h3>
					  		<div class="row">
							  	<div class="form-group col-md-12">
							  		<label for="contract_id">{{$t('Mening shartnomalarim')}}</label>
							  		<select
							  			class="form-control input_style"
								    	id="contract_id"
								    	v-model="form.contract_id"
								    	rows="4"
								    	:class="isRequired(form.contract_id) ? 'isRequired' : ''"
								    	disabled="disabled"
							  		>
							  			<option value="" selected disabled>{{$t('Tanlang')}}!</option>
							  			<option :value="item.id" v-for="(item,index) in getUserMycontractList">{{item.number}}</option>
							  		</select>
						  		</div>
							  	<div class="form-group col-md-12">
					              	<label for="image">{{$t('Fayl')}}</label>
					              	<img :src="'/'+form.user_file" class="img-fluid" alt="" width="70">
						  		</div>
							  	<div class="form-group col-md-12">
								    <label for="text">{{$t('Text')}}</label>
								    <textarea
								    	class="form-control input_style"
								    	id="text"
								    	v-model="form.text"
								    	rows="4"
								    	disabled
								    	:class="isRequired(form.text) ? 'isRequired' : ''"
								    ></textarea>
							  	</div>
							</div>
						</div>
					  	<div class="form-group col-md-6">
					  		<h3>{{$t('Xabarga javob')}}</h3>
							<div class="row">
								<div class="form-group col-md-12" v-if="form.approved_by">
					              	<label for="image">{{$t('Kim tomondan koʼrilgan')}}</label>
					              	<div class="form-control">
										{{form.approved_by}}
				              		</div>
						  		</div>
								<div class="form-group col-md-12">
					              	<label for="image">{{$t('Holati')}}</label>
					              	<div class="alert alert-success">
										{{form.status}}
				              		</div>
						  		</div>
								<div class="form-group col-md-12" v-if="form.answer_file">
					              	<label for="image">{{$t('Fayl')}}</label>
					              	<img :src="'/'+form.answer_file" class="img-fluid" alt="" width="70">
						  		</div>
							  	<div class="form-group col-md-12" v-if="form.answer_text">
								    <label for="text">{{$t('Text')}}</label>
								    <textarea
								    	class="form-control input_style"
								    	id="text"
								    	v-model="form.answer_text"
								    	rows="4"
								    	disabled
								    	:class="isRequired(form.answer_text) ? 'isRequired' : ''"
								    ></textarea>
							  	</div>
							</div>
						</div>
					</div>
				</form>
		  	</div>
	  	</div>
	</div>
</template>
<script>
	import { mapGetters , mapActions } from 'vuex'
	import Loader from '../../Loader'
	export default{
		components:{
			Loader
		},
		data(){
			return{
				form:{
					contract_id:'',
					text:'',
					user_file:'',
				},
				image: '',
				requiredInput:false,
				laoding: true
			}
		},
		computed:{
			...mapGetters('myappeal',['getMassage','getMyAppeal']),
			...mapGetters('mycontract',['getUserMycontractList']),
		},
		async mounted(){
			await this.actionEditMyAppeal(this.$route.params.myappealId)
			await this.actionUserMycontractList()
			this.form = this.getMyAppeal
			this.laoding = false
		},
		methods:{
			...mapActions('myappeal',['actionEditMyAppeal','actionUpdateMyAppeal']),
			...mapActions('mycontract',['actionUserMycontractList']),
			isRequired(input){
	    		return this.requiredInput && input === '';
		    },
		    changeFile(event) {
	      		this.form.user_file = event.target.files[0];
	      		let file = event.target.files[0];
	      		if(file.size > 1048576){
			        swal.fire({
			          type: "error",
			          icon: "error",
			          title: this.$t('Hatolik'),
			          text: this.$t('Fayl hajmi 1 MB dan oshmasligi kerak')
			        });
	      		}else{
	        		let reader = new FileReader();
		        	reader.onload = e => {
	          			this.image = e.target.result;
		        	};
		        	reader.readAsDataURL(file);
		      }
		    },
			async saveMyAppeal(){
		    	if (this.form.contract_id != '' && this.form.text != '' && this.form.user_file != ''){
					this.laoding = true
					let formData = new FormData();
					formData.append('contract_id',this.form.contract_id)
					formData.append('text',this.form.text)
					formData.append('user_file',this.form.user_file)
					await this.actionUpdateMyAppeal(formData)
					if (this.getMassage.success) {
						toast.fire({
					    	type: 'success',
					    	icon: 'success',
							title: this.getMassage.message,
					    })
						this.$router.push("/crm/myappeal");
						this.requiredInput = false
					}
					this.laoding = false
				}else{
					this.requiredInput = true
				}
		    }
		}
	}
</script>
<style scoped>

</style>
