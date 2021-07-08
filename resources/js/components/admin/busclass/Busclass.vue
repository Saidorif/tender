<template>
	<div class="region">
        <Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-bus-alt"></i>
				    {{$t('Avtomobil sinfi')}}
				</h4>
				<router-link class="btn btn-primary" to="/crm/busclass/add">
					<i class="fas fa-plus"></i> {{$t('Qoʼshish')}}
				</router-link>
		  	</div>
		  	<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered text-center table-hover table-striped">
						<thead>
							<tr>
								<th scope="col">№</th>
								<th scope="col">{{$t('Avtomobil sinfi nomi')}}</th>
								<th scope="col">{{$t('Avtobus toifasi')}}</th>
								<!-- <th scope="col">{{$t('Avtomobil rusumi')}}</th> -->
								<!-- <th scope="col">{{$t('Oʼrindiqlar soni')}}</th> -->
								<!-- <th scope="col">{{$t('Oʼrindiqlar soni')}} (по)</th> -->
								<!-- <th scope="col">Пассажировместимость</th> -->
								<!-- <th scope="col">Пассажировместимость (по)</th> -->
								<th scope="col">{{$t('Tahrirlash')}}</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(bus,index) in getBusclasses.data">
								<td scope="row">{{bus.id}}</td>
								<td>{{bus.name}}</td>
								<td>{{bus.bustype ? bus.bustype.name : ''}}</td>
								<!-- <td>{{bus.model ? bus.model.name : ''}}</td> -->
								<!-- <td>{{bus.seat_from}}</td> -->
								<!-- <td>{{bus.seat_to}}</td> -->
								<!-- <td>{{bus.stay_from}}</td> -->
								<!-- <td>{{bus.stay_to}}</td> -->
								<td>
									<router-link
										tag="button"
										class="btn_transparent"
										:to='`/crm/busclass/edit/${bus.id}`'
										v-if="$can('edit', 'TClassController')"
									>
										<i class="pe_icon pe-7s-edit editColor"></i>
									</router-link>
									<button
										class="btn_transparent"
										@click="deleteType(bus.id)"
										v-if="$can('destroy', 'TClassController')"
									>
										<i class="pe_icon pe-7s-trash trashColor"></i>
									</button>
								</td>
							</tr>
						</tbody>
						<pagination :limit="4" :data="getBusclasses" @pagination-change-page="getResults"></pagination>
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
                laoding: true,
			}
		},
		async mounted(){
			let page = 1;
            await this.actionBusclasses(page)
            this.laoding = false
		},
		computed:{
			...mapGetters('busclass',['getBusclasses','getMassage']),
		},
		methods:{
			...mapActions('busclass',['actionBusclasses','actionDeleteBusclass']),
			async getResults(page = 1){
                this.laoding = true
				await this.actionBusclasses(page)
                this.laoding = false
			},
			async deleteType(id){
				if(confirm(this.$t('Siz chindan ham oʼchirishni xohlaysizmi?'))){
                    let page = 1
                    this.laoding = true
                    await this.actionDeleteBusclass(id)
					if (this.getMassage.success) {
						await this.actionBusclasses(page)
						toast.fire({
				            type: "success",
				            icon: "success",
				            title: this.getMassage.message
				          });
						this.$router.push("/crm/busclass");
						this.requiredInput = false
                    }
                    this.laoding = false
				}
			}
		}
	}
</script>
<style scoped>

</style>
