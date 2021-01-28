<template>
	<div class="dashboard">
		<Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon pe-7s-rocket"></i>
				    Админ панель
				</h4>
		  	</div>
		  	<div class="card-body">
	  			<div class="row">
	  				<div class="col-md-3 mb-3">
	  					<div class="bg-dashboard bg1">
	  						<router-link class="dashboard-link" to="/crm/direction" v-if="$can('index', 'DirectionController')">
				              <i class="peIcon fas fa-route"></i>
				              <p>
				                Направления
				              </p>
				            </router-link>
	  					</div>
	  				</div>
	  				<div class="col-md-3 mb-3">
	  					<div class="bg-dashboard bg2">
	  						<router-link class="dashboard-link" to="/crm/client" v-if="$can('carrier', 'UserController')">
				              <i class="peIcon pe-7s-users"></i>
				              <p>
				                Перевозчики
				              </p>
				            </router-link>
	  					</div>
	  				</div>
	  				<div class="col-md-3 mb-3">
	  					<div class="bg-dashboard bg3">
	  						<router-link class="dashboard-link" to="/crm/tenderannounce" v-if="$can('index', 'TenderController')">
				              <i class="peIcon fas fa-bullhorn"></i>
				              <p>
				                Объявить тендер
				              </p>
				            </router-link>
	  					</div>
	  				</div>
	  				<div class="col-md-3 mb-3">
	  					<div class="bg-dashboard bg4">
	  						<router-link class="dashboard-link" to="/crm/payment" v-if="$can('index', 'EmployeeController')">
				              <i class="peIcon fas fa-money-bill-alt"></i>
				              <p>
				                Платежи
				              </p>
				            </router-link>
	  					</div>
	  				</div>
	  				<div class="col-md-3 mb-3">
	  					<div class="bg-dashboard bg5">
	  						<router-link class="dashboard-link" to="/crm/complaint-list" v-if="$can('index', 'ComplaintCategoryController')">
				              <i class="peIcon fas fa-comment"></i>
				              <p>
			                    Список обращения
			                  </p>
				            </router-link>
	  					</div>
	  				</div>
	  				<div class="col-md-3 mb-3">
	  					<div class="bg-dashboard bg6">
	  						<router-link class="dashboard-link" to="/crm/apply" v-if="$can('index', 'ClientAccessController')">
				              <i class="peIcon fas fa-vote-yea"></i>
				              <p>
				                Доступ
				              </p>
				            </router-link>
	  					</div>
	  				</div>
	  				<div class="col-md-3 mb-3">
	  					<div class="bg-dashboard bg7">
	  						<router-link class="dashboard-link" to="/crm/contract-list" v-if="$can('checkTenders', 'TenderController')">
	  							<i class="peIcon fas fa-file"></i>
			                    <p>
			                    	Договора
			                    </p>
				            </router-link>
	  					</div>
	  				</div>
	  				<div class="col-md-3 mb-3">
	  					<div class="bg-dashboard bg8">
	  						<router-link class="dashboard-link" to="/crm/protocol-list" v-if="$can('checkTenders', 'TenderController')">
	  						  <i class="peIcon fas fa-file-alt"></i>	
			                  <p>
			                    Протокол
			                  </p>
				            </router-link>
	  					</div>
	  				</div>
	  			</div>
	  			<div class="row">
	  				<div class="col-md-4">
	  					<line-chart></line-chart>
	  				</div>
	  			</div>
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
