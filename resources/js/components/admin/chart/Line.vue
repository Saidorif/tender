<!-- <template>
	<canvas ref="canvas" height="400"></canvas>
</template>
<script>
import { Pie } from 'vue-chartjs'
export default {
  extends: Pie ,
	props: ['propchartdata', 'propLabel', 'propColor'],
	data(){
		return{
			chartdata: {
				labels: Object.keys(this.propchartdata),
				datasets: [
					{
						label: this.propLabel,
						backgroundColor: this.propColor,
						data: Object.values(this.propchartdata)
					}
        ],
			},
			options: {
        type: Object,
        default: null
			},
		}
	},
	mounted () {
		this.renderChart(this.chartdata, this.options)
	}
} -->
<script>
  import { Line } from 'vue-chartjs'
  import { mapGetters , mapActions } from 'vuex'
  export default {
    extends: Line,
    data () {
      return {
        chartData: {
          labels: ["Babol",	"Cabanatuan",	"Daegu",	"Jerusalem",	"Fairfield",	"New York",	"Gangtok", "Buenos Aires", "Hafar Al-Batin", "Idlib"],
          datasets: [
            {
              label: 'Направления по республике',
              data: [600,	1150,	342,	6050,	2522,	3241,	1259,	157,	1545, 9841],
              fill: false,
              borderColor: '#2554FF',
              backgroundColor: '#2554FF',
              borderWidth: 1
            },
          ]
        },
        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true
              },
              gridLines: {
                display: true
              }
            }],
            xAxes: [ {
              gridLines: {
                display: false
              }
            }]
          },
          legend: {
            display: true
          },
          responsive: true,
          maintainAspectRatio: false
        }
      }
    },
    computed:{
		...mapGetters('region',['getRegionList','getMassage']),
		regions(){
			let regions = this.getRegionList;
			if(regions.length > 0){
				return regions.map((region,index)=>{
					return region.name
				})
			}
		}
	},
    methods:{
		...mapActions('region',['actionRegionList','actionDeleteRegion']),
	},
    async mounted () {
      await this.actionRegionList()
      this.renderChart(this.chartData, this.options)
    }
  }
</script>