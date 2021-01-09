<template>
    <div class="text-danger" v-if="valid">{{ message[0] }}</div>
</template>
<script>
    export default {
        props: ['errors', 'for'],

        computed: {
            message() {
                return this.errors[this.for] || [];
            },
            valid() {
                return this.message.length;
            }
        },
    }
</script>