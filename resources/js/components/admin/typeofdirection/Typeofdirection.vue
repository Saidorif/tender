<template>
	<div class="region">
		<Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-border-style"></i>
				    {{$t('Yoʼnalish turi')}}
				</h4>
				<router-link class="btn btn-primary" to="/crm/typeofdirection/add"><i class="fas fa-plus"></i> {{$t('Qoʼshish')}}</router-link>
		  	</div>
		  	<div class="card-body">
			  <div class="table-responsive">
				<table class="table table-bordered text-center table-hover table-striped">
					<thead>
						<tr>
							<th scope="col">№</th>
							<th scope="col">{{$t('Nomi')}}</th>
							<th scope="col">{{$t('Turi')}}</th>
							<th scope="col">{{$t('Tahrirlash')}}</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(type,index) in getTypeofdirections.data">
							<td scope="row">{{type.id}}</td>
							<td>{{type.name}}</td>
							<td>{{type.type}}</td>
							<td>
								<router-link tag="button" class="btn_transparent" :to='`/crm/typeofdirection/edit/${type.id}`'>
									<i class="pe_icon pe-7s-edit editColor"></i>
								</router-link>
								<button v-if="$can('destroy', 'DirectionTypeController')"  class="btn_transparent" @click="deleteType(type.id)">
									<i class="pe_icon pe-7s-trash trashColor"></i>
								</button>
							</td>
						</tr>
					</tbody>
					<pagination :limit="4" :data="getTypeofdirections" @pagination-change-page="getResults"></pagination>
				</table>
			  </div>
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

			}
		},
		async mounted(){
			let page = 1;
			await this.actionTypeofdirections()
			this.laoding = false
		},
		computed:{
			...mapGetters('typeofdirection',['getTypeofdirections','getMassage'])
		},
		methods:{
			...mapActions('typeofdirection',['actionTypeofdirections','actionDeleteTypeofdirection']),
			async getResults(page = 1){
				await this.actionTypeofdirections(page)
			},
			async deleteType(id){
				if(confirm(this.$t('Siz chindan ham oʼchirishni xohlaysizmi?'))){
					let page = 1
					this.laoding = true
					await this.actionDeleteTypeofdirection(id)
					this.laoding = false
					if (this.getMassage.error) {
						await this.actionTypeofdirections(page)
						toast.fire({
				            type: "success",
				            icon: "success",
				            title: this.getMassage.message
				          });
						this.$router.push("/crm/typeofdirection");
						this.requiredInput = false
					}
				}
			}
		}
	}
</script>
<style scoped>

</style>
