import noJump from "../assets/noJump";

export default {
    namespaced: true,
    state() {
        return {
            modal: false,
            quiz: true,
            lastStep: false,
            main: true,
        }
    },
    getters: {
        stateMain(state) {
          return state.main
        },
        stateLastStep(state) {
            return state.lastStep
        },
        stateQuiz(state) {
            return state.quiz
        },
        stateModal(state) {
            return state.modal
        },
    },
    mutations: {
        MAIN_TRUE(state) {
          state.main = true
        },
        MAIN_FALSE(state) {
          state.main = false
        },
        LAST_STEP_TRUE(state) {
            state.lastStep = true
        },
        LAST_STEP_FALSE(state) {
            state.lastStep = false
        },
        QUIZ_TRUE(state) {
            state.quiz = true
        },
        QUIZ_FALSE(state) {
            state.quiz = false
        },
        MODAL_TRUE(state) {
            state.modal = true
        },
        MODAL_FALSE(state) {
            state.modal = false
        },
    },
    actions: {
        modalTrue({ commit }) {
            commit('MODAL_TRUE')
            noJump()
        },
        modalFalse({ commit }) {
            commit('MODAL_FALSE')
            document.body.style = ''
        },
        modalQuizTrue({ commit }) {
            commit('QUIZ_TRUE')
            noJump()
        },
        modalQuizFalse({ commit }) {
            commit('QUIZ_FALSE')
            document.body.style = ''
        },
        modalLastTrue({ commit }) {
            commit('LAST_STEP_TRUE')
            noJump()
        },
        modalLastFalse({ commit }) {
            commit('LAST_STEP_FALSE')
            document.body.style = ''
        },
    }
}
