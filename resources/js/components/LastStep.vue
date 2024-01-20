<template>
    <transition>
        <div v-show="stateLastStep" class="last">
            <div class="last__progress">
                <div class="last-progress">
                   
                </div>
            </div>
            <div class="last__question">
                <div class="last-question">
                    <div class="last-question__title">Заполните данные и узнай как списать 100% Долгов</div>
                    <div class="last-question__form">
                        <form @submit.prevent="submitForm" action="#" class="form">
                            <div class="form__wrapper">
                                <label class="form__field">
                                    <input
                                        v-model="name"
                                        :class="{'is-invalid' : (v$.name.required.$invalid && v$.$dirty) || (v$.name.minLength.$invalid && v$.$dirty)}"
                                        :disabled="isDisabled"
                                        class="form__input" type="text" placeholder="Ваше имя" id="quizName">

                                    <div class="invalid-feedback" v-if="v$.name.required.$invalid && v$.$dirty">Обязательное поле.</div>
                                    <div class="invalid-feedback" v-if="v$.name.minLength.$invalid && v$.$dirty">Минимальная длина {{v$.name.minLength.$params.min}}</div>
                                </label>
                                <label class="form__field">
                                    <input
                                        v-maska
                                        v-model="phone"
                                        data-maska="+7 (###) ###-####"
                                        :class="{'is-invalid' : (v$.phone.required.$invalid && v$.$dirty) || (v$.phone.minLength.$invalid && v$.$dirty)}"
                                        :disabled="isDisabled"
                                        class="form__input" type="tel" placeholder="Телефон" id="quizPhone">

                                    <div class="invalid-feedback" v-if="v$.phone.required.$invalid && v$.$dirty">Обязательное поле.</div>
                                    <div class="invalid-feedback" v-if="v$.phone.minLength.$invalid && v$.$dirty">Неверный формат</div>
                                </label>
                                <button class="form__submit btn btn--red" type="submit">Бесплатная консультация</button>
                                <label class="policy">
                                    <input v-model="policy" class="policy__input" type="checkbox">
                                    <span class="policy__ok"></span>
                                    <span class="policy__text">Я согласен(на) с <a href="/policy"  target="_blank">политикой конфиденциальности</a></span>
                                    <span class="invalid-feedback invalid-feedback--policy" v-if="v$.policy.agree.$invalid && v$.$dirty">Согласие обязательно</span>
                                </label>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </transition>
</template>

<script>
import { useVuelidate } from '@vuelidate/core'
import {required, minLength, email} from '@vuelidate/validators'

export default {
    setup () {
        return { v$: useVuelidate() }
    },
    name: "LastStep",
    props: ["data", "stateLastStep"],
    data() {
        return {
            name: '',
            phone: '',
            policy: true,
            isDisabled: false,
            counters: null
        }
    },
    computed: {
    },
    methods: {
        toQuiz() {
            this.$emit('toQuiz')
        },
        clear() {
            this.name = ''
            this.phone = ''
        },
        async submitForm () {
            const isFormCorrect = await this.v$.$validate()

            if (!isFormCorrect) return

            this.isDisabled = true
            await axios.post('api/v1/lead.add',{
                host: window.location.host,
                referrer: document.referrer,
                url_query_string: sessionStorage.getItem('urlQueryString'),
                name: this.name,
                phone: this.phone.replace(/\D/g,""),
                data: this.data,
                cost: this.data[0].answer
            }).then( response => {
                if(response.status === 201){
                    if (this.counters.ym) ym(this.counters.ym, "reachGoal", "order");
                    this.v$.$reset()
                    this.clear()
                    this.isDisabled = false
                    window.location.href = '/thanks'
                }
            })
        }
    },
    validations() {
        return {
            name: {required, minLength: minLength(2)},
            phone: {required, minLength: minLength(17)},
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
    }

}
</script>

<style scoped>
.v-enter-active {
    transition: opacity 0.5s ease;
}

.v-enter-from {
    opacity: 0;
}

.invalid-feedback {
    position:absolute;
    top: 0;
    left: 10px;
    width: 100%;
    color: #dc3545;
    text-align: left;
    font-size: 14px;
}
.invalid-feedback--politics {
    top: auto;
    left: 0;
    bottom: -20px;
}
.invalid-feedback--policy {
    display: block;
    text-align: center;
    top: auto;
    bottom: -15px;
}
</style>
