<template>
	<div class="area">
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-vote-yea"></i>
				    Доступ 
				</h4>
				<button class="btn btn-info" @click="applyActive" :disabled="getApplies.data && getApplies.data.length > 0 ? false : true">
		    		<i class="fas fa-user-check"></i>
		    		Активировать
		    	</button>
		  	</div>
		  	<div class="card-body">	
		  		<div class="table-responsive">
			  		<table class="table table-bordered text-center table-hover">
			          	<thead>
				            <tr>
			            	  <th class="allcheckbox" v-if="getApplies.data && getApplies.data.length > 0">
			            	  	<label><vs-checkbox v-model="allChecked" @change="allCheckbox"></vs-checkbox></label>
			            	  </th>
				              <th scope="col">№</th>
				              <th scope="col">ИНН</th>
				              <th scope="col">Статус</th>
				              <th scope="col">E-mail</th>
				              <th scope="col">Дата поступления</th>
				              <th scope="col">Изображение</th>
				            </tr>
			          	</thead>
			          	<tbody>
			          		<tr v-for="(item, index) in getApplies.data" :key="item.id" v-if="getApplies.data.length > 0">
			          			<td class="centerx">	
									<vs-checkbox v-model="allIds" :vs-value="item"  v-if="item.status != 'active'"></vs-checkbox>
			          			</td>
			          			<td>{{item.id}}</td>
			          			<td style="letter-spacing: 3px;">{{item.inn}}</td>
			          			<td style="letter-spacing: 3px;">
			          				<div class="badge" :class="item.status == 'active' ? 'badge-success' : 'badge-warning'">
			          					{{item.status == 'active' ? 'отправлен' : 'неотправлен'}}
				          			</div>
				          		</td>
			          			<td width="25%">
			          				<input type="email" v-model="item.email" @blur="checkEmailExist(item.email, index)" class="form-control" placeholder="E-mail..." required v-if="item.status != 'active'">
									<small class="text-danger" v-if="item.status != 'active'">{{errors[index]}}</small>
			          			</td>
			          			<td>
			          				{{item.created_at}}
			          			</td>
			          			<td>
			          				<a :href="photoApply(item.file)" data-fancybox>
									    <img :src="photoApply(item.file)" width="50" />
								  	</a>
			          			</td>
			          		</tr>
			          	</tbody>
		          	</table>
	          	</div>
	          	<pagination :limit="4" :data="getApplies" @pagination-change-page="getResults"></pagination>
          	</div>	
	  	</div>
	</div>
</template>
<script>
	import { mapGetters , mapActions } from 'vuex'
	export default{
		data(){
			return{
				allIds:[],
				allChecked:false,
				sendData: [],
				emailMsg: '',
				emailIsExist: false,
				errors:[],
				filter:{
					inn:null
				},
				page:null
			}
		},
		async mounted(){
			let page = 1;
			await this.actionApplies(page)
		},
		computed:{
			...mapGetters('apply',['getApplies','getMassage','getCheckEmail'])
		},
		methods:{
			...mapActions('apply',['actionApplies','actionSendApplyActive','actionCheckEmail']),
			async getResults(page = 1){ 
				await this.actionApplies(page)
			},
			allCheckbox(){
				if(this.allChecked){
					this.allIds = []
					for(let item in this.getApplies.data){
						this.allIds.push(this.getApplies.data[item]);
					}
				}else{
					this.allIds = []
				}
			},
			photoApply(img){
				return img ? '/uploads/'+img : '';
			},
			defaultData(){
				this.allChecked=false
				this.allIds=[]
			},
			async applyActive(){
				if(this.allIds.length > 0){
					let result = this.allIds.map((item)=>{
						return {
							id:item.id,
							email:item.email ? item.email : '' 
						}
					})
					await this.actionSendApplyActive({users:result});
					if(this.getCheckEmail.success){
						// let data = {
						// 	inn:this.filter.inn
						// }
						await this.actionApplies();
						toast.fire({
							type: "success",
							icon: "success",
							title: "Список E-mail добавлен!"
						});
					}
					this.allIds = []
				}else{
					toast.fire({
						type: "error",
						icon: "error",
						title: "Выбирайте чтобы активировать"
					});
				}
			},
			async checkEmailExist(email, index){
				let message = ''
				await this.actionCheckEmail({email: email});
				console.log(this.getCheckEmail.message)
				if(this.getCheckEmail.error){
					if(this.getCheckEmail.message.email[0] === "The email must be a valid email address."){
						message = "Адрес электронной почты должен быть действительным.";
					}else if(this.getCheckEmail.message.email[0] === "The email has already been taken."){
						message = "На этот email уже зарегистрирован аккаунт";
					}else if(this.getCheckEmail.message.email[0] === "The email field is required."){
						message = "Поле не должно быть пустым";
					}else{
						message = ""
					}
				}
				Vue.set(this.errors, index, message)
			},
		}
	}
</script>
<style scoped>
	
</style>