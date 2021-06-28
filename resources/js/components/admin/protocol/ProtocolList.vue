<template>
	<div class="role">
		<Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i  class="peIcon fas fa-file"></i>
				    {{$t('Bayonnomalar ro‘yxati')}}
				</h4>
		  	</div>
		  	<div class="card-body">
			  <div class="table-responsive">
				<table class="table table-bordered text-center table-hover table-striped">
					<thead>
						<tr>
							<th scope="col">№</th>
							<th scope="col">{{$t('Nomi')}}</th>
							<th scope="col">{{$t('Tahrirlash')}}</th>
						</tr>
					</thead>
					<tbody>
						<tr>
						<!-- 	<td scope="row">{{cont.id}}</td>
							<td>{{cont.name}}</td>
							<td>{{cont.label}}</td>
							<td>
								<router-link tag="button" class="btn_transparent" :to='`/crm/conts/edit/${cont.id}`'>
									<i class="pe_icon pe-7s-edit editColor"></i>
								</router-link> -->
							<!-- 	<button class="btn_transparent" @click="deleteConts(cont.id)">
									<i class="pe_icon pe-7s-trash trashColor"></i>
								</button> -->
							</td>
						</tr>
					</tbody>
					<!-- <pagination :limit="4" :data="getConts" @pagination-change-page="getResults"></pagination> -->
				</table>
			  </div>
		  </div>
	  	</div>
	</div>
</template>
<script>
	import {mapActions, mapGetters} from 'vuex'
	import Loader from '../../Loader'
	export default{
		components:{
			Loader
		},
		data(){
			return{
				laoding: true
			}
		},
		async mounted(){
			// await this.actionConts()
			this.laoding = false
		},
		computed:{
			// ...mapGetters('conts',['getConts','getMassage'])
		},
		methods:{
			// ...mapActions('conts',['actionConts']),
			// async getResults(page = 1){
			// 	this.laoding = true
				// await this.actionConts(page)
			// 	this.laoding = false
			// },
		}
	}
</script>
<style scoped>

</style>
