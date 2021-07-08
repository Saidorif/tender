<template>
	<div class="complaint">
        <Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-comment"></i>
				    {{$t('Murojat')}}
				</h4>
				<router-link class="btn btn-primary" to="/crm/complaint-list-user/add"><i class="fas fa-plus"></i> {{$t('Qoʼshish')}}</router-link>
		  	</div>
		  	<div class="card-body">
			  <div class="table-responsive">
				<table class="table table-bordered text-center table-hover table-striped">
					<thead>
						<tr>
							<th scope="col">№</th>
							<th scope="col">{{$t('Sarlovxa')}}</th>
							<th scope="col">{{$t('Tahrirlash')}}</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(compl,index) in getComplaints.data">
							<td scope="row">{{compl.id}}</td>
							<td>{{compl.name}}</td>
							<td>
								<router-link
                                    tag="button"
                                    class="btn_transparent"
                                    :to='`/crm/complaint/edit/${compl.id}`'
								>
									<i class="pe_icon pe-7s-edit editColor"></i>
								</router-link>
							</td>
						</tr>
					</tbody>
					<pagination :limit="4" :data="getComplaints" @pagination-change-page="getResults"></pagination>
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
                laoding: true,
			}
		},
		async mounted(){
            await this.actionComplaints()
            this.laoding = false
		},
		computed:{
			...mapGetters('complaint',['getComplaints','getMassage'])
		},
		methods:{
			...mapActions('complaint',['actionComplaints','actionDeleteComplaint']),
			async getResults(page = 1){
                this.laoding = true
				await this.actionComplaints(page)
                this.laoding = false
			},
			async deleteComplaint(id){
				if(confirm(this.$t('Siz chindan ham oʼchirishni xohlaysizmi?'))){
                    let page = 1
                    this.laoding = true
					await this.actionDeleteComplaint(id)
                    await this.actionComplaints(page)
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
