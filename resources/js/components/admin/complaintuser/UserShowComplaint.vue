<template>
	<div class="add_cont">
        <Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-comment"></i>
				    {{$t('Tahrirlash')}}
				</h4>
				<router-link class="btn btn-primary back_btn" to="/crm/complaint"><span class="peIcon pe-7s-back"></span> {{$t('Orqaga')}}</router-link>
		  	</div>
		  	<div class="card-body">
		  		<form @submit.prevent.enter="saveComplt" >
					<div class="row">
					  <div class="form-group col-md-9">
					    <label for="name"> {{$t('Sarlovxa')}}</label>
					    <input
					    	type="text"
					    	class="form-control input_style"
					    	id="name"
					    	v-model="form.name"
					    	:class="isRequired(form.name) ? 'isRequired' : ''"
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
    import {mapActions, mapGetters} from 'vuex'
    import Loader from '../../Loader'
	export default{
        components:{
            Loader
        },
		data(){
			return{
				form:{
					name:'',
                },
                laoding: true,
                requiredInput:false
			}
		},
		computed:{
			...mapGetters('complaint',['getMassage','getComplaint'])
		},
		async mounted(){
			await this.actionEditComplaint(this.$route.params.complaintId)
            this.form = this.getComplaint
            this.laoding = false
		},
		methods:{
			...mapActions('complaint',['actionUpdateComplaint','actionEditComplaint']),
			isRequired(input){
	    		return this.requiredInput && input === '';
		    },
		    async saveComplt(){
		    	if (this.form.name != ''){
                    this.laoding = true
                    await this.actionUpdateComplaint(this.form)
                    this.laoding = false
					this.$router.push("/crm/complaint");
					this.requiredInput =false
					toast.fire({
				    	type: 'success',
				    	icon: 'success',
						title: this.$t('Maʼlumot saqlandi'),
				    })
				}else{
					this.requiredInput =true
				}
		    }
		}
	}
</script>
<style scoped>

</style>
