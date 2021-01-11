<template>
	<div class="add_area">
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon pe-7s-id"></i>
				    Добавить Tarifcity
				</h4>
				<router-link class="btn btn-primary back_btn" to="/crm/tarifcity"><span class="peIcon pe-7s-back"></span> Назад</router-link>
		  	</div>
		  	<div class="card-body">
		  		<form @submit.prevent.enter="saveArea" >
					<div class="row">
					  <div class="form-group col-md-3">
					    <label for="region_id">Region</label>
					    <select
					    	class="form-control input_style"
					    	v-model="form.region_id"
					    	:class="isRequired(form.region_id) ? 'isRequired' : ''"
				    	>
					    	<option value="" selected disabled>choose option</option>
					    	<option :value="item.id" v-for="(item,index) in getRegionList">{{item.name}}</option>
					    </select>
					  </div>
					  <div class="form-group col-md-3">
					    <label for="name">Tarif</label>
					    <input
					    	type="text"
					    	class="form-control input_style"
					    	id="name"
					    	v-model="form.tarif"
					    	:class="isRequired(form.tarif) ? 'isRequired' : ''"
				    	>
					  </div>
					  <div class="form-group col-md-3">
					    <label for="name">Tarif bagaj</label>
					    <input
					    	type="text"
					    	class="form-control input_style"
					    	id="name"
					    	v-model="form.tarif_bagaj"
				    	>
					  </div>
					  <div class="form-group col-md-3">
					    <label for="file">file</label>
					    <input
					    	type="file"
					    	class="form-control input_style"
					    	id="file"
				    	>
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
	export default{
		data(){
			return{
				form:{
					region_id:'',
					tarif:'',
					tarif_bagaj:'',
					file:'',
				},
				requiredInput:false
			}
		},
		computed:{
			...mapGetters('region',['getMassage','getRegionList']),
			...mapGetters('area',['getMassage']),
		},
		async mounted(){
			await this.actionRegionList()
		},
		methods:{
			...mapActions('region',['actionRegionList']),
			...mapActions('area',['actionAddArea']),
			isRequired(input){
	    		return this.requiredInput && input === '';
		    },
			async saveArea(){
		    	if (this.form.name != '' && this.form.region_id != ''){
					await this.actionAddArea(this.form)
					if(this.getMassage.success){
						toast.fire({
				            type: "success",
				            icon: "success",
				            title: this.getMassage.message
			          	});
						this.$router.push("/crm/area");
						this.requiredInput = false
					}
				}else{
					this.requiredInput = true
				}
		    }
		}
	}
</script>
<style scoped>

</style>
