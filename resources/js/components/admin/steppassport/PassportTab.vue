<template>
  <div class="passport_tab">
    <ul class="nav nav-tabs " id="myTab" role="tablist">
      <li class="nav-item">
        <router-link :to='`/crm/direction/titul-tab/${$route.params.directionId}`'>Titul</router-link>
      </li>
      <li class="nav-item">
        <router-link :to='`/crm/direction/timing-tab/${$route.params.directionId}`'>Xronametraj</router-link>
      </li>
      <li class="nav-item">
        <router-link :to='`/crm/direction/scheme-tab/${$route.params.directionId}`'>Sxema</router-link>
      </li>
      <li class="nav-item">
        <router-link :to='`/crm/direction/schedule-tab/${$route.params.directionId}`'>Xarkatlanish jadvali</router-link>
      </li>
      <li class="nav-item">
        <router-link :to='`/crm/direction/tarif-tab/${$route.params.directionId}`'>Tarif</router-link>
      </li>
      <li class="nav-item">
        <router-link :to='`/crm/direction/demand-tab/${$route.params.directionId}`'>Talab</router-link>
      </li>
    </ul>
    <router-link class="btn btn-primary back_btn" to="/crm/direction">
      <span class="peIcon pe-7s-back"></span> 
      Назад
    </router-link>
  </div>
</template>
<script>
	import { mapGetters , mapActions } from 'vuex'
	export default{
        components: {
        },
		data(){
			return{

			}
		},
		mounted(){
		},
		computed:{
		},
		methods:{
		}
	}
</script>
<style scoped>
	.nav-item{
    padding: 0px 10px;
  }
  .passport_tab{
    display: flex;
    justify-content: space-between;
    width: 100%;
    align-items: center;
  }
</style>