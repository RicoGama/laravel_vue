<template src="../_form.html"></template>

<script type="text/javascript">
    import billReceiveMixin from '../../../mixins/bill-mixin';
    import ValidatorOffRemoveMin from '../../../mixins/validator-off-remove-mixins';

    export default {
        mixins: [billReceiveMixin, ValidatorOffRemoveMin],
        ready() {
            this.initSelect2();
        },
        methods: {
            namespace() {
                return 'billReceive';
            },
            categoryNamespace() {
                return 'categoryRevenue';
            },
            title() {
                return 'Nova Receita';
            }
        }
    }
</script>

<style type="text/css" scoped src="../_style.css"></style>