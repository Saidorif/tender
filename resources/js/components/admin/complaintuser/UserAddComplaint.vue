<template>
	<div class="add_cont">
        <Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-comment"></i>
				    Добавить вариант обращения
				</h4>
				<router-link class="btn btn-primary back_btn" to="/crm/complaint-list-user"><span class="peIcon pe-7s-back"></span> {{$t('Orqaga')}}</router-link>
		  	</div>
		  	<div class="card-body">
		  		<form @submit.prevent.enter="saveComplt" >
					<div class="row">
					  <div class="form-group col-md-9">
					    <label for="usertext">Заголовок</label>
					    <input
					    	type="text"
					    	class="form-control input_style"
					    	id="usertext"
					    	placeholder="Заголовок"
					    	v-model="form.text"
					    	:class="isRequired(form.text) ? 'isRequired' : ''"
				    	>
					  </div>
                       <!-- <vue-editor id="editor" useCustomImageHandler @imageAdded="handleImageAdded" v-model="htmlForEditor"> </vue-editor> -->
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
					text:'',
					file:'',
                },
                laoding: true,
                requiredInput:false
			}
		},
		computed:{
			...mapGetters('complaint',['getMassage','getComplaint'])
		},
		async mounted(){
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
						title: 'Жалоба изменена!',
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
