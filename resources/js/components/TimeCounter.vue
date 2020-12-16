<template>
	<div :id='id'></div>
</template>
<script>
	export default{
		props:['date','id'],
		mounted(){
			let countDownDate = new Date(this.date).getTime();
			  // Update the count down every 1 second
		  	let x = setInterval(function() {

		    // Get today's date and time
		    let now = new Date().getTime();

		    // Find the distance between now and the count down date
		    let distance = countDownDate - now;

		    // Time calculations for days, hours, minutes and seconds
		    let days = Math.floor(distance / (1000 * 60 * 60 * 24));
		    let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
		    let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
		    let seconds = Math.floor((distance % (1000 * 60)) / 1000);

		    // Display the result in the element with id=id
		    document.getElementById(this.id).innerHTML = `<div class="d-flex justify-content-center">
		      <div class="time_counter">
		        <div>${days}</div>
		        <div>день</div>
		      </div>
		      <div class="time_counter">
		        <div>${hours}</div>
		        <div>час</div>
		      </div>
		      <div class="time_counter">
		        <div>${minutes}</div>
		        <div>минут</div>
		      </div>
		      <div class="time_counter">
		        <div>${seconds}</div>
		        <div>секунд</div>
		      </div>
		    </div>`;

		    // If the count down is finished, write some text
		    if (distance < 0) {
		      clearInterval(x);
		      document.getElementById(this.id).innerHTML = "<div class='btn btn-outline-info'>Завершено!</div>";
		    }
		  }, 1000);
		}
	}
</script>
<style scoped>
	.time_counter{
	    background-color: #292666;
	    border-radius: 5px;
	    color: white;
	    font-weight: 600;
	    padding: 0 5px;
	    font-size: 14px;
	    margin-right:3px;
	}
</style>