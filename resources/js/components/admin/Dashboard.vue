<template>
	<div class="dashboard">
		<Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon pe-7s-rocket"></i>
				    {{$t('admin_menu.admin_panel')}}
				</h4>
		  	</div>
		  	<div class="card-body">
	  			<div class="row">
	  				<div class="col-xl-3 col-lg-4 col-md-6 mb-3" v-if="$can('index', 'DirectionController')">
	  					<div class="bg-dashboard bg1">
	  						<router-link class="dashboard-link" to="/crm/direction">
				              <i class="peIcon fas fa-route"></i>
				              <p>
				                {{$t('Yoʼnalish')}}
				              </p>
				            </router-link>
	  					</div>
	  				</div>
	  				<div class="col-xl-3 col-lg-4 col-md-6 mb-3" v-if="$can('carrier', 'UserController')">
	  					<div class="bg-dashboard bg2">
	  						<router-link class="dashboard-link" to="/crm/client">
				              <i class="peIcon pe-7s-users"></i>
				              <p>
				                {{$t('Tashuvchilar')}}
				              </p>
				            </router-link>
	  					</div>
	  				</div>
	  				<div class="col-xl-3 col-lg-4 col-md-6 mb-3" v-if="$can('index', 'TenderController')">
	  					<div class="bg-dashboard bg3">
	  						<router-link class="dashboard-link" to="/crm/tenderannounce">
				              <i class="peIcon fas fa-bullhorn"></i>
				              <p>
				                {{$t('Tender eʼlon qilish')}}
				              </p>
				            </router-link>
	  					</div>
	  				</div>
	  				<div class="col-xl-3 col-lg-4 col-md-6 mb-3" v-if="$can('index', 'EmployeeController')">
	  					<div class="bg-dashboard bg4">
	  						<router-link class="dashboard-link" to="/crm/payment">
				              <i class="peIcon fas fa-money-bill-alt"></i>
				              <p>
				                {{$t('Toʼlovlar')}}
				              </p>
				            </router-link>
	  					</div>
	  				</div>
	  				<div class="col-xl-3 col-lg-4 col-md-6 mb-3" v-if="$can('index', 'ComplaintCategoryController')">
	  					<div class="bg-dashboard bg5">
	  						<router-link class="dashboard-link" to="/crm/complaint-list">
				              <i class="peIcon fas fa-comment"></i>
				              <p>
			                     {{$t('Murojaatlar ro‘yxati')}}
			                  </p>
				            </router-link>
	  					</div>
	  				</div>
	  				<div class="col-xl-3 col-lg-4 col-md-6 mb-3" v-if="$can('index', 'ClientAccessController')">
	  					<div class="bg-dashboard bg6">
	  						<router-link class="dashboard-link" to="/crm/apply">
				              <i class="peIcon fas fa-vote-yea"></i>
				              <p>
				                {{$t('Ruxsat')}}
				              </p>
				            </router-link>
	  					</div>
	  				</div>
	  				<div class="col-xl-3 col-lg-4 col-md-6 mb-3" v-if="$can('checkTenders', 'TenderController')">
	  					<div class="bg-dashboard bg7">
	  						<router-link class="dashboard-link" to="/crm/contract-list">
	  							<i class="peIcon fas fa-file"></i>
			                    <p>
			                    	{{$t('Shartnomalar')}}
			                    </p>
				            </router-link>
	  					</div>
	  				</div>
	  				<div class="col-xl-3 col-lg-4 col-md-6 mb-3" v-if="$can('checkTenders', 'TenderController')">
	  					<div class="bg-dashboard bg8">
	  						<router-link class="dashboard-link" to="/crm/protocol-list">
	  						  <i class="peIcon fas fa-file-alt"></i>
			                  <p>
			                    {{$t('Bayonnoma')}}
			                  </p>
				            </router-link>
	  					</div>
	  				</div>
	  			</div>
	  			<!-- <div class="row">
	  				<div class="col-md-6">
	  					<line-chart></line-chart>
	  				</div>
	  			</div> -->
		  	</div>
	  	</div>
	</div>
</template>
<script>
	// import Bar from './chart/Bar'
	import LineChart from './chart/Line'
	// import Pie from './chart/Pie'
	import Loader from '../Loader'
	import {mapActions, mapGetters} from 'vuex'
	export default{
		components:{
			// Bar,
			LineChart,
			// Pie,
			Loader
		},
		data(){
			return{
				loaded: false,
				laoding: true
			}
		},
		computed:{
			...mapGetters('dashboard',['getDashboard'])
		},
		methods:{
			...mapActions('dashboard',['actionDashboard'])
		},
		async mounted(){
			await this.actionDashboard()
			this.loaded = true
			this.laoding = false
		}
	}
</script>
<style scoped>
	.bg1{
		background-color:#ea606d;
	}
	.bg2{
		background-color:#bb5ca7;
	}
	.bg3{
		background-color:#844025;
	}
	.bg4{
		background-color:#38b1b7;
	}
	.bg5{
		background-color:#393940;
	}
	.bg6{
		background-color:#4497ff;
	}
	.bg7{
		background-color:#217d20;
	}
	.bg8{
		background-color:#4d44ff;
	}
	.bg-dashboard .peIcon{
		color:white !important;
	}
	.bg-dashboard{
		color:white !important;
		border-radius:2px;
	}
	.dashboard-link{
		display: flex;
	    align-items: center;
	    justify-content: center;
	    height: 100px;
	    font-size: 20px;
	    font-weight: bold;
		color:white !important;
		text-decoration: none;
	}
	.dashboard-link p{
		margin-bottom:0;
	}
</style>
