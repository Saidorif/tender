<template>
        <div class="form_content auth_request">
              <div class="login_alert" v-if="errorMsgSign">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ errorMsgSign.message }}
              </div>
              <form @submit.enter.prevent="onSignUp">
                <div class="col-md-6">
                  <div class="pas_confirm_frame">
                    <div class="input-group">
                      <input
                        type="password"
                        class="form-control"
                        placeholder="Пароль подтверждения"
                        v-model="signUp.confirm_password"
                        :class="
                          isRequired(signUp.confirm_password)
                            ? 'isRequired'
                            : ''
                        "
                        @input="confirmPassword()"
                      />
                    </div>
                    <small class="redText" v-if="checkPassword">
                      <b>Пароль не совпадает</b>
                    </small>
                  </div>
                  <div class="input-group mt-4">
                    <button type="submit" class="btn btn-primary btn-block">
                      Зарегистрироваться
                    </button>
                  </div>
                </div>
              </form>
        </div>
</template>