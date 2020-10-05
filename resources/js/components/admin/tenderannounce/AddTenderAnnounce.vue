<template>
	<div class="add_region">
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-bullhorn"></i>
				    Добавить объявление тендера
				</h4>
				<router-link class="btn btn-primary back_btn" to="/crm/tenderannounce">
					<span class="peIcon pe-7s-back"></span> 
					Назад
				</router-link>
		  	</div>
		  	<div class="card-body">
		  		<form @submit.prevent.enter="saveTender" >
					<div class="row">
					  <div class="form-group col-md-3">
					    <label for="name">Дата тердера</label>
					    <date-picker 
		                  id="time"
		                  lang="ru" 
		                  type="datetime"
		                  placeholder="Дата тердера"
		                  v-model="form.time" 
		                  valueType="format" 
		                  class="input_style"
		                  :class="isRequired(form.time) ? 'isRequired' : ''"
		                ></date-picker>
					  </div>
					  <div class="form-group col-md-5">
					    <label for="address">Адрес</label>
					    <input type="text" class="form-control input_style" v-model="form.address" id="address">	
					  </div>
					  <div class="form-group col-md-2">
					    <label for="checked">Пакет</label>
					    <input 
					    	type="checkbox" 
					    	class="form-control input_style" 
					    	v-model="checked" 
					    	id="checked"
				    	>	
					  </div>
					  <div class="form-group col-md-4">
					    <label for="checked">Маршрут</label>
					    <multiselect 
							:value="direction_ids"
							:options="getDirectionFindList"
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
	import DatePicker from "vue2-datepicker";
	import Multiselect from 'vue-multiselect';
	import { mapGetters , mapActions } from 'vuex'
	export default{
		components: {
	    	DatePicker,
	    	Multiselect,
	  	},
		data(){
			return{
				form:{
					time:'',
					direction_ids:[],
					address:'',
				},
				requiredInput:false,
				direction_ids:{},
				checked:false,
				isLoading:false,
			}
		},
		computed:{
			...mapGetters('tenderannounce',['getMassage']),
			...mapGetters('direction',['getDirectionFindList'])
		},
		mounted(){

		},
		methods:{
			...mapActions('tenderannounce',['actionAddTenderAnnounce']),
			...mapActions('direction',['actionDirectionFind']),
			isRequired(input){
	    		return this.requiredInput && input === '';
		    },
		    async findDirection(value){
		      if(value != ''){
		        this.isLoading = true
		        await setTimeout(async ()=>{
		           await this.actionDirectionFind({name: value})
		        this.isLoading = false
		        },1000)
		      }
		    },
		    dispatchAction(data){
		      this.form.direction_ids.push(data.id)
		    },
			async saveTender(){
				console.log(this.form)
		    	if (this.form.name != ''){
					await this.actionAddTenderAnnounce(this.form)
					console.log(this.getMassage)
					// this.$router.push("/crm/tenderannounce");
					this.requiredInput = false
				}else{
					this.requiredInput = true
				}
		    }
		}
	}
</script>
