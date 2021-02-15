export const g = {
    toWord(id,name='document'){
      let header = "<html xmlns:o='urn:schemas-microsoft-com:office:office' "+
        "xmlns:w='urn:schemas-microsoft-com:office:word' "+
        "xmlns='http://www.w3.org/TR/REC-html40'>"+
        "<head><meta charset='utf-8'><title>Export HTML to Word Document with JavaScript</title></head><body>";
       let footer = "</body></html>";
       let sourceHTML = header+document.getElementById(id).innerHTML+footer;

       let source = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(sourceHTML);
       let fileDownload = document.createElement("a");
      document.body.appendChild(fileDownload);
      fileDownload.href = source;
      fileDownload.download = name+'.doc';
      fileDownload.click();
      document.body.removeChild(fileDownload);
    },
    getFirstLetter(name){
      if (name) {
          return name.substring(0,1)
      }
    },
  	getDate(date){
	    let new_date = new Date(date);
	    var month = new_date.getMonth()+1;
	    var day = new_date.getDate() <= 9 ? '0'+new_date.getDate() : new_date.getDate();
	    var year = new_date.getFullYear();
	    return day + "-" + month + "-" + year;
  	},
  	getTime(date){
  		let new_date = new Date(date);
	    var hour = new_date.getHours();
	    var minute = new_date.getMinutes();
	    return hour+'-'+minute;
  	},
  	checkPrefix(url){
  		if (url.includes("crm")) {
  			return false
  		}else{
  			return true
  		}
  	},
    stations(){
      return [
        {id:1,name:'Avtovokzal'},
        {id:2,name:'Avtostansiya'},
        {id:3,name:'Bekat'},
        {id:4,name:'Shox bekat'},
      ];
    },
    findStation(id){
      let result = ''
      let stations = [
        {id:1,name:'Avtovokzal'},
        {id:2,name:'Avtostansiya'},
        {id:3,name:'Bekat'},
        {id:4,name:'Shox bekat'},
      ]
      stations.forEach((station,index)=>{
        if (station.id == id) {
          result = station.name
        }
      })
      return result
    },
    replaceCommaToDot(val){
      if(val != ''){
        val = val.replace(/,/g, '.')
        return val
      }
    },
    getYear(year){
      if(year){
        let new_date = new Date(year);
        return new_date.getFullYear();
      }
    },
    getDay(day){
      if(day){
        // let new_date = new Date(day);
        let new_date = day.split('-')
        let myDay = Number(new_date[2]);
        return myDay;
      }
    },
    itemDate(day){
      if(day){
        let new_date = new Date(day).toLocaleDateString("en-US");
        let date = new_date.split('/')
        let month  = Number(date[0]) <= 9 ? '0'+date[0] : date[0]
        return date[2]+'-'+month+'-'+date[1];
      }
    },
    getMonth(month){
      if(month){
        let new_date = new Date(month);
        return new_date.getMonth();
      }
    },
    dateCounter(date,id){
      // Set the date we're counting down to
      let countDownDate = new Date(date).getTime();

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
        if(document.getElementById(id)){
            document.getElementById(id).innerHTML = `<div class="d-flex justify-content-center">
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
                document.getElementById(id).innerHTML = "<div class='btn btn-outline-info'>Завершено!</div>";
            }
        }

      }, 1000);
    },
    getMonthInLetter(date){
    if (date) {
      // let new_date = new Date(date);
      // let month = new_date.getMonth();
      let new_date = date.split('-')
      let month = Number(new_date[1]);
      let months=[
        {id:1,name:'январь'},
        {id:2,name:'февраль'},
        {id:3,name:'март'},
        {id:4,name:'апрель'},
        {id:5,name:'май'},
        {id:6,name:'июнь'},
        {id:7,name:'июль'},
        {id:8,name:'августь'},
        {id:9,name:'сентябрь'},
        {id:10,name:'октябрь'},
        {id:11,name:'ноябрь'},
        {id:12,name:'декабрь'},
      ];
      months.forEach((items,index)=>{
        if(month == items.id){
            name = items.name
        }
      })
      return name
    }else{
      return date
    }
  },
}
