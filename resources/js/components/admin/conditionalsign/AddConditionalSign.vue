<template>
	<div class="add_region">
		  <Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-sign"></i>
				    Добавить условный символ 
				</h4>
				<router-link class="btn btn-primary back_btn" to="/crm/conditionalsign"><span class="peIcon pe-7s-back"></span> Назад</router-link>
		  	</div>
		  	<div class="card-body">
		  		<form @submit.prevent.enter="saveSign" >
					<div class="row">
					  <div class="form-group col-md-8">
					    <label for="name">Название</label>
					    <input 
					    	type="text" 
					    	class="form-control input_style" 
					    	id="name" 
					    	placeholder="Название"
					    	v-model="form.name"
					    	:class="isRequired(form.name) ? 'isRequired' : ''"  
				    	>
					  </div>
					  <div class="col-md-4">
			            <div class="form-group photoFileUploader">
			              <div class="avatar-upload">
			                <div class="avatar-edit">
			                  <input
			                    type="file"
			                    id="photo"
			                    accept=".png, .jpg, .jpeg"
			                    @change="changePhoto($event)"
			                  />
			                  <label for="photo">
			                    <i class="pe-7s-pen"></i>
			                  </label>
			                </div>
			                <div class="avatar-preview">
			                  <div
			                    id="imagePreview"
			                    :style="{'backgroundImage': 'url('+ photoImg(form.photo) +')'}"
			                  ></div>
			                </div>
			              </div>
			            </div>
			          </div>
					  <div class="form-group col-lg-12 form_btn d-flex justify-content-end">
					  	<button type="submit" class="btn btn-primary btn_save_category">
					  		<i class="fas fa-save"></i>
						  	Сохранить
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
					name:'',
					photo:''
				},
				requiredInput:false,
				laoding: true
			}
		},
		computed:{
			...mapGetters('conditionalsign',['getMassage'])
		},
		mounted(){
			this.laoding = false
		},
		methods:{
			...mapActions('conditionalsign',['actionAddConditionalSign']),
			isRequired(input){
	    		return this.requiredInput && input === '';
		    },
		    changePhoto(event) {
		      let file = event.target.files[0];
		      if (
		        event.target.files[0]["type"] === "image/png" ||
		        event.target.files[0]["type"] === "image/jpeg" ||
		        event.target.files[0]["type"] === "image/jpg"
		      ) {
		        if (file.size > 1048576) {
		          swal.fire({
		            type: "error",
		            title: "Ошибка",
		            text: "Размер изображения больше лимита"
		          });
		        } else {
		          let reader = new FileReader();
		          reader.onload = event => {
		            this.form.photo = event.target.result;
		          };
		          reader.readAsDataURL(file);
		        }
		      } else {
		        swal.fire({
		          type: "error",
		          title: "Ошибка",
		          text: "Картинка должна быть только png,jpg,jpeg!"
		        });
		      }
		    },
		    photoImg(img) {
		    	if (img) {
			      if (img.length < 100) {
			        return "/img/user.jpg";
			      } else {
			        return img;
			      }
		    	}
		    },
			async saveSign(){
		    	if (this.form.name != ''){
					await this.actionAddConditionalSign(this.form)
					if (this.getMassage.success) {
						toast.fire({
					    	type: 'success',
					    	icon: 'success',
							title: this.getMassage.message,
					    })
					}
					this.$router.push("/crm/conditionalsign");
					this.requiredInput = false
				}else{
					this.requiredInput = true
				}
		    }
		}
	}
</script>
<style scoped>
	
</style>