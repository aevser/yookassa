import {createApp} from "vue";
import {store} from "./store";

//components
import ModalApp from "./components/Modal.vue";
import QuizApp from "./components/Quiz.vue";

import { vMaska } from "maska"

const app = createApp({
    components: {
        ModalApp,
        QuizApp
    },

    created: function(){

        if(!sessionStorage.getItem('urlQueryString'))
            sessionStorage.setItem('urlQueryString', window.location.href);
    }
});

app.use(store)
app.directive("maska", vMaska)

app.mount("#app");
