<template>
	<div class="add_role">
        <Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon pe-7s-id"></i>
				    Add Role
				</h4>
				<router-link class="btn btn-primary back_btn" to="/crm/role"><span class="peIcon pe-7s-back"></span> {{$t('Orqaga')}}</router-link>
		  	</div>
		  	<div class="card-body">
		  		<form @submit.prevent.enter="saveRole" >
					<div class="row">
					  <div class="form-group col-md-9">
					    <label for="roleName">Role Name</label>
					    <input
					    	type="text"
					    	class="form-control input_style"
					    	id="roleName"
					    	v-model="form.name"
					    	:class="isRequired(form.name) ? 'isRequired' : ''"
				    	>
					  </div>
					  <div class="form-group col-md-9">
					    <label for="roleName">Label</label>
					    <input
					    	type="text"
					    	class="form-control input_style"
					    	id="roleName"
					    	v-model="form.label"
					    	:class="isRequired(form.label) ? 'isRequired' : ''"
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
					label:''
                },
                laoding: true,
				requiredInput:false
			}
		},
		computed:{
			...mapGetters('role',['getMassage'])
        },
        async mounted(){
			this.laoding = false
		},
		methods:{
			...mapActions('role',['actionAddRole']),
			isRequired(input){
	    		return this.requiredInput && input === '';
		    },
		    async saveRole(){
		    	if (this.form.name != '' && this.form.label != ''){
                    this.laoding = true
                    await this.actionAddRole(this.form)
                    this.laoding = false
					if (this.getMassage.success) {
						toast.fire({
					    	type: 'success',
					    	icon: 'success',
							title: this.getMassage.message,
					    })
						this.$router.push("/crm/role");
						this.requiredInput = false
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
