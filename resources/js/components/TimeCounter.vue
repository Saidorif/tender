<template>
  <div class="countdown" v-if="defineDate">
    <div class="block">
      <p class="digit">{{ days | two_digits }}</p>
      <p class="text">день</p>
    </div>
    <div class="block">
      <p class="digit">{{ hours | two_digits }}</p>
      <p class="text">час</p>
    </div>
    <div class="block">
      <p class="digit">{{ minutes | two_digits }}</p>
      <p class="text">минут</p>
    </div>
    <div class="block">
      <p class="digit">{{ seconds | two_digits }}</p>
      <p class="text">секунд</p>
    </div>
  </div>
  <div v-else>
  	<div class='btn btn-color'>Завершено!</div>
  </div>
</template>
<script>
	export default{
		filters: {
		  two_digits: function (value) {
		    if (value < 0) {
			    return '00';
			  }
		  	if (value.toString().length <= 1) {
			    return `0${value}`;
		  	}	
		  	return value;
		  }
		},
		mounted() {
		    window.setInterval(() => {
		        this.now = Math.trunc((new Date()).getTime() / 1000);
		    },1000);
  		},
	  	props: {
		    date: {
		      type: String
		    }
	  	},
	  	data() {
		    return {
		      now: Math.trunc((new Date()).getTime() / 1000)
		    }
	  	},
	  	computed: {
	  		defineDate(){
	  			let now = Math.trunc(Date.parse(this.date) / 1000);
	  			let date = Math.trunc((new Date()).getTime() / 1000)
	  			if(now >= date){
	  				return true
	  			}else{
	  				return false
	  			}
	  		},
		    dateInMilliseconds() {
		      return Math.trunc(Date.parse(this.date) / 1000)
		    },
		    seconds() {
		      return (this.dateInMilliseconds - this.now) % 60;
		    },
		    minutes() {
		      return Math.trunc((this.dateInMilliseconds - this.now) / 60) % 60;
		    },
		    hours() {
		      return Math.trunc((this.dateInMilliseconds - this.now) / 60 / 60) % 24;
		    },
		    days() {
		      return Math.trunc((this.dateInMilliseconds - this.now) / 60 / 60 / 24);
		    },
	  	}
	}
</script>
<style scoped>
	.countdown {
	  display: flex;
	  justify-content: center;
	  align-items:center;
	}

	.block {
	    display: flex;
	    margin-right: 20px;
	}
	.block p{
		margin-bottom:0 !important;
	}
	.text {
	    color: #1abc9c;
	    font-size: 20px;
	    font-family: 'Roboto Condensed', serif;
	    font-weight: 40;
	    text-align: center;
	}

	.digit {
        color: #2a3d42;
	    font-size: 20px;
	    font-weight: 100;
	    font-family: 'Roboto', serif;
	    text-align: center;
	}
	.btn-color{
		color:#1abc9c;
		border:2px solid #1abc9c;
		font-weight:bold;
	}
</style>