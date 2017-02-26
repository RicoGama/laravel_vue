<template src="../_form.html"></template>

<script type="text/javascript">
    import billPayMixin from '../../../mixins/bill-mixin';

    export default {
        mixins: [billPayMixin],
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
                return 'Novo Pagamento';
            }
        }
    }
</script>

<style type="text/css" scoped src="../_style.css"></style>