<template>
	<div class="area">
        <Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-vote-yea"></i>
				    {{ $t('Kirish') }}
				</h4>
				<button class="btn btn-info" @click="applyActive" :disabled="getApplies.data && getApplies.data.length > 0 ? false : true">
		    		<i class="fas fa-user-check"></i>
                    {{ $t('Faollashtirish') }}
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
				              <th scope="col">{{ $t('INN') }}</th>
				              <th scope="col">{{ $t('Holati') }}</th>
				              <th scope="col">{{ $t('Email') }}</th>
				              <th scope="col">{{ $t('Kelib tushgan sana') }}</th>
				              <th scope="col">{{ $t('Rasm') }}</th>
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
			          					{{item.status == 'active' ? $t('yuborilgan') : $t('yuborilmagan') }}
				          			</div>
				          		</td>
			          			<td width="25%">
			          				<input type="email" v-model="item.email" @blur="checkEmailExist(item.email, index)" class="form-control"  required v-if="item.status != 'active'">
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
    import Loader from '../../Loader'
	export default{
		data(){
			return{
                laoding: true,
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
        components:{
            Loader
        },
		async mounted(){
			let page = 1;
            await this.actionApplies(page)
            this.laoding = false
		},
		computed:{
			...mapGetters('apply',['getApplies','getMassage','getCheckEmail'])
		},
		methods:{
			...mapActions('apply',['actionApplies','actionSendApplyActive','actionCheckEmail']),
			async getResults(page = 1){
                this.laoding = true
				await this.actionApplies(page)
                this.laoding = false
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
                    this.laoding = true
					await this.actionSendApplyActive({users:result});
					if(this.getCheckEmail.success){
						// let data = {
						// 	inn:this.filter.inn
						// }
						await this.actionApplies();
						toast.fire({
							type: "success",
							icon: "success",
							title: this.$t("Elektron pochta roʼyxati qoʼshildi")
						});
					}
                    this.laoding = false
					this.allIds = []
				}else{
					toast.fire({
						type: "error",
						icon: "error",
						title: this.$t("Faollashtirish uchun tanlang")
					});
				}
			},
			async checkEmailExist(email, index){
				let message = '';
                this.laoding = true
				await this.actionCheckEmail({email: email});
                this.laoding = false
				if(this.getCheckEmail.error){
					if(this.getCheckEmail.message.email[0] === "The email must be a valid email address."){
						message = this.$t("Elektron pochta manzili haqiqiy bo'lishi kerak");
					}else if(this.getCheckEmail.message.email[0] === "The email has already been taken."){
						message = this.$t("Bu elektron pochta band");
					}else if(this.getCheckEmail.message.email[0] === "The email field is required."){
						message = this.$t("Maydon bo‘sh bo‘lmasligi kerak");
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
