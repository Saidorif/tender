<template id="countdown-template">
  <div class="countdown">
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
		    }
	  	}
	}
</script>
<style scoped>

	.countdown {
	  display: flex;
	}

	.block {
	    display: flex;
	    margin-right: 20px;
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
</style>