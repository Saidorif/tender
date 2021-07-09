<template>
	<div class="payment">
		<Loader v-if="laoding"/>
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon fas fa-money-bill-alt"></i>
				   {{$t('Toʼlovlar')}}
				</h4>
		  	</div>
                <div class="card-body">
                    <div class="invoice_blank printThisShowInvoise" id="invoice_blank" style="padding-top: 50px;position:relative;">
                    <h2  class="invoice_blank_title" style="margin-top: 30px;font-size: 18px;font-weight: bolder;text-align: center;margin-bottom: 0;text-transform:uppercase;">Подтверждение </h2>
                    <h6 class="invoice_blank_subtitle" style="font-size: 16px;text-align: center;font-style: italic;margin-bottom: 50px;">о получении разрешительных документов № invoiceData.number от  formatDate(invoiceData.date)</h6>
                    <div class="invoice_blank_header" style="width: 100%;display: flex;justify-content: space-between;align-items: flex-start;margin-bottom: 30px;">
                        <div class="provider" style="width: 45%;">
                        <p class="provider_text" style="margin-bottom: 0;font-size: 14px;font-style: italic;" >
                            provider.name
                        </p>
                        <p class="provider_text">
                            <b class="provider_text_title">Адрес:</b>provider.address
                        <p class="provider_text" style="margin-bottom: 0;font-size: 14px;font-style: italic;">
                            <b class="provider_text_title">Телефон:</b> provider.phone
                        </p>
                        <p class="provider_text" style="margin-bottom: 0;font-size: 14px;font-style: italic;">
                            <b class="provider_text_title">Р/счет:</b> provider.bank_number  provider.city
                        </p>
                        <p class="provider_text" style="margin-bottom: 0;font-size: 14px;font-style: italic;">
                            <b class="provider_text_title">Город:</b> г.Ташкент
                        </p>
                        <p class="provider_text" style="margin-bottom: 0;font-size: 14px;font-style: italic;">
                            <b class="provider_text_title">ИНН:</b> provider.inn
                            <b class="provider_text_title" style="margin-left: 10px;">МФО:</b> provider.mfo
                        </p>
                        <p class="provider_text" style="margin-bottom: 0;font-size: 14px;font-style: italic;">
                            <b class="provider_text_title">ОКЭД:</b> provider.oked
                        </p>
                        </div>
                        <div class="customer" v-if="getInvoice.user" style="width: 45%;" >
                            <p class="provider_text" style="margin-bottom: 0;font-size: 14px;font-style: italic;">
                                {{ getInvoice.user.company_name}}
                            </p>
                            <p class="provider_text" style="margin-bottom: 0;font-size: 14px;font-style: italic;">
                                <b class="provider_text_title">Адрес:</b> {{getInvoice.user.address}}
                            </p>
                            <p class="provider_text" style="margin-bottom: 0;font-size: 14px;font-style: italic;">
                                <b class="provider_text_title">Телефон:</b>{{ getInvoice.user.phone}}
                            </p>
                            <p class="provider_text" style="margin-bottom: 0;font-size: 14px;font-style: italic;">
                                <b class="provider_text_title">Р/счет:</b>{{ getInvoice.user.bank_number}}
                            </p>
                            <p class="provider_text" style="margin-bottom: 0;font-size: 14px;font-style: italic;">
                                <b class="provider_text_title">Город:</b> {{getInvoice.user.city}}
                            </p>
                            <p class="provider_text" style="margin-bottom: 0;font-size: 14px;font-style: italic;">
                                <b class="provider_text_title">ИНН:</b> {{getInvoice.user.inn}}
                                <b class="provider_text_title">МФО:</b> {{getInvoice.user.mfo}}
                            </p>
                            <p class="provider_text" style="margin-bottom: 0;font-size: 14px;font-style: italic;">
                                <b class="provider_text_title">ОКЭД:</b>{{ getInvoice.user.oked}}
                            </p>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover text-center table-bordered" style="font-size: 14px;border: 2px solid black; ">
                            <thead style="background-color: aliceblue;">
                            <tr align="center">
                                <th rowspan="2" style="padding: 0.25rem !important;vertical-align: middle !important;font-size: 12px !important;border: solid 2px #000 !important;" scope="col">№</th>
                                <th rowspan="2" scope="col" style="padding: 0.25rem !important;vertical-align: middle !important;font-size: 12px !important;border: solid 2px #000 !important;">
                                Наименование и номер <br>
                                бланков разрешений
                                </th>
                                <th rowspan="2" scope="col" style="padding: 0.25rem !important;vertical-align: middle !important;font-size: 12px !important;border: solid 2px #000 !important;">Ед. Изм.</th>
                                <th rowspan="2" scope="col" align="center" style="padding: 0.25rem !important;vertical-align: middle !important;font-size: 12px !important;border: solid 2px #000 !important;">Кол-во</th>
                                <th rowspan="2" scope="col" align="center" style="padding: 0.25rem !important;vertical-align: middle !important;font-size: 12px !important;border: solid 2px #000 !important;">Цена</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr >
                                    <th scope="row" style="padding: 0.25rem !important;vertical-align: middle !important;font-size: 12px !important;border: solid 2px #000 !important;">1</th>
                                    <td style="padding: 0.25rem !important;vertical-align: middle important;font-size: 12px important;border: solid #000 !important;border-width: 0 1px 1px 0 !important;display:flex;flex-wrap:wrap;">
                                        тендер таклифларини юбориши учун ахборот тизимидан фойдаланиш
                                    </td>
                                    <td scope="col" style="padding: 0.25rem !important;vertical-align: middle important;font-size: 12px important;border: solid #000 !important;border-width: 0 1px 1px 0 !important;">шт</td>
                                    <td scope="col" style="padding: 0.25rem !important;vertical-align: middle important;font-size: 12px important;border: solid #000 !important;border-width: 0 1px 1px 0 !important;">1</td>
                                    <td scope="col" style="padding: 0.25rem !important;vertical-align: middle important;font-size: 12px important;border: solid #000 !important;border-width: 0 1px 1px 0 !important;">{{getInvoice.price}}</td>
                                </tr>
                            </tbody>
                            <tfoot style="background-color: aliceblue;">
                            <tr>
                                <th scope="row" style="padding: 0.25rem !important;vertical-align: middle !important;font-size: 12px !important;border: solid 2px #000 !important;"></th>
                                <th scope="row" style="padding: 0.25rem !important;vertical-align: middle !important;font-size: 12px !important;border: solid 2px #000 !important;text-align:left;">ИТОГО</th>
                                <th scope="row" style="padding: 0.25rem !important;vertical-align: middle !important;font-size: 12px !important;border: solid 2px #000 !important;">шт</th>
                                <th scope="row" style="padding: 0.25rem !important;vertical-align: middle !important;font-size: 12px !important;border: solid 2px #000 !important;">1</th>
                                <th scope="row" style="padding: 0.25rem !important;vertical-align: middle !important;font-size: 12px !important;border: solid 2px #000 !important;">{{getInvoice.price}}</th>
                            </tr>
                            <tr>
                                <th scope="row" style="padding: 0.25rem !important;vertical-align: middle !important;font-size: 12px !important;border: solid 2px #000 !important;"></th>
                                <th scope="row" style="padding: 0.25rem !important;vertical-align: middle !important;font-size: 12px !important;border: solid 2px #000 !important;text-align:left;" colspan="10">Всего к оплате: <i> results.numberToWords | uppercaseFirstNumber results.capeyka</i> (Без НДС).</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="invoice_blank_footer" style="display: flex;justify-content: flex-end;align-items: flex-start;padding-top: 40px;position:relative;">
                        <div class="qrcode_block" style="position: absolute;right: 50%;top: 50px;">
                            <!-- <img :src='"/"+invoiceData.qrcode' width="100" height="100" alt="" v-if="invoiceData.qrcode"> -->
                        </div>
                        <div class="customer" style="width: 40%;">
                            <h5 class="provider_txt" style="font-size: 12px; margin-bottom: 20px;">Получил<span class="provider_span" style="border-bottom: 1px solid #000;display: inline-block;width: 250px;"></span></h5>
                            <i class="provider_i" style="font-size: 10px;transform: translateY(-10px);display: inline-block;font-weight: bold;">(подпись  уполномоченного представителя)</i>
                            <h5 class="provider_txt" style="font-size: 12px; margin-bottom: 20px;">По доверности №<span class="provider_span" style="border-bottom: 1px solid #000;display: inline-block;width: 250px;"></span></h5>
                            <h5 class="provider_txt" style="font-size: 12px; margin-bottom: 20px;">от "<span style="border-bottom: 1px solid #000;display: inline-block;width: 50px;" class="provider_span"></span>" <span class="provider_span" style="border-bottom: 1px solid #000;display: inline-block;width: 250px;"></span>new Date().getFullYear() .</h5>
                            <h5 class="provider_txt" style="font-size: 12px; margin-bottom: 20px;"> <span class="provider_span" style="border-bottom: 1px solid #000;display: inline-block;width: 250px;"></span><i class="provider_i" style="font-size: 10px;transform: translateY(0px);display: inline-block;font-weight: bold;">(Ф.И.О. получателя)</i></h5>
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
			this.laoding = false
		},
		computed:{
			...mapGetters('invoices',['getInvoice'])
		},
		methods:{
            ...mapActions('invoices', ['actionShowInvoice']),
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
