<template>
    <div class="row">
        <page-title>
            <h5>Minhas contas a receber</h5>
        </page-title>
        <div class="card-panel z-depth-5">
            <search @on-submit="filter" :model.sync="search"></search>
            <table class="bordered striped highlight responsive-table">
                <thead>
                    <tr>
                        <th v-for="(key, o) in table.headers" :width="o.width">
                            <a href="#" @click.prevent="sortBy(key)">
                                {{ o.label }}
                                <i class="material-icons right" v-if="searchOptions.order.key == key">
                                    {{ searchOptions.order.sort == 'asc' ? 'arrow_drop_up' : 'arrow_drop_down' }}
                                </i>
                            </a>
                        </th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(index, o) in bills">
                        <td>{{ o.id }}</td>
                        <td>{{ o.date_due | dateFormat }}</td>
                        <td>{{ o.name }}</td>
                        <td>{{ o.value | numberFormat true }}</td>
                        <td>
                            <a href="#" @click.prevent="openModalEdit(index)">Editar</a>
                            <a href="#" @click.prevent="openModalDelete(o)">Excluir</a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <pagination :current-page.sync="searchOptions.pagination.current_page"
                        :per-page="searchOptions.pagination.per_page"
                        :total-records="searchOptions.pagination.total"></pagination>
        </div>

        <div class="fixed-action-btn">
            <a href="#" class="btn-floating btn-large" @click.prevent="openModalCreate()">
                <i class="large material-icons">add</i>
            </a>
        </div>
    </div>

    <bill-receive-create :modal-options="modalCreate"></bill-receive-create>
    <bill-receive-update :index="indexUpdate" :modal-options="modalEdit"></bill-receive-update>

    <modal :modal="modalDelete">
        <div slot="content" v-if="billReceiveDelete">
            <h4>Mensagem de confirmação</h4>
            <p><strong>Deseja excluir esta conta?</strong></p>
            <div class="divider"></div>
            <p>Vencimento: <strong>{{ billReceiveDelete.date_due }}</strong></p>
            <p>Nome: <strong>{{ billReceiveDelete.name }}</strong></p>
            <p>Valor: <strong>{{ billReceiveDelete.value }}</strong></p>
            <div class="divider"></div>
        </div>
        <div slot="footer">
            <button class="btn btn-flat waves-effect green lighten-2 modal-close modal-action"
                    @click="destroy()">OK
            </button>
            <button class="btn btn-flat waves-effect waves-red modal-close modal-action">Cancelar</button>
        </div>
    </modal>
</template>

<script type="text/javascript">
    import ModalComponent from '../../../../../_default/components/Modal.vue';
    import PaginationComponent from '../../Pagination.vue';
    import PageTitleComponent from '../../PageTitle.vue';
    import SearchComponent from '../../Search.vue';
    import BillReceiveCreateComponent from './BillReceiveCreate.vue';
    import BillReceiveUpdateComponent from './BillReceiveUpdate.vue';
    import store from '../../../store/store';

    export default {
        components: {
            'modal': ModalComponent,
            'pagination': PaginationComponent,
            'page-title': PageTitleComponent,
            'search': SearchComponent,
            'bill-receive-create': BillReceiveCreateComponent,
            'bill-receive-update': BillReceiveUpdateComponent
        },
        data() {
            return {
                modalDelete: {
                    id: 'modal-delete'
                },
                modalCreate: {
                    id: 'modal-create'
                },
                modalEdit: {
                    id: 'modal-edit'
                },
                indexUpdate: 0,
                table: {
                    headers: {
                        id: {label: '#', width: '7%'},
                        date_due: {label: 'Vencimento', width: '30%'},
                        name: {label: 'Nome', width: '30%'},
                        value: {label: 'Valor', width: '7%'},
                    }
                }
            };
        },
        computed: {
            bills() {
                return store.state.billReceive.bills;
            },
            searchOptions() {
                return store.state.billReceive.searchOptions;
            },
            search: {
                get() {
                    return store.state.billReceive.searchOptions.search;
                },
                set(value) {
                    store.commit('billReceive/setFilter', value);
                }
            },
            billReceiveDelete() {
                return store.state.billReceive.billDelete;
            }
        },
        created() {
            store.dispatch('billReceive/query');
            store.dispatch('bankAccount/lists');
            store.dispatch('categoryRevenue/query');
        },
        methods: {
            destroy() {
                store.dispatch('billReceive/delete').then((response) => {
                    Materialize.toast('Conta excluída com sucesso!', 4000);
                });
            },
            openModalCreate() {
                $('#modal-create').modal('open');
            },
            openModalEdit(index) {
                this.indexUpdate = index;
                $('#modal-edit').modal('open');
            },
            openModalDelete(billReceive) {
                store.commit('billReceive/setDelete', billReceive);
                $('#modal-delete').modal('open');
            },
            sortBy(key) {
                store.dispatch('billReceive/queryWithSortBy', key);
            },
            filter() {
                store.dispatch('billReceive/queryWithFilter');
            }
        },
        events: {
            'pagination::changed'(page) {
                store.dispatch('billReceive/queryWithPagination', page);
            }
        }
    }
</script>