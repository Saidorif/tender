<template>
	<div class="edit_region">
		<Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-file-alt"></i>
				    Изменить старый контракт
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
			          	<div class="form-group col-md-3">
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
					  	<div class="form-group col-md-3">
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
		              		<small>
		              			<a :href="fileName" download>
		              				<i class="fas fa-download"></i>
		              				Скачать файл
		              			</a>
		              		</small>
			          	</div>
			          	<div class="form-group col-md-3">
						    <label for="marshrut">Направления</label>
						    <multiselect
								:value="directionvalues"
								:options="findDirectionList"
								@search-change="value => findDirection(value)"
								v-model="directionvalues"
		                        placeholder="Направления"
		                        :searchable="true"
		                        track-by="id"
		                        label="name"
		                        :max="3"
								:loading="isDirectionLoading"
								selectLabel="Нажмите Enter, чтобы выбрать"
								deselectLabel="Нажмите Enter, чтобы удалить"
								:option="[{name: 'Otash', id: 1}]"
								@remove="removeDirect"
                                :multiple="true"
								>
								<span slot="noResult">По вашему запросу ничего не найдено</span>
								<span slot="noOptions">Cписок пустой</span>
							</multiselect>
				  		</div>
				  		<div class="ml-3 d-flex justify-content-center w-100 border pt-2 mb-4">
							<h4>Мои автомобили</h4>
						</div>
					  	<div class="form-group col-lg-12">
					  		<div class="row" v-for="(car,index) in cars">
					        	<div class="item_index">
					        		{{index+1}})
				        		</div>
					        	<div class="form-group col-md-1">
								    <label for="auto_number">Номер Авто</label>
								    <input
								    	type="text"
								    	class="form-control input_style"
								    	id="auto_number"
								    	v-mask="'********'"
								    	placeholder="Авто №"
								    	v-model="car.auto_number"
								    	:class="isRequired(car.auto_number) ? 'isRequired' : ''"
							    	>
							  	</div>
							  	<div class="form-group col-md-3">
								    <label for="bustype_id">Категория Авто</label>
								    <select
									    class="form-control input_style"
								    	id="bustype_id"
								    	placeholder="Номер Авто"
								    	v-model="car.bustype_id"
								    	:class="isRequired(car.bustype_id) ? 'isRequired' : ''"
			                            @change="selectClass(car)"
								    >
								    	<option value="" selected disabled>Выберите категорию авто!</option>
								    	<option
								    		:value="busType.id"
								    		v-for="(busType,index) in getTypeofbusList"
								    		data-toggle="tooltip" data-placement="right" title="Tooltip on right"
							    		>{{busType.name}}</option>
								    </select>
							  	</div>
			                    <div class="form-group col-md-2">
								    <label for="tclass_id">Класс Авто</label>
								    <select
									    class="form-control input_style"
								    	id="tclass_id"
								    	placeholder="Номер Авто"
								    	v-model="car.tclass_id"
								    	:class="isRequired(car.tclass_id) ? 'isRequired' : ''"
								    >
								    	<option value="" selected disabled>Выберите класс авто!</option>
								    	<option :value="busClass.id" v-for="(busClass,index) in car.getBusclassFindList">{{busClass.name}}</option>
								    </select>
							  	</div>
							  	<div class="form-group col-md-2">
								    <label for="busmarka_id">Марка Авто</label>
								    <select
									    class="form-control input_style"
								    	id="busmarka_id"
								    	placeholder="Номер Авто"
								    	v-model="car.busmarka_id"
								    	:class="isRequired(car.busmarka_id) ? 'isRequired' : ''"
								    	@change="selectCarMarka(car)"
								    >
								    	<option value="" selected disabled>Выберите марку авто!</option>
								    	<option :value="item.id" v-for="(item,index) in getBusBrandList">{{item.name}}</option>
								    </select>
							  	</div>
							  	<div class="form-group col-md-2">
								    <label for="busmodel_id">Модель Авто</label>
								    <select
									    class="form-control input_style"
								    	id="busmodel_id"
								    	placeholder="Номер Авто"
								    	v-model="car.busmodel_id"
								    	:class="isRequired(car.busmodel_id) ? 'isRequired' : ''"
								    >
								    	<option value="" selected disabled>Выберите модель авто!</option>
								    	<option :value="item.id" v-for="(item,index) in car.getBusmodelFindList">{{item.name}}</option>
								    </select>
							  	</div>
							  	<template v-if="car.id">
								  	<div class="form-group col-md-1 trash_car_item" @click.prevent="removeCarFromServer(car.id)">
								  		<i class="fas fa-trash-alt"></i>
								  	</div>	
							  	</template>
							  	<template v-else>
								  	<div class="form-group col-md-1 trash_car_item" @click.prevent="removeCarItem(index)" v-if="index!=0">
								  		<i class="fas fa-trash-alt"></i>
								  	</div>	
							  	</template>
					        </div>
				  	  	</div>
					  	<div class="form-group col-lg-12 d-flex justify-content-end align-items-center">
						  	<button type="button" class="btn btn-info mr-3" @click.prevent="addCarItem">
						  		<i class="fas fa-plus"></i>
							  	Добавить авто
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
					id:'',
					number:'',
					date:'',
					exp_date:'',
					direction_ids:[],
					cars:[],
					protocol_id:'',
					user_id:'',
					contract_period:'',
					file:'',
				},
				cars:[
					{
						bustype_id:'',
						busmarka_id:'',
						busmodel_id:'',
						tclass_id:'',
					   	auto_number:'',
					},
				],
				direction_ids:{},
				protocol_values: {},
				directionvalues: null,
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
        watch:{
            directionvalues: function(newQuestion, oldQuestion){
                this.form.direction_ids = newQuestion.map(item => item.id);
            },
        },
		computed:{
			...mapGetters('typeofbus',['getTypeofbusList']),
            ...mapGetters('busmodel',['getBusmodelList', 'getBusmodelFindList']),
			...mapGetters('busclass',['getBusclassFindList']),
            ...mapGetters("busbrand", ["getBusBrandList"]),
			...mapGetters('oldcontract',[
				'getMassage',
				'getOldcontractFind',
				'getOldcontract',
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
		async mounted(){
			await this.actionEditOldcontract(this.$route.params.oldcontractId)
			this.form = this.getOldcontract
			this.user_values = this.getOldcontract.user
			this.protocol_values = this.getOldcontract.protocol
			this.cars = this.getOldcontract.cars
			if(this.cars.length == 0){
				this.cars = [{
					bustype_id:'',
					busmarka_id:'',
					busmodel_id:'',
					tclass_id:'',
				   	auto_number:'',
				}]
			}
			this.directionvalues = this.getOldcontract.direction_ids.map((item,index)=>{
				return item
			})
			this.getOldcontract.cars.forEach(async (car,index)=>{
				if (car){
		    		let data = {
		    			'bustype_id':car.bustype_id,
                    }
                    this.laoding = true
                    await this.actionBusclassFind(data)
                    car.getBusclassFindList = this.getBusclassFindList
	                await this.actionBusmodelFindList(car);
	                this.laoding = false
	                car.getBusmodelFindList = this.getBusmodelFindList
		    	}
			})
			await this.actionTypeofbusList()
			await this.actionBusmodelList()
            await this.actionBusBrandList()
			this.laoding = false
		},
		methods:{
			...mapActions('typeofbus',['actionTypeofbusList']),
			...mapActions('busmodel',['actionBusmodelList', 'actionBusmodelListByBrand', 'actionBusmodelFindList']),
			...mapActions('busclass',['actionBusclassFind']),
            ...mapActions("busbrand",["actionBusBrandList"]),
			...mapActions('oldcontract',[
				'actionEditOldcontract',
				'actionUpdateOldcontract',
				'actionOldprotocolFind',
				'actionDeleteOldcontractCar',
			]),
			...mapActions('oldprotocol',[
				'actionOldprotocolFind',
			]),
			...mapActions('user',[
				'ActionUserFind',
			]),
			...mapActions('direction',['actionDirectionFind']),
			addCarItem(){
				let car = {
					bustype_id:'',
					busmarka_id:'',
					busmodel_id:'',
					tclass_id:'',
				   	auto_number:'',
				}
				this.cars.push(car)
			},
			removeCarItem(index){
				if(index != 0){
					if(confirm("Вы действительно хотите удалить?")){
						Vue.delete(this.cars,index)
					}
				}
			},
			async removeCarFromServer(id){
				if(confirm("Вы действительно хотите удалить?")){
					await this.actionDeleteOldcontractCar(id)
					await this.actionEditOldcontract(this.$route.params.oldcontractId)
					this.cars = this.getOldcontract.cars
					this.getOldcontract.cars.forEach(async (car,index)=>{
						if (car){
				    		let data = {
				    			'bustype_id':car.bustype_id,
		                    }
		                    this.laoding = true
		                    await this.actionBusclassFind(data)
		                    car.getBusclassFindList = this.getBusclassFindList
			                await this.actionBusmodelFindList(car);
			                this.laoding = false
			                car.getBusmodelFindList = this.getBusmodelFindList
				    	}
					})
				}
			},
			async selectClass(car){
		    	car.tclass_id = ''
		    	car.busmarka_id = ''
		    	car.busmodel_id = ''
		    	if (car) {
		    		let data = {
		    			'bustype_id':car.bustype_id,
                    }
                    this.laoding = true
                    await this.actionBusclassFind(data)
                    car.getBusclassFindList = this.getBusclassFindList
                    this.laoding = false
		    	}
		    },
		    async selectCarMarka(car){
                car.busmodel_id = ''
                this.laoding = true
                await this.actionBusmodelFindList(car);
                this.laoding = false
                car.getBusmodelFindList = this.getBusmodelFindList
            },
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
		    changePhoto(event){
		      	if (event.target.files[0]["type"] === "application/pdf"){
					let file = event.target.files[0]
			    	this.form.file = event.target.files[0];
			        let reader = new FileReader();
					reader.onload = event => {
						this.fileName = event.target.result;
					};
					reader.readAsDataURL(file);
		      	}else{
			        swal.fire({
		          		type: "error",
		          		icon: "error",
		          		title: "Ошибка",
		          		text: "Картинка должна быть только pdf!"
			        });
		      		this.form.file = ''
		      	}
			},
			async saveOldcontract(){
		    	if (this.form.number != '' && this.form.date != '' && this.form.file != '' && this.form.contract_period != '' && this.form.user_id != '' && this.form.protocol_id != '' && this.form.exp_date != ''){
		    		if(this.form.direction_ids.length > 0){
			    		let formData = new FormData();
			    		formData.append('id',this.form.id)
			    		formData.append('number',this.form.number)
			    		formData.append('date',this.form.date)
			    		formData.append('exp_date',this.form.exp_date)
			    		formData.append('protocol_id',this.form.protocol_id)
			    		formData.append('user_id',this.form.user_id)
			    		formData.append('file',this.form.file)
			    		formData.append('contract_period',this.form.contract_period)
			    		this.form.direction_ids.forEach((item,index)=>{
				    		formData.append('direction_ids['+index+"]",item)
			    		})
			    		this.cars.forEach((item,index)=>{
				    		formData.append('cars['+index+"][id]",item.id)
				    		formData.append('cars['+index+"][bustype_id]",item.bustype_id)
				    		formData.append('cars['+index+"][busmarka_id]",item.busmarka_id)
				    		formData.append('cars['+index+"][busmodel_id]",item.busmodel_id)
				    		formData.append('cars['+index+"][tclass_id]",item.tclass_id)
				    		formData.append('cars['+index+"][auto_number]",item.auto_number)
			    		})
			    		let data = {
			    			id:this.form.id,
			    			items:formData
			    		}
						this.laoding = true
						await this.actionUpdateOldcontract(data)
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
						toast.fire({
							type: "error",
							icon: "error",
							title: 'Выберите направление!'
					 	});		    			
		    		}
				}else{
					this.requiredInput = true
				}
		    }
		}
	}
</script>
<style scoped>
	.btn_save{
		margin-top: 40px;
	}
	.item_index{
	    margin: 30px 0 0 30px;
    	font-size: 23px;
	}
	.trash_car_item{
		margin: 30px 0 0 30px;
    	font-size: 23px;
    	color:#c73838;
    	cursor:pointer;
	}
</style>
