import {BankAccount} from '../services/resources';
import searchOptions from '../services/search-options';

const state = {
    bankAccounts: [],
    bankAccountDelete: null,
    searchOptions: new searchOptions('bank'),
};

const mutations = {
    set(state, bankAccounts) {
        state.bankAccounts = bankAccounts;
    },
    setDelete(state, bankAccount) {
        state.bankAccounts = bankAccount;
    },
    'delete'(state) {
        state.bankAccounts.$remove(state.bankAccountDelete);
    },
    setOrder(state, key) {
        state.searchOptions.order.key = key;
        let sort = state.searchOptions.order.sort;
        state.searchOptions.order.sort = sort == 'desc' ? 'asc' : 'desc';
    },
    setPagination(state, pagination) {
        state.searchOptions.pagination = pagination;
    },
    setCurrentPage(state, currentPage) {
        state.searchOptions.pagination.current_page = currentPage;
    },
    setFilter(state, filter) {
        state.searchOptions.search = filter;
    }
};

const actions = {
    query(context) {
        let searchOptions = context.state.searchOptions;
        return BankAccount.query(searchOptions.createOptions()).then((response) => {
            context.commit('set', response.data.data);
            context.commit('setPagination', response.data.meta.pagination);
        });
    },
    queryWithsortBy(context, key) {
        context.commit('setOrder', key);
        context.dispatch('query');
    },
    queryWithPagination(context, currentPage) {
        context.commit('setCurrentPage', currentPage);
        context.dispatch('query');
    },
    queryWithFilter(context) {
        context.dispatch('query');
    },
};

const module = {
    state, mutations, actions
};
export default module;