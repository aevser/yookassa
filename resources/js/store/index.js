import { createStore } from 'vuex'

import modal from './modal'
import quiz from './quiz'

const store = createStore({
    modules: {
        modal,
        quiz
    }
})

export {store}
