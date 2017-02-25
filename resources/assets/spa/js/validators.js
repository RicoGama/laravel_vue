import VeeValidate from 'vee-validate';
import dictPtMessages from './locale/validator/pt-br';

Vue.use(VeeValidate, {
    locale: 'pt-br',
    dictionary: {
        'pt-br': {
            messages: dictPtMessages
        }
    }
});