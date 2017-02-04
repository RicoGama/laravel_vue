import JwtToken from './services/jwt-token';
import LocalStorage from './services/localStorage';
import {User} from './services/resources';
import Vuex from 'vuex';

const USER = 'user';

const state = {
    user: LocalStorage.getObject(USER) || {name: ''},
    check: JwtToken.token != null
};

const mutations = {
    setUser(state, user) {
        state.user = user;
        if (user != null) {
            LocalStorage.setObject(USER, user);
        } else {
            LocalStorage.remove(USER);
        }
    },
    authenticated(state) {
        state.check = true;
    },
    unauthenticated(state) {
        state.check = false;

    }
};

const actions = {
    login(context, {email, password}) {
        return JwtToken.accessToken(email, password).then((response) => {
            context.commit('authenticated');
            context.dispatch('getUser');
            return response;
        });
    },
    getUser(context) {
        return User.get().then((response) => {
            context.commit('setUser', response.data);
        });
    },
    clearAuth(context) {
        context.commit('unauthenticated');
        context.commit('setUser', null);
    },
    logout(context) {
        let afterLogout = (response) => {
            context.dispatch('clearAuth');
            return response;
        };

        return JwtToken.revokeToken()
            .then(afterLogout)
            .catch(afterLogout);
    }
};

export default new Vuex.Store({state, mutations, actions});