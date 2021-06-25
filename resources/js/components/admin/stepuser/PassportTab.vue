<template>
  <div class="passport_tab">
    <h2 style="margin: 0;font-size: 20px;font-weight: bold;">{{ getDirection ? getDirection.name : '' }}</h2>
    <ul class="nav nav-tabs " id="myTab" role="tablist">
      <li class="nav-item">
        <router-link :to='`/crm/stepuser/titul-tab/${$route.params.directionId}`' > {{$t('Titul')}}</router-link>
      </li>
      <li class="nav-item">
        <router-link :to='`/crm/stepuser/timing-tab/${$route.params.directionId}`'>{{$t('Xronametraj')}}</router-link>
      </li>
      <li class="nav-item">
        <router-link :to='`/crm/stepuser/scheme-tab/${$route.params.directionId}`'>{{$t('Sxema')}}</router-link>
      </li>
      <li class="nav-item">
        <router-link :to='`/crm/stepuser/schedule-tab/${$route.params.directionId}`'> {{$t('Xarkatlanish jadvali')}}</router-link>
      </li>
      <li class="nav-item">
        <router-link :to='`/crm/stepuser/tarif-tab/${$route.params.directionId}`'>{{$t('Tarif')}}</router-link>
      </li>
      <li class="nav-item">
        <router-link :to='`/crm/stepuser/demand-tab/${$route.params.directionId}`'>{{$t('Talab')}}</router-link>
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
