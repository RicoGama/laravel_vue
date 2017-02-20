import {CategoryRevenue, CategoryExpense} from '../services/resources';

const findParent = (id, categories) => {
    let result = null;
    for (let category of categories) {
        if (id == category.id) {
            result = category;
            break;
        }
        result = findParent(id, category.children.data);
        if (result !== null) {
            break;
        }
    }
    return result;
};

const addChild = (child, categories) => {
    let parent = findParent(child.parent_id, categories);
    parent.children.data.push(child);
};

const state = {
    categories: [],
    category: null,
    parent: null,
    resource: null
};

const mutations = {
    set(state, categories) {
        state.categories = categories;
    },
    setDelete(state, category) {
        state.category = category;
    },
    add(state) {
        if (state.category.parent_id === null) {
            state.categories.push(state.category);
        } else {
            state.parent.children.data.push(state.category);
        }
    },
    edit(state) {
        if (state.category.parent_id === null) {
            /**
             * Categoria alterada, está sem pai
             * E antes ela tinha um pai
             */
            if (state.parent) {
                state.parent.children.data.$remove(state.category);
                state.categories.push(state.category);
                return;
            }
        } else {
            /**
             * Categoria alterada, se tem pai
             */
            if (state.parent) {
                /**
                 * Trocar categoria de pai
                 */
                if (state.parent.id != state.category.parent_id) {
                    state.parent.children.data.$remove(state.category);
                    addChild(state.category, state.categories);
                    return;
                }
            } else {
                /**
                 * Tornar a categoria um filho
                 * Antes a categoria era um pai
                 */
                state.categories.$remove(state.category);
                addChild(state.category, state.categories);
                return;
            }
        }

        /**
         * Alteração somente no nome da categoria
         * Atualizar as informações na árvore
         */
        if (state.parent) {
            let index = state.parent.children.data.findIndex(element => {
                return element.id == state.category.id;
            });
            state.parent.children.data.$set(index, state.category);
        } else {
            let index = state.categories.children.data.findIndex(element => {
                return element.id == state.category.id;
            });
            state.categories.$set(index, state.category);
        }
    },
    'delete'(state) {
        if (state.parent) {
            state.state.parent.children.data.$remove(state.category);
        } else {
            state.categories.$remove(state.category);
        }
    },
    setCategory(state, category) {
        state.category = category;
    },
    setParent(state, parent) {
        state.parent = parent;
    },
    setResource(state, type) {
        state.resource = type == 'categoryRevenue' ? CategoryRevenue : CategoryExpense;
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
    'delete'(context) {
        let id = context.state.bankAccountDelete.id;
        return BankAccount.delete({id: id}).then((response) => {
            context.commit('delete');
            context.commit('setDelete', null);

            let bankAccounts = context.state.bankAccounts;
            let pagination = context.state.searchOptions.pagination;
            if (bankAccounts.length === 0 && pagination.current_page > 0) {
                context.commit('setCurrentPage', pagination.current_page--);
            }
            return response;
        });
    },
    save(context, bankAccount) {
        BankAccount.save({}, bankAccount).then((response) => {
           return response;
        });
    }
};

const module = {
    namespaced: true,
    state,
    mutations,
    actions
};
export default module;