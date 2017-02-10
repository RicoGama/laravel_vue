<template src="./_form.html"></template>

<script type="text/javascript">
    import {BankAccount, Bank} from '../../services/resources';
    import PageTitle from '../PageTitle.vue';
    import 'materialize-autocomplete';
    import store from '../../store/store';

    export default {
        components: {
            'page-title': PageTitle
        },
        data() {
            return {
                title: 'Nova conta bancária',
                bankAccount: {
                    name: '',
                    agency: '',
                    account: '',
                    bank_id: '',
                    'default': false,
                },
                bank: {
                    name: ''
                },
                banks: []
            };
        },
        computed: {
            banks() {
                return store.state.bank.banks;
            }
        },
        created() {
            this.getBanks();
        },
        methods: {
            updateName(event) {
                store.commit('updateName', event.target.value);
            },
            submit() {
                BankAccount.save({}, this.bankAccount).then(() => {
                    Materialize.toast('Conta bancária criada com sucesso!', 4000);
                    this.$router.go({name: 'bank-account.list'});
                });
            },
            getBanks() {
                store.dispatch('bank/query').then((response) => {
                    this.initAutocomplete();
                });
            },
            initAutocomplete() {
                let self = this;
                $(document).ready(() => {
                    $('#bank-id').materialize_autocomplete({
                        limit: 10,
                        multiple: {
                            enabled: true
                        },
                        dropdown: {
                            el: '#bank-id-dropdown',
                        },
                        getData(value, callback) {
                            let mapBanks = store.getters['bank/mapBanks'];
                            let banks = mapBanks(value);
                            callback(value, banks);
                        },
                        onSelect(item) {
                            self.bankAccount.bank_id = item.id;
                        }
                    });
                });
            }
        }
    }
</script>