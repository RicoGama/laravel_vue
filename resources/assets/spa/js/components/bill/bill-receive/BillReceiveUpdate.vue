<template src="../_form.html"></template>

<script type="text/javascript">
    import billReceiveMixin from '../../../mixins/bill-mixin';
    import store from '../../../store/store';
    import BillReceive from '../../../models/bill-receive';
    import ValidatorOffRemoveMin from '../../../mixins/validator-off-remove-mixins';

    export default {
        mixins: [billReceiveMixin, ValidatorOffRemoveMin],
        created() {
            let self = this;
            this.modalOptions.options = {};
            this.modalOptions.options.ready = () => {
                self.getBill();
            };
        },
        ready() {
            this.initSelect2();
        },
        methods: {
            namespace() {
                return 'billReceive';
            },
            categoryNamespace() {
                return 'categoryRevenues';
            },
            title() {
                return 'Editar receita';
            },
            getBill() {
                this.resetScope();
                let bill = store.getters[`${this.namespace()}/billByIndex`](this.index);
                this.bill = new BillReceive(bill);
                let text = store.getters['bankAccount/textAutoComplete'](bill.bankAccount.data);
                this.bankAccount.text = text;
            }
        }
    }
</script>