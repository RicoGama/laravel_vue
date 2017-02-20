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
    add(state) {
        if (state.category.parent_id === null) {
            state.categories.push(state.category);
        } else {
            state.parent.children.data.push(state.category);
        }
    },
    edit(state, categoryUpdated) {
        if (state.category.parent_id === null) {
            /**
             * Categoria alterada, está sem pai
             * E antes ela tinha um pai
             */
            if (state.parent) {
                state.parent.children.data.$remove(state.category);
                state.categories.push(categoryUpdated);
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
                    addChild(categoryUpdated, state.categories);
                    return;
                }
            } else {
                /**
                 * Tornar a categoria um filho
                 * Antes a categoria era um pai
                 */
                state.categories.$remove(state.category);
                addChild(categoryUpdated, state.categories);
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
            state.parent.children.data.$set(index, categoryUpdated);
        } else {
            let index = state.categories.children.data.findIndex(element => {
                return element.id == state.category.id;
            });
            state.categories.$set(index, categoryUpdated);
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
        return context.state.resource.query().then((response) => {
            context.commit('set', response.data.data);
            return response;
        });
    },
    'delete'(context) {
        let id = context.state.category.id;
        return context.state.resource.delete({id: id}).then((response) => {
            context.commit('delete');
            context.commit('setCategory', null);
            return response;
        });
    },
    save(context, category) {
        let categoryCopy = $.extend(true, {}, category);
        if (categoryCopy.parent_id === null) {
            delete categoryCopy.parent_id;
        }
        if(category.id === 0) {
            return context.dispatch('new', categoryCopy);
        } else {
            return context.dispatch('edit', categoryCopy);
        }
    },
    'new'(context, category) {
        return context.state.resource.save(category).then(response => {
            context.commit('setCategory', category);
            context.commit('add');
            return response;
        });
    },
    edit(context, category) {
        return this.resource.update({id: category.id}, category).then(response => {
            context.commit('edit', response.data.data);
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