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
					  		<label for="contract_id">{{$t('Mening shartnomalarim')}}</label>
					  		<select
					  			class="form-control input_style"
						    	id="contract_id"
						    	v-model="form.contract_id"
						    	rows="4"
						    	:class="isRequired(form.contract_id) ? 'isRequired' : ''"
					  		>
					  			<option value="" selected disabled>{{$t('Tanlang')}} !</option>
					  			<option :value="item.id" v-for="(item,index) in getUserMycontractList">{{item.number}}</option>
					  		</select>
				  		</div>
					  	<div class="form-group col-md-6">
			              	<label for="image">{{$t('Fayl')}} </label>
			              	<input
				                type="file"
				                class="form-control input_style"
				                id="image"
				                @input="changeFile($event)"
			               	/>
				  		</div>
					  	<div class="form-group col-md-12">
						    <label for="text">{{$t('Text')}}</label>
						    <textarea
						    	class="form-control input_style"
						    	id="text"
						    	v-model="form.text"
						    	rows="4"
						    	:class="isRequired(form.text) ? 'isRequired' : ''"
						    ></textarea>
					  	</div>
				  		<div class="form-group col-lg-12 d-flex justify-content-end">
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
			...mapGetters('myappeal',['getMassage']),
			...mapGetters('mycontract',['getUserMycontractList']),
		},
		async mounted(){
			await this.actionUserMycontractList()
			this.laoding = false
		},
		methods:{
			...mapActions('myappeal',['actionAddMyAppeal']),
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
					await this.actionAddMyAppeal(formData)
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
