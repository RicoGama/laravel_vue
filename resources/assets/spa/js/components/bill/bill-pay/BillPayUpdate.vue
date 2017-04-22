<template src="../_form.html"></template>

<script type="text/javascript">
    import billPayMixin from '../../../mixins/bill-mixin';
    import store from '../../../store/store';
    import BillPay from '../../../models/bill-pay';
    import ValidatorOffRemoveMin from '../../../mixins/validator-off-remove-mixins';

    export default {
        mixins: [billPayMixin, ValidatorOffRemoveMin],
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
                return 'billPay';
            },
            categoryNamespace() {
                return 'categoryExpense';
            },
            title() {
                return 'Editar pagamento';
            },
            getBill() {
                this.resetScope();
                let bill = store.getters[`${this.namespace()}/billByIndex`](this.index);
                this.bill = new BillPay(bill);
                let text = store.getters['bankAccount/textAutoComplete'](bill.bankAccount.data);
                this.bankAccount.text = text;
            }
        }
    }
</script>