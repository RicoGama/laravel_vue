<template src="./_form.html"></template>

<script type="text/javascript">
    import {BankAccount, Bank} from '../../services/resources';
    import PageTitle from '../PageTitle.vue';
    import 'materialize-autocomplete';

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
                banks: []
            };
        },
        created() {
            this.getBanks();
        },
        methods: {
            submit() {
                BankAccount.save({}, this.bankAccount).then(() => {
                    Materialize.toast('Conta bancária criada com sucesso!', 4000);
                    this.$router.go({name: 'bank-account.list'});
                });
            },
            getBanks() {
                Bank.query().then((response) => {
                    this.banks = response.data.data;
                    this.initAutocomplete();
                });
            },
            initAutocomplete() {
                let self = this;
                $(document).ready(() => {
                    $('#bank-id').materialize_autocomplete({
                        limit: 10,
                        multiple: {
                            enabled: false
                        },
                        dropdown: {
                            el: '#bank-id-dropdown'
                        },
                        getData: (value, callback) => {
                            callback(value, self.banks);
                        }
                    });
                });
            }
        }
    }
</script>