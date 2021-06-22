<template>
	<div class="add_action">
        <Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-clipboard-check"></i>
				    Подтвердить тендер
				</h4>
				<router-link class="btn btn-primary back_btn" to="/crm/action"><span class="peIcon pe-7s-back"></span> {{$t('Orqaga')}}</router-link>
		  	</div>
		  	<div class="card-body">
		  		<form @submit.prevent.enter="saveAction" >
					<div class="row">
					  <div class="form-group col-md-9">
					    <label for="contName">Название контроллера</label>
						<multiselect
							:value="findController"
							:options="getContList"
							@search-change="value => filterController(value)"
							v-model="findController"
							:searchable="true"
							track-by="id"
							label="name"
							:max="3"
							:loading="isLoading"
							:selectLabel="$t('Tanlash uchun Enter tugmasini bosing')"
							:deselectLabel="$t('Oʼchirish uchun Enter tugmasini bosing')"
							@select="selectedItem"
	      					:class="isRequired(form.conts_id) ? 'isRequired' : ''"
							>
							<span slot="noResult">{{$t('Sizning qidirgan maʼlumot topilmadi.')}}</span>
							<span slot="noOptions">{{$t('Royxat boʼsh')}}</span>
						</multiselect>
					  </div>
					  <div class="form-group col-md-9">
					    <label for="contName">Action Name</label>
					    <input
					    	type="text"
					    	class="form-control input_style"
					    	id="contName"
					    	placeholder="Action Name"
					    	v-model="form.name"
					    	:class="isRequired(form.name) ? 'isRequired' : ''"
				    	>
					  </div>
					  <div class="form-group col-md-9">
					    <label for="contName">Code</label>
					    <input
					    	type="text"
					    	class="form-control input_style"
					    	id="contName"
					    	placeholder="Code"
					    	v-model="form.code"
					    	:class="isRequired(form.code) ? 'isRequired' : ''"
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
	import Multiselect from 'vue-multiselect';
	import {mapActions,mapGetters} from 'vuex'
    import Loader from '../../Loader'
	export default{
		components: {
	    	Multiselect,
            Loader
	  	},
		data(){
			return{
                laoding: true,
				form:{
					name:'',
					code:'',
					conts_id:'',
				},
				requiredInput:false,
				isLoading: false,
				findController: {},
			}
		},
		computed:{
			...mapGetters('action',['getMassage']),
			...mapGetters('conts',['getContList']),
		},
		methods:{
			...mapActions('action',['actionAddAction']),
			...mapActions('conts',['actionContsFind']),
			isRequired(input){
	    		return this.requiredInput && input === '';
		    },
		    async saveAction(){
		    	if (this.form.name != '' && this.form.code != ''){
					await this.actionAddAction(this.form)
					if (this.getMassage.success) {
						toast.fire({
					    	type: 'success',
					    	icon: 'success',
							title: this.getMassage.message,
					    })
						this.$router.push("/crm/action");
						this.requiredInput =false
					}else{
						toast.fire({
					    	type: 'error',
					    	icon: 'error',
							title: 'Такой Action уже существует!',
					    })
					}
				}else{
					this.requiredInput =true
				}
		    },
		    filterController(value){
	      		if(value != ''){
					  this.isLoading = true
					setTimeout(()=>{
		          		this.actionContsFind({name: value,})
						this.isLoading = false
					},1000)
				}
		    },
		    selectedItem(selectedOption, id){
	      		this.findController = selectedOption
	      		this.form.conts_id = this.findController.id
			},
		},
		async mounted(){
            this.laoding = false
		}
	}
</script>
<style scoped>

	.multiselect__tags {
		min-height: 40px;
		display: block;
		padding: 8px 40px 0 8px;
		border-radius: 5px;
		border: 1px solid #e8e8e8;
		background: #fff;
		font-size: 14px;
	}
</style>
