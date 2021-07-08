<template>
	<div class="add_region">
        <Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-sign"></i>
				    {{$t('Tahrirlash')}}
				</h4>
				<router-link class="btn btn-primary back_btn" to="/crm/conditionalsign"><span class="peIcon pe-7s-back"></span> {{$t('Orqaga')}}</router-link>
		  	</div>
		  	<div class="card-body">
		  		<form @submit.prevent.enter="saveSign" >
					<div class="row">
					  <div class="form-group col-md-8">
					    <label for="name">{{$t('Nomi')}} </label>
					    <input
					    	type="text"
					    	class="form-control input_style"
					    	id="name"
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
		data(){
			return{
				form:{
					name:'',
					photo:''
                },
                laoding: true,
				requiredInput:false
			}
        },
        components:{
            Loader
        },
		computed:{
			...mapGetters('conditionalsign',['getMassage','getConditionalSign'])
		},
		async mounted(){
            await this.actionEditConditionalSign(this.$route.params.conditionalsignId)
            this.laoding = false
			this.form = this.getConditionalSign
		},
		methods:{
			...mapActions('conditionalsign',['actionUpdateConditionalSign','actionEditConditionalSign']),
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
		            title: this.$t('Hatolik'),
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
		          title: this.$t('Hatolik'),
		          text: "Картинка должна быть только png,jpg,jpeg!"
		        });
		      }
		    },
		    photoImg(img) {
		    	if (img) {
			      if (img.length > 100) {
			        return img;
			      } else {
			        return '/signs/'+img;
			      }
		    	}
		    },
			async saveSign(){
		    	if (this.form.name != ''){
		    		let data ={
		    			id:this.$route.params.conditionalsignId,
		    			items:this.form
                    }
                    this.laoding = true
                    await this.actionUpdateConditionalSign(data)
                    this.laoding = false
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
