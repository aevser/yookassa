<template>

    <div class="modal">
        <div class="modal__container">
            <div class="modal__wrapper">
                <div class="modal__close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M35.5594 0.440625C35.6991 0.579945 35.8099 0.74545 35.8855 0.927663C35.9611 1.10987 36 1.30521 36 1.50249C36 1.69977 35.9611 1.89511 35.8855 2.07732C35.8099 2.25953 35.6991 2.42504 35.5594 2.56436L2.5643 35.5602C2.28268 35.8418 1.90073 36 1.50246 36C1.10419 36 0.722234 35.8418 0.440616 35.5602C0.158998 35.2785 0.000786779 34.8966 0.000786779 34.4983C0.000786779 34.1 0.158998 33.7181 0.440616 33.4364L33.4357 0.440625C33.575 0.300953 33.7405 0.190139 33.9227 0.114529C34.1049 0.0389196 34.3003 0 34.4975 0C34.6948 0 34.8901 0.0389196 35.0724 0.114529C35.2546 0.190139 35.4201 0.300953 35.5594 0.440625Z"
                              fill="#2D2D2D"/>
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M0.440616 0.440625C0.300947 0.579945 0.190135 0.74545 0.114527 0.927663C0.0389188 1.10987 0 1.30521 0 1.50249C0 1.69977 0.0389188 1.89511 0.114527 2.07732C0.190135 2.25953 0.300947 2.42504 0.440616 2.56436L33.4357 35.5602C33.7173 35.8418 34.0993 36 34.4975 36C34.8958 36 35.2778 35.8418 35.5594 35.5602C35.841 35.2785 35.9992 34.8966 35.9992 34.4983C35.9992 34.1 35.841 33.7181 35.5594 33.4364L2.5643 0.440625C2.42498 0.300953 2.25948 0.190139 2.07727 0.114529C1.89506 0.0389196 1.69973 0 1.50246 0C1.30519 0 1.10985 0.0389196 0.927642 0.114529C0.745434 0.190139 0.579932 0.300953 0.440616 0.440625Z"
                              fill="#2D2D2D"/>
                    </svg>
                </div>
                <div class="modal__title">Бесплатная консультация</div>
                <div class="modal__subtitle">Чтобы получить консультацию оставьте свои данные</div>
                <div class="modal__form">
                    <form @submit.prevent="submitForm" action="#" class="modal__dialog">
                        <div class="form__wrapper">
                            <label class="form__field">
                                <input
                                    v-model="name"
                                    :class="{'is-invalid' : (v$.name.required.$invalid && v$.$dirty) || (v$.name.minLength.$invalid && v$.$dirty)}"
                                    :disabled="isDisabled"
                                    class="form__input" type="text" placeholder="Ваше имя" id="quizName">

                                <div class="invalid-feedback" v-if="v$.name.required.$invalid && v$.$dirty">Обязательное
                                    поле.
                                </div>
                                <div class="invalid-feedback" v-if="v$.name.minLength.$invalid && v$.$dirty">Минимальная
                                    длина {{ v$.name.minLength.$params.min }}
                                </div>
                            </label>
                            <label class="form__field">
                                <input
                                    v-maska
                                    v-model="phone"
                                    data-maska="+7 (###) ###-####"
                                    :class="{'is-invalid' : (v$.phone.required.$invalid && v$.$dirty) || (v$.phone.minLength.$invalid && v$.$dirty)}"
                                    :disabled="isDisabled"
                                    class="form__input" type="tel" placeholder="Телефон" id="quizPhone">

                                <div class="invalid-feedback" v-if="v$.phone.required.$invalid && v$.$dirty">
                                    Обязательное поле.
                                </div>
                                <div class="invalid-feedback" v-if="v$.phone.minLength.$invalid && v$.$dirty">Неверный
                                    формат
                                </div>
                            </label>
                            <button class="form__submit btn btn--red" type="submit">Получить консультацию</button>
                            <label class="policy">
                                <input v-model="policy" class="policy__input" type="checkbox">
                                <span class="policy__ok"></span>
                                <span class="policy__text">Я согласен(на) с <a href="/policy" target="_blank">политикой конфиденциальности</a></span>
                                <span class="invalid-feedback invalid-feedback--policy"
                                      v-if="v$.policy.agree.$invalid && v$.$dirty">Согласие обязательно</span>
                            </label>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal modal--active -->

</template>

<script>
import {useVuelidate} from '@vuelidate/core'
import {required, minLength, email} from '@vuelidate/validators'
import {modal} from "../assets/modal.js";


export default {
    setup() {
        return {v$: useVuelidate()}
    },
    name: "Modal",
    data() {
        return {
            name: '',
            phone: '',
            isDisabled: false,
            counters: null,
            policy: true,
        }
    },
    methods: {
        clear() {
            this.name = ''
            this.phone = ''
        },
        async submitForm() {
            const isFormCorrect = await this.v$.$validate()
            if (!isFormCorrect) return
            this.isDisabled = true
            await axios.post('/api/v1/lead.add', {
                name: this.name,
                phone: this.phone.replace(/\D/g, ""),
                url: window.location.href,
                host: window.location.host,
                referrer: document.referrer,
                url_query_string: sessionStorage.getItem('urlQueryString'),
            }).then(response => {
                if (response.status === 201 || response.status === 200) {
                    if (this.counters.ym) ym(this.counters.ym, "reachGoal", "order");
                    this.v$.$reset()
                    this.clear()
                    window.location.href = '/thanks'
                }
            })
        },
    },
    validations() {
        return {
            name: {required, minLength: minLength(2)},
            phone: {required, minLength: minLength(11)},
            policy: {
                agree: (value) => {
                    return value
                }
            },
        }
    },
    async created() {
        await axios
            .get("/api/v1/counters")
            .then((response) => {
                this.counters = response.data
            })
            .catch((error) => {
                console.log(error.message);
            });
    },
    mounted() {
        modal('.modal', 'modal--active', '[data-modal]', '.modal__close');
    }
}
</script>

<style scoped>
.invalid-feedback {
    position: absolute;
    top: -2px;
    left: 10px;
    width: 100%;
    color: #dc3545;
    text-align: left;
    font-size: 14px;
}

.invalid-feedback--politics {
    top: auto;
    bottom: -13px;
    left: 0;
    font-size: 12px;
    line-height: 100%;
    display: block;
}

.invalid-feedback--policy {
    display: block;
    text-align: center;
    top: auto;
    bottom: -15px;
}
</style>
