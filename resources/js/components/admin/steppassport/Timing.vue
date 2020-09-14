<template>
    <div class="row tabRow">
        <div class="form-group col-md-6 double_input">
            <label for="station_name">Oraliq toxtash bekatlari nomlari</label>
            <input
                type="text"
                class="form-control input_style"
                id="station_name"
                placeholder="Bekatdan"
                v-model="form.station.from"
            />
            <input
                type="text"
                class="form-control input_style"
                id="station_name"
                placeholder="Bekatga"
                v-model="form.station.from"
            />
        </div>
    </div>
</template>
<script>
	import { mapGetters , mapActions } from 'vuex'
	export default{
		data(){
			return{
                form: {
                    station: {
                        from: '',
                        to: ''
                    }
                }
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
	.tabRow{
        padding-left: 30px;
        padding-right: 30px;
    }
    .double_input{
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
    }
    .double_input label{
        width: 100%;
    }
    .double_input input{
        width: 49%;
    }
</style>