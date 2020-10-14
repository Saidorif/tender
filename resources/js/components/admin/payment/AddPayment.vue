<template>
	<div class="add_region">
		<Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-money-bill-alt"></i>
				    Добавить Платеж
				</h4>
				<router-link class="btn btn-primary back_btn" to="/crm/payment"><span class="peIcon pe-7s-back"></span> Назад</router-link>
		  	</div>
		  	<div class="card-body">
		  		<form @submit.prevent.enter="savePayment" >
					<div class="row">
					  <div class="form-group col-md-3">
					    <label for="name">Названия компаний</label>
					    <multiselect 
							:value="direction_ids"
							:options="findList"
							@search-change="value => findDirection(value)"
							v-model="direction_ids" 
	                        placeholder="Выберите маршрут"
	                        :searchable="true"
	                        track-by="id"
	                        label="name"
	                        :max="3"
							:loading="isLoading"
							selectLabel="Нажмите Enter, чтобы выбрать"
							deselectLabel="Нажмите Enter, чтобы удалить"
							:option="[{name: 'Otash', id: 1}]"
							@select="dispatchAction"
							>
							<span slot="noResult">По вашему запросу ничего не найдено</span>
							<span slot="noOptions">Cписок пустой</span>
						</multiselect>	
				<!-- 	    <input 
					    	type="text" 
					    	class="form-control input_style" 
					    	id="name" 
					    	placeholder="Названия компаний"
					    	v-model="form.name"
					    	:class="isRequired(form.name) ? 'isRequired' : ''"  
				    	> -->
					  </div>
					  <div class="form-group col-md-2">
					    <label for="summ">Сумма</label>
					    <input 
					    	type="number" 
					    	class="form-control input_style" 
					    	id="summ" 
					    	placeholder="Сумма"
					    	v-model="form.summ"
					    	:class="isRequired(form.summ) ? 'isRequired' : ''"  
				    	>
					  </div>
					  <div class="form-group col-md-2">
					    <label for="date">Дата</label>
					    <input 
					    	type="date" 
					    	class="form-control input_style" 
					    	id="date" 
					    	placeholder="Дата"
					    	v-model="form.date"
					    	:class="isRequired(form.date) ? 'isRequired' : ''"  
				    	>
					  </div>
					  <div class="form-group col-md-3">
					    <label for="detail">Детали</label>
					    <input 
					    	type="text" 
					    	class="form-control input_style" 
					    	id="detail" 
					    	placeholder="Область"
					    	v-model="form.detail"
					    	:class="isRequired(form.detail) ? 'isRequired' : ''"  
				    	>
					  </div>
					  <div class="form-group col-lg-2 form_btn">
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
					company_id:'',
					company_name:'',
					summ:'',
					date:'',
					detail:'',
				},
				requiredInput:false,
				laoding: true,
				findList:[],
			}
		},
		computed:{
			...mapGetters('payment',['getMassage']),
			...mapGetters('find',['getFindByCompanies']),
		},
		mounted(){
			this.laoding = false
		},
		methods:{
			...mapActions('payment',['actionAddPayment']),
			...mapActions('find',['actionFindByCompanies']),
			isRequired(input){
	    		return this.requiredInput && input === '';
		    },
		    async findDirection(value){
		   //    if(value != ''){
		   //      this.isLoading = true
		   //      await setTimeout(async ()=>{
					// await this.actionFindByCompanies({name: value})
			  //       this.findList = this.getFindByCompanies
		   //      this.isLoading = false
		   //      },1000)
		   //    }
		    },
		    async dispatchAction(data){
		  		// this.form.direction_ids.push(data.id);
			  	// this.laoding = true
			  	// await this.actionGetScheduleTable(data.id)
			  	// this.laoding = false
		    },
			async savePayment(){
		    	if (this.form.name != ''){
					this.laoding = true
					await this.actionAddPayment(this.form)
					this.laoding = false
					this.$router.push("/crm/payment");
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