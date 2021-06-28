<template>
	<div class="edit_certificate">
		<Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-file"></i>
				     {{$t('Guvoxnomani tahrirlash')}}
				</h4>
                <div class="d-flex">
                    <button type="button" class="btn btn-warning mr-3"  @click="$g.printDoc('prindDiv')" >
                        <i class="fas fa-print mr-2"></i>{{$t('Chop etish')}}
                    </button>
                    <router-link class="btn btn-primary back_btn" to="/crm/certificate">
                        <span class="peIcon pe-7s-back"></span>
                            {{$t('Orqaga')}}
                    </router-link>
                </div>
		  	</div>
		  	<div class="card-body">
                <div id="prindDiv" style="width:21cm;height:29.7cm;padding:0px 50px;">
                    <div align="center" style="margin-top:30px;"><img src="/img/gerb.png" width="111px"></div>
                    <h2 style="text-align:center;font-size:17.265914px;font-weight:bold;font-family:'Times New Roman';margin-top:30px;margin-bottom:30px">{{$t('O‘ZBEKISTON RESPUBLIKASI TRANSPORT VAZIRLIGI')}}</h2>
                    <p style="text-align:center;font-size:17.265914px;font-weight:normal;font-family:'Times New Roman';margin-top:0px;margin-bottom:0px">
                        <u style="text-decoration: underline;">{{form.seria}}{{form.number}}</u> -{{$t('son')}} <u style="text-decoration: underline;">{{form.direction ? form.direction.name : ''}}</u>-{{$t('nomli')}}
                    </p>
                    <p style="text-align:center;font-size:17.265914px;font-weight:normal;font-family:'Times New Roman';margin-top:0px;margin-bottom:30px">{{$t('yo‘nalishda qatnovlarni amalga oshirish huquqini tasdiqlovchi')}} </p>
                    <h2 style="text-align:center;font-size:17.265914px;font-weight:bold;font-family:'Times New Roman';margin-top:30px;margin-bottom:30px">{{$t('GUVOHNOMA')}}</h2>
                    <div style="text-align: center; margin-top: 10px">
                        <p style="padding-bottom: 2px;margin: 0px;text-align: left;font-size: 15px;line-height: 20px;font-family:'Times New Roman';">
                            {{$t('Ushbu guvohnoma')}} <b style="width: 70%;border-bottom: 1px solid;display: inline-block;text-align:center;font-family:'Times New Roman';">{{form.company_name}}</b> {{$t('ga')}}
                        </p>
                        <small style="font-size: 13px;font-family:'Times New Roman';">({{$t('tashuvchining nomi')}})</small>
                    </div>
                    <div style="text-align: center; margin-top: 10px">
                        <p style="padding-bottom: 2px;margin: 0px;text-align: left;font-size: 15px;line-height: 20px;font-family:'Times New Roman';">
                            {{$t('guvohnoma egasi')}}
                            <b style="width: 45%;border-bottom: 1px solid;display: inline-block;text-align:center;font-family:'Times New Roman';">{{$g.getDate(form.exp_date)}}</b> {{$t('dagi')}}
                            <b style="width: 20%;border-bottom: 1px solid;display: inline-block;text-align:center;font-family:'Times New Roman';">{{form.number}}</b> - {{$t('sonli')}}
                        </p>
                        <small style="font-size: 13px;font-family:'Times New Roman';">({{$t('shartnoma sanasi va raqami')}})</small>
                    </div>
                     <p style="text-align:left;font-size:15px;font-weight:normal;font-family:'Times New Roman';margin-top:0px;">{{$t('shartnomaga asosan')}} </p>
		  		</div>

		  		<!-- <div>
					{{$t('Ushbu guvohnoma')}} {{form.company_name}} {{$t('ga')}}
	          		({{$t('tashuvchining nomi')}})
		  		</div>
		  		<div>
					guvohnoma egasi____________________________dagi_________-sonli
					                                                           hartnoma sanasi va raqami)
					shartnomaga asosan
		  		</div>
				<div>
					guvohnoma raqami __________________ davlat raqami________________________
		            (avtotransport vositasi ro‘yxatdan o‘tkazilganligi to‘g‘risidagi ma’lumotlar)
				</div>
				<div>
					rusumi____________________________________________________bo‘lgan
					(yo‘nalishda qatnovchi avtotransport vositasiga tegishli ma’lumotlar)
				</div>
				<div>
					avtotransport vositasida
					____- sonli_______________________________________yo‘nalishda
                 	(yo‘nalish raqami va nomi)
				</div>
				<div>
					__________________________________________________sanasigacha
	                          (guvohnomaning amal qilish muddati)
				</div>
				<div>
					qatnovlarni amalga oshirish huquqiga egaligini tasdiqlaydi.
				</div>
				<div>
				    <img :src='"/"+form.qr_code' alt="">
              	</div>
              	<div>
					{{form.seria}} {{form.number}}
              	</div> -->
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
			...mapGetters('certificate',['getMassage','getCertificate'])
		},
		async mounted(){
			await this.actionEditCertificate(this.$route.params.certificateId)
			this.laoding = false
			this.form = this.getCertificate
            console.log( this.getCertificate)
		},
		methods:{
			...mapActions('certificate',['actionUpdateCertificate','actionEditCertificate']),
			isRequired(input){
	    		return this.requiredInput && input === '';
		    },
			async saveCertificate(){
		    	if (this.form.name != ''){
					this.laoding = true
					await this.actionUpdateCertificate(this.form)
					if (this.getMassage.success) {
						toast.fire({
					    	type: 'success',
					    	icon: 'success',
							title: this.getMassage.message,
					    })
						this.$router.push("/crm/certificate");
						this.requiredInput = false
					}
					this.laoding = false
				}else{
					this.requiredInput = true
				}
		    }
		}
	}
</script>
<style scoped>
    .card-body{
        display: flex;
        justify-content: center;
    }
    #prindDiv{
        border: 1px solid red;
    }
</style>
