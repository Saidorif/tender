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
	  			<!-- 	<div class="col-md-3" v-if="loaded">
	  					<Bar :propchartdata="this.getDashboard.ages" propLabel="Yoshi" propColor="#f87979"/>
	  				</div>
	  				<div class="col-md-3" v-if="loaded">
	  					<Pie :propchartdata="this.getDashboard.staj" propLabel="Staj" propColor="#b87979"/>
	  				</div> -->
	  			</div>
		  	</div>
	  	</div>
	</div>
</template>
<script>
	// import Bar from './chart/Bar'
	// import Line from './chart/Line'
	// import Pie from './chart/Pie'
	import Loader from '../Loader'
	import {mapActions, mapGetters} from 'vuex'
	export default{
		components:{
			// Bar,
			// Line,
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


<Loader v-if="laoding"/>
import Loader from '../../Loader'
components:{
	Loader
},
laoding: true,
this.laoding = false

