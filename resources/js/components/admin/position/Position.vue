<template>
	<div class="role">
		<Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i  class="peIcon pe-7s-graph1"></i>
				    {{$t('Lavozim')}}
				</h4>
				<router-link
					class="btn btn-primary"
					to="/crm/position/add"
					v-if="$can('store', 'PositionController')"
				>
					<i class="fas fa-plus"></i>
					{{$t('Qoʼshish')}}
				</router-link>
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
						<tr v-for="(position,index) in getPositions.data">
							<td scope="row">{{position.id}}</td>
							<td>{{position.name}}</td>
							<td>
								<router-link tag="button" class="btn_transparent"
									:to='`/crm/position/edit/${position.id}`'
									v-if="$can('edit', 'PositionController')"
								>
									<i class="pe_icon pe-7s-edit editColor"></i>
								</router-link>
								<button
									class="btn_transparent"
									@click="deletePosition(position.id)"
									v-if="$can('destroy', 'PositionController')"
								>
									<i class="pe_icon pe-7s-trash trashColor"></i>
								</button>
							</td>
						</tr>
					</tbody>
					<pagination :limit="4" :data="getPositions" @pagination-change-page="getResults"></pagination>
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
			let page = 1;
			await this.actionPositions()
			this.laoding = false
		},
		computed:{
			...mapGetters('position',['getPositions','getMassage'])
		},
		methods:{
			...mapActions('position',['actionPositions','actionDeletePosition']),
			async getResults(page = 1){
				this.laoding = true
				await this.actionPositions(page)
				this.laoding = false
			},
			async deletePosition(id){
				if(confirm(this.$t('Siz chindan ham oʼchirishni xohlaysizmi?'))){
					let page = 1;
                    this.laoding = true
					await this.actionDeletePosition(id)
					await this.actionPositions(page)
                    this.laoding = false
					toast.fire({
				    	type: 'success',
				    	icon: 'success',
						title: this.$t('Oʼchirildi'),
				    })
				}
			}
		}
	}
</script>
<style scoped>

</style>
