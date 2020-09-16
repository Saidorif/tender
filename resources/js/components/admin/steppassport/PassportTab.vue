<template>
	<div class="area">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="timing-tab" data-toggle="tab" href="#timing" role="tab" aria-controls="timing" aria-selected="true">Timing</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Profile</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="timing" role="tabpanel" aria-labelledby="home-tab">
                <Timing  />
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
        </div>
	</div>
</template>
<script>
	import { mapGetters , mapActions } from 'vuex'
	import Timing  from './Timing'
	export default{
        components: {
            Timing
        },
		data(){
			return{

			}
		},
		async mounted(){
		},
		computed:{
		},
		methods:{
		}
	}
</script>
<style scoped>
	
</style>