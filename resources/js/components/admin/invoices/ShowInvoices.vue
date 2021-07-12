<template>
	<div class="payment">
		<Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-money-bill-alt"></i>
				   {{$t('Hisob-faktura')}}
				</h4>
                <router-link class="btn btn-primary back_btn" to="/crm/invoices">
                    <span class="peIcon pe-7s-back"></span> {{$t('Orqaga')}}
                </router-link>
		  	</div>
                <div class="card-body">
                    <div class="invoice_blank printThisShowInvoise" id="invoice_blank" style="padding-top: 50px;position:relative;">
                    <h2  class="invoice_blank_title" style="margin-top: 30px;font-size: 18px;font-weight: bolder;text-align: center;margin-bottom: 50зч;text-transform:uppercase;">Ҳисоб-фактура </h2>
                    <div class="invoice_blank_header" style="width: 100%;display: flex;justify-content: space-between;align-items: flex-start;margin-bottom: 30px;">
                        <div class="provider" style="width: 45%;">
                        <p class="provider_text" style="margin-bottom: 0;font-size: 14px;font-style: italic;" >
                           {{getSetting.name}}
                        </p>
                        <p class="provider_text">
                            <b class="provider_text_title">{{$t('Manzil')}}:</b>{{getSetting.address}}
                        <p class="provider_text" style="margin-bottom: 0;font-size: 14px;font-style: italic;">
                            <b class="provider_text_title">{{$t('Telefon')}}:</b>{{ getSetting.phone}}
                        </p>
                        <p class="provider_text" style="margin-bottom: 0;font-size: 14px;font-style: italic;">
                            <b class="provider_text_title">{{$t('X/raqam')}}:</b>{{ getSetting.bank_number}}
                        </p>
                        <p class="provider_text" style="margin-bottom: 0;font-size: 14px;font-style: italic;">
                            <b class="provider_text_title">{{$t('Shaxar')}}:</b> ш.Ташкент
                        </p>
                        <p class="provider_text" style="margin-bottom: 0;font-size: 14px;font-style: italic;">
                            <b class="provider_text_title">{{$t('INN')}}:</b>{{ getSetting.inn}}
                            <b class="provider_text_title" style="margin-left: 10px;">{{$t('MFO')}}:</b>{{ getSetting.mfo}}
                        </p>
                        <p class="provider_text" style="margin-bottom: 0;font-size: 14px;font-style: italic;">
                            <b class="provider_text_title">{{$t('OKED')}}:</b>{{ getSetting.oked}}
                        </p>
                        </div>
                        <div class="customer" v-if="getInvoice.user" style="width: 45%;" >
                            <p class="provider_text" style="margin-bottom: 0;font-size: 14px;font-style: italic;">
                                {{ getInvoice.user.company_name}}
                            </p>
                            <p class="provider_text" style="margin-bottom: 0;font-size: 14px;font-style: italic;">
                                <b class="provider_text_title">{{$t('Manzil')}}:</b> {{getInvoice.user.address}}
                            </p>
                            <p class="provider_text" style="margin-bottom: 0;font-size: 14px;font-style: italic;">
                                <b class="provider_text_title">{{$t('Telefon')}}:</b>{{ getInvoice.user.phone}}
                            </p>
                            <p class="provider_text" style="margin-bottom: 0;font-size: 14px;font-style: italic;">
                                <b class="provider_text_title">{{$t('X/raqam')}}:</b>{{ getInvoice.user.bank_number}}
                            </p>
                            <p class="provider_text" style="margin-bottom: 0;font-size: 14px;font-style: italic;">
                                <b class="provider_text_title">{{$t('Shaxar')}}:</b> {{getInvoice.user.city}}
                            </p>
                            <p class="provider_text" style="margin-bottom: 0;font-size: 14px;font-style: italic;">
                                <b class="provider_text_title">{{$t('INN')}}:</b> {{getInvoice.user.inn}}
                                <b class="provider_text_title">{{$t('MFO')}}:</b> {{getInvoice.user.mfo}}
                            </p>
                            <p class="provider_text" style="margin-bottom: 0;font-size: 14px;font-style: italic;">
                                <b class="provider_text_title">{{$t('OKED')}}:</b>{{ getInvoice.user.oked}}
                            </p>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover text-center table-bordered" style="font-size: 14px;border: 2px solid black; ">
                            <thead style="background-color: aliceblue;">
                            <tr align="center">
                                <th rowspan="2" style="padding: 0.25rem !important;vertical-align: middle !important;font-size: 12px !important;border: solid 2px #000 !important;" scope="col">№</th>
                                <th rowspan="2" scope="col" style="padding: 0.25rem !important;vertical-align: middle !important;font-size: 12px !important;border: solid 2px #000 !important;">
                                    Хизмат тури
                                </th>
                                <th rowspan="2" scope="col" align="center" style="padding: 0.25rem !important;vertical-align: middle !important;font-size: 12px !important;border: solid 2px #000 !important;">Нарх</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr >
                                    <th scope="row" style="padding: 0.25rem !important;vertical-align: middle !important;font-size: 12px !important;border: solid 2px #000 !important;">1</th>
                                    <td style="padding: 0.25rem !important;vertical-align: middle important;font-size: 12px important;border: solid #000 !important;border-width: 0 1px 1px 0 !important;display:flex;flex-wrap:wrap;">
                                        тендер таклифларини юбориши учун ахборот тизимидан фойдаланиш
                                    </td>
                                    <td scope="col" style="padding: 0.25rem !important;vertical-align: middle important;font-size: 12px important;border: solid #000 !important;border-width: 0 1px 1px 0 !important;">{{getInvoice.price}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="invoice_blank_footer" style="display: flex;justify-content: flex-end;align-items: flex-start;padding-top: 40px;position:relative;">
                        <div class="qrcode_block" style="position: absolute;right: 50%;top: 50px;">
                            <!-- <img :src='"/"+invoiceData.qrcode' width="100" height="100" alt="" v-if="invoiceData.qrcode"> -->
                        </div>
                        <div class="customer" style="width: 40%;">
                            <h5 class="provider_txt" style="font-size: 12px; margin-bottom: 20px;">Қабул қилди<span class="provider_span" style="border-bottom: 1px solid #000;display: inline-block;width: 250px;"></span></h5>
                            <i class="provider_i" style="font-size: 10px;transform: translateY(-10px);display: inline-block;font-weight: bold;">(ваколатли вакилнинг имзоси)</i>
                            <h5 class="provider_txt" style="font-size: 12px; margin-bottom: 20px;">Ишончнома орқали №<span class="provider_span" style="border-bottom: 1px solid #000;display: inline-block;width: 250px;"></span></h5>
                            <h5 class="provider_txt" style="font-size: 12px; margin-bottom: 20px;">дан "<span style="border-bottom: 1px solid #000;display: inline-block;width: 50px;" class="provider_span"></span>" <span class="provider_span" style="border-bottom: 1px solid #000;display: inline-block;width: 250px;"></span>{{new Date().getFullYear()}} .</h5>
                            <h5 class="provider_txt" style="font-size: 12px; margin-bottom: 20px;"> <span class="provider_span" style="border-bottom: 1px solid #000;display: inline-block;width: 250px;"></span><i class="provider_i" style="font-size: 10px;transform: translateY(0px);display: inline-block;font-weight: bold;">(ТЎЛИҚ ИСМ олувчи)</i></h5>
                        </div>
                    </div>
                    </div>
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
				laoding: true
			}
		},
		async mounted(){
			await this.actionShowInvoice(this.$route.params.id)
            await this.actionSetting()
			this.laoding = false
		},
		computed:{
			...mapGetters('invoices',['getInvoice']),
            ...mapGetters('setting',['getSetting'])
		},
		methods:{
            ...mapActions('invoices', ['actionShowInvoice']),
            ...mapActions('setting',['actionSetting']),
        }

	}
</script>
<style scoped>
.card-body{
    display: flex;
    justify-content: center;
}
.invoice_blank {
    width: 1122px;
    padding: 30px;
    box-shadow: rgb(0 0 0 / 75%) 0px 0px 5px 0px;
}
</style>
