<template>
  <div class="cv_block">
      <Loader v-if="laoding"/>
    <div class="card">
      <div class="card-header">
        <button
          class="btn btn-primary"
          @click="$g.toWord('word', 'contract')"
        >
          <i class="fas fa-download"></i>
          Юклаш
        </button>
        <button type="button" class="btn btn-primary back_btn" @click="back">
          <span class="peIcon pe-7s-back"></span> Назад
        </button>
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
            <h6 style="font-size: 16px;text-align:center;font-weight:bold;margin-left:70px;margin-right:70px;">
                Шаҳарлараро-вилоятлараро ва халқаро йўловчилар ташиш
                йўналишларида хизмат кўрсатиш бўйича
            </h6>
            <h6 style="font-size: 16px;text-align:center;font-weight:bold;">{{getContract.number}} - сонли КОНТРАКТ</h6>
            <table style="width:100%;">
                <tr>
                    <td style="font-size: 16px;margin: 0;line-heifht:0;">{{$g.getYear(myDate)}} йил {{$g.getDay(myDate)}} {{$g.getMonthInLetter(myDate)}}</td>
                    <td style="font-size: 16px;margin: 0;line-heifht:0;text-align:right">Тошкент ш.</td>
                </tr>
            </table>
            <p style="font-size: 16px;margin: 0;line-heifht:0;text-align:justify;margin-top:15px;margin-bottom:15px;">
                Шаҳарлараро - вилоятлараро ва ҳалқаро йўналишларни жойлаштириш учун очиқ тендерлар ташкил этиш ва ўтказиш масалалари бўйича Идоралараро комиссиянинг 2020 йил « 19 » февралдаги қарори (2-сонли баённома)га асосан, Ўзбекистон Республикаси Транспорти вазир ўринбосари – Идоралараро комиссия раиси номидан Д.Дехканов, бундан кейин “Буюртмачи” деб аталувчи бир томондан ва
                “{{getCompanyInfo.company_name}}” раҳбари {{$g.getFirstLetter(getCompanyInfo.name)}}.{{$g.getFirstLetter(getCompanyInfo.middlename)}}.{{getCompanyInfo.surname}}, бундан кейин “Ташувчи” деб аталувчи иккинчи томондан қуйидагилар ҳақида ушбу Контрактни туздилар.
            </p>
            <h6 style="font-size: 16px;text-align:center;font-weight:bold;">
                I.Контрактнинг мавзуси
            </h6>
            <p>
                “Буюртмачи” {{$g.getYear(getContract.exp_date)}} йил « {{$g.getDay(getContract.exp_date)}} » {{$g.getMonthInLetter(getContract.exp_date)}}идан “Ташувчи”га ушбу Контрактда изоҳланган шартларда, <template v-for="(dir,index) in getDirections">ВШ-{{dir.pass_number}}-сонли «{{dir.name}}» </template> автобус йўналишида йўловчиларни ташишни амалга ошириш ҳуқуқини беради.
            </p>
            <h6 style="font-size: 16px;text-align:center;font-weight:bold;">
                II. Томонларнинг ҳуқуқ ва мажбуриятлари
            </h6>
            <p style="font-size: 16px;font-weight:bold;text-indent: 50px;">2.1. “Ташувчи”нинг мажбуриятлари:</p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;">
                2.1.1. йўловчиларни ташишда Ўзбекистон Республикасининг “Автомобиль транспорти тўғрисида”ги, “Фаолиятнинг айрим турларини лицензиялаш тўғрисида”ги  ва «Йўл ҳаракати хавфсизлиги тўғрисида»ги Қонунлари, Ўзбекистон Республикаси Вазирлар Маҳкамасининг 2003 йил 4 ноябрдаги 482-сонли қарори билан тасдиқланган «Ўзбекистон Республикасида автомобиль транспортида йўловчилар ва багаж ташиш қоидалари» ва «Ўзбекистон Республикасида автобусларда йўловчилар ташиш хавфсизлигини таъминлашга доир талаблар» ва «Йўл ҳаракати қоидалари»га қатъий амал қилинишини таъминлаш ҳамда уларда белгиланган талаб ва шартларнинг тўлиқ бажарилишини таъминлашга ташувчи (биринчи раҳбар) шахсан жавобгар;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;">
                2.1.2. йўловчиларни сифатли ташиш ва хизмат кўрсатиш маданиятини ошириш, транспорт воситаларини бошқариш ҳуқуқи учун мувофиқ тоифага, шунингдек шаҳарлараро йўловчилар ташиш йўналишларида норматив-ҳуқуқий ҳужжатлар талаблари асосида белгиланган иш стажига ва тажрибага эга бўлган ҳайдовчиларни ишлатишни таъминлаш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;">
                2.1.3. контрактнинг амалдаги муддати давомида транспорт хизмати кўрсатиш учун берилган йўналишда йўловчиларни мунтазам ташиш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;">
                2.1.4. ВШ-988-сонли йўналишда қуйидаги русумли, давлат рақамлари ва ўриндиқларга эга.
            </p>
            <table style="width:100%;">
                <thead>
                    <tr>
                        <th style="border:1px solid #000;text-align:center;">№</th>
                        <th style="border:1px solid #000;text-align:center;">Автотранспорт русуми</th>
                        <th style="border:1px solid #000;text-align:center;">Давлат рақами</th>
                        <th style="border:1px solid #000;text-align:center;">Ўриндиқлар сони</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="cars.length > 0 " v-for="(car,index) in cars">
                        <td style="border:1px solid #000;font-size: 16px;margin: 0;line-heifht:0;text-align:center">{{index+1}}</td>
                        <td style="border:1px solid #000;font-size: 16px;margin: 0;line-heifht:0;text-align:center">
                            {{car.busmarka ? car.busmarka.name : ''}}
                        </td>
                        <td style="border:1px solid #000;font-size: 16px;margin: 0;line-heifht:0;text-align:center">
                            {{car.auto_number}}
                        </td>
                        <td style="border:1px solid #000;font-size: 16px;margin: 0;line-heifht:0;text-align:center">
                            {{car.capacity}}
                        </td>
                    </tr>
                </tbody>
            </table>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                бўлган, чап томондан бошқариладиган ва йўловчилар учун эшиклари ўнг томонда бўлиб, йўловчиларнинг қулай чиқиши ва тушишини таъминловчи, жадвалда кўрсатилган ўриндиқлар сони тўғри келадиган ва техник талабларга жавоб берадиган автобуслардан фойдаланиш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.1.5. «Ташувчининг фуқаролик жавобгарлигини мажбурий суғурта қилиш тўғрисида»ги Ўзбекистон Республикаси Қонуни талаблари асосида ташувчининг фуқаролик жавобгарлигини суғурта қилиш бўйича белгиланган мажбуриятларнинг бажарилишини таъминлаш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.1.6. автотранспортни GPS тузилмаси билан жихозлаш ва уни доимий равишда ишлашини таъминлаш, GPS тузилмасини ҳайдовчилар томонидан ўчириб қўйилишига йўл қўймаслик.
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.1.7. белгиланган иш тартиби, тасдиқланган қатнов жадвали, ҳаракатланувчи таркибнинг йўналишда ишлаши учун режалаштирилган сонига қатъий амал қилиш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.1.8. автобуслар тахографлар билан жихозланган бўлишини ва уларнинг доимий соз ҳолда ишлашини таъминлаш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.1.9. автотранспорт воситаларининг техник ҳолати ва анжомлари тегишли стандартлар ҳамда техник фойдаланиш қоидалари талабларига жавоб бериши керак;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.1.10. ҳар бир автобус ва микроавтобуснинг салонида йўналиш схемаси, йўл ҳақи қийматининг тариф жадвали осиб қўйилишини, “Ташувчи”нинг телефон рақамлари, люк, деразаларни шошилинч очиш усуллари ва йўл-транспорт ходисаси юз берганида автобус салонидаги ойналарни кўчириш усуллари тўғрисида ахборотлар, ўт ўчиргич, аптечкалар, авария холатида ташқарига чиқиш жойлари ишоралар билан кўрсатиб қўйилиши ва бошқа қонунчилик талаблари асосида жихозланишини таъминлаш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
               2.1.11. автобусни олд томонининг пастки ва ўнг томондаги олдинги эшикнинг ёнига йўналишнинг рақами ва қисқача тавсифи кўрсатилган трафаретлар жойлаштирилиши;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.1.12. автобус давлат андозаси ва уни ишлаб чиқарган заводнинг техник шартларига мувофиқ жихозланиши, шу жумладан фалокат юз берганида йўловчилар ташқарига чиқадиган жой, ўриндиқлар соз холда бўлиши, ўриндиқлари рақамлаштирилган бўлиши, бунда олдинги 2 та  ўриндиқ захирадаги иккинчи ҳайдовчига қолдирилиши, салонига кирадиган эшиклар, ҳеч қандай тўсиқсиз, автомат усулда, ҳайдовчининг бошқаруви билан очилиб-ёпилиши, микроавтобуснинг салонида бегона нарсалар (захира қисмлар солинган яшиклар, ишлатиш учун керакли суюқликлар солинган идишлар ва ш.к.) сақланишига йўл қўймаслик;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.1.13. йўловчиларни ташишда йўналиш бўйича тасдиқланган йўлкира ҳақи тарификациясида белгиланган миқдорида ...... сўм тарифини қўллаш. Ташиш учун тарифни ошириш тамонига ўзгартиришга йўл қўймаслик;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.1.14. йўналиш бўйича тасдиқланган қатнов жадвалига мувофиқ, қатновларни Йўл ҳаракати хавфсизлиги бошқармалари томонидан келишилган йўналиш схемасига асосан, фақат шартнома тузилган автовокзал ва автостанциялар орқали амалга оширилишини таъминлаш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.1.15. автотранспорт воситалари салонида ҳайдовчилар ва йўловчиларга чекиш, шаҳарлараро йўналишларда микроавтобус салонида ўриндиқлар сонидан ортиқ йўловчиларни олиб юриш, автобус салонида ва томида юк ташиш, салонда спиртли ичимликлар ичиш қатъиян ман этилиши ҳақидаги талабларни ҳайдовчиларга ва йўловчиларга етказиш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.1.16. автобусларга тегишли тоифадаги ҳайдовчилик гувоҳномасига ҳамда камида 3 йил меҳнат стажига эга бўлган ҳайдовчиларни бириктириш, автобусни бошқариш вақти 9 соатдан ортиқ бўлганда ёки йўналишнинг узунлиги 400 км. ва ундан ортиқ бўлган холатда, автобусда иккинчи хайдовчининг дам олиши учун алоҳида жой жиҳозлаш, ҳайдовчиларнинг ишлаш ва дам олиш режимини назорат қилиш, ҳайдовчининг иш вақти Ўзбекистон Республикаси қонунчилигида белгиланган меъёрдан ошмаслигини таъминлаш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.1.17. автобусни ишлатиш пайтида ҳаракатланишга хавф солувчи, транспорт воситаси тизимлари ва механизмларида техник томондан бузилиш юз берса автобусни тўхтатиш, ҳамда эшикларни (зарурат бўлса авария люкларини) очиш, йўловчиларни салондан пастга тушириш, уларни мавжуд чипталари билан, шу йўналиш  бўйлаб келаётган кейинги автобусга чиқаришни ташкил қилиш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.1.18. ҳайдовчиларни «Тендер ғолиби» гувоҳномаси, лицензия варақаси, йўл варақаси, чипталар ва чипталарни ҳисобга олиш варақаси, қатнов жадвали,  йўналиш схемаси  ва бошқа керакли ҳужжатлар  билан таъминлаш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.1.19. ҳайдовчи қатнов олдидан автобуснинг кунлик техник кўрикдан ўтганлиги ва ўзининг кунлик тиббий кўрикдан ўтганлигини қайд эттирилган йўл варақасини олиб юришини талаб қилиш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.1.20. «Буюртмачига» белгиланган шакл ҳар ойнинг 5 санасигача муддатда ҳисобот бериш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.1.21. “Буюртмачи” томонидан йўналишда аниқланган камчилик ва қоидабузарликлар бўйича киритилган огохлантириш хатлари ва тақдимномаларини белгиланган муддатларда бартараф этиш, чораларини кўриш ва 5 кунлик муддатда ёзма равишда ахборот киритиш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.1.22. йўналиш иши бўйича тушган ариза ва шикоятларни ўз вақтида кўриб чиқиш, айбдор шахсларга нисбатан ваколат доирасида чоралар кўриш ва муаллифларга жавоб берилишини таъминлаш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.1.23. автотранспортдан бепул ёки имтиёзли фойдаланиш ҳуқуқига эга бўлган йўловчилар тоифасининг рўйхати бўлиши ва уларни қонунларга мувофиқ тўсқинликсиз ташилишини таъминлаш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.1.24. “Ташувчи” бошқа амалдаги қонунчиликда белгиланган мажбуриятларни бажарилишини таъминлаши шарт.
            </p>
            <p style="font-size: 16px;font-weight:bold;text-indent: 50px;margin-bottom:0px;">
                2.2. “Буюртмачи”нинг мажбуриятлари:
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.2.1. “Ташувчи”дан ташиш самарадорлигини ошириш масалалари бўйича тушган таклифларни ўрнатилган тартибда кўриб чиқиш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
               2.2.2. йўналишда хизмат кўрсатиш бўйича шикоятларни ваколат доирасида белгиланган муддатларда кўриб чиқиш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.2.3. йўналишда йўловчилар оқими ўзгариши муносабати билан ташувчининг мурожаати асосида тендер Контрактидаги транспорт сонини кўпайтириш ёки камайтиришга рухсат этиш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.2.4. “Ташувчи”нинг ушбу Контрактда қайд этилган автотранспорт воситаларини “Тендер ғолиби” гувоҳномаси билан таъминлаш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.2.5. қатновларни амалга ошириш учун шартнома тузилган автовокзал ва автостанцияларга тасдиқланган қатнов жадваллари нусхаларини етказиш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.2.6.  йўловчилар ташиш йўналишлари бўйича ҳаракат жадвалларини тасдиқлаш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.2.7.  йўловчиларнинг ҳуқуқлари таъминланишини назорат қилиш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.2.8. ёқилғи-мойлаш материаллари, электр энергияси, асосий эҳтиёт қисмлар ва материаллар нархлари ўзгарганда тарифларни ошириш ёки камайтириш бўйича “Ташувчи”нинг таклифларини кўриб чиқиши;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.2.9. йўналиш бўйича белгиланган тарифларни ўзгартирилганлиги ҳақида “Ташувчи”га хабар бериш.
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.2.10. “Ташувчи” томонидан Контрактда қайд этилган автотранспорт воситалари сотилганда, рўйхатдан чиқарилганда, давлат рақамлари ўзгарганда, уларни ўрнига уларни ўрнига бошқа ҳолати олдингисидан яхши ва лицензия варақасига эга бўлган автотранспорт воситаларига алмаштириш бўйича ёзма мурожаат қилганда, уни кўриб чиқиш  ва тегишли ўзгартириш киритиш;
            </p>
            <p style="font-size: 16px;font-weight:bold;text-indent: 50px;margin-bottom:0px;">
                2.3. “Ташувчи”нинг ҳуқуқлари:
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.3.1. “Буюртмачи”га йўналишларни очиш, ўзгартириш, ёпиш, транспорт воситаларининг режадаги сонини, жадвалларни, иш тартиби, ташиш учун тарифни қайта кўриб чиқиш бўйича асосли таклифлар киритиш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.3.2. ташиш жараёнини ташкил этиш бўйича зарур шароитларни таъминлаш юзасидан тегишли идораларга таклифларни киритиш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.3.3. контрактда қайд этилган автотранспорт воситалари сотилганда, рўйхатдан чиқарилганда, давлат рақамлари ўзгарганда, уларни ўрнига бошқа лицензия варақасига эга бўлган автотранспорт воситаларига алмаштириш бўйича “Буюртмачи”га ёзма мурожаат қилиш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.3.4. контрактнинг амал қилиш муддатини узайтириш бўйича Комиссияга мурожаат қилиш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.3.6. “Буюртмачи” томонидан контракт асоссиз равишда бекор қилинганда Комиссия ва суд органларига мурожаат қилиш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.3.7. ўз ихтиёри билан “Буюртмачини” албатта хабардор қилган ҳолда, белгиланган тарифни пасайтириш.
            </p>
            <p style="font-size: 16px;font-weight:bold;text-indent: 50px;margin-bottom:0px;">
                2.4. “Буюртмачи”нинг ҳуқуқлари
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.4.1. “Ташувчи”дан Контракт бўйича қабул қилинган мажбуриятларни бажарилиши тўғрисида ҳисоботларни тақдим этишни талаб қилиш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.4.2. “Ташувчи” томонидан ушбу Контрактнинг барча шартларига риоя қилинган тақдирда Идоралараро комиссия қарори асосида Контрактнинг амал қилиш муддатини узайтириш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.4.3. “Ташувчи”нинг ҳайдовчиси томонидан йўловчиларга қўпол муомалада бўлганлиги, имтиёзли юриш ҳуқуқига эга йўловчиларни ташишдан бош торганлиги, йўл ҳақи нархларини ўз бошимчалик билан оширганлиги, автотранспорт воситаси салонининг антисанитар ҳолати ва ҳайдовчининг ташқи кўриниши тоза эмаслиги, ҳаракат жадвали, иш тартиби ва мунтазамликка риоя этмаганлиги каби камчиликларга йўл қўйилганда, ҳар бир аниқланган ҳолат учун:
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                “Ташувчи”га огоҳлантириш ва камчиликларни бартараф этиш чораларини кўриш бўйича кўрсатма бериш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                 “Ташувчи”нинг ҳайдовчиси, мансабдор шахсларига чора кўриш ва эгаллаб турган лавозимидан озод этиш бўйича тақдимнома киритиш.
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;">
                2.4.4. “Ташувчи” томонидан ушбу Контракт талаблари бажарилмаган ёки бир маротаба қўпол равишда бузилишига йўл қўйилганда (лицензияловчи орган ёки суд томонидан “Ташувчи”га берилган лицензиянинг амал қилишини тўхтатиб туриш, лицензиянинг амал қилишини тугатиш ёки лицензияни бекор қилиш тўғрисида қарор қабул қилинганда, автотранспорт воситалари тегишли лицензия варақалари билан таъминланмаганида ҳамда мазкур Контрактнинг 2.1.7; 2.1.13 ва 2.1.23. – бандлари бажарилмаганида) “Буюртмачи” Контрактни бир томонлама бекор қилиш ва йўналишни қайта тендерга қўйиш ҳамда бу тўғрисида 5 кун муддатда “Ташувчи”ни ёзма равишда хабардор қилиш ҳуқуқига эга.
            </p>
            <p style="font-size: 16px;font-weight:bold;text-align:center;">III. Тарафларнинг жавобгарлиги</p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">3.1. “Ташувчи” ушбу Контракт мажбуриятларини бажармаган ёки зарур даражада бажармаган тақдирда, Автомобиль транспортида йўловчилар ва багажни ташиш Қоидалари ва бошқа қонун ҳужжатларида назарда тутилган тартибда жавоб беради;</p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;">3.2. “Буюртмачи” томонидан ушбу Контракт мажбуриятларини бажармаган ёки зарур даражада бажармаган тақдирда, қонун ҳужжатларида назарда тутилган тартибда жавоб беради.</p>
            <p style="font-size: 16px;font-weight:bold;text-align:center;">IV. Енгиб бўлмайдиган куч (форс-мажор) ҳолатлари</p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                4.1. Агар ушбу контракт бўйича мажбуриятлар қисман ёки тўлиқ бажарилмаслиги табиат ҳодисалари ва бошқа енгиб бўлмайдиган куч ҳолатлари натижасида келиб чиқса ва агар бу ҳолатлар мазкур контрактнинг бажарилишига бевосита таъсир этса, томонлар бундай қисман ёки тўлиқ бажармаслик учун жавобгарликдан озод этиладилар.
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                4.2. Мазкур контракт бўйича мажбуриятларни бажариш муддати енгиб бўлмайдиган куч ҳолатлари амал қилган, шунингдек ушбу ҳолатлар юзага келтирган вақтга мутаносиб равишда узайтирилади.
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
               4.3. Агар енгиб бўлмайдиган куч ҳолатлари ёки уларнинг оқибатлари беш кундан кўп вақтга чўзилса, у ҳолда Буюртмачи ва Ташувчи қандай чоралар кўрилишини муҳокама қиладилар.
            </p>
            <p style="font-size: 16px;font-weight:bold;text-align:center;">IV. Енгиб бўлмайдиган куч (форс-мажор) ҳолатлари</p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                5.1. Мазкур Контрактни тузиш, ижро этиш, ўзгартириш ва бекор қилишда вужудга келадиган низоларни Томонлар музокаралар йўли билан ҳал этиш чораларини кўрадилар.
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                5.2. Томонлар низоларни ҳал этолмасалар, улар қонун ҳужжатларида белгиланган тартибда суд томонидан кўриб чиқилади.
            </p>
            <p style="font-size: 16px;font-weight:bold;text-align:center;">VI.  Контрактга  илова  қилинадиган  ҳужжатлар</p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                6.1.  Йўналишнинг бошланғич ва охирги бекатлари жойлашган  йўналиш схемаси.
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                6.2. Йўналиш бўйича йўлкира ҳақи тарификация жадвали.
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;">
                6.3. Автотранспорт воситаларининг йўналиш бўйича қатнов жадвали.
            </p>
            <p style="font-size: 16px;font-weight:bold;text-align:center;">VII. Контрактнинг амал қилиш муддати, уни ўзгартириш ва бекор қилиш</p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                7.1. Мазкур Контракт имзоланган кундан бошлаб кучга киради ва {{$g.getYear(getContract.exp_date)}} йилнинг «{{$g.getDay(getContract.exp_date)}}» {{$g.getMonthInLetter(getContract.exp_date)}}игача амал қилади.
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                7.2. Мазкур Контрактни ўзгартириш ва бекор қилиш ушбу Контрактнинг         2.4.4. бандига асосан, шунингдек томонларнинг келишувига кўра ва Ўзбекистон Республикасининг қонун ҳужжатларига мувофиқ амалга оширилади.
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;">
                7.3 Мазкур Контракт Томонларнинг ҳар бири учун бир хил тенг юридик кучга эга бўлган икки нусхада тузилди.
            </p>
            <p style="font-size: 16px;font-weight:bold;text-align:center;">VIII. Томонларнинг реквизитлари ва юридик манзиллари</p>
            <table style="width:100%;">
                <thead>
                    <tr>
                        <th  style="width:50%;font-size: 16px;text-align:center;font-weight: bold;"> “Ташувчи”</th>
                        <th  style="width:50%;font-size: 16px;text-align:center;font-weight: bold;">«Буюртмачи»</th>
                    </tr>
                    <tr>
                        <th style="width:50%;font-size: 16px;text-align:center;font-weight: bold;">
                            “{{getCompanyInfo.company_name}}” раҳбари
                        </th>
                        <th style="width:50%;font-size: 16px;text-align:center;font-weight: bold;">
                            Ўзбекистон Республикаси Транспорти
                            вазир ўринбосари  – Идоралараро
                                комиссия раиси
                        </th>
                    </tr>
                    <tr>
                        <th style="width:50%;font-size: 16px;text-align:center;font-weight: bold;">
                            _____________ {{$g.getFirstLetter(getCompanyInfo.name)}}.{{$g.getFirstLetter(getCompanyInfo.middlename)}}.{{getCompanyInfo.surname}}
                        </th>
                        <th style="width:50%;font-size: 16px;text-align:center;font-weight: bold;">_________________Д.Дехканов </th>
                    </tr>
                </thead>
            </table>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import DatePicker from "vue2-datepicker";
import Loader from '../../Loader'
import { mapActions, mapGetters } from "vuex";
export default {
  components: {
    DatePicker,
    Loader
  },
  data() {
    return {
        laoding: true,
        cars:[],
        myDate:'',
        customdate:'',
    };
  },
  async mounted() {
    await this.actionContract(this.$route.params.conId);
    if(this.getContract && this.getContract.app){
        this.cars = this.getContract.app.cars_with.length > 0 ? this.getContract.app.cars_with : []
    }
    this.myDate = this.$g.itemDate(this.getContract.created_at)
    this.laoding = false
  },
  computed: {
    ...mapGetters("contract", ["getContract"]),
    getCompanyInfo(){
        if(this.getContract){
            return this.getContract.user ? this.getContract.user : ''
        }
    },
    getDirections(){
        if(this.getContract && this.getContract.lot){
            return this.getContract.lot.direction_id.length > 0 ? this.getContract.lot.direction_id : []
        }
    }
  },
  methods: {
    ...mapActions("contract", ["actionContract"]),
    back(){
        if(this.$route.query.TID){
            this.$router.push(`/crm/completed-tenders/show/${this.$route.query.TID}`) 
        }else{
            this.$router.push(`/crm/completed-tenders/show/${this.$route.params.conId}`) 
        }
    }
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
