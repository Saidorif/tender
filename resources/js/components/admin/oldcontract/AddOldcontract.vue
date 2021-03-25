<template>
	<div class="add_region">
		<Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-file-alt"></i>
				    Добавить старый контракт
				</h4>
				<router-link class="btn btn-primary back_btn" to="/crm/oldcontract">
					<span class="peIcon pe-7s-back"></span> 
					Назад
				</router-link>
		  	</div>
		  	<div class="card-body">
		  		<form @submit.prevent.enter="saveOldcontract" enctype="multipart/form-data">
					<div class="row">
					  	<div class="form-group col-md-3">
						    <label for="number">Номер контракта</label>
						    <input 
						    	type="text" 
						    	class="form-control input_style" 
						    	id="number" 
						    	placeholder="Номер контракта"
						    	v-model="form.number"
						    	:class="isRequired(form.number) ? 'isRequired' : ''"  
					    	>
					  	</div>
					  	<div class="form-group col-md-3">
			              	<label for="date">Контракт тузилган сана</label>
			              	<date-picker
				                lang="ru"
				                type="date" format="YYYY-MM-DD" valueType="format"
				                v-model="form.date"
				                class="input_style"
				                placeholder="Контракт тузилган сана"
				                :class="isRequired(form.date) ? 'isRequired' : ''"
			              	></date-picker>
			          	</div>
					  	<div class="form-group col-md-3">
			              	<label for="exp_date">Амал қилиш муддати</label>
			              	<date-picker
				                lang="ru"
				                type="date" format="YYYY-MM-DD" valueType="format"
				                v-model="form.exp_date"
				                class="input_style"
				                placeholder="Амал қилиш муддати"
				                :class="isRequired(form.exp_date) ? 'isRequired' : ''"
			              	></date-picker>
			          	</div>
			          	<div class="form-group col-md-3">
						    <label for="protocol_id">Название Компании</label>
						    <multiselect
								:value="user_values"
								:options="findUserList"
								@search-change="value => findUser(value)"
								v-model="user_values"
		                        placeholder="Название Компании"
		                        :searchable="true"
		                        track-by="id"
		                        label="company_name"
		                        :max="3"
								:loading="isUserLoading"
								selectLabel="Нажмите Enter, чтобы выбрать"
								deselectLabel="Нажмите Enter, чтобы удалить"
								:option="[{company_name: 'Otash', id: 1}]"
								@select="dispatchUser"
								@remove="removeUser"
								:class="isRequired(form.user_id) ? 'isRequired' : ''"
								>
								<span slot="noResult">По вашему запросу ничего не найдено</span>
								<span slot="noOptions">Cписок пустой</span>
							</multiselect>
				  	    </div>
			          	<div class="form-group col-md-4">
						    <label for="protocol_id">Протокол рақами</label>
						    <multiselect
								:value="protocol_values"
								:options="findProtocolList"
								@search-change="value => findProtocol(value)"
								v-model="protocol_values"
		                        placeholder="Протокол рақами"
		                        :searchable="true"
		                        track-by="id"
		                        label="number"
		                        :max="3"
								:loading="isProtocolLoading"
								selectLabel="Нажмите Enter, чтобы выбрать"
								deselectLabel="Нажмите Enter, чтобы удалить"
								:option="[{number: 'Otash', id: 1}]"
								@select="dispatchProtocol"
								@remove="removeProtocol"
								:class="isRequired(form.protocol_id) ? 'isRequired' : ''"
								>
								<span slot="noResult">По вашему запросу ничего не найдено</span>
								<span slot="noOptions">Cписок пустой</span>
							</multiselect>
				  	    </div>
					  	<div class="form-group col-md-4">
			              	<label for="contract_period">Контракт периоди</label>
			              	<select class="form-control input_style" v-model="form.contract_period">
			              		<option value="" selected disabled>Контракт периоди танланг!</option>
			              		<option value="1">1 йил</option>
			              		<option value="2">2 йил</option>
			              		<option value="3">3 йил</option>
			              		<option value="4">4 йил</option>
			              		<option value="5">5 йил</option>
			              	</select>
			          	</div>
					  	<div class="form-group col-md-4">
			              	<label for="date">Файл</label>
			              	<input 
			              		type="file" 
			              		name="file"  
			              		id="file" 
			              		class="form-control input_style"  
			              		:class="isRequired(form.file) ? 'isRequired' : ''"
			              		@change="changePhoto($event)"
		              		>
		              		<small>
		              			<a :href="fileName" download>
		              				<i class="fas fa-download"></i>
		              				Скачать файл
		              			</a>
		              		</small>
			          	</div>
			          	<div class="form-group col-md-6">
						    <label for="marshrut">Йўналиш рақами ва номи</label>
						    <multiselect
								:value="directionvalues"
								:options="findDirectionList"
								@search-change="value => findDirection(value)"
								v-model="directionvalues"
		                        placeholder="Йўналиш рақами ва номи"
		                        :searchable="true"
		                        track-by="id"
		                        label="name"
		                        :max="3"
								:loading="isDirectionLoading"
								selectLabel="Нажмите Enter, чтобы выбрать"
								deselectLabel="Нажмите Enter, чтобы удалить"
								:option="[{name: 'Otash', id: 1}]"
								@select="dispatchAction"
								@remove="removeDirect"
								>
								<span slot="noResult">По вашему запросу ничего не найдено</span>
								<span slot="noOptions">Cписок пустой</span>
							</multiselect>
				  		</div>
					  	<div class="form-group col-lg-12 d-flex justify-content-end">
						  	<button type="button" class="btn btn-info mr-3" @click.prevent="addDirection">
						  		<i class="fas fa-plus"></i>
							  	Добавить направление
							</button>
						  	<button type="submit" class="btn btn-primary">
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
	import Multiselect from 'vue-multiselect';
	import DatePicker from "vue2-datepicker";
	export default{
		components:{
			Loader,
			DatePicker,
			Multiselect,
		},
		data(){
			return{
				form:{
					number:'',
					date:'',
					exp_date:'',
					direction_ids:[],
					protocol_id:'',
					user_id:'',
					contract_period:'',
					file:'',
				},
				direction_ids:{},
				protocol_values: {},
				directionvalues: {},
				user_values: {},
				findDirectionList: [],
				findProtocolList: [],
				findUserList: [],
				requiredInput:false,
				laoding: true,
				isDirectionLoading: false,
				isProtocolLoading: false,
				isUserLoading: false,
				fileName: '',
			}
		},
		computed:{
			...mapGetters('oldcontract',[
				'getMassage',
				'getOldprotocolFind',
			]),
			...mapGetters('oldprotocol',[
				'getOldprotocolFind',
			]),
			...mapGetters('user',[
				'getUserfindList',
			]),
			...mapGetters('direction',[
				'getDirectionFindList',
			]),
		},
		mounted(){
			this.laoding = false
		},
		methods:{
			...mapActions('oldcontract',[
				'actionAddOldcontract',
				'actionOldprotocolFind',
			]),
			...mapActions('oldprotocol',[
				'actionOldprotocolFind',
			]),
			...mapActions('user',[
				'ActionUserFind',
			]),
			...mapActions('direction',['actionDirectionFind']),
		    async findDirection(value){
		      if(value != ''){
		        this.isDirectionLoading = true
		        await setTimeout(async ()=>{
                    await this.actionDirectionFind({name: value})
			        this.findDirectionList = this.getDirectionFindList
		        this.isDirectionLoading = false
		        },1000)
		      }
		    },
		    removeDirect(){
		    	this.form.direction_ids=[]
		    	this.direction_ids={}
				this.findDirectionList = []
		    },
		    async dispatchAction(data){
				this.directionvalues = data;
				this.form.direction_ids = data.id;
		    },
			removeProtocol(){
		    	this.form.protocol_id=''
		    	this.protocol_values={}
				this.findProtocolList = []
		    },
		    async findProtocol(value){
		      if(value != ''){
		        this.isProtocolLoading = true
		        await setTimeout(async()=>{
					await this.actionOldprotocolFind({number: value})
			        this.findProtocolList = this.getOldprotocolFind
		        	this.isProtocolLoading = false
		        },1000)
		      }
		    },
		    async dispatchProtocol(data){
				this.protocol_values = data;
				this.form.protocol_id = data.id
		    },
			removeUser(){
		    	this.form.user_id=''
		    	this.user_values={}
				this.findUserList = []
		    },
		    async findUser(value){
		      if(value != ''){
		        this.isUserLoading = true
		        await setTimeout(async()=>{
					await this.ActionUserFind({name: value})
			        this.findUserList = this.getUserfindList
		        	this.isUserLoading = false
		        },1000)
		      }
		    },
		    async dispatchUser(data){
				this.user_values = data;
				this.form.user_id = data.id
		    },
			isRequired(input){
	    		return this.requiredInput && input === '';
		    },
		    photoImg(img){
		    	// if (img) {
			    //   if (img.length > 100) {
			    //     return img;
			    //   } else {
			    //     return '/offer/'+img;
			    //   }
		    	// }
		    },
		    addDirection(){

		    },
		    changePhoto(event){
				this.form.file = event.target.files[0];
				let file = event.target.files[0]
		    	let reader = new FileReader();
				reader.onload = event => {
					this.fileName = event.target.result;
				};
				reader.readAsDataURL(file);
			},
			async saveOldcontract(){
		    	if (this.form.number != '' && this.form.date != '' && this.form.file != ''){
		    		let formData = new FormData();
		    		formData.append('number',this.form.number)
		    		formData.append('date',this.form.date)
		    		formData.append('file',this.form.file)


					this.laoding = true
					await this.actionAddOldcontract(formData)
					if(this.getMassage.success){
						toast.fire({
					    	type: 'success',
					    	icon: 'success',
							title: this.getMassage.message,
					    })
						this.$router.push("/crm/oldcontract");
						this.requiredInput = false
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