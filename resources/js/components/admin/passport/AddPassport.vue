<template>
	<div class="add_area">
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon pe-7s-id"></i>
				    Добавить Area
				</h4>
				<router-link class="btn btn-primary back_btn" to="/crm/passport"><span class="peIcon pe-7s-back"></span> Назад</router-link>
		  	</div>
		  	<div class="card-body">
		  		<form @submit.prevent.enter="savePassport" enctype="multipart/form-data">
					<div class="row">
					  <div class="form-group col-md-12">
					    <label for="name">Название пасспорта</label>
					    <input 
					    	class="form-control input_style" 
					    	v-model="form.name" 
					    	:class="isRequired(form.name) ? 'isRequired' : ''"  
					    	placeholder="Название пасспорта..." 
				    	/>
					  </div>
					  <div class="form-group col-md-6">
					    <label for="region_from_id">Regions (From)</label>
					    <select 
					    	class="form-control input_style" 
					    	v-model="form.region_from_id" 
					    	:class="isRequired(form.region_from_id) ? 'isRequired' : ''"  
				    	>
					    	<option value="" selected disabled>choose option</option>
					    	<option :value="item.id" v-for="(item,index) in getRegionList">{{item.name}}</option>
					    </select>
					  </div>
					  <div class="form-group col-md-6">
					    <label for="region_to_id">Regions (To)</label>
					    <select 
					    	class="form-control input_style" 
					    	v-model="form.region_to_id" 
					    	:class="isRequired(form.region_to_id) ? 'isRequired' : ''"  
				    	>
					    	<option value="" selected disabled>choose option</option>
					    	<option :value="item.id" v-for="(item,index) in getRegionList">{{item.name}}</option>
					    </select>
					  </div>
					  <div class="form-group col-md-6">
					    <label for="area_from_id">Area (From)</label>
					    <select 
					    	class="form-control input_style" 
					    	v-model="form.area_from_id" 
				    	>
					    	<option value="" selected disabled>choose option</option>
					    	<option :value="item.id" v-for="(item,index) in getRegionList">{{item.name}}</option>
					    </select>
					  </div>
					  <div class="form-group col-md-6">
					    <label for="area_to_id">Area (To)</label>
					    <select 
					    	class="form-control input_style" 
					    	v-model="form.area_to_id" 
				    	>
					    	<option value="" selected disabled>choose option</option>
					    	<option :value="item.id" v-for="(item,index) in getRegionList">{{item.name}}</option>
					    </select>
					  </div>
					  <div class="form-group col-md-12">
					  	<div class="form-group d-flex justify-content-end">
					  		<button type="button" class="btn btn-outline-primary" @click.prevent="AddFile">
					  			<i class="fas fa-plus"></i>
					  			Add file
					  		</button>
					  	</div>
					  	<div class="row">
					  		<div class="col-md-6" v-for="(item, index) in form.files">
					  			<div class="form-group">
					  				<div class="form-group">
					  					<input 
					  						type="text" 
					  						:class="isRequired(item.title) ? 'isRequired' : ''"  
					  						class="form-control" 
									    	placeholder="Название файла" 
					  						v-model="item.title" />
					  				</div>
								    <label for="file">Файл {{index + 1}}</label>
								    <input 
								    	type="file" 
								    	id="file" 
								    	class="form-control" 
								    	@input.prevent="changeFile($event,item, index)"
								    	:class="isRequired(item.file) ? 'isRequired' : ''" 
							    	>
								    <span v-if="form.files.length > 1">
								    	<i class="fas fa-times" @click="removeFile(index)"></i>
								    </span>
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
	export default{
		data(){
			return{
				form:{
					region_from_id:'',
					region_to_id:'',
					area_from_id:'',
					area_to_id:'',
					name:'',
					files:[{title:'', file:''}]
				},
				requiredInput:false,
				requiredFileInput:false,
			}
		},
		computed:{
			...mapGetters('region',['getMassage','getRegionList']),
			...mapGetters('area',['getMassage']),
			...mapGetters('passport',['getMassage']),
		},
		async mounted(){
			await this.actionRegionList()
		},
		methods:{
			...mapActions('region',['actionRegionList']),
			...mapActions('area',['actionAddArea']),
			...mapActions('passport',['actionAddPassport']),
			isRequired(input){
	    		return this.requiredInput && input === '';
		    },
			async savePassport(){
				let status = false 
				this.form.files.forEach((item)=>{
		    		if(item.file !== '' && item.title !== ''){
		    			status = true
		    		}else{
		    			status = false
		    		}
		    	})
		    	if (this.form.region_from_id != '' && this.form.region_to_id != '' && this.form.name != '' && status){
					let formData = new FormData();
					console.log(this.form.files)
					this.form.files.forEach((item, index) => {
						formData.append('files['+index+'][file]', item.file);
						formData.append('files['+index+'][title]', item.title);
					})
					formData.append('region_from_id', this.form.region_from_id);
					formData.append('region_to_id', this.form.region_to_id);
					formData.append('area_from_id', this.form.area_from_id);
					formData.append('area_to_id', this.form.area_to_id);
					formData.append('name', this.form.name);
					await this.actionAddPassport(formData)
					if (this.getMassage.success) {
						this.$router.push("/crm/passport");
						this.requiredInput = false
					}
				}else{
					this.requiredInput = true
				}
		    },
		    changeFile(event, item,index) {
				item.file = event.target.files[0]
		        // if (file.size > 1048576){
		        //   swal.fire({
		        //     type: "error",
		        //     icon: "error",
		        //     title: "Ошибка",
		        //     text: "Размер файл не должно быть больше 1мб"
		        //   });
		        // } else {
		        //   let reader = new FileReader();
		        //   reader.onload = event => {
		        //     this.form.files[index].file = event.target.result;
		        //   };
		        //   reader.readAsDataURL(file);
		        //   this.form.files[index].title = item.title
		        // }
		    },
		    removeFile(index){
  			    this.form.files.splice(index, 1)
    		},
    		AddFile() {
		      this.form.files.push({title:'',file:''});
		    },
		}
	}
</script>
<style scoped>
	
</style>