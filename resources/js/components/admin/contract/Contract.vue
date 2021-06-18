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
          <span class="peIcon pe-7s-back"></span> {{$t('Orqaga')}}
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
                Йўловчилар ташиш йўналишларида хизмат кўрсатиш бўйича
            </h6>
            <h6 style="font-size: 16px;text-align:center;font-weight:bold;">{{getContract.number}} - сонли ШАРТНОМА</h6>
            <table style="width:100%;">
                <tr>
                    <td style="font-size: 16px;margin: 0;line-heifht:0;">{{$g.getYear(myDate)}} йил « {{$g.getDay(myDate)}} »  {{$g.getMonthInLetter(myDate)}}</td>
                    <td style="font-size: 16px;margin: 0;line-heifht:0;text-align:right">Тошкент ш.</td>
                </tr>
            </table>
            <p style="font-size: 16px;margin: 0;line-heifht:0;text-align:justify;margin-top:15px;margin-bottom:15px;">
                Шаҳарлараро - вилоятлараро ва ҳалқаро йўналишларни жойлаштириш учун очиқ тендерлар ташкил этиш ва ўтказиш масалалари бўйича Идоралараро комиссиянинг 2020 йил «23» декабрдаги қарори (8-сонли баённома)га асосан, Ўзбекистон Республикаси Транспорт вазирлиги номидан иш кўрувчи департамент бошлиғи Р.Рузметов, бундан кейин “Буюртмачи” деб аталувчи бир {{$t('tomondan')}} ва “{{getCompanyInfo.company_name}}” МЧЖ раҳбари {{$g.getFirstLetter(getCompanyInfo.name)}}.{{$g.getFirstLetter(getCompanyInfo.middlename)}}.{{getCompanyInfo.surname}}, бундан кейин “Ташувчи” деб аталувчи иккинчи томондан қуйидагилар ҳақида ушбу шартномани туздилар.
            </p>
            <h6 style="font-size: 16px;text-align:center;font-weight:bold;">
                I.Шартноманинг мавзуси
            </h6>
            <p>
                1.1. Буюртмачи {{$g.getYear(getContract.exp_date)}} йил «{{$g.getDay(getContract.exp_date)}}» {{$g.getMonthInLetter(getContract.exp_date)}} санасидан {{$g.getYear(getContract.exp_date)}} йилнинг «{{$g.getDay(getContract.exp_date)}}» {{$g.getMonthInLetter(getContract.exp_date)}}игача бўлган муддатда Ташувчига ушбу шартноманинг 1-иловасида белгиланган шартларда, <template v-for="(dir,index) in getDirections">ВШ-{{dir.pass_number}}-сонли «{{dir.name}}» </template> автобус йўналишида йўловчиларни ташишни амалга ошириш ҳуқуқини беради.
            </p>
            <h6 style="font-size: 16px;text-align:center;font-weight:bold;">
                II. Томонларнинг ҳуқуқ ва мажбуриятлари
            </h6>
            <p style="font-size: 16px;font-weight:bold;text-indent: 50px;">2.1. “Ташувчи”нинг мажбуриятлари:</p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;">
                2.1.1. шартноманинг 1-иловасида белгиланган шартларга тўлиқ риоя қилиш;
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;">
                2.1.2. шартноманинг амалдаги муддати давомида транспорт хизмати кўрсатиш учун берилган йўналишда йўловчиларни мунтазам ташиш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;">
                2.1.3. хизмат кўрсатиш чоғида ташиш ҳуқуқини берувчи лицензияга ҳамда мунтазам йўналишда йўловчи ташиш хизматларини кўрсатиш ҳуқуқини тасдиқловчи гувоҳномага эга бўлиш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;">
                2.1.4. сертификатга эга бўлган ва Ўзбекистон Республикаси Вазирлар Маҳкамаси томонидан белгиланган тартибда рўйхатга олинган ишга яроқли транспорт воситаларидан фойдаланиш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.1.5. йўловчилар ва багаж ташишнинг белгиланган қоидаларига риоя қилиш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.1.6. йўловчининг хавфсизлигини, хизмат кўрсатишнинг зарур қулайликлари ва шартларини таъминлаш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.1.7. ишлаб чиқариш санитарияси ва экология талабларини бажариш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.1.8. ташувчи ташишни давом эттиришдан бош тортган тақдирда мижоз кўрган зарарни қоплаш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.1.9. фуқароларнинг айрим тоифаларини бепул ва имтиёзли ташиш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.1.10. қонун ҳужжатларида назарда тутилган бошқа мажбуриятларни бажариши шарт.
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
               2.1.11. Ташувчиларнинг белгиланган йўналишдан ўзбошимчалик билан четга чиқиши, ҳаракат жадвалини бузиши ҳамда йўловчиларга қонун ҳужжатларида назарда тутилмаган бирон-бир талабни қўйиши ман этилади.
            </p>
            <p style="font-size: 16px;font-weight:bold;text-indent: 50px;">2.2. “Буюртмачи”нинг мажбуриятлари:</p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.2.1. Ташувчидан шартнома шартларига ўзгартириш киритиш бўйича тушган таклифларни ўрнатилган тартибда кўриб чиқиш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.2.2. Ташувчининг ушбу шартноманинг 1-иловасида қайд этилган автотранспорт воситаларига мунтазам йўналишда йўловчи ташиш хизматларини кўрсатиш ҳуқуқини тасдиқловчи гувоҳномани тақдим этиш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.2.3.  йўловчиларнинг ҳуқуқлари таъминланишини назорат қилиш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.2.4. ёқилғи-мойлаш материаллари, электр энергияси, асосий эҳтиёт қисмлар ва материаллар нархлари ўзгарганда тарифларни ошириш ёки камайтириш бўйича Ташувчининг таклиф ва хисоб-китобларини кўриб чиқиши;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.2.5. йўналиш бўйича белгиланган тарифларни ўзгартирилганлиги ҳақида Ташувчига хабар бериш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                2.2.6. шартнома бир томонлама бекор қилинган тақдирда 5 кун муддатда Ташувчини ёзма равишда хабардор қилиш.
            </p>
            <p style="font-size: 16px;font-weight:bold;text-indent: 50px;">2.3. “Ташувчи”нинг ҳуқуқлари:</p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;">
                2.3.1. фуқаролар ҳаётига, йўл ҳаракати хавфсизлигига таҳдид солувчи, экология ва санитария нормалари бузилишига ёки бошқа ғайриқонуний ҳаракатларга сабаб бўлувчи ҳолатларда ташишдан воз кечиш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;">
                2.3.2. шартнома шартларини ўзгартириш ёки шартномани бекор қилиш юзасидан Буюртмачига асосланган таклифлар киритиш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;">
                2.3.3. Буюртмачи томонидан шартнома асоссиз равишда бекор қилинганда суд органларига мурожаат қилиш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;">
                2.3.4. ўз ихтиёри билан Буюртмачини хабардор қилган ҳолда, белгиланган тарифни пасайтириш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;">
                2.3.5. Ташувчи қонун ҳужжатларига мувофиқ бошқа ҳуқуқларга ҳам эга бўлиши мумкин.
            </p>
            <p style="font-size: 16px;font-weight:bold;text-align:center;">2.4. “Буюртмачи”нинг ҳуқуқлари</p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;">
                2.4.1. йўловчиларнинг ҳуқуқлари таъминланишини назорат қилиш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;">
                2.4.2. Ташувчи томондан шартнома шартларига риоя этилмаслик ҳолатлари икки маротабагача қайд этилган тақдирда Ташувчига огоҳлантириш ва камчиликларни бартараф этиш чораларини кўриш бўйича кўрсатма бериш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;">
                2.4.3. қуйидаги ҳолларда шартномани бир томонлама бекор қилиш:
                а) мониторинг натижаларига кўра Ташувчининг лот бўйича берган таклифлари ҳақиқий эмас деб топилса;
                б) ташувчи шартнома талаб ва шартларини уч маротаба бузса;
                в) ташувчининг лицензияси бекор қилинса, тугатилса ёки суд қарорига асосан ўн кундан ортиқ муддатга тўхтатилса;

            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;">
                2.4.4. қонун ҳужжатларига мувофиқ бошқа ваколатларни амалга ошириш.
            </p>
            <h6 style="font-size: 16px;text-align:center;font-weight:bold;">
                III. Томонларнинг жавобгарлиги
            </h6>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;">
                3.1. Томонлар ушбу шартнома мажбуриятларини бажармаган ёки зарур даражада бажармаган тақдирда қонун ҳужжатларида назарда тутилган тартибда жавоб беради.
            </p>
            <p style="font-size: 16px;font-weight:bold;text-align:center;">IV. Енгиб бўлмайдиган куч (форс-мажор) ҳолатлари</p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;">
                4.1. Агар ушбу шартнома бўйича мажбуриятлар қисман ёки тўлиқ бажарилмаслиги табиат ҳодисалари ва бошқа енгиб бўлмайдиган куч ҳолатлари натижасида келиб чиқса ва агар бу ҳолатлар мазкур шартноманинг бажарилишига бевосита таъсир этса, томонлар бундай қисман ёки тўлиқ бажармаслик учун жавобгарликдан озод этиладилар.
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;">
                4.2. Мазкур шартнома бўйича мажбуриятларни бажариш муддати енгиб бўлмайдиган куч ҳолатлари амал қилган, шунингдек ушбу ҳолатлар юзага келтирган вақтга мутаносиб равишда узайтирилади.
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;">
                4.3. Агар енгиб бўлмайдиган куч ҳолатлари ёки уларнинг оқибатлари беш кундан кўп вақтга чўзилса, у ҳолда Буюртмачи ва Ташувчи қандай чоралар кўрилишини муҳокама қиладилар.
            </p>
            <p style="font-size: 16px;font-weight:bold;text-align:center;">V. Низоларни ҳал этиш тартиби</p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;">
                5.1. Мазкур шартномани тузиш, ижро этиш, ўзгартириш ва бекор қилишда вужудга келадиган низоларни Томонлар музокаралар йўли билан ҳал этиш чораларини кўрадилар.
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;">
                5.2. Томонлар низоларни ҳал эта олмасалар, улар қонун ҳужжатларида белгиланган тартибда суд томонидан кўриб чиқилади.
            </p>
            <p style="font-size: 16px;font-weight:bold;text-align:center;">VI.  Шартноманинг амал қилиш муддати, уни ўзгартириш ва бекор қилиш</p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;">
                7.1. Мазкур шартнома имзоланган кундан бошлаб кучга киради ва ушбу шартноманинг 1.1. бандида белгиланган муддатларда амалда бўлади.
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;">
                7.2. Мазкур шартномани ўзгартириш ва бекор қилиш томонларнинг келишувига кўра, шунингдек, шартноманинг 2.4.3. бандига ҳамда Ўзбекистон Республикасининг қонун ҳужжатларига мувофиқ амалга оширилади.
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;">
                7.3 Мазкур шартнома томонларнинг ҳар бири учун бир хил тенг юридик кучга эга бўлган икки нусхада тузилди.
            </p>
            <p style="font-size: 16px;font-weight:bold;text-align:center;">VII. Шартномага  илова  қилинадиган  ҳужжатлар</p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;margin-bottom:0px;">
                6.1. Йўналишга хизмат кўрсатиш шартлари мазкур шартноманинг 1-иловасида берилган бўлиб, шартноманинг ажралмас қисми хисобланади.
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
            <!-- ilova -->
        </div>
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
            <table style="width:100%;margin-top:50px;">
                <tr>
                    <td style="font-size: 16px;margin: 0;line-heifht:0;text-align:right">
                        <div>
                           <em> “___” январдаги “___” - сонли </em>
                        </div>
                        <div>
                            <em>шартномага 1-илова</em>
                        </div>
                    </td>
                </tr>
            </table>
            <h6 style="font-size: 16px;text-align:center;font-weight:bold;margin-left:70px;margin-right:70px;margin-top:30px;">
                Йўналишга хизмат кўрсатиш талаб ва шартлари
            </h6>
            <p style="font-size: 16px;margin: 0;line-heifht:0;text-align:justify;margin-top:15px;margin-bottom:15px;">
                “{{getCompanyInfo.company_name}}” МЧЖ раҳбари {{$g.getFirstLetter(getCompanyInfo.name)}}.{{$g.getFirstLetter(getCompanyInfo.middlename)}}.{{getCompanyInfo.surname}}, бундан кейин “Ташувчи” {{$g.getYear(getContract.date)}} йил «{{$g.getDay(getContract.date)}}» {{$g.getMonthInLetter(getContract.date)}} санасидан {{$g.getYear(getContract.exp_date)}} йил «{{$g.getDay(getContract.exp_date)}}» {{$g.getMonthInLetter(getContract.exp_date)}} санасигача бўлган муддатда қуйида келтирилган шартларда, <template v-for="(dir,index) in getDirections">{{dir.pass_number}}-сонли «{{dir.name}}» </template> автобус йўналишида йўловчиларни ташишни амалга оширади.
            </p>
            <p style="font-size: 16px;margin: 0;line-heifht:0;margin-left:70px;text-align:justify;margin-top:15px;margin-bottom:15px;">
                <u>Талабдаги маълумотлар олиб келиб берилади (тендердан кейинги ҳолати)</u>
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;">
                1. Ташувчи йўналишда йўловчиларни ташиш учун чап томондан бошқариладиган ва йўловчиларнинг қулай чиқиши ва тушишини таъминлайдиган, йўловчилар эшиги ўнг томонда жойлашган _____ та автотранспортдан фойдаланади:
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
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px; margin-top:20px;">
                2.  Ташувчи қуйидаги мажбуриятларга эга:
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;">
                2.1.    йўловчиларни ташишда Ўзбекистон Республикасининг “Автомобиль транспорти тўғрисида”ги, “Фаолиятнинг айрим турларини лицензиялаш тўғрисида”ги  ва «Йўл ҳаракати хавфсизлиги тўғрисида»ги Қонунлари, Ўзбекистон Республикаси Вазирлар Маҳкамасининг 2003 йил 4 ноябрдаги 482-сонли қарори билан тасдиқланган «Ўзбекистон Республикасида автомобиль транспортида йўловчилар ва багаж ташиш қоидалари» ва «Ўзбекистон Республикасида автобусларда йўловчилар ташиш хавфсизлигини таъминлашга доир талаблар» ва «Йўл ҳаракати қоидалари»га қатъий амал қилинишини таъминлаш ҳамда уларда белгиланган талаб ва шартларнинг тўлиқ бажарилишини таъминлашга ташувчи (биринчи раҳбар) шахсан жавобгар;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;">
                2.2. йўловчиларни сифатли ташиш ва хизмат кўрсатиш маданиятини ошириш, транспорт воситаларини бошқариш ҳуқуқи учун мувофиқ тоифага, шунингдек шаҳарлараро йўловчилар ташиш йўналишларида норматив-ҳуқуқий ҳужжатлар талаблари асосида белгиланган иш стажига ва тажрибага эга бўлган ҳайдовчиларни ишлатишни таъминлаш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;">
                2.3. «Ташувчининг фуқаролик жавобгарлигини мажбурий суғурта қилиш тўғрисида»ги Ўзбекистон Республикаси Қонуни талаблари асосида ташувчининг фуқаролик жавобгарлигини суғурта қилиш бўйича белгиланган мажбуриятларнинг бажарилишини таъминлаш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;">
                2.4. автотранспортни GPS тузилмаси билан жихозлаш ва уни доимий равишда ишлашини таъминлаш, GPS тузилмасини ҳайдовчилар томонидан ўчириб қўйилишига йўл қўймаслик;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;">
                2.5. белгиланган иш тартиби, тасдиқланган қатнов жадвали, ҳаракатланувчи таркибнинг йўналишда ишлаши учун режалаштирилган сонига қатъий амал қилиш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;">
                2.6. автобуслар тахографлар билан жихозланган бўлишини ва уларнинг доимий соз ҳолда ишлашини таъминлаш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;">
                2.7. ҳар бир автобус ва микроавтобуснинг салонида йўналиш схемаси, йўл ҳақи қийматининг тариф жадвали осиб қўйилишини, “Ташувчи”нинг {{$t('Telefon')}} рақамлари, люк, деразаларни шошилинч очиш усуллари ва йўл-транспорт ходисаси юз берганида автобус салонидаги ойналарни кўчириш усуллари тўғрисида ахборотлар, ўт ўчиргич, аптечкалар, авария холатида ташқарига чиқиш жойлари ишоралар билан кўрсатиб қўйилиши ва бошқа қонунчилик талаблари асосида жихозланишини таъминлаш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;">
                2.8. автобусни олд томонининг пастки ва ўнг томондаги олдинги эшикнинг ёнига йўналишнинг рақами ва қисқача тавсифи кўрсатилган трафаретлар жойлаштирилиши;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;">
                2.9. автобус давлат андозаси ва уни ишлаб чиқарган заводнинг техник шартларига мувофиқ жихозланиши, шу жумладан фалокат юз берганида йўловчилар ташқарига чиқадиган жой, ўриндиқлар соз холда бўлиши, ўриндиқлари рақамлаштирилган бўлиши, салонига кирадиган эшиклар, ҳеч қандай тўсиқсиз, автомат усулда, ҳайдовчининг бошқаруви билан очилиб-ёпилиши, микроавтобуснинг салонида бегона нарсалар (захира қисмлар солинган яшиклар, ишлатиш учун керакли суюқликлар солинган идишлар ва ш.к.) сақланишига йўл қўймаслик;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;">
                2.10. йўловчиларни ташишда йўналиш бўйича тасдиқланган йўлкира ҳақи тарификациясида белгиланган миқдорида тариф қўллаш. Ташиш учун тарифни ошириш тамонига ўзгартиришга йўл қўймаслик;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;">
                2.11. йўналиш бўйича тасдиқланган қатнов жадвалига, йўналиш схемасига мувофиқ, фақат шартнома тузилган автовокзал ва автостанциялар орқали амалга оширилишини таъминлаш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;">
                2.12. автобусни ишлатиш пайтида ҳаракатланишга хавф солувчи, транспорт воситаси тизимлари ва механизмларида техник томондан бузилиш юз берса автобусни тўхтатиш, ҳамда эшикларни (зарурат бўлса авария люкларини) очиш, йўловчиларни салондан пастга тушириш, уларни мавжуд чипталари билан, шу йўналиш  бўйлаб келаётган кейинги автобусга чиқаришни ташкил қилиш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;">
                2.13. ҳайдовчи қатнов олдидан автобуснинг кунлик техник кўрикдан ўтганлиги ва ўзининг кунлик тиббий кўрикдан ўтганлигини қайд эттирилган йўл варақасини олиб юришини талаб қилиш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;">
                2.14. транспорт воситаларининг йўналишда мунтазам равишда қатновини таъминлаш учун транспорт воситалари йўналишдан чиқиб кетган вазиятларда автобусларни бир йўналишдан иккинчи йўналишга ўтказиш. Техник ёки бошқа сабабларга кўра йўналишдан чиқиб кетган автобусларни тезкорлик билан алмаштириш учун ____та захира автобусга эга бўлиш;
            </p>
            <p style="font-size: 16px;font-weight:normal;text-indent: 50px;">
                2.15. автотранспорт воситалари салонида ҳайдовчилар ва йўловчиларга чекиш, фақат ўтириб кетиш учун мўлжалланган автотранспорт воситалари салонида ўриндиқлар сонидан ортиқ йўловчиларни олиб юриш, автобус салонида ва томида юк ташиш, салонда спиртли ичимликлар ичиш қатъиян ман этилади.
            </p>
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
    },
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
