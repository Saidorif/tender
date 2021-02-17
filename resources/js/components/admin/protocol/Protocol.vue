<template>
  <div class="cv_block">
      <Loader v-if="laoding"/>
    <div class="card">
      <div class="card-header">
        <button
          class="btn btn-primary"
          @click="$g.toWord('word', 'protocol')"
        >
          <i class="fas fa-download"></i>
          Юклаш
        </button>
        <router-link class="btn btn-primary back_btn" :to="`/crm/completed-tenders/show/${$route.params.tenderId}`">
          <span class="peIcon pe-7s-back"></span> Назад
        </router-link>
      </div>
    </div>
    <div class="download_btn d-flex justify-content-center mb-4">
      <div id="word">
        <div
          size="A4"
          class="front_cv"
          style="
            background: white;
            display: block;
            margin: 0 auto;
            margin-bottom: 0.5cm;
            box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
            font-family: 'Times New Roman';
            width: 21cm;
            min-height: 29.7cm;
            padding: 30px 30px 40px 80px;
            position: relative;
          "
        >
            <div style="list-style: none; list-style-type: none">
                <p style="text-align: right;margin-bottom:0;">
                    <u style="text-decoration: underline;font-size: 21px;">ЛОЙИҲА</u>
                </p>
                <h2 style="font-size: 18.5px;font-weight: bold;text-align: right;margin-right:150px;margin-top:15px;">«Тасдиқлайман»</h2>
                <p style="font-size: 18.5px;margin-left:250px;text-align:justify;">
                    Ўзбекистон автомобиль транспорти агентлиги бошлиғи, Шаҳарлараро - вилоятлараро йўналишларни жойлаштири учун очиқ тендерлар ўтказишни ташкил этиш масалалари бўйича идоралараро комиссия Раиси
                </p>
                <p  style="font-size: 18.5px;text-align:right;margin:0;padding:0;font-weight:bold;line-heifht:0;">
                    _____________________ Д.Т.Дехканов
                </p>
                <p style="font-size: 18.5px;text-align:right;line-heifht:0;margin: 0 80px; padding:0;">
                    {{getProtocol.tender ? $g.getYear(getProtocol.tender.time) : ''}} йил «{{getProtocol.tender ? $g.getDay(getProtocol.tender.time) : ''}}» {{getProtocol.tender ? $g.getMonthInLetter(getProtocol.tender.time) : ''}}
                </p>
                <p style="font-size: 18.5px;text-align:center;margin:10px 40px 0px 40px;">
                    Шаҳарлараро-вилоятлараро йўналишларни жойлаштириш
                    учун очиқ тендерлар ўтказишни ташкил этиш масалалари бўйича
                    идоралараро комиссиянинг (кейинги ўринда Идоралараро комиссия)
                </p>
                <p style="text-align:center;font-size: 18.5px;margin: 0;line-heifht:0;">4 - сонли мажлис <b>Баёни</b> </p>

                <table style="width:100%;">
                    <tr>
                        <td style="font-size: 18.5px;margin: 0;line-heifht:0;">{{getProtocol.tender ? $g.getYear(getProtocol.tender.time) : ''}} йил {{getProtocol.tender ? $g.getDay(getProtocol.tender.time) : ''}} {{getProtocol.tender ? $g.getMonthInLetter(getProtocol.tender.time) : ''}}</td>
                        <td style="font-size: 18.5px;margin: 0;line-heifht:0;text-align:right">
                            {{getProtocol.tender ? getProtocol.tender.moderator : ''}}
                        </td>
                    </tr>
                </table>
                <h4 style="font-size: 18.5px;text-align:center;font-weight:bold;">Кун тартиби:</h4>
                <ol>
                    <li style="font-size: 18.5px;margin: 0;font-weight:bold;">
                    Шаҳарлараро - вилоятлараро автобус ва йўналишли такси йўналишларида ишлаш ҳуқуқини олиш учун 2018 йилнинг 26 декабрь кунига режалаштирилган очиқ тендерни ўтказиш.
                    </li>
                    <li style="font-size: 18.5px;margin: 0;font-weight:bold;">Тендер талабларига оид масалалар. </li>
                </ol>
                <p style="font-size: 18.5px;margin:0;">Қатнашчилар: Идоралараро комиссиянинг ваколатли вакиллари ва ишчи гуруҳи:</p>
                <p style="font-size: 18.5px;margin:0;">
                    Ўзбекистон автомобиль транспорти агентлиги томонидан – <b>Д.Т.Дехканов,  А.А.Исаев, Т.Т.Джамалходжаев, Н.М.Худойбердиев, Ф.Ф.Туропов.</b> Ўзбекистон Республикаси ИИВ томонидан - вакил ЙҲХББ, ТНБ бўлимидан - <b> Д.Камолов,</b> Ўзбекистон Республикаси Хусусийлаштирилган корхоналарга кўмаклашиш ва рақобатни ривожлантириш давлат қўмитаси томонидан - вакиллар, бош мутахассис – <b>В.К.Дубровская</b> ва тендер саноқ ишчи гуруҳи раиси - <b>З.М.Розиқбоева,</b> Ўзбекистон Республикаси Давлат божхона қўмитаси томонидан - вакил ДБҚ катта инспектори <b>Х.Халбаев,</b> Ўзбекистон Республикаси Давлат солиқ қўмитаси томонидан – вакил ДСҚ бош инспектор <b>М.Амиров,</b> Ўзбекистон Республикаси савдо-саноат палатаси томонидан – вакил етакчи мутахассис <b>Б.Шукуруллохонов,</b> Ўзбекистон Республикаси Адлия вазирлиги томонидан - вакил бошқарма бошлиғи <b>Н.Жуманёзов,</b> «Авто +» газетаси мухбири - <b>О.Мўминов.</b>
                </p>
                <p style="font-size: 18.5px;margin:0;">
                    Идоралараро комиссиянинг йиғилишини Ўзбекистон автомобиль транспорти агентлиги бошлиғи Идоралараро комиссия раиси <b>Д.Т.Дехканов </b>олиб борди ва Идоралараро комиссия аъзоларини кун тартиби билан таништирди.
                </p>
                <h6 style="font-size: 18.5px;margin-top:10px;margin-bottom:0px;font-weight:bold;">Кун тартибидаги биринчи масала бўйича: </h6>
                <p style="font-size: 18.5px;margin-bottom:10px;">
                    Шаҳарлараро - вилоятлараро автобус ва йўналишли такси йўналишларида ишлаш ҳуқуқини олиш учун жорий йилнинг 26 декабрь куни ўтказилиши режалаштирилган очиқ тендерга 28 та йўналиш қўйилиб, тендерда иштирок этиш учун йўналишларга талабгорлардан жами 20 та аризалар келиб тушган.
                </p>
                <h6 style="font-size: 18.5px;margin:0;font-weight:bold;margin-bottom:10px;">Келиб тушган тендер таклифларини баҳолаш натижалари қуйидагича: </h6>
                <div style="margin-bottom: 30px;" v-for="(items,index) in getProtocol.lots">
                    <h6 style="font-size: 18.5px;margin:0;margin-bottom:0px;font-weight:normal;"><b>{{index+1}}) {{items.title}}</b>	 автобус йўналиши бўйича:</h6>
                    <h6 style="font-size: 18.5px;margin:0;font-weight:normal;">кутилаётган энг кам балл {{items.minimal_ball}} балл</h6>
                    <p style="font-size: 18.5px;margin:0px;" v-for="(val,k) in items.items">1)	«{{val.company_name}}»   - тўплаган бали {{val.total}} балл </p>
                </div>
                <h6 style="font-size: 18.5px;margin:0;font-weight:bold;margin-bottom:10px;text-decoration: underline;font-style: italic;text-align:center;">Идоралараро Комиссия бир овоздан қуйидагиларни қарор қилди:</h6>
                <p style="font-size: 18.5px;margin:0;">- юқори балл тўплаган талабгорни эълон қилиш;</p>
                <p style="font-size: 18.5px;margin:0;">- таклиф келиб тушмаган йўналишлар бўйича тендер бўлмади деб эътироф қилиш;</p>
                <p style="font-size: 18.5px;margin:0;">- ўн беш кун муддат ичида тендерда юқори балл тўплаган талабгорларнинг Комиссияга тақдим қилган тендер таклифларини хаққонийлигини текширишни ташкил қилиш ва текшириш натижалари асосида ташувчилар билан тендер контрактини тузиш учун ҳужжатларни талаб қилиб олган ҳолда, Тендер битимларини тузишни ҳамда «Тендер ғолиби» гувоҳномаларини берилишини таъминлашни топшириш;</p>
                <p style="font-size: 18.5px;margin:0;">- талабгорлар бўлмаган йўналишларнинг тендер талаблари қайта кўриб чиқиш ва навбатдаги тендерга қўйиш;</p>
                <p style="font-size: 18.5px;margin:0;">- тендерга қўйилган, лекин жойлаштирилмаган йўналишларда хизмат кўрсатаётган ташувчилар билан тузилган тендер контрактлари муддатини кейинги тендер ўтказилгунга қадар узайтиришни топшириш.</p>
            </div>
            <h6 style="text-align:center;font-size: 18.5px;margin: 10px;line-heifht:0;font-weight:bold;">Кун тартибидаги иккинчи масала бўйича:</h6>
            <p style="font-size: 18.5px;margin-left:50px;">Модератор томонидан ручной киритилади</p>
            <table style="width:90%;margin-left: 50px;margin-right:50px;">
                <tr>
                    <td style="font-size: 18.5px;margin: 0;line-heifht:0;font-weight:bold;">Баённи тузувчи</td>
                    <td style="font-size: 18.5px;margin: 0;line-heifht:0;text-align:right;font-weight:bold;">Ф.Туропов</td>
                </tr>
                <tr>
                    <td style="font-size: 18.5px;margin: 0;line-heifht:0;text-align:center;font-weight:bold;" colspan="2">Идоралараро комиссиянинг аъзолари ва ишончли вакиллари</td>
                </tr>
                <tr>
                    <td style="font-size: 18.5px;margin: 0;line-heifht:0;font-weight:bold;"></td>
                    <td style="font-size: 18.5px;margin: 0;line-heifht:0;text-align:right;font-weight:bold;">В.Дубровская</td>
                </tr>
                <tr>
                    <td style="font-size: 18.5px;margin: 0;line-heifht:0;font-weight:bold;"></td>
                    <td style="font-size: 18.5px;margin: 0;line-heifht:0;text-align:right;font-weight:bold;">Д.Камолов</td>
                </tr>
                <tr>
                    <td style="font-size: 18.5px;margin: 0;line-heifht:0;font-weight:bold;"></td>
                    <td style="font-size: 18.5px;margin: 0;line-heifht:0;text-align:right;font-weight:bold;">Х.Халбаев</td>
                </tr>
                <tr>
                    <td style="font-size: 18.5px;margin: 0;line-heifht:0;font-weight:bold;"></td>
                    <td style="font-size: 18.5px;margin: 0;line-heifht:0;text-align:right;font-weight:bold;">М.Амиров</td>
                </tr>
                <tr>
                    <td style="font-size: 18.5px;margin: 0;line-heifht:0;font-weight:bold;"></td>
                    <td style="font-size: 18.5px;margin: 0;line-heifht:0;text-align:right;font-weight:bold;">Б.Шукуруллохонов</td>
                </tr>
                <tr>
                    <td style="font-size: 18.5px;margin: 0;line-heifht:0;font-weight:bold;"></td>
                    <td style="font-size: 18.5px;margin: 0;line-heifht:0;text-align:right;font-weight:bold;">Н.Жуманёзов</td>
                </tr>
            </table>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import DatePicker from "vue2-datepicker";
import { mapActions, mapGetters } from "vuex";
import Loader from '../../Loader'
export default {
  components: {
    DatePicker,
    Loader
  },
  data() {
    return {laoding: true,};
  },
  async mounted() {
    await this.actionProtocol(this.$route.params.tenderId);
    this.laoding = false
  },
  computed: {
    ...mapGetters("protocol", ["getProtocol"]),
  },
  methods: {
    ...mapActions("protocol", ["actionProtocol"]),
  },
};
</script>
<style scoped>
/*.cv_block{

}
.front_cv{

}
.front_cv h5{
    text-align: center;
    font-weight: bold;
    font-size: 17px;
}
.front_cv h6{
    font-weight: bold;font-size: 14px;
}
.front_cv p{
    font-weight: normal;font-size: 14px;
}
.front_cv p span{
    margin-right: 5px;
}
.front_cv p span:last-child{
    margin-right: 0px;
}
.front_cv {
    background: white;display: block;margin: 0 auto;margin-bottom: 0.5cm;box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);font-family: "Times New Roman";width: 21cm;height: 29.7cm;padding: 60px 30px 40px 80px;
}
.front_cv[size="A4"] {
  width: 21cm;height: 29.7cm;padding: 60px 30px 40px 80px;
}
.cv_double_item{
    display: flex;justify-content: space-between;
}
.cv_double_item .cv_item{
    width: 50%;
}
.front_cv ul li{
    list-style: none;
}
.mb_30{
    margin-bottom: 30px;
}
table th,
table td {
   text-align: center;
}
.table thead th{
    border-color: #000;
}
.table th, .table td{
    border-color: #000;
}*/
</style>
