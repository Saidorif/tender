<template>
	<div class="complaint">
        <Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header header_filter">
		  		<div class="header_title mb-2">
				    <h4 class="title_user">
				    	<i class="peIcon fas fa-comment"></i>
					    {{$t('Murojatlar roʼyxat')}}
					</h4>
	            	<div class="add_user_btn">
	            		<span class="alert alert-info" style="    margin: 0px 15px 0px auto;">
		            		{{$t('Murojatlar soni')}} <b>{{ getComplaintListAll.total }} {{$t('ta')}}.</b>
		            	</span>
			            <button type="button" class="btn btn-info toggleFilter mr-3" @click.prevent="toggleFilter">
						    <i class="fas fa-filter"></i>
			            	{{$t('Saralash')}}
						</button>
		            </div>
	            </div>
	            <transition name="slide">
				  	<div class="filters" v-if="filterShow">
				  		<div class="row">
				  			<div class="form-group col-xl-3 col-md-6">
							    <label for="name">{{$t('Yoʼnalish')}}</label>
							    <multiselect
					                :value="values"
					                :options="getDirectionFindList"
					                @search-change="value => filterVariantList(value)"
					                v-model="values"
					                :searchable="true"
					                track-by="id"
					                label="name"
					                :max="3"
					                :loading="isLoading"
					                :selectLabel="$t('Tanlash uchun Enter tugmasini bosing')"
					                :deselectLabel="$t('Oʼchirish uchun Enter tugmasini bosing')"
					                :option="[{name: '', id: 1}]"
					                @select="dispatchAction"
				                >
				                <span slot="noResult">{{$t('Hech qanday natija topilmadi')}}</span>
				                <span slot="noOptions">{{$t('Royxat boʼsh')}}</span>
				                </multiselect>
						  	</div>
				  			<div class="form-group col-xl-3 col-md-6">
				  				<label for="region_id">{{$t('Viloyat boʼyicha saralash')}}!</label>
			                    <select
			                      id="region_id"
			                      class="form-control input_style"
			                      v-model="filter.region_id"
			                    >
			                      <option value="" selected >{{$t('Viloyatni tanlang')}}!</option>
			                      <option :value="item.id" v-for="(item,index) in getRegionList">{{item.name}}</option>
			                    </select>
              				</div>
				  			<div class="form-group col-xl-3 col-md-6">
				  				<label for="category_id">{{$t('Qoida buzarlik boʼyicha saralash')}}!</label>
			                    <select
			                      id="category_id"
			                      class="form-control input_style"
			                      v-model="filter.category_id"
			                    >
			                      <option value="" selected >{{$t('Tanlang')}}!</option>
			                      <option :value="item.id" v-for="(item,index) in getComplaintList">{{item.name}}</option>
			                    </select>
              				</div>
				  			<div class="form-group col-xl-3 col-md-6">
				  				<label for="time">{{$t('Sana boʼyicha saralash')}}!</label>
				  				<date-picker
					                lang="ru"
					                type="date"
					                v-model="filter.time"
					                format="YYYY-MM-DD" valueType="format"
					                class="input_style"
				              	></date-picker>

              				</div>
						  	<div class="col-lg-12 form-group d-flex justify-content-end">
							  	<button type="button" class="btn btn-warning clear" @click.prevent="clear">
							  		<i class="fas fa-times"></i>
								  	{{$t('Tozalash')}}
							  	</button>
							  	<button type="button" class="btn btn-primary ml-2" @click.prevent="search">
							  		<i class="fas fa-search"></i>
								  	{{$t('Qidirish')}}
							  	</button>
					  	  	</div>
				  		</div>
				  	</div>
			  	</transition>
		  	</div>
		  	<div class="card-body">
			  <div class="table-responsive">
				<table class="table table-bordered text-center table-hover table-striped">
					<thead>
						<tr>
							<th scope="col">№</th>
							<th scope="col">{{$t('Holati')}}</th>
							<th scope="col">{{$t('Natija')}}</th>
							<th scope="col">{{$t('Toʼliq ism (yuboruvchi)')}}</th>
							<th scope="col">{{$t('Telefon')}}</th>
							<th scope="col">{{$t('Tashkilot nomi')}}</th>
							<th scope="col">{{$t('Yoʼnalish soni')}}</th>
							<th scope="col">{{$t('Tahrirlash')}}</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(compl,index) in getComplaintListAll.data">
							<td scope="row">{{compl.id}}</td>
							<td>
								<div class="badge " :class="getStatusClass(compl.status)">
									{{getStatusText(compl.status)}}
								</div>
							</td>
							<td>
								<div class="badge " :class="getResultClass(compl.status)">
									{{getResultText(compl.status)}}
								</div>
							</td>
							<td>{{compl.surname}} {{compl.name}} {{compl.middlename}}</td>
							<td>{{compl.phone}}</td>
							<td>{{compl.direction ? compl.direction.name : ''}}</td>
							<td>{{compl.direction ? compl.direction.pass_number : ''}}</td>
							<td>
								<router-link tag="button" class="btn_transparent" :to='`/crm/complaint-list/edit/${compl.id}`'>
									<i class="pe_icon pe-7s-edit editColor"></i>
								</router-link>
							<!-- 	<button class="btn_transparent" @click="deleteComplaint(compl.id)">
									<i class="pe_icon pe-7s-trash trashColor"></i>
								</button> -->
							</td>
						</tr>
					</tbody>
					<pagination :limit="4" :data="getComplaintListAll" @pagination-change-page="getResults"></pagination>
				</table>
			  </div>
		  </div>
	  	</div>
	</div>
</template>
<script>
    import {mapActions, mapGetters} from 'vuex'
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
				filter:{
					region_id:'',
					time:'',
					category_id:'',
					direction_id:'',
				},
				values:{
					id:'',
					name:'',
				},
                laoding: true,
                isLoading: false,
                filterShow: false,
			}
		},
		async mounted(){
			let page = 1
			await this.actionComplaintListAll({page:page,items:this.filter})
			await this.actionRegionList()
			await this.actionComplaintList()
            this.laoding = false
		},
		computed:{
			...mapGetters('complaint',['getComplaintListAll','getMassage',"getComplaintList"]),
			...mapGetters("region", ["getRegionList"]),
			...mapGetters("direction", ["getMassage","getDirectionFindList"]),
		},
		methods:{
			...mapActions('complaint',['actionComplaintListAll','actionComplaintList']),
			...mapActions("region", ["actionRegionList"]),
			...mapActions("direction", ["actionDirectionFind"]),
			async getResults(page = 1){
                this.laoding = true
				await this.actionComplaintListAll({page:page,items:this.filter})
                this.laoding = false
			},
			async filterVariantList(value){
		      if(value != ''){
		        this.isLoading = true
		        setTimeout(()=>{
		          this.actionDirectionFind({name: value})
		        this.isLoading = false
		        },1000)
		      }
		    },
		    dispatchAction(data){
		      this.filter.direction_id =  data.id;
		    },
			toggleFilter(){
				this.filterShow = !this.filterShow
			},
			async search(){
				let page = 1
				if(this.filter.region_id != '' || this.filter.time != '' || this.filter.category_id != '' || this.filter.direction_id != ''){
					let data = {
						page:page,
						items:this.filter
					}
					this.laoding = true
					await this.actionComplaintListAll(data)
					this.laoding = false
				}
			},
			async clear(){
				if(this.filter.region_id != '' || this.filter.time != '' || this.filter.category_id != '' || this.filter.direction_id != ''){
					this.filter.region_id = ''
					this.filter.time = ''
					this.filter.category_id = ''
					this.filter.direction_id = ''
                    let page  = 1
                    this.laoding = true
                    await this.actionComplaintListAll({page: page,items:this.filter})
                    this.laoding = false
				}

			},
			getStatusText(text){
				if (text == 'pending') {
					return this.$t('Yangi shikoyat')
				}else{
					return $t('Ko‘rib chiqilgan')
				}
			},
			getResultText(text){
				if (text == 'active') {
					return this.$t('Tasdiqlanmagan')
				}else if(text == 'completed'){
					return this.$t('Yakunlangan')
				}else{
					return $t('Tasdiqlanmagan')
				}
			},
			getResultClass(text){
				if (text == 'active') {
					return 'badge-danger'
				}else if(text == 'completed'){
					return 'badge-secondary'
				}else{
					return 'badge-info'
				}
			},
			getStatusClass(text){
				if (text == 'pending') {
					return 'badge-warning'
				}else{
					return 'badge-primary'
				}
			},
			// async deleteComplaint(id){
			// 	if(confirm(this.$t('Siz chindan ham oʼchirishni xohlaysizmi?'))){
			// 		let page = 1
			// 		await this.actionDeleteComplaint(id)
			// 		await this.getComplaintListAll(page)
			// 		toast.fire({
			// 	    	type: 'success',
			// 	    	icon: 'success',
			// 			title: this.$t('Oʼchirildi'),
			// 	    })
			// 	}
			// }
		}
	}
</script>
<style scoped>

</style>
