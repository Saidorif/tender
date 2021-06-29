<template>
	<div class="edit_certificate">
		<Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-file"></i>
				     {{$t('Guvoxnomani tahrirlash')}}
				</h4>
				<router-link class="btn btn-primary back_btn" to="/crm/usercertificate">
					<span class="peIcon pe-7s-back"></span>
						{{$t('Orqaga')}}
				</router-link>
		  	</div>
            <div class="card-body">
                <div id="prindDiv" style="width:21cm;height:25cm;padding:0px 50px;box-shadow: 0px 5px 10px 2px rgba(34, 60, 80, 0.2);">
                    <div align="center" class="gerb_div"><img src="/img/gerb.png" width="111px"></div>
                    <h2 style="text-align:center;font-size:17.265914px;font-weight:bold;font-family:'Times New Roman';margin-top:30px;margin-bottom:10px">{{$t('O‘ZBEKISTON RESPUBLIKASI TRANSPORT VAZIRLIGI')}}</h2>
                    <p style="text-align:center;font-size:17.265914px;font-weight:normal;font-family:'Times New Roman';margin-top:0px;margin-bottom:0px">
                        <u style="text-decoration: underline;">{{form.seria}}{{form.number}}</u> -{{$t('son')}} <u style="text-decoration: underline;">{{form.direction ? form.direction.name : ''}}</u>-{{$t('nomli')}}
                    </p>
                    <p style="text-align:center;font-size:17.265914px;font-weight:normal;font-family:'Times New Roman';margin-top:0px;margin-bottom:30px">{{$t('yo‘nalishda qatnovlarni amalga oshirish huquqini tasdiqlovchi')}} </p>
                    <h2 style="text-align:center;font-size:17.265914px;font-weight:bold;font-family:'Times New Roman';margin-top:30px;margin-bottom:30px">{{$t('GUVOHNOMA')}}</h2>
                    <div style="text-align: center; margin-top: 10px">
                        <p style="padding-bottom: 2px;margin: 0px;text-align: left;font-size: 15px;line-height: 20px;font-family:'Times New Roman';">
                            {{$t('Ushbu guvohnoma')}} <b style="width: 70%;border-bottom: 1px solid;display: inline-block;text-align:center;font-family:'Times New Roman';">{{form.company_name}}</b> {{$t('ga')}}
                        </p>
                        <small style="font-size: 13px;font-family:'Times New Roman';font-style: italic;">({{$t('tashuvchining nomi')}})</small>
                    </div>
                    <div style="text-align: center; margin-top: 10px">
                        <p style="padding-bottom: 2px;margin: 0px;text-align: left;font-size: 15px;line-height: 20px;font-family:'Times New Roman';">
                            {{$t('guvohnoma egasi')}}
                            <b style="width: 45%;border-bottom: 1px solid;display: inline-block;text-align:center;font-family:'Times New Roman';">{{form.contract ? $g.getDate(form.contract.date) : ''}} {{$t('yil')}}</b> {{$t('dagi')}}
                            <b style="width: 20%;border-bottom: 1px solid;display: inline-block;text-align:center;font-family:'Times New Roman';">{{form.contract ? form.contract.number : ''}}</b> - {{$t('sonli')}}
                        </p>
                        <small style="font-size: 13px;font-family:'Times New Roman';font-style: italic;">({{$t('shartnoma sanasi va raqami')}})</small>
                    </div>
                     <p style="text-align:left;font-size:15px;font-weight:normal;font-family:'Times New Roman';margin-top:0px;">{{$t('shartnomaga asosan')}} </p>
                    <div style="text-align: center; margin-top: 10px">
                        <p style="padding-bottom: 2px;margin: 0px;text-align: left;font-size: 15px;line-height: 20px;font-family:'Times New Roman';">
                            <i>{{$t('guvohnoma raqami')}}</i>
                            <b style="width: 30%;border-bottom: 1px solid;display: inline-block;text-align:center;font-family:'Times New Roman';">{{form.car?form.car.auto_number:''}} </b> <i>{{$t('davlat raqami')}}</i>
                            <b style="width: 30%;border-bottom: 1px solid;display: inline-block;text-align:center;font-family:'Times New Roman';">{{form.car ? form.car.busmarka.name : '' }}</b>
                        </p>
                        <small style="font-size: 13px;font-family:'Times New Roman';font-style: italic;">({{$t('avtotransport vositasi ro‘yxatdan o‘tkazilganligi to‘g‘risidagi ma’lumotlar')}})</small>
                    </div>
                    <div style="text-align: center; margin-top: 10px">
                        <p style="padding-bottom: 2px;margin: 0px;text-align: left;font-size: 15px;line-height: 20px;font-family:'Times New Roman';">
                            <i>{{$t('rusumi')}}</i>
                            <b style="width: 80%;border-bottom: 1px solid;display: inline-block;text-align:center;font-family:'Times New Roman';">{{$t('texpasport')}}  AAF 0946926, {{$t('litsenziya varaqasi')}} {{form.car.license_number}}  </b> <i>{{$t('bo‘lgan')}}</i>
                        </p>
                        <small style="font-size: 13px;font-family:'Times New Roman';font-style: italic;">({{$t('yo‘nalishda qatnovchi avtotransport vositasiga tegishli ma’lumotlar')}})</small>
                    </div>
                     <p style="text-align:left;font-size:15px;font-weight:normal;font-family:'Times New Roman';margin-top:0px;">{{$t('avtotransport vositasida')}} </p>
                    <div style="text-align: center; margin-top: 10px">
                        <p style="padding-bottom: 2px;margin: 0px;text-align: left;font-size: 15px;line-height: 20px;font-family:'Times New Roman';">
                            <b style="width: 84%;border-bottom: 1px solid;display: inline-block;text-align:center;font-family:'Times New Roman';" v-if="form.direction">{{ form.direction.type ? form.direction.type.type : ''}}-{{form.direction.pass_number}}- {{$t('sonli')}} {{form.direction.name}}</b><i> {{$t('yo‘nalishda')}}</i>
                        </p>
                        <small style="font-size: 13px;font-family:'Times New Roman';font-style: italic;">({{$t('Yoʼnalish raqami va nomi')}})</small>
                    </div>
                    <div style="text-align: center; margin-top: 10px">
                        <p style="padding-bottom: 2px;margin: 0px;text-align: left;font-size: 15px;line-height: 20px;font-family:'Times New Roman';">
                            <b style="width: 84%;border-bottom: 1px solid;display: inline-block;text-align:center;font-family:'Times New Roman';">{{$g.getDate(form.exp_date)}} {{$t('yil')}}</b><i> {{$t('sanasigacha')}}</i>
                        </p>
                        <small style="font-size: 13px;font-family:'Times New Roman';font-style: italic;">({{$t('guvohnomaning amal qilish muddati')}})</small>
                    </div>
                     <p style="text-align:left;font-size:15px;font-weight:normal;font-family:'Times New Roman';margin-top:0px;">{{$t('qatnovlarni amalga oshirish huquqiga egaligini tasdiqlaydi.')}} </p>
                    <div align="right"><img :src="'/'+form.qr_code"  width="100"></div>
                     <p style="text-align:center;font-size:15px;font-weight:normal;font-family:'Times New Roman';margin-top:0px;">
                        {{form.seria}} {{form.number}}
                     </p>

                  </div>
		  	</div>
	  	</div>
	</div>
</template>
<script>
	import { mapGetters , mapActions } from 'vuex'
	import Loader from '../../Loader'
	export default{
		components:{
			Loader
		},
		data(){
			return{
				form:{
					name:''
				},
				requiredInput:false,
				laoding: true
			}
		},
		computed:{
			...mapGetters('certificate',['getMassage','getUserCertificate'])
		},
		async mounted(){
			await this.actionEditUserCertificate(this.$route.params.usercertificateId)
			this.laoding = false
			this.form = this.getUserCertificate
		},
		methods:{
			...mapActions('certificate',['actionUpdateCertificate','actionEditUserCertificate']),
			isRequired(input){
	    		return this.requiredInput && input === '';
		    },
		}
	}
</script>
<style scoped>
    .card-body{
        display: flex;
        justify-content: center;
    }
    .gerb_div{
        margin-top: 30px;
    }
</style>
