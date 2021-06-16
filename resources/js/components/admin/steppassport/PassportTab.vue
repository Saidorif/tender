<template>
  <div class="passport_tab">
    <h2 style="margin: 0;font-size: 20px;font-weight: bold;">{{ getDirection ? getDirection.name : '' }}</h2>
    <ul class="nav nav-tabs " id="myTab" role="tablist">
      <li class="nav-item">
        <router-link :to='`/crm/direction/titul-tab/${$route.params.directionId}`' >  Titul</router-link>
      </li>
      <li class="nav-item">
        <router-link :to='`/crm/direction/timing-tab/${$route.params.directionId}`'> Xronametraj</router-link>
      </li>
      <li class="nav-item">
        <router-link :to='`/crm/direction/scheme-tab/${$route.params.directionId}`'> Sxema</router-link>
      </li>
      <li class="nav-item">
        <router-link :to='`/crm/direction/schedule-tab/${$route.params.directionId}`'> Xarkatlanish jadvali</router-link>
      </li>
      <li class="nav-item">
        <router-link :to='`/crm/direction/tarif-tab/${$route.params.directionId}`'> Tarif</router-link>
      </li>
      <li class="nav-item">
        <router-link :to='`/crm/direction/demand-tab/${$route.params.directionId}`'>Talab</router-link>
      </li>
    </ul>
    <!-- <router-link class="btn btn-primary back_btn" to="/crm/direction">
      <span class="peIcon pe-7s-back"></span>
      {{$t('Orqaga')}}
    </router-link> -->
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
            ...mapGetters("direction", ["getDirection",'getMassage']),
		},
		methods:{
		}
	}
</script>
<style scoped>
    .passport_tab{
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>
