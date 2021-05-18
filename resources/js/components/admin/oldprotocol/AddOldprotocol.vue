<template>
	<div class="add_region">
		<Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-file"></i>
				    Добавить старый протокол
				</h4>
				<router-link class="btn btn-primary back_btn" to="/crm/oldprotocol">
					<span class="peIcon pe-7s-back"></span>
					Назад
				</router-link>
		  	</div>
		  	<div class="card-body">
		  		<form @submit.prevent.enter="saveOldprotocol" enctype="multipart/form-data">
					<div class="row">
					  	<div class="form-group col-md-3">
						    <label for="number">Номер протокола</label>
						    <input
						    	type="text"
						    	class="form-control input_style"
						    	id="number"
						    	placeholder="Номер протокола"
						    	v-model="form.number"
						    	:class="isRequired(form.number) ? 'isRequired' : ''"
					    	>
					  	</div>
					  	<div class="form-group col-md-3">
			              	<label for="date">Сана</label>
			              	<date-picker
				                lang="ru"
				                type="date" format="YYYY-MM-DD" valueType="format"
				                v-model="form.date"
				                class="input_style"
				                placeholder="Сана"
				                :class="isRequired(form.date) ? 'isRequired' : ''"
			              	></date-picker>
			          	</div>
					  	<div class="form-group col-md-3">
			              	<label for="date">Файл</label>
			              	<input
			              		type="file"
			              		name="file"
			              		id="file"
			              		class="form-control input_style"
			              		:class="isRequired(form.file) ? 'isRequired' : ''"
			              		@change="changePhoto($event)"
		              		>
		              		<small v-if="fileName">
		              			<a :href="fileName" download>
		              				<i class="fas fa-download"></i>
		              				Скачать файл
		              			</a>
		              		</small>
			          	</div>
					  	<div class="form-group col-lg-3 form_btn">
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
	import DatePicker from "vue2-datepicker";
	export default{
		components:{
			Loader,
			DatePicker,
		},
		data(){
			return{
				form:{
					number:'',
					date:'',
					file:'',
				},
				requiredInput:false,
				laoding: true,
				fileName:''
			}
		},
		computed:{
			...mapGetters('oldprotocol',['getMassage'])
		},
		mounted(){
			this.laoding = false
		},
		methods:{
			...mapActions('oldprotocol',['actionAddOldprotocol']),
			isRequired(input){
	    		return this.requiredInput && input === '';
		    },
		    photoImg(img) {
		    	// if (img) {
			    //   if (img.length > 100) {
			    //     return img;
			    //   } else {
			    //     return '/offer/'+img;
			    //   }
		    	// }
		    },
		    changePhoto(event){
				this.form.file = event.target.files[0];
				let file = event.target.files[0]
		    	let reader = new FileReader();
				reader.onload = event => {
					this.fileName = event.target.result;
				};
				reader.readAsDataURL(file);
				// if(
				// 	event.target.files[0]['type'] ==='image/png' ||
				// 	event.target.files[0]['type'] ==='image/jpeg' ||
				// 	event.target.files[0]['type'] ==='image/jpg'
				// ){
				// 	if (file.size > 1048576) {
				// 		swal.fire({
				// 			type: 'error',
				// 			title: 'Ошибка',
				// 			text:'Размер изображения больше лимита',
				// 		})
				// 	}else{
				// 		let reader = new FileReader();
				// 		reader.onload = event => {
				// 			this.form.file = event.target.result;
				// 		};
				// 		reader.readAsDataURL(file);

				// 	}
				// }else{
				// 	swal.fire({
				// 		type: 'error',
				// 		title: 'Ошибка',
				// 		text:'Картинка должна быть только png,jpg,jpeg!',
				// 	})
				// }
			},
			async saveOldprotocol(){
		    	if (this.form.number != '' && this.form.date != '' && this.form.file != ''){
		    		let formData = new FormData();
		    		formData.append('number',this.form.number)
		    		formData.append('date',this.form.date)
		    		formData.append('file',this.form.file)
					this.laoding = true
					await this.actionAddOldprotocol(formData)
					if(this.getMassage.success){
						toast.fire({
					    	type: 'success',
					    	icon: 'success',
							title: this.getMassage.message,
					    })
						this.$router.push("/crm/oldprotocol");
						this.requiredInput = false
					}else{
                      	toast.fire({
					    	type: 'error',
					    	icon: 'error',
							title: this.getMassage.message.file[0],
					    })
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
