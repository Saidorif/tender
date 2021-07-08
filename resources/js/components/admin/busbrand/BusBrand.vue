<template>
	<div class="region">
        <Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-bus"></i>
				    {{$t('Avtobus markasi')}}
				</h4>
				<router-link class="btn btn-primary" to="/crm/busbrand/add">
					<i class="fas fa-plus"></i> {{$t('Qoʼshish')}}
				</router-link>
		  	</div>
		  	<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered text-center table-hover table-striped">
						<thead>
							<tr>
								<th scope="col">№</th>
								<th scope="col">{{$t('Marka nomi')}}</th>
								<th scope="col">{{$t('Tahrirlash')}}</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(model,index) in getBusBrands.data">
								<td scope="row">{{model.id}}</td>
								<td>{{model.name}}</td>
								<td>
									<router-link
										tag="button"
										class="btn_transparent"
										:to='`/crm/busbrand/edit/${model.id}`'
										v-if="$can('edit', 'BusMarkaController')"
									>
										<i class="pe_icon pe-7s-edit editColor"></i>
									</router-link>
									<button
										class="btn_transparent"
										@click="deleteType(model.id)"
										v-if="$can('destroy', 'BusMarkaController')"
									>
										<i class="pe_icon pe-7s-trash trashColor"></i>
									</button>
								</td>
							</tr>
						</tbody>
						<pagination :limit="4" :data="getBusBrands" @pagination-change-page="getResults"></pagination>
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
            await this.actionBusBrands()
            this.laoding = false
		},
		computed:{
			...mapGetters('busbrand',['getBusBrands','getMassage'])
		},
		methods:{
			...mapActions('busbrand',['actionBusBrands','actionDeleteBusBrand']),
			async getResults(page = 1){
                this.laoding = true
				await this.actionBusBrands(page)
                this.laoding = false
			},
			async deleteType(id){
				if(confirm(this.$t('Siz chindan ham oʼchirishni xohlaysizmi?'))){
                    let page = 1
                    this.laoding = true
                    await this.actionDeleteBusBrand(id)
					if (this.getMassage.success) {
						await this.actionBusBrands(page)
						toast.fire({
				            type: "success",
				            icon: "success",
				            title: this.getMassage.message
				          });
						this.$router.push("/crm/typeofbus");
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
