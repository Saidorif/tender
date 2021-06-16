<template>
	<div class="add_area">
        <Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon pe-7s-id"></i>
				    Добавить Tarifcity
				</h4>
				<router-link class="btn btn-primary back_btn" to="/crm/tarifcity"><span class="peIcon pe-7s-back"></span> {{$t('Orqaga')}}</router-link>
		  	</div>
		  	<div class="card-body">
		  		<form @submit.prevent.enter="saveTarifcity" >
					<div class="row">
					  <!-- <div class="form-group col-md-3">
					    <label for="region_id">Region</label>
					    <select
					    	class="form-control input_style"
					    	v-model="form.region_id"
					    	:class="isRequired(form.region_id) ? 'isRequired' : ''"
				    	>
					    	<option value="" selected disabled>choose option</option>
					    	<option :value="item.id" v-for="(item,index) in getRegionList">{{item.name}}</option>
					    </select>
					  </div> -->
					  <div class="form-group col-md-3">
					    <label for="name">Tarif</label>
					    <input
					    	type="number"
					    	class="form-control input_style"
					    	id="name"
					    	v-model="form.tarif"
					    	:class="isRequired(form.tarif) ? 'isRequired' : ''"
				    	>
					  </div>
					  <div class="form-group col-md-3">
					    <label for="name">Tarif bagaj</label>
					    <input
					    	type="number"
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
                            accept="application/pdf"
                            :class="isRequired(form.file) ? 'isRequired' : ''"
                            @change="changeFile($event)"
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
    import { mapGetters , mapActions } from 'vuex'
    import Loader from '../../Loader'
	export default{
        components:{
            Loader
        },
		data(){
			return{
				form:{
					region_id:'',
					tarif:'',
					tarif_bagaj:'',
					file:'',
                },
                laoding: true,
				requiredInput:false
			}
		},
		computed:{
			...mapGetters('region',['getMassage','getRegionList']),
			...mapGetters('tarifcity',['getMassage']),
		},
		async mounted(){
            await this.actionRegionList()
            this.laoding = false
		},
		methods:{
			...mapActions('region',['actionRegionList']),
			...mapActions('tarifcity',['actionAddTarifcity']),
			isRequired(input){
	    		return this.requiredInput && input === '';
            },
            changeFile(event) {
                let file = event.target.files[0];
                this.form.file = file
            },
			async saveTarifcity(){
		    	if (this.form.tarif != '' && this.form.file != ''){
                    let formData = new FormData();
                    formData.append('file', this.form.file);
                    formData.append('tarif', this.form.tarif);
                    formData.append('tarif_bagaj', this.form.tarif_bagaj);
                    this.laoding = true
                    await this.actionAddTarifcity(formData)
                    this.laoding = false
					if(this.getMassage.success){
						toast.fire({
				            type: "success",
				            icon: "success",
				            title: this.getMassage.message
			          	});
						this.$router.push("/crm/tarifcity");
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
