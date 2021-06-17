<template>
	<div class="add_cont">
        <Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-comment"></i>
				    {{$t('Yangi qoʼshish')}}
				</h4>
				<router-link class="btn btn-primary back_btn" to="/crm/complaint"><span class="peIcon pe-7s-back"></span> {{$t('Orqaga')}}</router-link>
		  	</div>
		  	<div class="card-body">
		  		<form @submit.prevent.enter="saveComplt" >
					<div class="row">
					  <div class="form-group col-lg-9 col-md-8">
					    <label for="name">{{$t('Sarlovxa')}}</label>
					    <input
					    	type="text"
					    	class="form-control input_style"
					    	id="name"
					    	v-model="form.name"
					    	:class="isRequired(form.name) ? 'isRequired' : ''"
				    	>
					  </div>
					  <div class="form-group col-lg-3 col-md-4 form_btn">
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
                laoding: true,
				form:{
					name:'',
				},
				requiredInput:false
			}
		},
		computed:{
			...mapGetters('complaint',['getMassage'])
        },
        async mounted(){
			this.laoding = false
		},
		methods:{
			...mapActions('complaint',['actionAddComplaint']),
			isRequired(input){
	    		return this.requiredInput && input === '';
		    },
		    async saveComplt(){
		    	if (this.form.name != ''){
                    this.laoding = true
                    await this.actionAddComplaint(this.form)
                    this.laoding = false
					if (this.getMassage.success) {
						toast.fire({
					    	type: 'success',
					    	icon: 'success',
							title: 'Жалоба добавлена!',
					    })
						this.$router.push("/crm/complaint");
						this.requiredInput =false
					}else{
						toast.fire({
					    	type: 'error',
					    	icon: 'error',
							title: 'Такая жалоба уже существует!',
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
