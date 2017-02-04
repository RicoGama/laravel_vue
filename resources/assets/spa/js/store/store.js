import Vuex from 'vuex';
import auth from './auth';
import bankAccount from './bank-account';
import bank from './bank';

export default new Vuex.Store({
    modules: {
        auth,
        bankAccount,
        bank
    }
});