<template>
  <div class="card">
    <Loader v-if="laoding" />
    <div class="card-header">
      <h3 class="card-title title_user mb-0">
        <i class="peIcon pe-7s-user"></i>{{ $t('Mening maʼlumotlarim') }}
      </h3>
      <div class="balance" v-if="form">
        <strong>{{ $t('Balans') }}:</strong> {{ form.balance }}
      </div>
    </div>
   <!--  <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item">
        <a
          class="nav-link active"
          id="home-tab"
          data-toggle="tab"
          href="#home"
          role="tab"
          aria-controls="home"
          aria-selected="true"
        >
          <i class="peIcon pe-7s-config"></i>Основные настройки
        </a>
      </li>
      <li class="nav-item">
        <a
          class="nav-link"
          id="profile-tab"
          data-toggle="tab"
          href="#profile"
          role="tab"
          aria-controls="profile"
          aria-selected="false"
        >
          <i class="peIcon pe-7s-unlock"></i> Изменить пароль
        </a>
      </li>
    </ul> -->
  <!--   <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active " id="home" role="tabpanel" aria-labelledby="home-tab">
        <form role="form" @submit.prevent.enter="sendProfile">
          <div class="card-body d-flex flex-wrap" v-if="form.user" >
            <div class="col-md-8">
              <div class="row">
                <div class="form-group col-md-6">
                  <label for="name">{{$t('F.I.Sh')}}</label>
                  <p class="form-control input_style disabled">{{form.user.name}}</p>
                </div>

                <div class="form-group col-md-6">
                  <label for="company_name">{{$t('Tashkilot nomi')}}</label>
                  <p class="form-control input_style disabled">{{ form.user.company_name}}</p>
                </div>
                <div class="form-group col-md-6">
                  <label for="email">E-mail</label>
                  <p class="form-control input_style disabled">{{ form.user.email }}</p>
                </div>
                <div class="form-group col-md-6">
                  <label for="name">{{$t('Manzil')}}</label>
                  <p class="form-control input_style disabled">{{ form.user.address }}</p>
                </div>
                <div class="form-group col-md-6">
                  <label for="bank_number">{{$t('X/raqam')}}</label>
                  <p class="form-control input_style disabled">{{ form.user.bank_number }}</p>
                </div>
                <div class="form-group col-md-6">
                  <label for="city">{{$t('Bankning manzili')}}</label>
                  <p class="form-control input_style disabled">{{ form.user.city }}</p>
                </div>
                <div class="form-group col-md-6">
                  <label for="inn">{{$t('INN')}}</label>
                  <p class="form-control input_style disabled">{{ form.user.inn }}</p>
                </div>
                <div class="form-group col-md-6">
                  <label for="mfo">{{$t('MFO')}}</label>
                  <p class="form-control input_style disabled">{{ form.user.mfo }}</p>
                </div>
                <div class="form-group col-md-6">
                  <label for="oked">{{$t('OKED')}}</label>
                  <p class="form-control input_style disabled">{{ form.user.oked }}</p>
                </div>
                <div class="form-group col-md-6">
                  <label for="phone">{{$t('Telefon')}}</label>
                  <p class="form-control input_style disabled">{{ form.user.phone }}</p>
                </div>
                <div class="form-group col-md-6">
                  <label for="status">{{$t('Holati')}}</label>
                  <p class="form-control input_style disabled">{{ form.user.status == 'active' ? 'Активный' : 'Неактивный' }}</p>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group photoFileUploader" style="margin-bottom: 18px;">
                <div class="avatar-upload">
                  <div class="avatar-edit">
                    <input type="file" id="file" @change="changeFile($event)" />
                    <label for="file">
                      <i class="pe-7s-pen"></i>
                    </label>
                  </div>
                  <div class="avatar-preview">
                    <div id="fileimagePreview">
                      <span>{{fileFormat}}</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 d-flex justify-content-end">
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> {{$t('Saqlash')}}
              </button>
            </div>
          </div>
        </form>
      </div>
      <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <form @submit.prevent.enter="changePassword">
          <div class="card-body d-flex flex-wrap">
            <div class="form-group col-md-6">
              <label for="exampleInputPassword1">Пароль</label>
              <input
                type="password"
                class="form-control input_style"
                id="exampleInputPassword1"
                placeholder="Пароль.."
                :class="isRequiredPassword(passwords.password) ? 'isRequired' : ''"
                v-model="passwords.password"
              />
            </div>
            <div class="form-group col-md-6">
              <label for="ConfirmPassword1">Подтвердите пароль</label>
              <input
                type="password"
                class="form-control input_style"
                id="ConfirmPassword1"
                placeholder="Подтвердите пароль.."
                v-model="passwords.confirm_password"
                :class="isRequiredPassword(passwords.confirm_password) ? 'isRequired' : ''"
                @input="confirmPassword()"
              />
              <small class="redText" v-if="checkPassword">
                <b>Пароль не совпадает</b>
              </small>
            </div>
            <div class="col-12 d-flex justify-content-end">
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> {{$t('Saqlash')}}
              </button>
            </div>
          </div>
        </form>
      </div>
    </div> -->
    <div class="card-body">
      <section class="content" v-if="form">
        <div class="container-fluid">
          <div class="row">
            <div class="col-xl-3 col-lg-4 profileLeft">
              <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                  <div class="text-center">
                    <img
                      src="/img/user.svg"
                      alt="User profile picture"
                      class="profile-user-img img-fluid img-circle"
                    />
                  </div>
                  <h3 class="profile-username text-center">{{ form.name}}</h3>
                  <p class="text-muted text-center">"OOO Pixeel.uz"</p>
                  <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                      <b>{{$t('Avtomobil soni')}}: </b> <a class="float-right">{{form.cars_count}}</a>
                    </li>
                    <li class="list-group-item">
                      <b>{{$t('Avtomobil yili')}}:</b>
                      <a class="float-right">
                         {{ form.balance }}
                        <i>{{$t('soʼm')}}</i></a
                      >
                    </li>
                    <li class="list-group-item">
                      <b>{{$t('Arizalar soni')}}:</b>
                      <a class="float-right">{{form.applications_count}} {{$t('ta')}}</a>
                    </li>
                    <li class="list-group-item">
                      <b>{{$t('Shartnomalar soni')}} :</b>
                      <a class="float-right">{{form.contracts_count}} {{$t('ta')}}</a>
                    </li>
                    <li class="list-group-item">
                      <b>{{$t('Holati')}}:</b>
                        <a class="float-right">
                            <div class="statusAlert alert-success" style="border-radius:6px;padding-left:5px; padding-right:5px;">
                            {{$t('faol')}}
                            </div>
                        </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-xl-9 col-lg-8 profileRight">
              <div class="card">
                <div
                  class="card-header p-2 d-flex justify-content-between align-items-center"
                >
                  <ul class="nav nav-pills tab_header_profile">
                    <li class="nav-item">
                      <a
                        href="#myInfo"
                        data-toggle="tab"
                        class="nav-link active"
                        ><i class="fas fa-id-card mr-1"></i>
                        Мои данные
                      </a>
                    </li>
                    <li class="nav-item">
                      <a
                        href="#mypassword"
                        data-toggle="tab"
                        class="nav-link show"
                        ><i class="fas fa-id-card mr-1"></i>
                        Изменить пароль
                      </a>
                    </li>
                  </ul>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div id="myInfo" class="tab-pane active">
                      <form class="form-horizontal">
                        <div class="row">
                          <div class="col-sm-12 form-group"></div>
                          <div class="col-sm-6 form-group">
                            <label for="inputName" class="control-label"
                              >{{$t('F.I.Sh')}}</label
                            >
                            <input
                              type="text"
                              id="inputName"
                              disabled="disabled"
                              class="form-control"
                              v-model="form.name"
                            />
                          </div>
                          <div class="col-sm-6 form-group">
                            <label for="inputEmail" class="control-label"
                              >E-mail почта</label
                            >
                            <input
                              type="email"
                              id="inputEmail"
                              placeholder="E-mail..."
                              disabled="disabled"
                              class="form-control"
                              v-model="form.email"
                            />
                          </div>
                          <div class="form-group col-sm-6">
                            <label for="inputCompanyName" class="control-label"
                              >Название фирмы</label
                            >
                            <input
                              type="text"
                              id="inputCompanyName"
                              placeholder="Название фирмы..."
                              disabled="disabled"
                              class="form-control"
                              v-model="form.company_name"
                            />
                          </div>
                          <div class="form-group col-sm-6">
                            <label for="inputAddress" class="control-label"
                              >{{$t('Manzil')}}</label
                            >
                            <input
                              type="text"
                              id="inputAddress"
                              disabled="disabled"
                              class="form-control"
                              v-model="form.address"
                            />
                          </div>
                          <div class="form-group col-sm-6">
                            <label for="inputTel" class="control-label"
                              >Номер телефона</label
                            >
                            <input
                              type="text"
                              disabled="disabled"
                              class="form-control"
                              v-model="form.phone"
                            />
                          </div>
                          <div class="form-group col-sm-6">
                            <label for="inputinn" class="control-label"
                              >{{$t('INN')}}</label
                            >
                            <input disabled="disabled" class="form-control" v-model="form.inn" />
                          </div>
                          <div class="form-group col-sm-6">
                            <label for="inputmfo" class="control-label"
                              >{{$t('MFO')}}</label
                            >
                            <input disabled="disabled" class="form-control"  v-model="form.mfo" />
                          </div>
                          <div class="form-group col-sm-6">
                            <label for="inputoked" class="control-label"
                              >ОКЭД</label
                            >
                            <input disabled="disabled" class="form-control"  v-model="form.oked" />
                          </div>
                          <div class="form-group col-sm-6">
                            <label for="inputRCh" class="control-label"
                              >{{$t('X/raqam')}}</label
                            >
                            <input disabled="disabled" class="form-control" v-model="form.bank_number" />
                          </div>
                          <div class="form-group col-sm-6">
                            <label for="inputBA" class="control-label"
                              >{{$t('Bankning manzili')}}</label
                            >
                            <input
                              type="text"
                              id="inputBA"
                              disabled="disabled"
                              class="form-control"
                               v-model="form.city"
                            />
                          </div>
                          <div class="form-group col-sm-12 saveBtn">
                            <button type="button" class="btn btn-info">
                              Изменить
                            </button>
                          </div>
                        </div>
                      </form>
                    </div>
                    <div id="mypassword" class="tab-pane show">
                      <form class="form-horizontal">
                        <div class="row">
                          <div class="col-sm-12 form-group"><!----></div>
                          <div class="col-sm-6 form-group">
                            <label for="inputName" class="control-label"
                              >Старый пароль</label
                            >
                            <input
                              type="password"
                              id="inputName"
                              placeholder="Пароль"
                              class="form-control"
                               v-model="form.password"
                            />
                          </div>
                          <div class="col-sm-6 form-group">
                            <label for="inputName" class="control-label"
                              >Новый пароль</label
                            >
                            <input
                              type="password"
                              id="inputName"
                              placeholder="Новый пароль"
                              class="form-control"
                              v-model="form.new_password"
                            />
                            <!---->
                          </div>
                          <div class="col-sm-6 form-group">
                            <label for="inputName" class="control-label"
                              >Подтвердите пароль</label
                            >
                            <input
                              type="password"
                              id="inputName"
                              placeholder="Подтвердите пароль"
                              class="form-control"
                              v-model="form.confirm_password"
                            />
                            <!---->
                          </div>
                          <div class="form-group col-sm-12 saveBtn">
                            <button type="button" class="btn btn-info mt-4">
                              Изменить
                            </button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>
<script>
import { mapActions, mapGetters } from "vuex";
import Loader from "../../Loader";
export default {
  components: {
    Loader,
  },
  data() {
    return {
      form: {
        name: "",
        email: "",
        address: "",
        phone: "",
        image: "/img/user.jpg",
        file: "",
        text: "",
        applications_count: 0,
        cars_count: 0,
        contracts_count: 0,
      },
      fileFormat: "нет-файла",
      passwords: {
        password: "",
        confirm_password: "",
      },
      requiredInput: false,
      requiredPassword: false,
      checkPassword: false,
      laoding: true,
    };
  },
  computed: {
    ...mapGetters("user", ["getProfile"]),
  },
  async mounted() {
    await this.ActionProfile();
    this.form = this.getProfile.user;
    this.laoding = false;
  },
  methods: {
    ...mapActions("user", [
      "ActionProfile",
      "ActionProfileUpdate",
      "ActionChangePassword",
    ]),
    confirmPassword() {
      if (this.passwords.password && this.passwords.confirm_password) {
        if (this.passwords.password != this.passwords.confirm_password) {
          this.checkPassword = true;
        } else {
          this.checkPassword = false;
        }
      }
    },
    photoImg(img) {
      if (img) {
        if (img.length < 100) {
          return "/users/" + img;
        } else {
          return img;
        }
      }
    },
    changeFile(event) {
      let file = event.target.files[0];
      if (file.size > 1048576) {
        swal.fire({
          type: "error",
          icon: "error",
          title: "Ошибка",
          text: "Размер файл не должно быть больше 1мб",
        });
      } else {
        let reader = new FileReader();
        reader.onload = (event) => {
          this.form.file = event.target.result;
          this.fileFormat = "docx";
        };
        reader.readAsDataURL(file);
      }
    },
    changePhoto(event) {
      let file = event.target.files[0];
      if (
        event.target.files[0]["type"] === "image/png" ||
        event.target.files[0]["type"] === "image/jpeg" ||
        event.target.files[0]["type"] === "image/jpg"
      ) {
        if (file.size > 1048576) {
          swal.fire({
            type: "error",
            title: "Ошибка",
            text: "Размер изображения больше лимита",
          });
        } else {
          let reader = new FileReader();
          reader.onload = (event) => {
            this.form.image = event.target.result;
          };
          reader.readAsDataURL(file);
        }
      } else {
        swal.fire({
          type: "error",
          title: "Ошибка",
          text: "Картинка должна быть только png,jpg,jpeg!",
        });
      }
    },
    isRequired(input) {
      return this.requiredInput && input === "";
    },
    isRequiredPassword(input) {
      return this.requiredPassword && input === "";
    },
    async sendProfile() {
      if (this.form.name && this.form.email) {
        await this.ActionProfileUpdate(this.form);
        toast.fire({
          type: "success",
          icon: "success",
          title: "Данный изменен!",
        });
      } else {
        this.requiredInput = true;
      }
    },
    async changePassword() {
      if (
        this.passwords.password &&
        this.passwords.confirm_password &&
        this.checkPassword == false
      ) {
        await this.ActionChangePassword(this.passwords);
        toast.fire({
          type: "success",
          icon: "success",
          title: "Пароль изменен!",
        });
      } else {
        this.requiredPassword = true;
      }
    },
    printCv() {
      $(".cv_block").printThis();
    },
  },
};
</script>
<style scoped>
.tab_header_profile.nav-pills .nav-link{
    color: #292666;
    font-weight: bold;
}
.tab_header_profile.nav-pills .nav-link:hover,
.tab_header_profile.nav-pills .nav-link.active{
    color: white;
}
.cv_tab {
  background: #9fc1cc40;
  padding: 30px 0px;
}
page {
  background: white;
  display: block;
  margin: 0px auto;
  margin-bottom: 0.5cm;
}
page[size="A4"] {
  width: 21cm;
  height: 29.7cm;
  padding: 30px;
}
page[size="A4"][layout="landscape"] {
  width: 29.7cm;
  height: 21cm;
}
.cv_title {
  text-align: center;
  font-weight: bold;
}
.cv_user_img {
  width: 130px;
  height: 150px;
  overflow: hidden;
  border: 1px solid #000;
  margin-right: 30px;
  margin-bottom: 30px;
}
.cv_user_img img {
  width: 100%;
}
.cv_header {
  display: flex;
  align-items: flex-start;
}
.cv_header_info {
  width: calc(100% - 150px);
}
.cv_header_info h2 {
  font-weight: bold;
}
.cv_block p {
  font-size: 16px;
}
.cv_header_info p {
  margin-bottom: 0;
}
.cv_body_list {
  display: flex;
  flex-wrap: wrap;
}
.cv_body_list li {
  list-style: none;
  width: 60%;
  margin-bottom: 10px;
}
.cv_body_list li:nth-child(odd) {
  width: 40%;
}
.cv_body_list li {
  display: flex;
  flex-direction: column;
}
.cv_body_list li:last-child {
  width: 100%;
}
.cv_exper_subtitle {
  text-align: center;
  font-weight: bold;
}
.cv_experience_list {
}
.cv_experience_list li {
  list-style: none;
  display: flex;
  justify-content: space-between;
}
.cv_ex_date {
  width: 220px;
}
.cv_experience_list li .cv_ex_info {
  width: calc(100% - 220px);
}
.cv_experience_list li .cv_ex_info p {
  margin-bottom: 0;
}
.print_cv {
  position: absolute;
  right: 0;
  top: 120px;
  background: #3f6ad8;
  color: #fff;
  padding: 10px 30px;
  border: none;
}
@media print {
  page {
    background: white;
    display: block;
    margin: 0px auto;
    margin-bottom: 0.5cm;
  }
  page[size="A4"] {
    width: 21cm;
    height: 29.7cm;
    padding: 30px;
  }
  page[size="A4"][layout="landscape"] {
    width: 29.7cm;
    height: 21cm;
  }
  .cv_title {
    text-align: center;
    font-weight: bold;
  }
  .cv_user_img {
    width: 130px;
    height: 150px;
    overflow: hidden;
    border: 1px solid #000;
    margin-right: 30px;
    margin-bottom: 30px;
  }
  .cv_user_img img {
    width: 100%;
  }
  .cv_header {
    display: flex;
    align-items: flex-start;
  }
  .cv_header_info {
    width: calc(100% - 150px);
  }
  .cv_header_info h2 {
    font-weight: bold;
  }
  .cv_block p {
    font-size: 16px;
  }
  .cv_header_info p {
    margin-bottom: 0;
  }
  .cv_body_list {
    display: flex;
    flex-wrap: wrap;
  }
  .cv_body_list li {
    list-style: none;
    width: 60%;
    margin-bottom: 10px;
  }
  .cv_body_list li:nth-child(odd) {
    width: 40%;
  }
  .cv_body_list li {
    display: flex;
    flex-direction: column;
  }
  .cv_body_list li:last-child {
    width: 100%;
  }
  .cv_exper_subtitle {
    text-align: center;
    font-weight: bold;
  }
  .cv_experience_list {
  }
  .cv_experience_list li {
    list-style: none;
    display: flex;
    justify-content: space-between;
  }
  .cv_ex_date {
    width: 220px;
  }
  .cv_experience_list li .cv_ex_info {
    width: calc(100% - 220px);
  }
  .cv_experience_list li .cv_ex_info p {
    margin-bottom: 0;
  }
}
.saveBtn{
    display: flex;
    justify-content: flex-end;

}
 .saveBtn   .btn-info{
    color: #ffffff;
    background-color: #292666;
    border-color: #292666;
}
</style>
