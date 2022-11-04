<template>
    <input @input="$emit('input', $event.target.value)"
           :value="value" type="text">
</template>
<script>
export default {
    name: "DateSelector",
    props: {
        value: ''
    },
    watch: {
        value() {
            setTimeout(() => {
                $(this.$el).datepicker("update");
            });
        }
    },
    mounted() {
        $(this.$el).datepicker({
            'format': 'yyyy-mm-dd'
        }).change(e => {
            this.$emit('input',this.$el.value);
        })
    }
}
</script>


