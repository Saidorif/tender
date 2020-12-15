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
        {id:3,name:'Oraliq bekat'},
        {id:4,name:'Shox bekat'},
      ];
    },
    findStation(id){
      let result = ''
      let stations = [
        {id:1,name:'Avtovokzal'},
        {id:2,name:'Avtostansiya'},
        {id:3,name:'Oraliq bekat'},
        {id:4,name:'Shox bekat'},
      ]
      stations.forEach((station,index)=>{
        if (station.id == id) {
          result = station.name
        }
      })
      return result
    }
}
