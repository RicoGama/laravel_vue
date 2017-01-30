<template>
    <select></select>
</template>

<script type="text/javascript">
    import 'select2';

    export default {
        props: {
            options: {
                type: Object,
                required: true,
            },
            selected: {
                type: [String, Number],
                required: true
            }
        },
        ready() {
            let self = this;
            $(this.$el)
                .select2(this.options)
                .on('change', function () {
                    self.selected = this.value
                });
            $(this.$el).val(this.selected).trigger('change');
        }
    }
</script>